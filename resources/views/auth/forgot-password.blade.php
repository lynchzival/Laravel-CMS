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
                        <h1 class="text-uppercase my-5 text-black">Password Reset</h1>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show d-flex p-1 justify-content-end mb-3 align-items-center" role="alert" id="alert">
                            <small class="w-100 mx-3 text-uppercase">
                                {{ session('status') }}
                            </small>
                            <button class="btn btn-info" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route("password.email") }}" method="POST">

                        @csrf

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3 text-uppercase">Send Reset Link</button>
                    </form>
                </div>
            </div>
        </div>

    </header>
@endsection