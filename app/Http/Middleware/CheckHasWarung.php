<?php

namespace App\Http\Middleware;

use Closure;

class CheckHasWarung
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->user()->warung){
            return redirect("/warung");
        }
        return $next($request);
    }
}
