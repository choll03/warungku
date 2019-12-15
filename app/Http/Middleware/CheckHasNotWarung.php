<?php

namespace App\Http\Middleware;

use Closure;

class CheckHasNotWarung
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
        if($request->user()->has('warung')->exists()){
            return redirect("/home");
        }
        return $next($request);
    }
}
