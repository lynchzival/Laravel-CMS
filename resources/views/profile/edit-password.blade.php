@extends('main.index', ['title' => 'Change Password', 'favicon' => asset('img/user-black.svg')])

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
                        <h1 class="text-uppercase my-5 text-black">Change Password</h1>
                    </div>

                    <form action="{{ route('user-password.update') }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" class="form-control" placeholder="Enter current password" name="current_password"
                            autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Enter password" name="password"
                            autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Enter password" name="password_confirmation"
                            autocomplete="off">
                        </div>

                        @if($errors->hasBag('updatePassword'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->updatePassword->all() as $message)
                                        <li><small class="text-uppercase">{{ $message }}</small></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success">
                                <small class="text-uppercase">Your password has been updated.</small>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 mt-3 text-uppercase">Submit</button>
                    </form>

                </div>
            </div>
        </div>

    </header>
@endsection