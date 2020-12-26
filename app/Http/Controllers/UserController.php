<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Profile;
use App\Models\User_Subscription;

use App\Mail\RegistrationAccount;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;

class UserController extends Controller
{
    public function user()
    {
        $user = User::find(Auth::id());

        $transactions = $user->transaction_history()->join('subscription', 'subscription.id', '=', 'subscription_id')->select('transaction_history.id', 'transaction_history.transaction_date', 'transaction_history.transaction_total', 'subscription.name', 'transaction_history.duration')->orderBy('id')->get();
        // $packages = $user->user_subscription()->join('subscription', 'subscription.id', '=', 'subscription_id')->where('type', 1)->get();
        $packages = User_Subscription::with('subscription')->whereHas('subscription', function ($q) {
            return $q->where('type', 1);
        })->where('user_id', Auth::id())->get();

        $addons = $user->user_subscription()->join('subscription', 'subscription.id', '=', 'subscription_id')->where('type', 2)->select('subscription.id', 'name', 'user_subscription.subscription_end')->orderBy('id')->get();

        foreach ($packages as $package) {
            if ($package->status == 1) {

                $package->update([
                    'subscription_end' => Carbon::createFromDate($package->subscription_start)->addDays(round(intval($package->duration) / 100)),
                ]);

                if ($package->trial == 1) {
                    if (now()->greaterThan($package->trial_end)) {
                        $package->update([
                            'trial' => 0,
                            'trial_end' => null,
                        ]);
                    }
                }

                if (now()->greaterThan($package->subscription_end)) {

                    dd('now: ' . now() . ' greatherThan ? ' . $package->subscription_end);

                    $package->select('user_subscription.id as subID')->first();
                    $package->destroy(User_Subscription::whereHas('subscription', function ($q) {
                        return $q->where('type', 1);
                    })->first()->id);

                    $newPackage = User_Subscription::where('status', 0)->first();
                    if ($newPackage) {
                        $newPackage->status = '1';
                        $newPackage->subscription_start = now();
                        $newPackage->subscription_end = now()->addDays(round($newPackage->duration / 100));
                        $newPackage->save();
                    }
                }

                if (User_Subscription::all()->count() == 0) {
                    $newPackage = User_Subscription::where('status', 0)->first();
                    if ($newPackage) {
                        $newPackage->status = '1';
                        $newPackage->subscription_start = now();
                        $newPackage->subscription_end = now()->addDays(round($newPackage->duration / 100));
                        $newPackage->save();
                    }
                }
            }
        }

        foreach (User_Subscription::whereHas('subscription', function ($q) {
            return $q->where('type', 2);
        })->get() as $addon) {

            $addon->update([
                'subscription_end' => Carbon::createFromDate($addon->subscription_start)->addDays(round($addon->duration / 100)),
            ]);

            if (now()->greaterThan($addon->subscription_end)) {
                $addon->destroy($addon->id);
            }
        }

        return view('membership.home', ['profile' => $user->profile()->first(), 'transactions' => $transactions, 'package' => $packages->where('status', '1')->first(), 'addons' => $addons]);
    }

    public function admin()
    {
        $users = User::with('profile')->where('rank', 0)->get();
        return view('admin.member', compact('users'));
    }

    public function view_member($id)
    {
        $user = User::with('profile')->where('id', $id)->first();
        return view('admin.edit_member', compact('id', 'user'));
    }

    public function add_member(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->name),
        ]);

        Profile::create([
            'user_id' => $user->id,
        ]);

        Mail::to('noreply@egym.com')->send(new RegistrationAccount());

        return redirect('/admin');
    }

    public function edit_member(Request $request)
    {
        $profile = Profile::where('user_id', $request->id)->first();

        $profile->age = $request->age;
        $profile->firstname = $request->firstname;
        $profile->lastname = $request->lastname;
        $profile->address = $request->address;
        $profile->phone_number = $request->phone_number;
        $profile->save();

        return redirect('admin/member/' . $request->id);
    }

    public function subscription_member($id)
    {
        return view('admin.subscription_member', ['id' => $id]);
    }

    public function delete_member($id)
    {
        $user = User::where('id', $id)->delete();
        return redirect('/admin');
    }
}