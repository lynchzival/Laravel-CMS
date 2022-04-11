@extends('main.index', ['title' => Route::currentRouteName()])

@section('navbrand')
    <img src="{{ asset('img/home.svg') }}" width="30" height="30" alt="">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/blog-card.css') }}">
@endsection

@section('content')
<header class="py-3 bg-image-full" style="background: #000000;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-11 mb-5">
                @if ($pins -> count() > 0)
                    @include('_pins')
                @endif

                @foreach ($categories as $category)
                    @if($category -> articles -> count() > 0)
                        @include('_categories')
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</header>
@endsection