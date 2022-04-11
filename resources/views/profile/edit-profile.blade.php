@extends('main.index', ['title' => 'Edit Profile', 'favicon' => asset('img/user-black.svg')])

@section('navbrand')
    <img src="{{ asset('img/user.svg') }}" width="30" height="30" alt="">
@endsection

@section('styles')
    <style>
        #article_thumbnail{
            background: #ecf0f1 url("{{ asset(auth()->user()->getProfileImg()) }}") no-repeat fixed center center;
            background-size: cover;
        }
    </style>
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
                        <h1 class="text-uppercase my-5 text-black">Edit Profile</h1>
                    </div>

                    <form action="{{ route('user-profile-information.update') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-4 mt-3">
                                    <div id="article_thumbnail">
                                        <input type="file" name="profile_img">
                                        <div>
                                            Drag your profile image here or click in this area.
                                        </div>
                                    </div>
                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div> 
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name"
                            value="{{ Auth::user()->name }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control" placeholder="Enter email" name="email"
                            value="{{ Auth::user()->email }}" autocomplete="off">
                        </div>

                        @if (auth()->user()->profile_img)
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="profile_img_removal">
                                    <label class="form-check-label">
                                        Use Default Avatar
                                    </label>
                                </div>
                            </div>
                        @endif

                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $message)
                                        <li><small class="text-uppercase">{{ $message }}</small></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success">
                                <small class="text-uppercase">Your profile has been updated.</small>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 mt-3 text-uppercase">Submit</button>
                    </form>

                    <div class="text-left my-3">
                        <ul class="list-unstyled lh-lg">
                            <li>
                                <a href="{{ route("profile.privacy") }}" 
                                class="text-uppercase text-decoration-none">privacy</a>
                            </li>
                            <li>
                                <a href="{{ route("profile.subscription") }}" 
                                class="text-uppercase text-decoration-none">subscription</a>
                            </li>
                            <li>
                                <a href="{{ route("profile.password") }}" 
                                class="text-uppercase text-decoration-none">change password</a>
                            </li>
                            <li>
                                <a href="{{ route("profile.two-factor") }}" 
                                class="text-uppercase text-decoration-none">two-factor authentication</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </header>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('#article_thumbnail input').change(function () {
                $('#article_thumbnail div').text(this.files.length + " file(s) selected");
            });
        });
    </script>
@endsection