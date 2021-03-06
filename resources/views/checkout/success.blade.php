@extends('navigations.navigation')

@section('title', 'Registration')

@section('content')

@php
$stripe_key =
'pk_test_51HgmW0Hf8OTLHWD64cpFSBJ9xOk66fr18L0U2O8I8abEdezpm6wg65StRQ8gy8JvdwvObQseHjllOPzIQj2KqUwf00DBlZOWZ8';
@endphp

<main class="flex flex-1 justify-center items-center bg-gray-100">
    <div class="flex flex-col flex-1 items-center text-center text-black py-6">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="fill-current text-black h-8 w-8 mr-2">
            <path
                d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z" />
        </svg>
        <h1 class="text-3xl font-thin">E-GYM</h1>
        <h1 class="text-2xl font-bold">PAYMENT GATEWAY</h1>
        <h1 class="text-gray-500">You have successfully subscribe a new membership package!</h1>
        <a href="/home" class="p-2 bg-green-400 text-white hover:bg-green-600 m-2 rounded">Go back to Home</a>
    </div>
</main>
@endsection