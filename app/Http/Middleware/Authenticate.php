<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $rank = Auth::user()->rank;
        switch ($rank) {
            case '0':
                return redirect('/home');
                break;
            case '1':
                return redirect('/admin');
                break;
            default:
                return route('login');
        }

        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}