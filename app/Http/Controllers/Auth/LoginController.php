<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'rank' => 0])) {
            return redirect('/home');
        }
        else if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'rank' => 1])) return redirect('/admin');
        else return redirect('/login')->with('message', 'You email address or password is incorrent!');
    }

    public function index()
    {
        
        return view('membership.home');
    }
}