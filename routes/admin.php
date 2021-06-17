<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "['web', 'theme:admin']" middleware group, 'admin' prefix, and 'admin.' route name.
| Now create something great!
|
*/

Route::group(['middleware' => 'auth:admin'], function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::view('home', 'home')->name('home');
});

Route::group(['middleware' => "guest:admin"], function () {

    $limiter = config('fortify.limiters.login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            $limiter ? "throttle:{$limiter}" : null,
        ]));

    Route::view('login', 'auth.login')->name('login');
});
