@extends('admin.layouts.app')

@section('main')
<div class="flex flex-col text-white w-full">
    <div class="flex flex-initial p-4 bg-gray-700 rounded-t justify-between items-center">
        <h1 class="text-2xl font-thin"> <i class="fas fa-user px-2"></i> MEMBERSHIP</h1>
        <a href="{{ route('admin') }}" class="bg-indigo-600 p-2 rounded hover:bg-indigo-700">Back to Admin Dashboard</a>
    </div>
    <form action="{{ route('member_edit') }}" method="POST" class="flex flex-1 flex-row">
        @csrf
        <div class="flex flex-1 p-4 flex-col text-gray-600">
            <h1 class="text-gray-500 text-md">User Information</h1>
            <div class="flex flex-initial p-2 flex-col w-2/4">
                <label for="name" class="text-gray-500">Username:</label>
                <input name="name" type="text" class="rounded border-2 p-2 text-xl" value="{{ $user->name }}">
            </div>
            <div class="flex flex-initial p-2 flex-col w-3/4">
                <label for="email" class="text-gray-500">Email:</label>
                <input name="email" type="text" class="rounded border-2 p-2 text-xl" value="{{ $user->email }}">
            </div>
            <div class="flex flex-initial p-2 flex-col w-3/4">
                <a href="" class="rounded bg-green-500 text-center text-white p-2">Reset Password</a>
            </div>
        </div>
        <div class="flex flex-1 p-4 flex-col text-gray-600">
            <h1 class="text-gray-500 text-md">Profile Information</h1>
            <div class="flex flex-initial">
                <div class="flex flex-initial p-2 flex-col w-2/4">
                    <label for="firstname" class="text-gray-500">Firstname:</label>
                    <input name="firstname" type="text" class="rounded border-2 p-2 text-xl"
                        value="{{ $user->profile->firstname }}">
                </div>
                <div class="flex flex-initial p-2 flex-col w-2/4">
                    <label for="lastname" class="text-gray-500">Lastname:</label>
                    <input name="lastname" type="text" class="rounded border-2 p-2 text-xl"
                        value="{{ $user->profile->lastname }}">
                </div>
            </div>
            <div class="flex flex-initial">
                <div class="flex flex-initial p-2 flex-col w-3/4">
                    <label for="phone_number" class="text-gray-500">Phone Number:</label>
                    <input name="phone_number" type="text" class="rounded border-2 p-2 text-xl"
                        value="{{ $user->profile->phone_number }}">
                </div>
                <div class="flex flex-initial p-2 flex-col w-1/4">
                    <label for="age" class="text-gray-500">Age:</label>
                    <input name="age" type="text" class="rounded border-2 p-2 text-xl"
                        value="{{ $user->profile->age }}">
                </div>
            </div>
            <div class="flex flex-initial p-2 flex-col">
                <label for="address" class="text-gray-500">Address:</label>
                <input name="address" type="text" class="rounded border-2 p-2 text-xl"
                    value="{{ $user->profile->address }}">
            </div>
            <button class="bg-yellow-500 m-2 p-2 rounded hover:bg-yellow-600 text-white">EDIT</button>
        </div>
    </form>
</div>
@endsection