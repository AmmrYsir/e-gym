@extends('admin.layouts.app')

@section('main')
<div class="flex flex-col text-white w-full">
    <div class="flex flex-initial p-4 bg-gray-700 rounded-t justify-between items-center">
        <h1 class="text-2xl font-thin"> <i class="fas fa-user px-2"></i> MEMBERSHIP</h1>
        <a href="{{ route('admin') }}" class="bg-indigo-600 p-2 rounded hover:bg-indigo-700">Back to Admin Dashboard</a>
    </div>
    <form action="{{ route('member_add') }}" method="POST" class="flex flex-1">
        @csrf
        <div class="flex flex-1 p-4 flex-col text-gray-600 justify-center items-center">
            <h1 class="text-gray-400 text-2xl mb-4">Add New Member</h1>
            <div class="flex flex-initial flex-col my-2">
                <label for="name" class="text-gray-500">Username:</label>
                <input type="text" name="name" class="border p-2 w-64">
            </div>
            <div class="flex flex-initial flex-col my-2">
                <label for="name">Email:</label>
                <input type="text" name="email" class="border p-2 w-64">
            </div>
            <button type="submit" class="bg-green-500 m-4 px-20 py-2 rounded hover:bg-green-600 text-white">ADD</button>
        </div>
</div>
</form>
</div>
@endsection