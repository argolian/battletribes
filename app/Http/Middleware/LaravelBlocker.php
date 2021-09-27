<?php

namespace App\Http\Middleware;

use App\Traits\LaravelCheckBlockTrait;
use Closure;
use Illuminate\Http\Request;

class LaravelBlocker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(config('laravelblocker.laravelBlockerEnabled'))
        {
            LaravelCheckBlockTrait::checkBlocked();
        }
        return $next($request);
    }
}
