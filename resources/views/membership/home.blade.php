@extends('navigations.navigation_user')

@section('title', 'User')

@section('content')
<div class="flex flex-1 flex-col items-center w-full bg-gray-100">
    <div class="flex flex-col flex-initial w-4/5 mt-2">
        @if (\Session::has('message'))
        <div class="flex flex-1 justify-center mx-2 mb-2 p-4 w-full bg-green-500 text-white rounded">
            <h1>{{ Session::get('message') }}</h1>
        </div>
        @endif
        <div class="flex flex-1 mx-2 p-4 w-full bg-indigo-500 text-white rounded-t">
            <h1>Your Dashboard \<a href="/home" class="m-1 hover:text-gray-300 p-1 ">Home</a>\<a href="/profile"
                    class="m-1 hover:text-gray-300 p-1 ">Profile</a> </h1>
        </div>
        <div class="flex flex-initial flex-row m-2 p-4 bg-white shadow-md w-full">
            <div class="flex flex-col pl-2">
                <div class="flex flex-1 items-center text-gray-500">
                    <h1>Your Membership</h1>
                </div>
                <div class="flex flex-1 items-center m-2">
                    @if (isset($package))
                    @if ($package->trial == 1)
                    <span class="bg-indigo-500 hover:bg-indigo-600 text-white px-2 rounded mr-2 font-bold">TRIAL</span>
                    @endif
                    <h1 class="text-center mr-2">{{ $package->subscription->name }}</h1>
                    <a href="/subscription"
                        class="bg-yellow-500 p-1 text-white rounded outline-none hover:bg-yellow-600">

                        <span class="">Renew</span>

                    </a>
                    @else
                    <h1 class="text-center mr-2">Free Membership</h1>
                    <a href="/subscription"
                        class="bg-yellow-500 px-2 py-1 text-white rounded outline-none hover:bg-yellow-600">Upgrade
                        to
                        <span>PRO</span></a>
                    @endif
                </div>
                <div class="flex flex-1 items-center text-gray-500">
                    <h1>Addons</h1>
                </div>
                @if (count($addons) > 0)
                @foreach($addons as $addon)
                <div class="flex flex-1 flex-row items-center m-2">
                    <h1 class="mr-2">{{ $addon->name }}</h1>
                    <sup class="bg-indigo-500 text-white rounded p-1 text-xs font-bold">
                        {{ Carbon\Carbon::parse($addon->subscription_end)->format('jS F Y') }}
                    </sup>
                </div>
                @endforeach
                @else
                <div class="flex flex-1 flex-col m-2">
                    <p class="text-gray-400">You doesn't subscribe any addons package.</p>
                    <a href="/subscription"
                        class="p-1 bg-green-500 hover:bg-green-600 text-center text-white rounded outline-none">Go to
                        Subscription Plan</a>
                </div>
                @endif
            </div>
            <div class="flex flex-1 flex-col text-right">
                <p class="text-gray-500">Your Membership Points:</p>
                <h1 class="text-4xl">{{ $profile->membership_point }}</h1>
            </div>
        </div>
        <div class="flex flex-initial flex-col m-2 p-4 bg-white shadow-md w-full">
            <h1 class="text-gray-500 mb-4">Transaction History</h1>
            <table class="w-full table-auto">
                <thead class="justify-between">
                    <tr class="bg-gray-100">
                        <th class="p-4">
                            <span class="text-gray-600 font-normal">ORDER ID</span>
                        </th>

                        <th class="">
                            <span class="text-gray-600 font-normal">TRANSACTION DATE</span>
                        </th>

                        <th class="">
                            <span class="text-gray-600 font-normal">SUBSCRIPTION PLAN</span>
                        </th>

                        <th class="">
                            <span class="text-gray-600 font-normal">SUBSCRIPTION LENGTH</span>
                        </th>

                        <th class="">
                            <span class="text-gray-600 font-normal">AMOUNT</span>
                        </th>

                    </tr>
                </thead>
                <tbody class="bg-gray-200">
                    @foreach ($transactions as $transaction)
                    <tr class="bg-white border-gray-200 text-center">
                        <td class="flex flex-row p-2 text-gray-600 items-center justify-around h-full">
                            <p>{{ $transaction->id }}</p>
                        </td>

                        <td class="p-2">
                            <p>{{ $transaction->transaction_date }}</p>
                        </td>

                        <td class="p-2">
                            <p>{{ $transaction->name }}</p>
                        </td>

                        <td class="p-2">
                            <p>{{ $transaction->duration }}
                            </p>
                        </td>

                        <td class="p-2">
                            <p>RM{{ $transaction->transaction_total/100 }} </p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection