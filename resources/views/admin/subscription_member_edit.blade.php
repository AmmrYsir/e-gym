@extends('admin.layouts.app')

@section('main')
<div class="flex flex-col text-white w-full">
    <div class="flex flex-initial p-3 bg-gray-700 rounded-t justify-between items-center">
        <div class="flex flex-initial">
            <a class="bg-green-500 px-4 py-2 rounded bg-indigo-500" href="{{ route('subscription') }}">Go Back</a>
        </div>
        <div class="flex flex-initial">
            <h1 class="text-2xl font-thin"> {{ $subscription->name }} | <i class="fas fa-user px-2"></i> SUBSCRIPTION
            </h1>
        </div>
    </div>
    @if (\Session::has('success'))
    <div class="flex flex-initial mx-2">
        <h1 class="bg-green-500 w-full my-2 p-2 rounded text-center">
            {!! \Session::get('success') !!}
        </h1>
    </div>
    @endif
    @if($errors->any())
    <div class="flex flex-initial mx-2">
        <h1 class="bg-red-500 w-full my-2 p-2 rounded text-center">
            {{ implode('', $errors->all('<div>:message</div>')) }}
        </h1>
    </div>

    @endif
    @livewire('subscription-member-form-edit', ['subscription' => $subscription, 'id' => $id, 'subscription_types' =>
    $subscription_types])
</div>
@endsection