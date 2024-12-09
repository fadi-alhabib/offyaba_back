<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ValidMethodMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    private array $methods = ['register', 'login'];
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array($request->route('method'), $this->methods) ){
            throw new NotFoundHttpException();
        }
        return $next($request);
    }
}
