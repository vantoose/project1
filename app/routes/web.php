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
    return view('welcome');
});

Auth::routes(['register' => env('AUTH_REGISTER', false), 'verify' => env('AUTH_VERIFY', false)]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->get('/hash/{q?}', function (Illuminate\Http\Request $request) {
	$text = $request->q ?: Illuminate\Support\Str::random(8);
	$hash = Illuminate\Support\Facades\Hash::make($text);
	return view('hash')->with(['text' => $text, 'hash' => $hash]);
	return ['text' => $text, 'hash' => $hash];
})->name('hash');
