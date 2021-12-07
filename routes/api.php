<?php

use App\Http\Controllers\{
    AuthController,
    ContactController,
    Controller,
    SessionController,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Base
Route::get('/', [Controller::class, 'routes'])
    ->name('route information')
    ->withoutMiddleware('api');
Route::get('/example', [Controller::class, 'example'])->name('example route');
Route::get('/login', [Controller::class, 'auth'])->name('login');

// Authentication
Route::get('redirect/{provider}', [AuthController::class, 'redirect'])->name('redirect to provider');
Route::get('callback/{provider}', [AuthController::class, 'callback'])->name('provider callback');
Route::get('onetap/{credential}', [AuthController::class, 'onetap'])->name('onetap support');
Route::post('attempt', [AuthController::class, 'attempt'])->name('email login attempt');
Route::post('login', [AuthController::class, 'login'])->name('attempt to start session');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('remove session');
Route::get('me', [AuthController::class, 'me'])->middleware('auth:api')->name('get logged in user');

// Session
Route::apiResource('session', SessionController::class)->middleware('auth:api')->only(['index', 'destroy']);

// Contact
// Route::apiResource('contact', ContactController::class);
Route::get('contact', [ContactController::class, 'index']);
Route::post('contact', [ContactController::class, 'store'])->middleware('auth:api');
Route::get('contact/{contact}', [ContactController::class, 'show']);
Route::put('contact/{contact}', [ContactController::class, 'update'])->middleware('auth:api');
Route::delete('contact/{contact}', [ContactController::class, 'destroy'])->middleware('auth:api');
