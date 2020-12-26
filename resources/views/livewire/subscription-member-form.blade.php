<div class="flex flex-col text-white w-full">
    <div class="flex flex-initial p-4 bg-gray-700 rounded-t justify-between items-center">
        <h1 class="text-2xl font-thin"> <i class="fas fa-user px-2"></i> MEMBERSHIP</h1>
        <a href="{{ route('admin') }}" class="bg-indigo-600 p-2 rounded hover:bg-indigo-700">Back to Admin Dashboard</a>
    </div>
    <div class="flex flex-1 flex-row">
        <div class="flex flex-1 p-4 flex-col">
            <h1 class="text-gray-400 text-md">User Subscription</h1>
            <div class="flex flex-initial flex-col">
                <p class="m-2 text-gray-500">Package</p>
                @if ($packages->isEmpty())

                <div class="flex flex-initial mx-4 items-center">
                    <p class="text-black text-sm text-gray-400">None</p>
                </div>

                @else
                @foreach($packages as $package)

                @if($package->status == 0)
                <div class="flex flex-initial m-2 items-center">
                    <p class="text-gray-500 font-medium mr-2">{{ $package->subscription->name }}</p>
                    <div class="bg-yellow-500 p-1 rounded text-xs">IN QUEUE</div>
                </div>
                @else
                <div class="flex flex-initial m-2 items-center">
                    <p class="text-gray-500 font-medium mr-2">{{ $package->subscription->name }}</p>
                    <div class="bg-green-500 p-1 rounded text-xs mr-2">ACTIVE</div>
                    <div class="bg-indigo-500 p-1 rounded text-xs">
                        Expired at {{ Carbon\Carbon::parse($package->subscription_end)->format('l jS F Y') }}
                    </div>
                </div>
                @endif

                @endforeach

                @endif
            </div>
            <div class="flex flex-initial flex-col">
                <p class="m-2 text-gray-500">Addon</p>
                @if ($addons->isEmpty())

                <div class="flex flex-initial mx-4 items-center">
                    <p class="text-black text-sm text-gray-400">None</p>
                </div>

                @else

                @foreach($addons as $addon)

                <div class="flex flex-initial m-2 items-center">
                    <p class="text-gray-500 font-medium mr-2">{{ $addon->subscription->name }}</p>
                    <div class="bg-green-500 p-1 rounded text-xs mr-2">ACTIVE</div>
                    <div class="bg-indigo-500 p-1 rounded text-xs">
                        Expired at {{ Carbon\Carbon::parse($addon->subscription_end)->format('l jS F Y') }}
                    </div>
                </div>

                @endforeach

                @endif
            </div>
        </div>
        <form action="{{ route('add_subscription') }}" method="POST" class="flex flex-1 p-4 flex-col text-gray-600">
            @csrf
            <h1 class="text-gray-400 text-md">Subscription</h1>
            <div class="flex flex-initial flex-col">
                <p class="m-2 text-gray-500">Package</p>
                @foreach($subscription as $subs)
                @if($subs->type == 1)
                <div class="flex flex-initial flex-col m-1 mx-2">
                    <div class="flex flex-initial items-center">
                        <input wire:model="package_select" type="radio" name="package" value="{{ $subs->id }}">
                        <label class="mx-2" for="package">{{ $subs->name }}</label>
                        @if ($subs->trial_able == 1)
                        <div class="bg-yellow-500 px-2 text-white rounded">
                            <input type="checkbox" class="mr-1" name="trial" value="{{ $subs->id }}">
                            <label for="trial" class="">{{ $subs->trial_duration_in_weeks }} WEEKS FREE TRIAL</label>
                        </div>
                        @endif
                    </div>
                    @if ($package_select == $subs->id)
                    <div class="flex flex-initial flex-wrap">
                        @foreach ($subs->duration as $duration)

                        <div class="p-1 rounded bg-indigo-500 mt-2 mr-2 items-center">
                            <input type="radio" class="bg-indigo-500" name="package_info" readonly
                                value="{{ $duration }}">
                            <label for="duration" class="text-white">{{ $duration }}</label>
                        </div>

                        @endforeach
                    </div>
                    @endif
                </div>
                @endif
                @endforeach
            </div>
            <div class="flex flex-initial flex-col">
                <p class="m-2 text-gray-500">Addon</p>
                @foreach($subscription as $subs)
                @if($subs->type == 2)
                <div class="flex flex-initial flex-col mx-2 mb-2">
                    <div class="flex flex-1 items-center">
                        <input wire:model="addon_select" type="checkbox" name="addon[]" value="{{ $subs->id }}">
                        <label class="mx-2" for="addon[]">{{ $subs->name }}</label>
                    </div>
                    @if (in_array($subs->id, $addon_select))
                    <div class="flex flex-initial flex-wrap">
                        @foreach ($subs->duration as $duration)
                        <div class="p-1 rounded bg-indigo-500 mt-2 mr-2 items-center">
                            <input type="radio" class="bg-indigo-500" name="addon_info[{{ $count }}]" readonly
                                value="{{ $duration }}">
                            <label for="duration" class="text-white">{{ $duration }}</label>
                        </div>
                        @endforeach
                        @php $count++ @endphp
                    </div>
                    @endif
                </div>

                @endif
                @endforeach
            </div>
            <input type="hidden" name="id" value="{{ $user_id }}">
            <div class="flex flex-initial">
                <button class="w-2/4 mt-4 bg-green-500 hover:bg-green-600 text-white px-3 py-2"
                    type="submit">SUBSCRIBE</button>
            </div>
        </form>
    </div>
</div>