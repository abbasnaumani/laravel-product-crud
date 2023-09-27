<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Route\Http\Product;
use Route\Http\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $view = (Auth::check()) ? 'dashboard' : 'login';
    return redirect()->route($view);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


User::register();
Product::register();

require __DIR__ . '/auth.php';
