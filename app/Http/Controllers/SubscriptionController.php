<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Transaction_History;
use App\Models\User_Subscription;
use App\Models\Subscription_Types;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{

    // GLOBAL 
    public function index()
    {
        $packages = Subscription::where('type', 1)->get();
        $addOns = Subscription::where('type', 2)->get();
        $id = Auth::id();
        return view('membership.subscription', ['packages' => $packages, 'addOns' => $addOns, 'id' => $id]);
    }

    public function addSubscription(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'string|integer|required_with:package,addon',
            'package' => 'string|max:4',
            'trial' => 'string|max:4',
            'package_info' => 'string|required_with:package',
            'addon' => 'array',
            'addon_info' => 'array|required_with:addon|min:' . ($request->has('addon') ? count($request->addon) : 0),
        ]);

        if ($request->trial) {

            $user_subscription = User_Subscription::whereHas('Subscription', function ($query) {
                return $query->where('type', '1');
            })->where('trial', 1);

            $subscription = Subscription::where('id', $request->trial)->first();

            if ($user_subscription->get()->count() >= 1) {

                $user_subscription = $user_subscription->first();

                if (Carbon::createFromDate($user_subscription->trial_end)->equalTo($user_subscription->end)) {
                    $user_subscription->update([
                        'trial_end' => Carbon::createFromDate($user_subscription->trial_end)->addWeeks($user_subscription->subscription->trial_duration_in_weeks),
                        'end' => Carbon::createFromDate($user_subscription->end)->addWeeks(2),
                    ]);
                } else {
                    $user_subscription->update([
                        'trial_end' => Carbon::createFromDate($user_subscription->trial_end)->addWeeks($user_subscription->subscription->trial_duration_in_weeks),
                    ]);
                }
            } else {

                User_Subscription::create([
                    'user_id' => $request->id,
                    'subscription_id' => $request->trial,
                    'status' => '1',
                    'trial' => '1',
                    'start' => now(),
                    'end' => now()->addWeek($subscription->trial_duration_in_weeks),
                    'trial_end' => now()->addWeeks($subscription->trial_duration_in_weeks),
                ]);

                Transaction_History::create([
                    'user_id' => $request->id,
                    'subscription_id' => $request->trial,
                    'duration' => $request->trial,
                    'transaction_date' => now(),
                    'transaction_total' => 0,
                ]);
            }
        }

        if (isset($request->package)) {

            $duration = 0;
            $arrayOfinfo = explode(' | ', $request->package_info);
            $durationInfo = $arrayOfinfo[0];
            $price = explode('RM', $arrayOfinfo[1])[1];

            switch (explode(" ", $durationInfo)[1]) {
                case 'Week':
                    $duration = intval(explode(" ", $durationInfo)[0]) * 7000;
                    break;
                case 'Month':
                    $duration = intval(explode(" ", $durationInfo)[0]) * 30417;
                    break;
                case 'Year':
                    $duration = intval(explode(" ", $durationInfo)[0]) * 365000;
                    break;
                default:
            }

            if (User_Subscription::whereHas('Subscription', function ($query) {
                return $query->where('type', '1');
            })->get()->count() >= 1) {

                $user_subscription = User_Subscription::whereHas('subscription', function ($q) {
                    return $q->where('type', 1);
                })->where('subscription_id', $request->package);

                if ($user_subscription->get()->count() > 0) {
                    $user_subscription->first()->update([
                        'duration' =>  $user_subscription->first()->duration + $duration,
                    ]);
                } //
                else {
                    User_Subscription::create([
                        'user_id' => $request->id,
                        'subscription_id' => $request->package,
                        'status' => '0',
                        'duration' => $duration,
                    ]);
                }

                Transaction_History::create([
                    'user_id' => $request->id,
                    'subscription_id' => $request->package,
                    'duration' => explode(' | ', $request->package_info)[0],
                    'transaction_date' => now(),
                    'transaction_total' => ($price * 100),
                ]);
            } //
            else {

                User_Subscription::create([
                    'user_id' => $request->id,
                    'subscription_id' => $request->package,
                    'status' => '1',
                    'duration' => $duration,
                    'subscription_start' => now(),
                    'subscription_end' => now()->addDays(round($duration / 100)),
                ]);

                Transaction_History::create([
                    'user_id' => $request->id,
                    'subscription_id' => $request->package,
                    'transaction_date' => now(),
                    'duration' => explode(' | ', $request->package_info)[0],
                    'transaction_total' => ($price * 100),
                ]);
            }
        }

        if (isset($request->addon)) {

            foreach ($request->addon as $key => $addon) {

                $duration = 0;
                $arrayOfinfo = explode(' | ', $request->addon_info[$key]);
                $durationInfo = $arrayOfinfo[0];
                $price = explode('RM', $arrayOfinfo[1])[1];

                switch (explode(" ", $durationInfo)[1]) {
                    case 'Week':
                        $duration = intval(explode(" ", $durationInfo)[0]) * 7000;
                        break;
                    case 'Month':
                        $duration = intval(explode(" ", $durationInfo)[0]) * 30417;
                        break;
                    case 'Year':
                        $duration = intval(explode(" ", $durationInfo)[0]) * 365000;
                        break;
                    default:
                }

                $user_subscription = User_Subscription::whereHas('subscription', function ($q) {
                    return $q->where('type', 2);
                })->where('subscription_id', $request->addon[$key]);

                if ($user_subscription->get()->count() > 0) {
                    $user_subscription->first()->update([
                        'duration' => $user_subscription->first()->duration + $duration,
                        'subscription_end' => Carbon::createFromDate($user_subscription->first()->subscription_start)->addDays(round($user_subscription->first()->duration / 100)),
                    ]);
                } else {
                    User_Subscription::create([
                        'user_id' => $request->id,
                        'subscription_id' => $request->addon[$key],
                        'status' => '1',
                        'duration' => $duration,
                        'subscription_start' => now(),
                        'subscription_end' => now()->addDays(round($duration / 100)),
                    ]);
                }
                Transaction_History::create([
                    'user_id' => $request->id,
                    'subscription_id' => $request->addon[$key],
                    'transaction_date' => now(),
                    'duration' => explode(' | ', $request->addon_info[$key])[0],
                    'transaction_total' => $price,
                ]);
            }
        }

        return redirect('/admin/member/subscription/' . $request->id);
    }

    public function checkSubscription()
    {
        $packages = User_Subscription::whereHas('subscription', function ($q) {
            return $q->where('type', 1);
        })->get();

        $addons = User_Subscription::whereHas('subscription', function ($q) {
            return $q->where('type', 2);
        })->get();

        foreach ($packages as $package) {

            $package = $package->where('status', 1)->first();

            // Can be deactive
            $package->update([
                'subscription_end' => Carbon::createFromDate($package->subscription_start)->addDays(round(intval($package->duration / 100))),
            ]);

            if (now()->greaterThan($package->subscription_end)) {
                $package->first();
                $package->destroy(User_Subscription::whereHas('subscription', function ($q) {
                    return $q->where('type', 1);
                })->first()->id);

                $newPackage = User_Subscription::where('status', 0)->first();
                if ($newPackage) {
                    $newPackage->status = '1';
                    $newPackage->subscription_start = now();
                    $newPackage->subscrition_end = now()->addDays(round(intval($newPackage->duration / 100)));
                    $newPackage->save();
                }
            }
        }

        foreach ($addons as $addon) {

            $addon->update([
                'subscription_end' => Carbon::createFromDate($addon->subscription_start)->addDays(round(intval($addon->duration / 100))),
            ]);

            if (now()->greaterThan($addon->subscription_end)) {
                $addon->destroy($addon->id);
            }
        }

        return redirect('/admin');
    }
    // END GLOBAL


    // FOR ADMIN ONLY
    public function add_new_subscription(Request $request) // SUBSCRIPTION
    {

        $validatedData = $request->validate([
            'name' => 'string',
            'desc' => 'string',
            'type' => 'string|max:5',
            'parent' => 'string|max:5',
            'duration' => 'required',
            'trial_able' => 'integer',
            'trial_duration' => 'required_with:trial_able'
        ]);

        Subscription::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'price' => $request->price * 100,
            'parent_id' => $request->parent,
            'type' => $request->type,
            'duration' => $request->duration,
            'trial_able' => $request->trial_able,
            'trial_duration_in_weeks' => $request->trial_duration,
            'duration_in_month' => 1,
        ]);

        return redirect('/admin/subscription')->with('success', 'You have successfully added new Subscription Plan');
    }

    public function delete_subscription($id) // SUBSCRIPTION
    {
        Subscription::where('id', $id)->first()->destroy(Subscription::where('id', $id)->first()->id);
        return redirect('/admin/subscription');
    }

    public function view_subscription($id) // SUBSCRIPTION
    {
        $subscription = Subscription::find($id);
        $subscription_types = Subscription_Types::all();
        return view('admin.subscription_member_edit', compact('id', 'subscription', 'subscription_types'));
    }

    public function edit_subscription(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => 'string',
            'desc' => 'string',
            'type' => 'string|max:2',
            'parent_id' => 'sometimes|string|max:3',
            'duration' => 'required|min:1',
            'trial_able' => 'sometimes|integer',
            'trial_duration_in_weeks' => 'required_with:trial_able|string|max:2'
        ]);

        $subscription = Subscription::find($id);

        $subscription->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
            'duration' => $request->duration,
            'trial_able' => $request->trial_able,
            'trial_duration_in_weeks' => $request->trial_duration_in_weeks,
        ]);

        if (!isset($request->trial_able)) {
            Subscription::find($id)->update(['trial_able' => 0]);
        }

        return redirect('/admin/subscription');
    }

    public function manage_subscription()
    {
        $subscription = Subscription::all();
        $subscription_types = Subscription_Types::all();
        return view('admin.subscription', compact('subscription', 'subscription_types'));
    }
    // FOR ADMIN ONLY END

}