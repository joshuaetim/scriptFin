<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckActive
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
        if((Auth::check() && Auth::user()->blocked)){
            session()->flash('error', 'You have been blocked from this platform. Contact support for more info');
            return redirect('/home');
        }
        if(!(Auth::check() && Auth::user()->active)){
            session()->flash('status', 'You have to activate your profile');
            return redirect('/home');
        }
        return $next($request);
    }
}
