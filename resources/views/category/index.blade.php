@extends('main.index', ['title' => "Categories", 'favicon' => asset('img/document.svg')])

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('navbrand')
    <img src="{{ asset('img/info.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #ecf0f1">

        <div class="container-fluid py-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 text-black mb-5">
                    <div class="text-center">
                        <img class="img-fluid mb-4 w-25" 
                        src="{{ asset('img/document.svg') }}" 
                        alt="...">
                    </div>
                </div>
            </div>
        </div>

        <div class="jumbotron m-0 articles text-center rounded-0" style="background: #ecf0f1">
            <div class="container">

                <div class="row mb-5">
                    <div class="col d-flex">
                        <a href="{{ route('category.create') }}" class="btn btn-dark text-uppercase">
                            <i class="fi fi-rr-add"></i>
                        </a>
                    </div>
                    
                    <div class="offset-0 offset-md-4 col">
                        <div class="input-group">
                            <input type="text" class="form-control text-black bg-transparent border-1 border-dark" 
                            placeholder="search" autocomplete="off" id="article_search"
                            value="{{ $keyword ?? "" }}" data-route="{{ route('user.search') }}">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fi fi-rr-document"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="article_data">
                    @include('category._load')
                </div>

                <div class="ajax-load mt-5" style="display: none">
                    <img src="{{ asset('img/loader.svg') }}" width="50" height="50" alt="">
                    <small class="text-danger text-uppercase"></small>
                </div>
    
            </div>
        </div>

    </header>
@endsection

@section('scripts')
    <script src="{{ asset('js/load_article.js') }}"></script>
    <script src="{{ asset('js/like_article.js') }}"></script>
    <script src="{{ asset('js/favorite_article.js') }}"></script>
    <script src="{{ asset('js/search_article.js') }}"></script>
@endsection