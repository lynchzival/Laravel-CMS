@extends('main.index', ['title' => "Subscription Plans"])

@section('navbrand')
    <img src="{{ asset('img/headset.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #ecf0f1">
        <div class="text-center my-5">

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
            </div>

            <h1 class="fs-3 fw-bolder text-uppercase mb-5">Plans</h1>

            <div class="container">
                <div class="row">
                    @foreach ($plans as $plan)
                        <div class="col">
                            <div class="d-flex justify-content-between bg-light shadow-sm rounded-3 p-3">
                                <div class="card-body">
                                    <h5 class="card-title display-6 text-uppercase mb-4">
                                        <span class="text-muted">
                                            {{ $plan->currency }}
                                        </span>
                                        {{ $plan->amount/100 }}
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted text-uppercase">{{ $plan -> product -> name }}</h6>
                                    <p class="card-text">Gain access to our premium contents.</p>
                                    <a href="{{ route('payment.index', ['plan' => $plan -> id]) }}" 
                                    class="card-link text-decoration-none">select</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </header>
@endsection