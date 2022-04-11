@extends('main.index', ['title' => "Payment"])

@section('navbrand')
    <img src="{{ asset('img/headset.svg') }}" width="30" height="30" alt="">
@endsection

@section('styles')
    <style>
        label{
            font-size: 12px;
        }
    </style>
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #ecf0f1">
        <div class="my-5">
{{-- 
            <div class="container-fluid py-5">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4 text-black mb-5">
                        <div class="text-center">
                            <img class="img-fluid mb-4 w-25" 
                            src="{{ asset('img/exclamation-black.svg') }}" 
                            alt="...">
                        </div>
                    </div>
                </div>
            </div> --}}

            <section class="ftco-section">
                <div class="container">

                    <div class="text-center">
                        <h1 class="text-uppercase my-5 text-black">Payment</h1>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-black mb-5 text-uppercase">
                            <form id="subscribe-form" action="{{ route("payment.store") }}" method="POST">
                                @csrf

                                {{-- Payment Plan --}}
                                <input type="hidden" name="plan" id="plan" value="{{ request('plan') }}">

                                {{-- Payment Method --}}
                                <input type="hidden" name="payment-method" id="payment-method">

                                <div class="bg-light shadow-sm rounded-3 p-3 my-3">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" readonly name="name" class="form-control" 
                                        value="{{ auth()->user()->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" readonly class="form-control" name="email" 
                                        value="{{ auth()->user()->email }}">
                                    </div>
                                    {{-- <div class="form-group">
                                        <label>Address Line 1</label>
                                        <input type="text" name="line1" class="form-control" placeholder="Line 1"
                                        value="{{ old("line1") }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Address Line 2</label>
                                        <input type="text" name="line2" class="form-control" placeholder="Line 2"
                                        value="{{ old("line2") }}">
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control" placeholder="City"
                                        value="{{ old("city") }}">
                                    </div>
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" name="state" class="form-control" placeholder="State"
                                        value="{{ old("state") }}">
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" name="country" class="form-control" placeholder="Country"
                                                value="{{ old("country") }}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input type="text" name="postal_code" class="form-control" placeholder="Postal Code"
                                                value="{{ old("postal_code") }}">
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="bg-light shadow-sm rounded-3 p-3 mt-4 mb-3">
                                    <div class="form-group">
                                        <label>Card's Holder Name</label>
                                        <input type="text" id="card-holder-name" 
                                        name="card-holder-name" class="form-control" 
                                        value="{{ auth()->user()->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Card</label>
                                        <div class="my-2 p-3 border border-dark rounded-2" id="card-element"></div>
                                    </div>

                                    <div id="card-errors"></div>
                                </div>

                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                        @endforeach
                                    </div>
                                @endif

                                <button id="card-button" type="submit" class="btn btn-primary w-100 mt-3 text-uppercase" 
                                data-secret="{{ $intent->client_secret }}">Pay</button>
                                
                            </form>
                        </div>
                    </div>


                </div>
            </section>

        </div>
    </header>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        var style = {
            base: {
                color: '#32325d',
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
        var card = elements.create('card', { 
            hidePostalCode: true,
            style: style
        });  

        card.mount('#card-element');    
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });    
        
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;    
        cardButton.addEventListener('click', async (e) => {
            e.preventDefault();
            console.log("attempting");
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: card,
                        billing_details: { name: cardHolderName.value }
                    }
                });        
                
                if (error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;        
                } else {            
                    paymentMethodHandler(setupIntent.payment_method);
                }

        });    
        
        function paymentMethodHandler(payment_method) {
            var form = document.getElementById('subscribe-form');
            var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', payment_method);
            form.appendChild(hiddenInput);    
            form.submit();
        }

















        // const stripe = Stripe('{{ env("STRIPE_KEY") }}');
        // const elements = stripe.elements();
        // const cardElements = elements.create('card');

        // const cardHolderName = $('input[name="card_holder_name"]');
        // const cardButton = $('button[type="submit"]');
        // const clientSecret = cardButton.data('secret');

        // cardElements.mount('#card-element');

        // cardElements.on('change', event => {
        //     const displayError = $('#card-errors');
        //     if (event.error) {
        //         displayError.text(event.error.message);
        //     } else {
        //         displayError.text('');
        //     }
        // });

        // const paymentForm = $('#payment-form');

        // paymentForm.submit(function(event) {
        //     event.preventDefault();

        //     stripe
        //         .handleCardPayment(
        //             clientSecret, cardElements, {
        //                 payment_method_data: {
        //                     billing_details: {
        //                         name: cardHolderName.val()
        //                     }
        //                 }
        //             }
        //         ).then(function(result) {
        //             if (result.error) {
        //                 $('#card-errors').text(result.error.message);
        //             } else {
        //                 const paymentMethodInput = $('#payment-method');
        //                 paymentMethodInput.val(result.setupIntent.payment_method);
        //                 paymentForm.submit(); 
        //             }
        //         });
        // });

    </script>
@endsection