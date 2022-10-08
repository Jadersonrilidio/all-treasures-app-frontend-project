<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('session.only')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::fallback(function () {
        return view('not-found');
    })->name('not-found');
    
    Route::middleware('guest.only')->group(function () {

        Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login.index');

        Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.login');

        Route::get('/register', function () {
            return view('register');
        })->name('register');
    });

    Route::middleware('auth.only')->group(function () {

        Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('login.logout');

        Route::get('/home', function () {
            return view('home', $_SESSION);
        })->name('home');

        Route::get('/topic', function () {
            return view('topic', $_SESSION);
        })->name('topic');

        Route::get('/stash', function () {
            return view('stash', $_SESSION);
        })->name('stash.index');

        Route::get('/stash/{stashId}', function () {
            return view('stash', $_SESSION);
        })->name('stash.show');

        Route::middleware('auth.only')->get('/artifact/{artifactId}', function () {
            return view('artifact', $_SESSION);
        })->name('artifact.show');
    });
});
