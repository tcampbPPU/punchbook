<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Attempt to get the real client IP address from aws or cloudflare in Vapor
         */
        Request::macro('clientIp', function () {
            /** @var Request $request */
            $request = $this;

            return $request->headers->get('cf-connecting-ip') ?? $request->headers->get('x-vapor-source-ip') ?? $request->ip();
        });
    }
}
