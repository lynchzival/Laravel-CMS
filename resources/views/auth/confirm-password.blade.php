@extends('main.index', ['title' => 'Login', 'favicon' => asset('img/sign-in-black.svg')])

@section('navbrand')
    <img src="{{ asset('img/sign-in.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #ecf0f1;">

        <div class="container-fluid py-5">

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 text-black mb-5">

                    <div class="text-center">
                        <img class="img-fluid rounded-circle mb-4 w-25" 
                        src="{{ asset('img/exclamation-black.svg') }}" 
                        alt="..." />
                        <h1 class="text-uppercase my-5 text-black">Confirm Password</h1>
                    </div>

                    <form action="{{ url('/user/confirm-password') }}" method="POST">

                        @csrf

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3 text-uppercase">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </header>
@endsection