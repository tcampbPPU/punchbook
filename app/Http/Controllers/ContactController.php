<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Rules\PhoneNumber;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|Response
    {
        $this
            ->option('order', 'nullable|in:' . implode(',', Contact::$sortable))
            ->option('direction', 'nullable|in:desc,asc')
            ->option('filterFields', 'nullable|array|in:' . implode(',', Contact::$filterable))
            ->option('filterInputs', 'nullable|array')
            ->option('search', 'nullable|string')
            ->option('perpage', 'nullable|numeric|in:6,9,12,16,18,21,24')
            ->verify();

        return $this->render($this->paginate(
            Contact::query()
                ->when($request->search, fn ($q) => $q->filter($request->only('search')))
                ->when(
                    $request->order && $request->direction,
                    fn ($q) => $q->orderBy($request->order, $request->direction)
                )
                ->when(
                    $request->filterInputs,
                    fn ($q) => $q->where(
                        array_map(
                            fn ($a, $b) => [$a, 'LIKE', "%$b%"],
                            $request->filterFields,
                            $request->filterInputs
                        )
                    )
                ),
            $request->perpage ?? 10,
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse|Response
    {
        $this->authorize('create', Contact::class);

        $this
            ->option('name', 'required|string|max:255')
            ->option('phone', ['required', new PhoneNumber(), 'min:10'])
            ->option('email', [
                'required',
                'email',
                'max:255',
                Rule::unique(Contact::class)->whereNull('deleted_at'),
            ])
            ->verify();

        $contact = (new Contact([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => Str::lower($request->email),
        ]));

        $contact->save();

        return $this->success('contact.created', ['name' => $contact->name], $contact);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact): JsonResponse|Response
    {
        return $this->render($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @throws AuthorizationException
     */
    public function update(Request $request, Contact $contact): JsonResponse|Response
    {
        $this->authorize('update', $contact);

        $this
            ->option('name', 'required|string|max:255')
            ->option('phone', ['required', new PhoneNumber(), 'min:10'])
            ->option('email', [
                'required',
                'email',
                'max:255',
                Rule::unique(Contact::class)
                    ->ignore($contact->id)
                    ->whereNull('deleted_at'),
            ])
            ->verify();

        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;

        if ($contact->isDirty()) {
            $contact->save();
        }

        return $this->success('contact.updated', ['name' => $contact->name], $contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws AuthorizationException
     */
    public function destroy(Contact $contact): JsonResponse|Response
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return $this->success('contact.deleted', ['name' => $contact->name]);
    }
}
