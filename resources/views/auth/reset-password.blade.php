@extends('main.index', ['title' => 'Register', 'favicon' => asset('img/form-black.svg')])

@section('navbrand')
    <img src="{{ asset('img/form.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background-color: #ecf0f1;">
        
        <section class="ftco-section">
            <div class="container">

                <div class="text-center">
                    <h1 class="text-uppercase my-5 text-black">create your password</h1>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4 text-black mb-5">
                        <form action="{{ route("password.update") }}" method="POST">

                            @csrf

                            <input type="hidden" name="token" value="{{ request()->route('token') }}">
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email"
                                value="{{ $request -> email }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password Confirmation</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Enter password">
                            </div>
                            
                            {{-- <div class="row">
                                <span class="text-uppercase">already registered?
                                    <a href="{{ route("login") }}" class="text-uppercase text-decoration-none">login</a>
                                </span>
                            </div> --}}

                            <button type="submit" class="btn btn-primary w-100 mt-3 text-uppercase">Submit</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </header>
@endsection