<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParseToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = strval($request->input('token'));
        $userid = $this->parseToken($token);

        $request->attributes->add(['uid' => $userid]);
        return $next($request);
    }

    private function parseToken(string $token) {
        $userService = new UserService();
        return $userService->getUserIdByToken($token);
    }
}
