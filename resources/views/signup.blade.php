@extends('navigations.navigation')

@section('title', 'Registration')

@section('content')
<main class="flex flex-1 justify-center items-center bg-gray-100">
    <div class="flex flex-col flex-1 items-center text-center text-black py-6">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="fill-current text-black h-8 w-8 mr-2">
            <path
                d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z" />
        </svg>
        <h1 class="text-3xl font-thin">E-GYM</h1>
        <h1 class="text-2xl font-bold">REGISTER YOUR ACCOUNT</h1>
        <h1>or <a href="{{ route('login') }}" class="text-blue-500 font-semibold">you can login with existing
                account</a>
        </h1>
        <form action="{{ route('register') }}" method="POST" class="flex flex-row">
            @csrf
            <div class="signup-form flex flex-col flex-1 text-left">
                <div class="mt-4">
                    <label for="email-address" class="">Email address</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required
                        class="appearance-none rounded relative w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Email address">
                    @error('email')
                    <strong class="text-sm font-thin text-red-500 px-2 block">* {{ $message }}</strong>
                    @enderror
                </div>
                <div class="mt-4">
                    <label for="name" class="">Username</label>
                    <input id="name" name="name" type="text" required
                        class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Username">
                    @error('name')
                    <strong class="text-sm font-thin text-red-500 px-2 block">* {{ $message }}</strong>
                    @enderror
                </div>
                <div class="mt-4">
                    <label for="password" class="">Password</label>
                    <input id="password" name="password" type="password" required
                        class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Password">
                    @error('password')
                    <strong class="text-sm font-thin text-red-500 px-2 block">* {{ $message }}</strong>
                    @enderror
                </div>
                <div class="mt-4">
                    <label for="password_confirmation" class="">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Confirm Password">
                    @error('password_confirmation')
                    <strong class="text-sm font-thin text-red-500 px-2 block">* {{ $message }}</strong>
                    @enderror
                </div>
                <button class="w-full my-4 p-2 rounded bg-gray-700 text-lg text-white hover:bg-gray-900">Sign
                    up</button>
            </div>
        </form>
    </div>
</main>
@endsection