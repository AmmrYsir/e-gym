@extends('admin.layouts.app')

@section('main')
<div class="flex flex-col text-white w-full">
    <div class="flex flex-initial p-4 bg-gray-700 rounded-t justify-between items-center">
        <h1 class="text-2xl font-thin"> <i class="fas fa-user px-2"></i> MEMBERSHIP</h1>
        <form action="{{ route('process') }}" method="POST">
            @csrf
            <button type="submit" class="bg-green-500 p-2 px-4 rounded hover:bg-green-600">Process</button>
            <a href="{{ route('member_add_view') }}" class="bg-indigo-600 p-2 rounded hover:bg-indigo-700">Add New
                Member</a>
        </form>
    </div>
    <div class="flex flex-1">
        <table class="w-full table-auto">
            <thead class="justify-between">
                <tr class="bg-gray-800">
                    <th class="py-2">
                        <span class="text-gray-300">Name</span>
                    </th>

                    <th class="">
                        <span class="text-gray-300">Membership Point</span>
                    </th>

                    <th class="">
                        <span class="text-gray-300">Subscription</span>
                    </th>

                    <th class="">
                        <span class="text-gray-300">Action</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-200 w-full">
                @foreach ($users as $user)
                <tr class="bg-white border-gray-200 text-center">

                    <td class="flex flex-row py-4 text-gray-600 items-center justify-around h-full">
                        <i class="fas fa-user"></i>
                        <p>{{ $user->email }}</p>
                    </td>

                    <td class="p-2">
                        <h1 class="text-gray-700 text-xlg">
                            {{ $user->profile->membership_point }}
                        </h1>
                    </td>

                    <td class="p-2">
                        <a class="bg-yellow-500 px-3 py-1 rounded hover:bg-yellow-600"
                            href="admin/member/subscription/{{ $user->id }}">Manage Subscription</a>
                    </td>

                    <td class="p-2 flex justify-center">
                        <a href="admin/member/{{ $user->id }}"
                            class="bg-green-500 px-3 py-1 rounded hover:bg-green-600">Edit</a>
                        <form action="admin/member/delete/{{ $user->id }}" method="POST" class="mx-2">
                            @csrf
                            <button class="bg-red-500 px-3 py-1 rounded hover:bg-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection