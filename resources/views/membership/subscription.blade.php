@extends('navigations.navigation_user')

@section('title', 'User')

@section('content')
<div class="flex flex-1 flex-col items-center w-full bg-gray-100">
    <div class="flex flex-col flex-initial w-4/5 mt-2">
        <div class="flex flex-1 mx-2 p-4 w-full bg-indigo-500 text-white rounded-t">
            <a href="/home" class="py-2 px-4 bg-indigo-600 rounded hover:bg-indigo-700">Back to Dashboard</a>
        </div>
        <div class="flex flex-initial m-2 p-4 bg-white shadow-md w-full">
            @livewire('subscription-form', ['packages' => $packages, 'addOns' => $addOns])
        </div>
    </div>
</div>
@endsection