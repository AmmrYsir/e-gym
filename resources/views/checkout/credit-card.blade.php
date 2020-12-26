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
        <h1 class="text-gray-500">pay with your card today</h1>
        <form action="{{ route('gateway') }}" id="payment-form" method="POST" class="flex flex-1 flex-row w-96">
            @csrf
            <div class="flex flex-col flex-1 text-left">
                <div class="mt-4">
                    <div class="card-header w-full">
                        <div id="payment-info"
                            class="text-sm text-center text-gray-400 bg-gray-700 p-2 rounded text-white mb-4">
                            <p>You will be charged about
                            <h1 class="text-2xl text-gray-300">MYR {{ $total }}</h1>
                            <div class="flex flex-1 flex-col ">
                                @foreach ($info as $i)
                                <div class="flex flex-1 flex-row items-center justify-center">
                                    <input class="mr-4" type="hidden" name="{{ $i[4] == 1 ? 'package' : 'addon[]' }}"
                                        value="{{ $i[0] }}">
                                    <input type="hidden"
                                        name="{{ $i[4] == 1 ? 'package_duration' : 'addon_duration[]' }}"
                                        value="{{ $i[2] }}">
                                    <input type="hidden" name="{{ $i[4] == 1 ? 'package_price' : 'addon_price[]' }}"
                                        value="{{ $i[3] }}">
                                    <label for="">{{ $i[1] }} | {{ $i[2] }}</label>
                                </div>
                                @endforeach
                            </div>
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <label for="card-element">
                            Enter your card information below:
                        </label>
                        <div id="card-element"
                            class="rounded relative block px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="card-name" class="">Name on card</label>
                    <input id="card-name" name="card-name" type="text" required
                        class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Name on card">
                    @error('card-name')
                    <strong class="text-sm font-thin text-red-500 px-2 block">* {{ $message }}</strong>
                    @enderror
                </div>
                <div class="mt-4 flex flex-col">
                    <label for="card-name" class="">Country</label>
                    <select id="Currency" name="currency"
                        class="rounded relative block w-full p-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        <option>Malaysia</option>
                        <option>Indonesia</option>
                        <option>Brunei</option>
                        <option>Singapura</option>
                    </select>
                </div>
                <button id="card-button"
                    class="w-full my-4 p-2 rounded bg-gray-700 text-lg text-white hover:bg-gray-900"
                    data-secret="{{ $intent }}">Pay</button>
            </div>
        </form>
    </div>
</main>
<script src="https://js.stripe.com/v3/"></script>
<script>
var style = {
    base: {
        color: '#32325d',
        lineHeight: '18px',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

const stripe = Stripe('{{ $stripe_key }}', {
    locale: 'en'
});

const elements = stripe.elements(); // Create an instance of Elements.
const cardElement = elements.create('card', {
    style: style
});

const cardButton = document.getElementById('card-button');
const clientSecret = cardButton.dataset.secret;

cardElement.mount('#card-element'); // Add an instance of the card Element into the `card-element` <div>.

cardElement.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission.
var form = document.getElementById('payment-form');

form.addEventListener('submit', function(event) {
    event.preventDefault();

    stripe.handleCardPayment(clientSecret, cardElement, {
            payment_method_data: {}
        })
        .then(function(result) {
            console.log(result);
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                console.log(result);
                form.submit();
            }
        });
});
</script>
@endsection