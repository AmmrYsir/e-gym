<form action="{{ route('edit_subscription', ['id' => $user_id]) }}" method="POST"
    class="flex flex-1 p-4 flex-col text-gray-600">
    @csrf
    <h1 class="text-gray-400 text-md">Edit Subscription</h1>
    <div class="flex flex-col w-1/4 m-2">
        <label for="name">Name:</label>
        <input wire:model="name" type="text" name="name" class="px-2 py-1 border rounded">
    </div>
    <div class="flex flex-col w-2/4 m-2">
        <label for="desc">Description:</label>
        <input wire:model="desc" type="text" name="desc" class="px-2 py-1 border rounded">
    </div>
    <div class="flex flex-row m-2">
        <label for="type">Type:</label>
        <div class="flex flex-col mx-2">
            @foreach ($subscription_types as $subs_type)

            <div class="flex items-center">
                <input wire:model="type" id="type" type="radio" class="mr-2" name="type" value="{{ $subs_type->id }}" />
                <label for="type">{{ $subs_type->name }}</label>
            </div>

            @endforeach
        </div>
        <div class="flex flex-row mx-4 items-center">
            <input wire:model="trial_able" class="mx-2" type="checkbox" name="trial_able" value="1">
            <label for="trial_able">Have a trial</label>
        </div>
        @if ($trial_able == 1)
        <div class="flex flex-col items-center w-12">
            <label for="">Week:</label>
            <input wire:model="trial_duration_in_weeks" max="36" maxlength="2"
                class="mx-2 w-full rounded border p-1 text-center" type="text" name="trial_duration_in_weeks">
        </div>
        @endif
    </div>

    @if ($type == 2)
    <div class="flex flex-row w-1/4 m-2" id="scope">
        <div class="flex flex-1 flex-col mr-2">
            <label for="parent">Scope:</label>
            <select id="parent_id" name="parent_id" class="rounded border px-2 py-1">
                <option value="0">Global</option>
                @foreach($subscriptions as $sub)
                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @else
    <input type="hidden" name="parent_id" value="0">
    @endif

    <div class="flex flex-row m-2">
        <label for="subscription_price" class="mr-2">Duration: </label>
        <div class="flex flex-row mr-2 border">
            <select wire:model="duration_value" id="duration_value" value="1">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
            </select>
        </div>
        <div class="flex flex-row mr-2 border">
            <select wire:model="duration_type" id="duration_type" value="Week">
                <option value="Week">Week</option>
                <option value="Month">Month</option>
                <option value="Year">Year</option>
            </select>
        </div>
        <div class="flex flex-row mr-2 border">
            <input wire:model="duration_price" id="duration_price" class="text-center" type="text" class="px-2" size="3"
                placeholder="RM30" maxlength="3" value="">
        </div>
        <i wire:click="addNewDuration" id="addDuration"
            class="bg-green-500 hover:bg-green-600 rounded px-2 py-1 cursor-pointer"><i
                class="fas fa-plus text-white "></i></i>
    </div>
    @error('duration')
    <div class="flex mx-2">
        <p class="text-red-500 text-xs">You have to create atleast one
            subscription plan duration</p>
    </div>
    @enderror
    <div id="durationSpace" class="flex flex-initial m-2 flex-wrap">
        @foreach ($durations as $key => $duration)
        <div class="flex flex-initial items-center rounded bg-yellow-500 text-white text-center mb-2 mr-2 px-2 py-1">
            <input type="text" class="bg-yellow-500 mr-2" size="12" value="{{ $duration }}" readonly="readonly"
                name="duration[{{ $key }}]">
            <label wire:click="removeSelectedDuration({{ $key }})"
                class="delete far fa-trash-alt text-white bg-red-500 rounded p-2 text-xs cursor-pointer"
                for="duration[{{ $key }}]"></label>
        </div>
        @endforeach
    </div>
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded m-2 w-2/4">Edit
        Subscription</button>
</form>