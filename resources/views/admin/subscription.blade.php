@extends('admin.layouts.app')

@section('main')
<div class="flex flex-col text-white w-full">
    <div class="flex flex-initial p-4 bg-gray-700 rounded-t justify-between items-center">
        <h1 class="text-2xl font-thin"> <i class="fas fa-user px-2"></i> SUBSCRIPTION</h1>
    </div>
    @if (\Session::has('success'))
    <div class="flex flex-initial mx-2">
        <h1 class="bg-green-500 w-full my-2 p-2 rounded text-center">
            {!! \Session::get('success') !!}
        </h1>
    </div>
    @endif
    @if ($errors->any())
    <div class="flex flex-initial mx-2">
        <h1 class="bg-red-500 w-full my-2 p-2 rounded text-center">
            {{ implode('', $errors->all(':message')) }}
        </h1>
    </div>
    @endif
    <div class="flex flex-1">
        <div class="flex flex-1 p-4 flex-col text-gray-600">
            <h1 class="text-gray-400 text-md">Subscription</h1>
            <div class="flex flex-initial flex-col">
                <p class="m-2 text-gray-500">Package</p>
                @foreach($subscription as $subs)
                @if($subs->type == 1)
                <div class="flex flex-initial mx-2 my-1 items-center">
                    <p class="mx-2">- {{ $subs->name }}
                    </p>
                    <a href="/admin/subscription/delete/{{ $subs->id }}"
                        class="far fa-trash-alt text-red-500 text-xs"></a>
                    <a href="/admin/subscription/edit/{{ $subs->id }}"
                        class="ml-2 fas fa-edit text-green-500 text-xs"></a>
                </div>
                @endif
                @endforeach
            </div>
            <div class="flex flex-initial flex-col">
                <p class="m-2 text-gray-500">Addon</p>
                @foreach($subscription as $subs)
                @if($subs->type == 2)
                <div class="flex flex-initial mx-2 my-1 items-center">
                    <p class="mx-2">- {{ $subs->name }}</p>
                    <a href="/admin/subscription/delete/{{ $subs->id }}"
                        class="far fa-trash-alt text-red-500 text-xs"></a>
                    <a href="/admin/subscription/edit/{{ $subs->id }}"
                        class="ml-2 fas fa-edit text-green-500 text-xs"></a>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <form action="{{ route('add_new_subscription') }}" method="POST" class="flex flex-1 p-4 flex-col text-gray-600">
            @csrf
            <h1 class="text-gray-400 text-md">Add New Subscription</h1>
            <div class="flex flex-col w-2/4 m-2">
                <label for="name">Name:</label>
                <input type="text" name="name" class="px-2 py-1 border rounded">
            </div>
            <div class="flex flex-col w-3/4 m-2">
                <label for="desc">Description:</label>
                <input type="text" name="desc" class="px-2 py-1 border rounded">
            </div>
            <div class="flex flex-row m-2">
                <label for="type">Type:</label>
                <div class="flex flex-col mx-2">
                    @foreach ($subscription_types as $subs_type)

                    <div class="flex items-center">
                        <input id="type" type="radio" class="mr-2" name="type" value="{{ $subs_type->id }}" />
                        <label for="type">{{ $subs_type->name }}</label>
                    </div>

                    @endforeach
                </div>
                <div class="flex flex-row mx-4 items-center">
                    <input class="mx-2" type="checkbox" name="trial_able" id="trial_able" value="1">
                    <label for="trial_able">Have a trial</label>
                </div>
                <div class="hidden flex flex-col items-center w-12" id="trial_input">
                    <label for="">Week:</label>
                    <input max="36" maxlength="2" class="mx-2 w-full rounded border p-1 text-center" type="text"
                        name="trial_duration" id="" value="4">
                </div>
            </div>
            <div class="hidden flex flex-row w-3/4 m-2" id="scope">
                <div class="flex flex-1 flex-col mr-2">
                    <label for="parent">Scope:</label>
                    <select id="parent" name="parent" class="rounded border px-2 py-1">
                        <option value="0">Global</option>
                        @foreach($subscription as $subs)
                        @if ($subs->type == 1)
                        <option value="{{ $subs->id }}">{{ $subs->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex flex-row m-2">
                <label for="subscription_price" class="mr-2">Duration: </label>
                <div class="flex flex-row mr-2 border">
                    <select id="duration_1" id="">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                    </select>
                </div>
                <div class="flex flex-row mr-2 border">
                    <select id="duration_2" name="" id="">
                        <option value="Week">Week</option>
                        <option value="Month">Month</option>
                        <option value="Year">Year</option>
                    </select>
                </div>
                <div class="flex flex-row mr-2 border">
                    <input id="duration_3" class="text-center" type="text" class="px-2" size="3" placeholder="RM30"
                        maxlength="3" value="">
                </div>
                <i id="addDuration" class="bg-green-500 hover:bg-green-600 rounded px-2 py-1 cursor-pointer"><i
                        class="fas fa-plus text-white "></i></i>
            </div>
            @error('duration')
            <div class="flex mx-2">
                <p class="text-red-500 text-xs">You have to create atleast one
                    subscription plan duration</p>
            </div>
            @enderror
            <div id="durationSpace" class="flex flex-initial m-2 flex-wrap">
            </div>
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded m-2 w-2/4">Add New
                Subscription</button>
        </form>
    </div>
</div>

<script>
let typeRadioButton = getAll('#type');
let scopeDiv = get('#scope');

let addDurationBtn = get('#addDuration');

let trialBtn = get('#trial_able')

onClick(trialBtn, () => {
    if (trialBtn.checked) get('#trial_input').classList.remove('hidden')
    else get('#trial_input').classList.add('hidden')
})

typeRadioButton.forEach(radioButton => {
    onClick(radioButton, () => {
        if (radioButton.checked && radioButton.value == 2) {
            if (scopeDiv.classList.contains('hidden')) {
                scopeDiv.classList.remove('hidden')
            }
        } else {
            if (!scopeDiv.classList.contains('hidden')) {
                scopeDiv.classList.add('hidden')
                get('#parent').value = 0
            }
        }
    })
})

onClick(addDurationBtn, () => {

    if (get('#durationSpace').childElementCount < 5) {
        if (get('#duration_3').value.length > 0) {
            let div = document.createElement('div')
            let input = document.createElement('input')
            let i = document.createElement('i')

            div.setAttribute("class",
                "flex flex-initial items-center rounded bg-yellow-500 text-white text-center mb-2 mr-2 px-2 py-1"
            )
            input.setAttribute("class", "bg-yellow-500 mr-2")
            input.setAttribute("size", "12")
            input.setAttribute("readonly", "readonly")
            input.setAttribute("value", get("#duration_1").value + ' ' + get("#duration_2").value + ' | RM' +
                get(
                    '#duration_3').value)
            input.setAttribute("name", "duration[]")
            i.setAttribute("class",
                "delete far fa-trash-alt text-white bg-red-500 rounded p-1 text-xs cursor-pointer")

            div.appendChild(input);
            div.appendChild(i);

            get("#durationSpace").appendChild(div)

            getAll('.delete').forEach(element => {
                onClick(element, () => {
                    element.parentElement.remove();
                })
            })
        } else {
            alert('Please enter subscription plan price');
        }
    } else {
        alert('You have exceed the limit!')
    }

})


// Function 

function onClick(el, func) {
    el.addEventListener('click', func);
}

function get(el) {
    return document.querySelector(el);
}

function getAll(el) {
    return document.querySelectorAll(el);
}
</script>
@endsection