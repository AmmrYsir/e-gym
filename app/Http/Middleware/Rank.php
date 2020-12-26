<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Rank as Middleware;
use Illuminate\Support\Facades\Auth;

class Rank
{

    public function handle($request, Closure $next, String $rank)
    {
        if (!Auth::check()) // This isnt necessary, it should be part of your 'auth' middleware
            return redirect('/login');

        $user = Auth::user();
        if ($user->rank == $rank)
            return $next($request);

        return redirect('/login');
    }
}