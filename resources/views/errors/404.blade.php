@extends('main.index', ['title' => 'Not Found'])

@section('navbrand')
    <img src="{{ asset('img/exclamation.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #c0392b">
        <div class="text-center my-5">
            <img class="img-fluid rounded-circle mb-4 w-25" 
            src="https://avatars.dicebear.com/api/adventurer/Not Found.svg" 
            alt="..." />
            <h1 class="text-white fs-3 fw-bolder text-uppercase">404 Not Found</h1>
        </div>
    </header>
@endsection