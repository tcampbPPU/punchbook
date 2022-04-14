<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\User;
use App\Notifications\LoginAttempt;
use Illuminate\Http\{JsonResponse, Request, Response};
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Provider a redirect URL
     *
     * @param string $provider
     * @return mixed
     */
    public function redirect(string $provider): mixed
    {
        if (!in_array($provider, Provider::$allowed)) {
            return $this->error('auth.provider-invalid');
        }
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Callback hit by the provider to verify user
     *
     * @param string $provider
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function callback(string $provider, Request $request): Response|JsonResponse
    {
        if (!in_array($provider, Provider::$allowed)) {
            return $this->error('auth.generic');
        }

        $oaUser = Socialite::driver($provider)->stateless()->user();

        $user = $this->oaHandle($oaUser, $provider);

        /** @var User $user */
        auth()->login($user, $provider);

        return $this->response($provider);
    }

    /**
     * Handle the login/creation process of a user
     * @param mixed $oaUser
     * @param string $provider
     * @return User
     */
    private function oaHandle($oaUser, string $provider): User
    {
        if (!$user = User::where('email', $oaUser->email)->first()) {
            $user = $this->createUser(
                $provider,
                $oaUser->name,
                $oaUser->email,
                $oaUser->picture ?? $oaUser->avatar_original ?? $oaUser->avatar,
                (array)$oaUser
            );
        }

        if ($user->avatar === null) {
            $user->avatar = $oaUser->picture ?? $oaUser->avatar_original ?? $oaUser->avatar;
            $user->save();
        }

        if (!$user->providers->where('name', $provider)->first()) {
            Provider::create(
                [
                    'user_id' => $user->id,
                    'name' => $provider,
                    'avatar' => $oaUser->picture ?? $oaUser->avatar_original ?? $oaUser->avatar,
                    'payload' => (array)$oaUser,
                ]
            );
        }

        return $user;
    }

    private function response(string $provider): Response
    {
        return response(
            view('complete', [
                'json' => json_encode([
                    'token' => auth()->token(),
                    'user' => auth()->user(),
                    'provider' => $provider,
                ])
            ])
        )->cookie('token', auth()->token(), 60 * 24 * 30, '/', '', true, false);
    }

    /**
     * Create new users with their initial team
     * @param string $provider
     * @param string $name
     * @param string $email
     * @param string $avatar
     * @param array $payload
     * @return User
     */
    private function createUser(string $provider, string $name, string $email, string $avatar, array $payload): User
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'avatar' => $avatar,
        ]);
        Provider::create([
            'user_id' => $user->id,
            'name' => $provider,
            'avatar' => $avatar,
            'payload' => $payload,
        ]);

        return $user;
    }

    /**
     * Login attempt via e-mail
     *
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function attempt(Request $request): Response|JsonResponse
    {
        $this
            ->option('email', 'required|email')
            ->option('action', 'nullable|string')
            ->verify();

        if (!$user = User::where('email', $request->email)->first()) {
            $user = $this->createUser(
                'email',
                explode('@', $request->email)[0],
                $request->email,
                'https://www.gravatar.com/avatar/' . md5($request->email),
                []
            );
        }

        $attempt = auth()->attempt($user, json_decode($request->action));
        $user->notify(new LoginAttempt($attempt));

        return $this->success('auth.attempt');
    }

    /**
     * Verify the link clicked in the e-mail
     *
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function login(Request $request): Response|JsonResponse
    {
        $this
            ->option('token', 'required|alpha_num|size:64')
            ->verify();

        if (!$login = auth()->verify($request->token)) {
            return $this->error('auth.failed');
        }

        return $this->render([
            'token' => auth()->token(),
            'user' => auth()->user(),
            'action' => $login->action, // @phpstan-ignore-line
        ])->cookie('token', auth()->token(), 60 * 24 * 30, '/', '', true, false);
    }

    /**
     * Standard user info auth check
     *
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function me(Request $request): Response|JsonResponse
    {
        $this
            ->option('providers', 'boolean')
            ->verify();
        if ($request->providers) {
            return $this->render(User::whereId(auth()->user()?->id)->with(['providers'])->first());
        }
        auth()->user()?->session->touch();
        return $this->render(auth()->user());
    }

    /**
     * Update user info
     *
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function update(Request $request)
    {
        $this
            ->option('name', 'required|string')
            ->option('avatar', 'required|url')
            ->verify();

        /** @var User $user */
        $user = auth()->user();

        $user->name ??= $request->name;
        $user->avatar ??= $request->avatar;
        $user->save();

        return $this->success('user.updated');
    }

    /**
     * Log a user out
     *
     * @return Response|JsonResponse
     */
    public function logout(): Response|JsonResponse
    {
        auth()->logout();

        return $this->success('auth.logout')->cookie('token', false, 0, '/', '', true, false);
    }
}
