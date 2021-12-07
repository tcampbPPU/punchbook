<?php

namespace App\Http\Controllers;

use acidjazz\Humble\Models\Session;
use acidjazz\metapi\MetApi;
use Faker\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, MetApi;

    public function __construct(Request $request)
    {
        $this->metApiInit($request);
    }

    /**
     * Display application routes
     *
     * @return string
     */
    public function routes(): string
    {
        Artisan::call('route:list');
        $routes = explode("\n", Artisan::output());
        foreach ($routes as $index => $route) {
            if (str_contains($route, 'debugbar')) {
                unset($routes[$index]);
            }
        }

        return '<pre>' . implode("\n", $routes) . '</pre>';
    }

    /**
     * Redirect Login Route
     *
     * @return Redirector|Application|RedirectResponse
     */
    public function auth(): Redirector|Application|RedirectResponse
    {
        return redirect(config('app.web'));
    }
}
