<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemoController;
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

/**
 * Public
 */

Route::prefix('public')->name('public.')->group(function () {
  Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/', [HomeController::class, 'posts_index'])->name('index');
    Route::get('/{post}', [HomeController::class, 'posts_show'])->name('show');
  });

  Route::prefix('uploads')->name('uploads.')->group(function () {
    Route::get('{hash}/download', [HomeController::class, 'uploads_download'])->name('download');
  });
});

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('5bukv', [HomeController::class, 'bukv5'])->name('5bukv');
Route::get('hash', [HomeController::class, 'hash'])->name('hash');

/**
 * Auth
 */

Route::middleware(['can:memos'])->resource('memos', MemoController::class);

Route::middleware(['can:posts'])->resource('posts', PostController::class);

Route::middleware(['can:uploads'])->group(function () {

  Route::prefix('uploads')->name('uploads.')->group(function () {
    Route::get('{upload}/download', [UploadController::class, 'download'])->name('download');
  });
  Route::resource('uploads', UploadController::class)->except(['create', 'edit', 'update']);
  
});

Route::middleware(['auth'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::get('/room/{room}', [ChatController::class, 'show'])->name('room');
    Route::post('/room/{room}/message', [ChatController::class, 'sendMessage'])->name('send');
    Route::post('/room/{room}/join', [ChatController::class, 'joinRoom'])->name('join');
    Route::post('/room/{room}/leave', [ChatController::class, 'leaveRoom'])->name('leave');
    Route::get('/room/{room}/messages', [ChatController::class, 'getNewMessages'])->name('messages');
});

/**
 * Admin
 */

Route::middleware(['role:admin'])->group(function () {

  Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
      Route::get('{user}/login_as', [App\Http\Controllers\Admin\UserController::class, 'login_as'])->name('login_as');
    });
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->only(['index']);
  });

});