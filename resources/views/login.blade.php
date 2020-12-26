@extends('navigations.navigation')

@section('title', 'Login')

@section('content')
<main class="flex flex-1 justify-center items-center bg-gray-100">
    <div class="flex flex-col flex-1 items-center text-center text-black py-6">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="fill-current text-black h-8 w-8 mr-2">
            <path
                d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z" />
        </svg>
        <h1 class="text-3xl font-thin">E-GYM</h1>
        <h1 class="text-2xl font-bold">LOG INTO YOUR ACCOUNT</h1>
        <h1>or <a href="{{ url('/signup') }}" class="text-blue-600 font-semibold">you can register new account</a>
        </h1>
        @if(session()->has('message'))
        <div class="flex flex-1 bg-gray-600 text-white p-4 mt-2 w-1/4 justify-center text-center">
            <h1>{{ session()->get('message') }}</h1>
        </div>
        @endif
        <form method="POST" action="/login" class="flex flex-col">
            @csrf
            <div class="mt-4 text-left">
                <label for="email-address" class="">Email address</label>
                <input id="email-address" name="email" type="email" autocomplete="email" required
                    class="appearance-none rounded relative w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="Email address">
            </div>
            <div class="mt-4 text-left">
                <label for="password" class="">Password</label>
                <input id="password" name="password" type="password" required
                    class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="Password">
            </div>

            <div class="flex items-center m-2">
                <input id="remember_me" name="remember_me" type="checkbox"
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                    Remember me
                </label>
            </div>

            <div class="text-sm flex mt-2">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Forgot your password?
                </a>
            </div>

            <button class="my-4 p-2 rounded bg-gray-700 text-lg text-white hover:bg-gray-900">Log In</button>
        </form>
    </div>
</main>
@endsection