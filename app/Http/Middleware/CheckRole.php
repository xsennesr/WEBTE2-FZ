<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
	if(Auth::user()){

		if(Auth::user()->ucitel && str_contains($request->getRequestUri(),'teacher')){
		   return $next($request);
		}
		if(!Auth::user()->ucitel && str_contains($request->getRequestUri(),'student')){
			return $next($request);
		}
		return new Response('Forbidden',403);
        }
	return new Response('Unauthorized',401);

    }
}
