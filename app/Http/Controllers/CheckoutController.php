<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Subscription;
use App\Models\User_Subscription;
use App\Models\Transaction_History;

use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {

        $validatedData = $request->validate([
            'package' => 'string',
            'packageDuration' => 'required_with:package|string',
            'addon' => 'array',
            'addonDuration' => 'required_with:addon|array',
        ]);

        \Stripe\Stripe::setApiKey('sk_test_51HgmW0Hf8OTLHWD6uAFlXuPh9gmwnNDx2i5z9AhuuIdib8FGbsrxukRKgqhORhRH7IrdWdaIKonGwD5tHPZUQZgs00HoAi4alK');

        $total = 0;
        $info = array();

        if (isset($request->package)) {
            $package = Subscription::where('id', $request->package)->first();

            $duration = explode(" | ", $request->packageDuration)[0];
            $price = explode(" | ", $request->packageDuration)[1];

            $total = $total + intval(explode("RM", $price)[1]);
            array_push($info, [$package->id, $package->name, $duration, $price, $package->type]);
        }

        if (isset($request->addon)) {
            foreach ($request->addon as $key => $addon) {

                $addonSubscription = Subscription::where('id', $addon)->first();

                $duration = explode(" | ", $request->addonDuration[$key])[0];
                $price = explode(" | ", $request->addonDuration[$key])[1];

                $total = $total + intval(explode("RM", $price)[1]);
                array_push($info, [$addonSubscription->id, $addonSubscription->name, $duration, $price, $addonSubscription->type]);
            }
        }

        $payment_intent = \Stripe\PaymentIntent::create([
            'description' => 'Subscription',
            'amount' => $total * 100,
            'currency' => 'MYR',
            'payment_method_types' => ['card'],
        ]);
        $intent = $payment_intent->client_secret;

        return view('checkout.credit-card', ['intent' => $intent, 'total' => $total, 'info' => $info]);
    }

    public function success(Request $request)
    {

        $id = Auth::id();

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
                    'user_id' => $id,
                    'subscription_id' => $request->trial,
                    'status' => '1',
                    'trial' => '1',
                    'start' => now(),
                    'end' => now()->addWeek($subscription->trial_duration_in_weeks),
                    'trial_end' => now()->addWeeks($subscription->trial_duration_in_weeks),
                ]);

                Transaction_History::create([
                    'user_id' => $id,
                    'subscription_id' => $request->trial,
                    'transaction_date' => now(),
                    'transaction_total' => 0,
                ]);
            }
        }

        if (isset($request->package)) {
            $duration = 0;
            $durationInfo = $request->package_duration;
            $price = explode('RM', $request->package_price)[1];

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
                return $q->where('type', 1);
            });

            if ($user_subscription->get()->count() > 0) {

                $user_subscription = User_Subscription::whereHas('subscription', function ($q) {
                    return $q->where('type', 1);
                })->where('subscription_id', $request->package);

                if ($user_subscription->get()->count() == 1) {

                    $user_subscription->first()->update([
                        'duration' =>  $user_subscription->first()->duration + $duration,
                    ]);

                    Transaction_History::create([
                        'user_id' => $id,
                        'subscription_id' => $request->package,
                        'transaction_date' => now(),
                        'duration' => $request->package_duration,
                        'transaction_total' => ($price * 100),
                    ]);
                } else {

                    User_Subscription::create([
                        'user_id' => $id,
                        'subscription_id' => $request->package,
                        'status' => '0',
                        'duration' => $duration,
                    ]);

                    Transaction_History::create([
                        'user_id' => $id,
                        'subscription_id' => $request->package,
                        'transaction_date' => now(),
                        'duration' => $request->package_duration,
                        'transaction_total' => ($price * 100),
                    ]);
                }
            } //
            else {

                User_Subscription::create([
                    'user_id' => $id,
                    'subscription_id' => $request->package,
                    'status' => '1',
                    'duration' => $duration,
                    'subscription_start' => now(),
                    'subscription_end' => now()->addDays(round($duration / 100)),
                ]);

                Transaction_History::create([
                    'user_id' => $id,
                    'subscription_id' => $request->package,
                    'transaction_date' => now(),
                    'duration' => $request->package_duration,
                    'transaction_total' => ($price * 100),
                ]);
            }
        }

        if (isset($request->addon)) {
            foreach ($request->addon as $key => $addon) {

                $duration = 0;
                $durationInfo = $request->addon_duration[$key];
                $price = explode('RM', $request->addon_price[$key])[1];

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
                        'user_id' => $id,
                        'subscription_id' => $request->addon[$key],
                        'status' => '1',
                        'duration' => $duration,
                        'subscription_start' => now(),
                        'subscription_end' => now()->addDays(round($duration / 100)),
                    ]);
                }
                Transaction_History::create([
                    'user_id' => $id,
                    'subscription_id' => $request->addon[$key],
                    'duration' => $request->addon_duration[$key],
                    'transaction_date' => now(),
                    'transaction_total' => ($price * 100),
                ]);
            }
        }

        /* if (isset($request->package)) {

            $package = Subscription::where('id', $request->package)->first();

            if (User_Subscription::whereHas('Subscription', function ($query) {
                return $query->where('type', '1');
            })->get()->count() >= 1) {

                $user_subscription = User_Subscription::where('user_id', $id)
                    ->join('subscription', 'subscription.id', '=', 'subscription_id')
                    ->where('subscription_id', $package->id)->select('user_subscription.*');

                if ($user_subscription->get()->count() > 0) {
                    $user_subscription->first()->update([
                        'duration' =>  $user_subscription->first()->duration + ($package->duration_in_month * $request->duration),
                        'status' => '1',
                    ]);
                } //
                else {
                    User_Subscription::create([
                        'user_id' => $id,
                        'subscription_id' => $package->id,
                        'status' => '0',
                        'duration' => ($package->duration_in_month * $request->duration),
                    ]);
                }

                Transaction_History::create([
                    'user_id' => $id,
                    'subscription_id' => $package->id,
                    'transaction_date' => now(),
                    'transaction_total' => $package->price,
                ]);
            } //
            else {

                $user_subscription = User_Subscription::where('user_id', $id)
                    ->join('subscription', 'subscription.id', '=', 'subscription_id')
                    ->where('subscription_id', $package->id)->select('user_subscription.*');

                if ($user_subscription->get()->count() > 0) {
                    $user_subscription->first()->update([
                        'subscription_end' => now()->addMonth($package->duration_in_month * $request->duration),
                    ]);
                } else {
                    User_Subscription::create([
                        'user_id' => $id,
                        'subscription_id' => $package->id,
                        'status' => '1',
                        'duration' => ($package->duration_in_month * $request->duration),
                        'subscription_start' => now(),
                        'subscription_end' => now()->addMonth($package->duration_in_month),
                    ]);
                }

                Transaction_History::create([
                    'user_id' => $id,
                    'subscription_id' => $package->id,
                    'transaction_date' => now(),
                    'transaction_total' => $package->price * $request->duration,
                    'duration' => $request->duration,
                ]);
            }
        }

        if (isset($request->addon)) {
            foreach ($request->addon as $ad) {
                $addon = Subscription::where('id', $ad)->first();

                $user_and_subscription = User_Subscription::where('user_id', $id)
                    ->join('subscription', 'subscription.id', '=', 'subscription_id')
                    ->where('subscription_id', $addon->id)->select('user_subscription.*');

                if ($user_and_subscription->get()->count() > 0) {
                    $user_and_subscription->first()->update([
                        'subscription_end' => now()->addMonth($addon->duration_in_month),
                    ]);
                } else {
                    User_Subscription::create([
                        'user_id' => $id,
                        'subscription_id' => $addon->id,
                        'status' => '1',
                        'subscription_start' => now(),
                        'subscription_end' => now()->addMonth($addon->duration_in_month),
                    ]);
                }
                Transaction_History::create([
                    'user_id' => $id,
                    'subscription_id' => $addon->id,
                    'transaction_date' => now(),
                    'transaction_total' => $addon->price,
                ]);
            }
        } */

        return view('checkout.success');
    }
}