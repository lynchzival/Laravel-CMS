@extends('main.index', ['title' => Auth::user()->name, 'favicon' => asset('img/user-black.svg')])

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('navbrand')
    <img src="{{ asset('img/user.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #fff;">

        <div class="container-fluid py-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 text-black mb-5">
                    <div class="text-center p-0 m-0">
                        <div class="background-grandient mb-4 d-inline-block rounded-circle p-2">
                            <img class="rounded-circle m-0" src="{{ Auth::user()->getProfileImg() }}" alt="..."/
                            width="300" height="300">
                        </div>

                        {{-- <img class="profile_img mb-4" src="{{ Auth::user()->getProfileImg() }}" alt="..."/> --}}

                        <h1 class="fs-3 fw-bolder text-uppercase mb-5">{{ Auth::user()->name }}
                            <a href="{{ url('profile/edit') }}" class="btn btn-info badge">
                                <i class="fi fi-rr-pencil text-black"></i>
                            </a>
                        </h1>

                        <p class="text-uppercase my-2">{{ Auth::user()->email }}</p>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-light badge mt-5 shadow-sm">
                                <i class="fi fi-rr-power text-danger fs-3"></i>
                            </button>
                        </form>

                        <div class="background-grandient shadow-sm rounded-3 p-3 mt-5" style="font-size: 12px">
                            <ul class="nav justify-content-center text-uppercase">
                                <li class="nav-item">
                                    <a class="nav-link text-light {{ (Route::is('profile')) ? 'text-dark' : '' }}" 
                                    href="{{ route('profile') }}">
                                        Following 
                                        <span class="badge badge-light text-dark">{{ Auth::user()->followings()->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light {{ (Route::is('profile.like')) ? 'text-dark' : '' }}" 
                                    href="{{ route('profile.like') }}">
                                        Like 
                                        <span class="badge badge-light text-dark">{{ Auth::user()->likes()->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light {{ (Route::is('profile.favorite')) ? 'text-dark' : '' }}" 
                                    href="{{ route('profile.favorite') }}">
                                        Saved 
                                        <span class="badge badge-light text-dark">{{ Auth::user()->favorites()->count() }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="jumbotron m-0 articles text-center rounded-0" style="background: #fff">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-9">
                        <div id="article_data">
                            @include('article.partials.articles-detailed')
                        </div>

                        <div class="ajax-load mt-5" style="display: none">
                            <img src="{{ asset('img/loader.svg') }}" width="50" height="50" alt="">
                            <small class="text-danger text-uppercase"></small>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 text-left">
                        @if (Auth::user() -> followings -> count() > 0)
                            <div class="p-1 background-grandient">
                                <div class="rounded-3 p-3" style="background: #fff">
                                    <h4 class="text-uppercase mb-4">Followings</h4>
                                    @foreach (Auth::user() -> followings as $following)
                                        <a href="{{ route('author.show', $following -> id) }}" class="text-decoration-none">
                                            <span class="badge text-uppercase badge-pill bg-black"
                                            style="font-size: 10px;">
                                                {{ $following -> name }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @can('adminOrAuthor')
                        @if (Auth::user() -> followers -> count() > 0)
                            <div class="p-1 my-3 background-grandient">
                                <div class="rounded-3 p-3" style="background: #fff">
                                    <h4 class="text-uppercase mb-4">Followers</h4>
                                    @foreach (Auth::user() -> followers as $follower)
                                        <a href="{{ route('user.show', $follower -> id) }}" class="text-decoration-none">
                                            <span class="badge text-uppercase badge-pill bg-black"
                                            style="font-size: 10px;">
                                                {{ $follower -> name }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>


        {{-- <div class="text-center my-5">
            <img class="profile_img mb-4" src="{{ Auth::user()->getProfileImg() }}" alt="..."/>

            <h1 class="fs-3 fw-bolder text-uppercase mb-5">{{ Auth::user()->name }}
                <a href="{{ url('profile/edit') }}" class="btn btn-info badge">
                    <i class="fi fi-rr-pencil text-black"></i>
                </a>
            </h1>

            <p class="text-uppercase my-2">{{ Auth::user()->email }}</p>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light badge mt-5 shadow-sm">
                    <i class="fi fi-rr-power text-danger fs-3"></i>
                </button>
            </form>
        </div> --}}

        {{-- <div class="container w-50 mb-5">
            <div class="bg-light shadow-sm rounded-3 p-2" style="font-size: 15px">
                <ul class="nav justify-content-center text-uppercase">
                    <li class="nav-item">
                        <a class="nav-link {{ (Route::is('profile')) ? 'text-secondary' : '' }}" 
                        href="{{ route('profile') }}">
                        Following <span class="badge badge-primary">{{ Auth::user()->followings()->count() }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (Route::is('profile.like')) ? 'text-secondary' : '' }}" 
                        href="{{ route('profile.like') }}">
                        Like <span class="badge badge-primary">{{ Auth::user()->likes()->count() }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (Route::is('profile.favorite')) ? 'text-secondary' : '' }}" 
                        href="{{ route('profile.favorite') }}">
                        Saved <span class="badge badge-primary">{{ Auth::user()->favorites()->count() }}</span></a>
                    </li>
                </ul>
            </div>
        </div> --}}

        {{-- <div class="container text-center">

            @if (Auth::user() -> followings -> count() > 0 && Route::is('profile'))
                <div class="card text-left bg-transparent">
                    <div class="card-body">
                        @foreach (Auth::user() -> followings as $following)
                            <a href="{{ route('author.show', $following -> id) }}" class="text-decoration-none">
                                <span class="badge badge-pill badge-{{ $following->getRoleColor() }}">
                                    {{ $following -> name }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div id="article_data">
                @include("article.partials.articles-detailed")
            </div>

            <div class="ajax-load mt-5" style="display: none">
                <img src="{{ asset('img/loader.svg') }}" width="50" height="50" alt="">
                <small class="text-danger text-uppercase"></small>
            </div>
        </div> --}}

    </header>

@endsection

@section('scripts')
    <script src="{{ asset('js/like_article.js') }}"></script>
    <script src="{{ asset('js/favorite_article.js') }}"></script>
    <script src="{{ asset('js/load_article.js') }}"></script>
@endsection