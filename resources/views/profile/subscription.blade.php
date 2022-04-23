@extends('main.index', ['title' => 'Privacy', 'favicon' => asset('img/user-black.svg')])

@section('navbrand')
    <img src="{{ asset('img/user.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #ecf0f1;">

        <div class="container-fluid py-5">

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 text-black mb-5">
                    <div class="text-center">
                        <img class="img-fluid rounded-circle mb-4 w-25" 
                        src="{{ asset('img/user-black.svg') }}" 
                        alt="..." />
                        <h1 class="text-uppercase my-5 text-black">Subscription</h1>
                    </div>

                    <div class="align-items-center bg-light shadow-sm rounded-3 p-3">
                        <div class="d-flex justify-content-between">
                            <label class="text-uppercase mb-0 text-success">active</label>
                            @if (Auth::user()->subscription('default')->onGracePeriod())
                                {{-- @if (!Auth::user()->subscription('default')->canceled()) --}}
                                    <form action="{{ route('profile.subscription.resume') }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-success text-uppercase">resubscribe</button>
                                    </form>
                                {{-- @endif --}}
                            @else
                                <form action="{{ route('profile.subscription.cancel') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-danger text-uppercase">unsubscribe</button>
                                </form>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <span class="text-uppercase">
                                <i class="fi fi-rr-credit-card"></i>
                                <small>{{ Auth::user() -> pm_type }}</small>
                            </span>
                            <span>&#8226;&#8226;&#8226;&#8226; &#8226;&#8226;&#8226;&#8226; &#8226;&#8226;&#8226;&#8226; {{ Auth::user() -> pm_last_four }}</span>
                        </div>
                    </div>

                    <div class="form-group mt-5">
                        <label class="text-uppercase text-left">
                            {{ Auth::user()->subscription('default')->onGracePeriod() ? 
                            'cancel on' : 'auto renewal on' }}
                        </label>

                        <div class="bg-light shadow-sm rounded-3 p-3 position-relative text-uppercase">
                            {{ date('l j, M Y', Auth::user()->subscription('default')->asStripeSubscription()->current_period_end )}}
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </header>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#toggle_private').change(function() {
                $(this).closest('form').submit();
            });
        });
    </script>
@endsection