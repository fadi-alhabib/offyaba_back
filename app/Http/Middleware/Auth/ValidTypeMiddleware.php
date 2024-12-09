<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ValidTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    private array
        $types = ['user', 'employee', 'admin'];

    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array($request->route('type'), $this->types) ){
            throw new NotFoundHttpException();
        }
            return $next($request);
    }
}
