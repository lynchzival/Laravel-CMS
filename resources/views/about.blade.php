@extends('main.index', ['title' => Route::currentRouteName()])

@section('navbrand')
    <img src="{{ asset('img/info.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #2980b9">
        <div class="text-center my-5">
            <img class="img-fluid rounded-circle mb-4 w-25" 
            src="https://avatars.dicebear.com/api/adventurer/{{ Route::currentRouteName() }}.svg" 
            alt="..." />
            <h1 class="text-white fs-3 fw-bolder text-uppercase">About Page</h1>
        </div>
    </header>
@endsection