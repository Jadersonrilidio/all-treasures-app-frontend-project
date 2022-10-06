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

Route::get('/', function () {
    if (!isset($_SESSION)) session_start();
    return view('welcome');
})->name('welcome');

Route::middleware('guest.only')->get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login.index');
Route::middleware('guest.only')->post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.login');
Route::middleware('auth.only')->post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('login.logout');

Route::middleware('guest.only')->get('/register', function () {
    if (!isset($_SESSION)) session_start();
    return view('register');
})->name('register');

Route::middleware('auth.only')->get('/home', function () {
    if (!isset($_SESSION)) session_start();
    return view('home');
})->name('home');

Route::fallback(function () {
    if (!isset($_SESSION)) session_start();
    return view('not-found');
})->name('not-found');
