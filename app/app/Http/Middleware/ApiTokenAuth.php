<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Получаем токен из заголовка Authorization
        $token = $request->bearerToken();
        
        // Если токен не предоставлен
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'API token is required.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        // Ищем пользователя по токену
        $user = \App\Models\User::where('api_token', hash('sha256', $token))->first();
        
        // Если пользователь не найден
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API token.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        // Авторизуем пользователя
        Auth::login($user);
        
        return $next($request);
    }
}
