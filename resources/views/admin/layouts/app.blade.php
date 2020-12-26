@extends('navigations.navigation_user')

@section('title', 'Admin')

@section('content')
<div class="flex h-screen overflow-hidden">
    <div class="flex flex-initial">
        <nav class="flex flex-1 flex-col bg-gray-800 text-white py-2 w-full">
            <h1 class="text-4xl font-thin px-16 py-2">ADMIN</h1>
            <ul class="flex flex-col">
                <a href="{{ route('admin') }}"
                    class="flex block p-3 text-gray-400 hover:bg-gray-900 text-center cursor-pointer items-center">
                    <i class="fas fa-users px-4"></i>
                    <p class="">Member</p>
                </a>
                <a href="{{ route('subscription') }}"
                    class="flex block p-3 text-gray-400 hover:bg-gray-900 text-center cursor-pointer items-center">
                    <i class="fas fa-cube px-4"></i>
                    <p class="">Subscription</p>
                </a>
            </ul>
        </nav>
    </div>
    <div class="flex flex-1 p-8 bg-gray-300">
        <div class="flex flex-1 bg-gray-100 shadow-lg">
            @yield('main')
        </div>
    </div>
</div>
@endsection