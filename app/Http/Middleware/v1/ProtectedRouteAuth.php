<?php

namespace App\Http\Middleware\v1;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProtectedRouteAuth {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next) {

        try {

            $user = JWTAuth::parseToken()->authenticate();

        } catch (Exception $e) {

            if ($e instanceof TokenInvalidException) {

                return response()->json(['error' => true, 'message' => 'Token inválido, verifique.'], 401);

            } elseif ($e instanceof TokenExpiredException) {

                return response()->json(['error' => true, 'message' => 'Token expirado, verifique.'], 401);

            } else {

                return response()->json(['error' => true, 'message' => 'Token não autorizado, verifique.'], 401);

            }

        }

        return $next($request);

    }

}