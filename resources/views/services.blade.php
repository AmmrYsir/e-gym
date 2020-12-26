@extends('navigations.navigation')

@section('title', 'Services')

@section('content')
<main class="flex flex-auto bg-gym-texture bg-cover">
    <div class="flex flex-col flex-1 items-center justify-center text-center bg-black bg-opacity-50 text-white">
        <h1 class="text-base md:text-7xl font-thin m-2">Welcome to E-GYM</h1>
        <p class="w-1/2">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aspernatur amet
            asperiores,
            sapiente minus
            libero architecto atque fugiat voluptas esse ducimus ipsam aliquid consequatur, minima excepturi?
        </p>
        <div class="flex">
            <button class="bg-gray-800 p-4 my-2 rounded hover:bg-gray-900 mx-2"><a href="{{ url('/about') }}">GET
                    STARTED</a></button>
            <button class="bg-green-600 p-4 my-2 rounded hover:bg-green-700"><a href="{{ url('/login') }}">ALREADY HAVE
                    ACCOUNT? LOG IN NOW</a></button>
        </div>
    </div>
</main>
@endsection