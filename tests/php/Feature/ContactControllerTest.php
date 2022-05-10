<?php

namespace Tests\Feature;

use App\Models\{Contact, User};
use Database\Seeders\ContactSeeder;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\HarmonyApiHelpers;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use HarmonyApiHelpers;

    private static bool $populated = false;
    private static User $admin;

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Setup Feature Test
     */
    public function setUp(): void
    {
        parent::setUp();
        if (! self::$populated) {
            self::$admin = User::factory()
                ->create([
                    'role' => User::ADMIN,
                ]);

            $this->seed(ContactSeeder::class);

            Contact::factory()
                ->create([
                    'phone' => '987-654-3210',
                    'email' => 'test@search.io',
                ]);

            self::$populated = true;
        }
    }

    /**
     * Contact index endpoint using default request values
     */
    public function testContactIndexEndpointWithDefaultValues()
    {
        $this->actingAs(self::$admin)
            ->json('get', '/contact')
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('status', 'success')
                    ->has('paginate')
                    ->has('benchmark')
                    ->has('query')
                    ->has('data')
                    ->has('data.0', fn ($json) =>
                        $json->has('id')
                            ->has('name')
                            ->has('phone')
                            ->has('email')
                            ->has('first_name')
                            ->has('avatar')
                            ->has('created_at')
                            ->has('updated_at')
                            ->where('deleted_at', null)
                            ->etc()));
    }

    /**
     * Test contact records can be searched by name
     */
    public function testContactListCanBeSearchedByName()
    {
        $contact = Contact::latest('id')->first();

        $url = "/contact?search={$contact->name}";

        $this->actingAs(self::$admin)
            ->json('get', $url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('status', 'success')
                    ->has('paginate')
                    ->has('benchmark')
                    ->has('query')
                    ->has('data')
                    ->has('data.0', fn ($json) =>
                        $json->has('id')
                            ->where('name', $contact->name)
                            ->has('phone')
                            ->has('email')
                            ->has('first_name')
                            ->has('avatar')
                            ->has('created_at')
                            ->has('updated_at')
                            ->where('deleted_at', null)
                            ->etc()));
    }

    /**
     * Test contact records can be searched by phone
     */
    public function testContactListCanBeSearchedByPhone()
    {
        $contact = Contact::latest('id')->first();

        $url = "/contact?search={$contact->phone}";

        $this->actingAs(self::$admin)
            ->json('get', $url)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('status', 'success')
                    ->has('paginate')
                    ->has('benchmark')
                    ->has('query')
                    ->has('data')
                    ->has('data.0', fn ($json) =>
                        $json->has('id')
                            ->has('name')
                            ->where('phone', $contact->phone)
                            ->has('email')
                            ->has('first_name')
                            ->has('avatar')
                            ->has('created_at')
                            ->has('updated_at')
                            ->where('deleted_at', null)
                            ->etc()));
    }

    /**
     * Contact store endpoint successful save
     */
    public function testContactStoreEndpoint()
    {
        $contact = Contact::factory()->makeOne();

        $result = $this->actingAs(self::$admin)
            ->json('post', '/contact', [
                'name' => $contact->name,
                'phone' => $contact->phone,
                'email' => $contact->email,
            ]);

        $result->assertJson($this->maStatus('contact.created', ['name' => $contact->name]));
        $this->assertDatabaseHas('contacts', [
            'name' => $contact->name,
            'phone' => $contact->phone,
            'email' => $contact->email,
        ]);
    }

    /**
     * Contact show endpoint
     */
    public function testContactShowEndpoint()
    {
        $contact = Contact::latest('id')->first();

        $this->actingAs(self::$admin)
            ->json('get', "/contact/{$contact->id}")
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('status', 'success')
                    ->has('benchmark')
                    ->has('query')
                    ->has('data', fn ($json) =>
                        $json->where('id', $contact->id)
                            ->where('name', $contact->name)
                            ->where('phone', $contact->phone)
                            ->where('email', $contact->email)
                            ->where('first_name', $contact->first_name)
                            ->where('avatar', $contact->avatar)
                            ->has('created_at')
                            ->has('updated_at')
                            ->where('deleted_at', null)
                            ->etc()));
    }

    /**
     * Contact update endpoint basic test
     */
    public function testContactBasicUpdateEndpoint()
    {
        $contact = Contact::latest('id')->first();

        $result = $this->actingAs(self::$admin)
            ->json('put', "/contact/{$contact->id}", [
                'name' => $contact->name . Str::random(6),
                'phone' => $contact->phone,
                'email' => $contact->email,
            ]);

        $contact->refresh();

        $result->assertJson($this->maStatus('contact.updated', ['name' => $contact->name]));
    }

    /**
     * Contact destroy endpoint test
     */
    public function testContactDestroy()
    {
        $contact = Contact::latest('id')->first();

        $result = $this->actingAs(self::$admin)
            ->json('delete', "/contact/{$contact->id}");

        $contact->refresh();

        $this->assertSoftDeleted($contact);
        $result->assertJson($this->maStatus('contact.deleted', ['name' => $contact->name]));
    }

    /**
     * Test Contact cannot be created without user auth
     */
    public function testCannotStoreContactWithoutAuth()
    {
        $this->json('post', '/contact')
            ->assertStatus(401)
            ->assertJsonFragment(
                [
                    'message' => 'Unauthenticated.',
                ]
            );
    }

    /**
     * Test Contact cannot be updated without user auth
     */
    public function testCannotUpdateContactWithoutAuth()
    {
        $contact = Contact::inRandomOrder()->first();

        $this->json('put', "/contact/{$contact->id}")
            ->assertStatus(401)
            ->assertJsonFragment(
                [
                    'message' => 'Unauthenticated.',
                ]
            );
    }

    /**
     * Test Contact cannot be deleted without user auth
     */
    public function testCannotDeletedContactWithoutAuth()
    {
        $contact = Contact::inRandomOrder()->first();

        $this->json('delete', "/contact/{$contact->id}")
            ->assertStatus(401)
            ->assertJsonFragment(
                [
                    'message' => 'Unauthenticated.',
                ]
            );
    }

    /**
     * Test contact email must be unique
     */
    public function testContactEmailMustBeUnique()
    {
        // Create existing record
        Contact::factory()
            ->create([
                'email' => 'foo@bar.com',
            ]);

        $contact = Contact::factory()->makeOne([
            'email' => 'foo@bar.com',
        ]);

        $this->actingAs(self::$admin)
            ->json('post', '/contact', [
                'name' => $contact->name,
                'phone' => $contact->phone,
                'email' => $contact->email,
            ])
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('status', 'error')
                    ->has('errors')
                    ->has('errors.0', fn ($json) =>
                        $json->where('status', 400)
                            ->where('message', 'email')
                            ->where('detail', 'The email has already been taken.')));
    }

    /**
     * Test Contact edit cannot change email to existing email
     */
    public function testContactEmailMustBeUniqueOnEdit()
    {
        $contact = Contact::inRandomOrder()->first();

        $this->actingAs(self::$admin)
            ->json('put', "/contact/{$contact->id}", [
                'name' => $contact->name,
                'phone' => $contact->phone,
                'email' => 'foo@bar.com',
            ])
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('status', 'error')
                    ->has('errors')
                    ->has('errors.0', fn ($json) =>
                        $json->where('status', 400)
                            ->where('message', 'email')
                            ->where('detail', 'The email has already been taken.')));
    }
}
