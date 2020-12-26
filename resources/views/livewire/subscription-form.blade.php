<form action="{{ route('checkout') }}" method="POST" class="flex flex-col pl-2 w-full">
    @csrf
    <div class="flex flex-1 text-gray-500 mb-4">
        <h1>Subscription Plan</h1>
    </div>
    @foreach ($packages as $package)
    <div class="flex flex-1 pl-4 items-center">
        <input wire:model="selectedPackage" type="radio" name="package" id="package" value="{{ $package->id }}">
        <label class="mx-4" for="">{{ $package->name }}</label>
    </div>
    <div class="flex flex-initial mx-4 flex-wrap">
        @if ($selectedPackage == $package->id)
        @foreach ($package->duration as $key => $duration)
        <div class="flex flex-initial items-center m-2 bg-indigo-500 p-1 rounded text-white">
            <input wire:model="selectedPackageDuration" class="mr-2 bg-indigo-500" name="packageDuration" type="radio"
                value="{{ $duration }}">
            <label for="">{{ $duration }}</label>
        </div>
        @endforeach
        @endif
    </div>
    @endforeach

    <div class="flex flex-1 text-gray-500 mb-4 mt-4">
        <h1>Adds On</h1>
    </div>

    @foreach ($addOns as $addOn)

    @if ($addOn->parent_id == $selectedPackage)
    <div class="flex flex-1 pl-4 items-center">
        <input wire:model="selectedAddOns" type="checkbox" name="addon[]" id="addon" value="{{ $addOn->id }}">
        <label class="mx-4" for="">{{ $addOn->name }}</label>
    </div>
    <div class="flex flex-initial mx-4 flex-wrap">
        @if (in_array($addOn->id, $selectedAddOns))
        @foreach ($addOn->duration as $duration)
        <div class="flex flex-initial items-center m-2 bg-indigo-500 p-1 rounded text-white">
            <input class="mr-2 bg-indigo-500" name="addonDuration[{{ $count }}]" type="radio" value="{{ $duration }}">
            <label for="">{{ $duration }}</label>
        </div>
        @endforeach
        @php $count++ @endphp
        @endif
    </div>


    @elseif ($addOn->parent_id == 0)


    <div class="flex flex-1 pl-4 items-center">
        <input wire:model="selectedAddOns" type="checkbox" name="addon[]" id="addon" value="{{ $addOn->id }}">
        <label class="mx-4" for="">{{ $addOn->name }}</label>
    </div>
    <div class="flex flex-initial mx-4 flex-wrap">
        @if (in_array($addOn->id, $selectedAddOns))
        @foreach ($addOn->duration as $duration)
        <div class="flex flex-initial items-center m-2 bg-indigo-500 p-1 rounded text-white">
            <input class="mr-2 bg-indigo-500" name="addonDuration[{{ $count }}]" type="radio" value="{{ $duration }}">
            <label for="">{{ $duration }}</label>
        </div>
        @endforeach
        @php $count++ @endphp
        @endif
    </div>

    @endif

    @endforeach

    <div class="flex flex-1 mt-4 pl-4 items-center">
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Checkout</button>
    </div>

</form>