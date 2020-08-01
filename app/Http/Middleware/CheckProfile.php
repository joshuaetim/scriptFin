<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckProfile
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
        if(!(Auth::check() && Auth::user()->profile_complete)){
            session()->flash('status', 'Welcome, '.Auth::user()->name.'. You have to complete your profile to use the platform');
            return redirect('/profile');
        }
        return $next($request);
    }
}
