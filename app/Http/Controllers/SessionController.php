<?php

namespace App\Http\Controllers;

use App\Models\User;
use Fumeapp\Humble\Models\Session;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse|Response
    {
        /** @var User $user */
        $user = auth()->user();

        return $this->render(Session::whereBelongsTo($user)->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws AuthorizationException
     */
    public function destroy(Session $session): JsonResponse|Response
    {
        $this->authorize('delete', $session);

        $session->delete();

        return $this->success('auth.session-removed');
    }
}
