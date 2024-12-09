<?php

namespace App\Http\Middleware\Auth;

use App\Http\Middleware\Authenticate;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Middleware\CheckScopes;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param ...$roles
     * @return Response
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        foreach ($roles as $role) {
            try {
                app(Authenticate::class)->handle($request, function () {
                }, $role . "-api");
                return app(CheckScopes::class)->handle($request, $next, $role);
            } catch (\Exception $e) {
            }
        }
        throw new AuthenticationException();
    }
}
