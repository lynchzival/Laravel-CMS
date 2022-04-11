@extends('main.index', ['title' => 'Login', 'favicon' => asset('img/sign-in-black.svg')])

@section('navbrand')
    <img src="{{ asset('img/sign-in.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #ecf0f1;">

        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 text-black mb-5">

                    <div class="text-center">
                        <h1 class="text-uppercase my-5 text-black">login</h1>
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

                    <form action="{{ route("login") }}" method="POST">

                        @csrf

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email"
                            value="{{ old("email") }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-check fs-6">
                                    <input type="checkbox" class="form-check-input" name="remember">
                                    <label class="form-check-label text-uppercase">remember me</label>
                                </div> 
                            </div>
                            <div class="col text-right">
                                <a href="{{ route("register") }}" 
                                class="text-uppercase text-decoration-none">register</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mt-3">
                                <a href="{{ route("password.request") }}" 
                                class="text-uppercase text-decoration-none">forgot password?</a>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3 text-uppercase">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </header>
@endsection