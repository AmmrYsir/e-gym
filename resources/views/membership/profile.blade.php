@extends('navigations.navigation_user')

@section('title', 'User')

@section('content')
<div class="flex flex-1 flex-col items-center w-full bg-gray-100">
    <div class="flex flex-col flex-initial w-4/5 mt-2">
        <div class="flex flex-1 mx-2 p-4 w-full bg-indigo-500 text-white rounded-t">
            <h1>Your Dashboard \<a href="/home" class="m-1 hover:text-gray-300 p-1 ">Home</a>\<a href="/profile"
                    class="m-1 hover:text-gray-300 p-1 ">Profile</a> </h1>
        </div>
        <div class="flex flex-initial flex-row m-2 p-4 bg-white shadow-md w-full">
            <form action="/profile" method="POST" class="flex flex-col pl-2 w-full">
                @csrf
                <div class="flex flex-1 text-gray-500 mb-4">
                    <h1>Your Profile</h1>
                </div>
                <div class="flex flex-1 flex-row w-2/4 mb-4">
                    <div class="flex flex-1 flex-col mr-4">
                        <label for="name" class="text-gray-700">Username:</label>
                        <input name="name" type="text" class="p-2 border rounded" value="{{ $user->name }}">
                    </div>
                    <div class="flex flex-1 flex-col mr-4">
                        <label for="age" class="text-gray-700">Age:</label>
                        <input name="age" type="text" maxlength="2" class="p-2 w-1/4 border rounded"
                            value="{{ $user->age }}">
                    </div>

                </div>
                <div class="flex flex-1 flex-row w-2/4 mb-4">
                    <div class="flex flex-1 flex-col mr-4">
                        <label for="firstname" class="text-gray-700">First Name:</label>
                        <input name="firstname" type="text" maxlength="32" class="p-2 border rounded"
                            value="{{ $user->firstname }}">
                    </div>
                    <div class="flex flex-1 flex-col mr-4">
                        <label for="lastname" class="text-gray-700">Last Name:</label>
                        <input name="lastname" type="text" maxlength="24" class="p-2 border rounded"
                            value="{{ $user->lastname }}">
                    </div>

                </div>
                <div class="flex flex-1 flex-row w-2/4 mb-4">
                    <div class="flex flex-1 flex-col">
                        <label for="address" class="text-gray-700">Address:</label>
                        <input name="address" type="text" class="p-2 border rounded" value="{{ $user->address }}">
                    </div>
                </div>
                <div class="flex flex-1 flex-row w-2/4 mb-4">
                    <div class="flex flex-1 flex-col">
                        <label for="phone_number" class="text-gray-700">Phone Number:</label>
                        <input name="phone_number" type="text" maxlength="12" class="p-2 border rounded"
                            value="{{ $user->phone_number }}">
                    </div>
                </div>
                <div class="flex flex-1 flex-row w-2/4 mb-4">
                    <button class="w-full bg-green-600 text-white hover:bg-green-700 px-4 py-2">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
    @endsection