<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $email = $this->faker->unique()->safeEmail();

        return [
            'name' => $this->faker->name(),
            'email' => $email,
            'role' => User::ADMIN,
            'avatar' => 'http://i.pravatar.cc/150?u=' . $email,
        ];
    }
}
