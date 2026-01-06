<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class PassportAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $cookie = $request->cookie('auth_token');

        if(!$cookie){
            return response()->json(['message' => 'Token not Found']);
        }

        $tokenData = json_decode($cookie, true);

        if (!$tokenData || !isset($tokenData['id'])) {
            return response()->json(['message' => 'Token is not valid.'], 401);
        }

        $tokenModel = PersonalAccessToken::find($tokenData['id']);
      
        if (!$tokenModel || !$tokenModel->tokenable){
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->setUserResolver(function () use ($tokenModel) {
            return $tokenModel->tokenable;
        });

        return $next($request);
    }
}
