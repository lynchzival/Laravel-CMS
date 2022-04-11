@extends('main.index', ['title' => 'Create', 'favicon' => asset('img/form-black.svg')])

@section('navbrand')
    <img src="{{ asset('img/form.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background-color: #ecf0f1;">
        
        <section class="ftco-section">
            <div class="container">

                <div class="text-center">
                    <h1 class="text-uppercase my-5 text-black">create</h1>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4 text-black mb-5">
                        <form action="{{ route("user.store") }}" method="POST">

                            @csrf

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter username"
                                value="{{ old("name") }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email"
                                value="{{ old("email") }}">
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
                            <div class="form-group">
                                <label>Roles</label>
                                <select class="form-select" name="role_id">
                                    <option selected disabled>Open this select menu</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3 text-uppercase">Submit</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </header>
@endsection