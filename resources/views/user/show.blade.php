@extends('main.index', ['title' => $user->name, 'favicon' => asset('img/user-black.svg')])

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('navbrand')
    <img src="{{ asset('img/user.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full">

        <div class="container-fluid py-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 text-black mb-5">
                    <div class="text-center p-0 m-0">

                        <div class="background-grandient mb-4 d-inline-block rounded-circle p-2">
                            <img class="rounded-circle m-0" src="{{ $user->getProfileImg() }}" alt="..."/
                            width="220" height="220">
                        </div>

                        <h2 class="text-uppercase">
                            @if ($user -> subscribed('default'))
                                <i class="fi fi-rr-diamond text-grandient"></i>
                            @endif
                            {{ $user->name }}
                        </h2>

                        <div class="background-grandient shadow-sm rounded-3 p-3 mt-5" style="font-size: 12px">
                            <ul class="nav justify-content-center gap-4 text-uppercase align-items-center">
                                <li class="nav-item">
                                    <a class="text-light nav-link {{ Route::is('user.show', $user->id) ? 'text-dark' : '' }}" 
                                    href="{{ route('user.show', $user->id) }}">
                                        Following 
                                        <span class="badge badge-light text-dark">{{ $user->followings()->count() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="text-light nav-link {{ Route::is('user.like', $user->id) ? 'text-dark' : '' }}" 
                                    href="{{ route('user.like', $user->id) }}">
                                        Like 
                                        <span class="badge badge-light text-dark">{{ $user->likes()->count() }}</span>
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

                        @if($user -> followings -> count() > 0)
                            <div class="p-1 background-grandient">
                                <div class="rounded-3 p-3" style="background: #fff">
                                    <h4 class="text-uppercase mb-4">Followers</h4>
                                    @foreach ($user -> followings as $following)
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

                    </div>
                </div>
            </div>
        </div>
    </header>

@endsection

@section('scripts')
    <script src="{{ asset('js/like_article.js') }}"></script>
    <script src="{{ asset('js/favorite_article.js') }}"></script>
    <script src="{{ asset('js/load_article.js') }}"></script>
@endsection