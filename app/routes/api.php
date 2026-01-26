<?php

use App\Http\Controllers\Api\V1\AuthController;

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    // Аутентификация
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    // Защищенные маршруты (требуют аутентификации)
    Route::middleware('api.token')->group(function () {
        // Аутентификация
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh-token', [AuthController::class, 'refreshToken']);
    });
});


/*

curl -X POST http://127.0.0.1:6080/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@ishipilov.ru",
    "password": "password",
    "password_confirmation": "password"
  }'

curl -X POST http://127.0.0.1:6080/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@ishipilov.ru",
    "password": "password"
  }'

curl -X GET http://127.0.0.1:6080/api/v1/me \
  -H "Authorization: Bearer UE3LjrDFi2ZfczZRVqIwSyTGMBa6JDGo0cP4sfzPObPsIq2krwu8LSFQwk7o"

curl -X POST http://127.0.0.1:6080/api/v1/logout \
  -H "Authorization: Bearer UE3LjrDFi2ZfczZRVqIwSyTGMBa6JDGo0cP4sfzPObPsIq2krwu8LSFQwk7o"

*/