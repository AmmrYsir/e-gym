<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $user = User::find($id)->join('profile', 'profile.user_id', '=', 'users.id')->select('users.id', 'users.name', 'email', 'profile.firstname', 'profile.lastname', 'profile.phone_number', 'profile.age', 'profile.address')->first();
        return view('membership.profile', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|string|max:2',
            'firstname' => 'required|string|max:36',
            'lastname' => 'required|string|max:24',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:12',
        ]);

        $user = User::with('profile')->first();
        $user->update([
            'name' => $request->name,
        ]);
        $user->profile->update([
            'age' => $request->age,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return redirect('/profile');
    }
}