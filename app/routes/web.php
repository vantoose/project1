<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UploadController;

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
	return redirect()->route('home')->withStatus('Welcome.');
    return view('welcome');
});

Auth::routes(['register' => env('AUTH_REGISTER', false), 'verify' => env('AUTH_VERIFY', false)]);

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('hash', [HomeController::class, 'hash'])->name('hash');
Route::get('5bukv', [HomeController::class, 'bukv5'])->name('5bukv');

Route::prefix('posts')->name('posts.')->group(function () {
  Route::get('published', [PostController::class, 'published'])->name('published');
});
Route::resource('posts', PostController::class);

Route::prefix('uploads')->name('uploads.')->group(function () {
  Route::get('{upload}/download', [UploadController::class, 'download'])->name('download');
});
Route::resource('uploads', UploadController::class)->except(['create', 'edit', 'update']);

/**
 * Admin
 */

Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
  Route::prefix('users')->name('users.')->group(function () {
		Route::get('{user}/login_as', [App\Http\Controllers\Admin\UserController::class, 'login_as'])->name('login_as');
	});
	Route::resource('users', App\Http\Controllers\Admin\UserController::class)->only(['index']);
});