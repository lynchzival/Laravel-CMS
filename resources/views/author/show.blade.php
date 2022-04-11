@extends('main.index', ['title' => $author -> name, 'favicon' => asset('img/document.svg')])

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('navbrand')
    <img src="{{ asset('img/info.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full">

        <div class="container-fluid py-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 text-black mb-5">
                    <div class="text-center p-0 m-0">

                        <div class="background-grandient mb-4 d-inline-block rounded-circle p-2">
                            <img class="rounded-circle m-0" src="{{ $author->getProfileImg() }}" alt="..."/
                            width="220" height="220">
                        </div>

                        <h2 class="text-uppercase">{{ $author->name }}</h2>

                        <div class="background-grandient text-light shadow-sm rounded-3 p-3 mt-5" style="font-size: 12px">
                            <ul class="nav justify-content-center gap-4 text-uppercase align-items-center">
                                @auth
                                <form action="{{ route('author.follow', $author->id) }}" method="post">
                                    @csrf
                                    <li class="nav-item">
                                        <button class="btn {{ (auth() -> user() -> isFollowing($author)) ? 'btn-light' : 'btn-outline-light' }}" id="follow-btn">
                                            <i class="fi {{ (auth() -> user() -> isFollowing($author)) ? 'fi-rr-delete-user' : 'fi-rr-following' }}"></i>
                                        </button>
                                    </li>
                                </form>
                                @endauth
                                <li class="nav-item">
                                    <span>Followers
                                        <span class="badge badge-light text-dark">{{ $author -> followers() -> count() }}</span>
                                    </span>
                                </li>
                                <li class="nav-item">
                                    <span>Articles
                                        <span class="badge badge-light text-dark">{{ $author -> getTotalArticles() }}</span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($author -> getTotalArticles() > 0)
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
                        <div class="input-group mb-4">
                            <input type="text" class="form-control text-black bg-transparent border-1 border-dark" 
                            placeholder="search" autocomplete="off" id="article_search"
                            value="{{ $keyword ?? "" }}" data-route="{{ route('author.article.search', $author->id) }}">
                            <div class="input-group-append">
                                <span class="input-group-text border-0 bg-black">
                                    <i class="fi fi-rr-search text-light"></i>
                                </span>
                            </div>
                        </div>

                        <div class="p-1 my-3 background-grandient">
                            <div class="rounded-3 p-3" style="background: #fff">
                                <h4 class="text-uppercase">Filter</h4>

                                <form action="{{ route('search') }}" method="get" class="filter">
                                    <div class="accordion" id="accordionExample">
                                        <div class="card border-0">
                                            <div class="card-header px-1 py-2 bg-transparent border-0" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="p-0 btn text-dark text-uppercase" type="button" data-toggle="collapse" data-target="#collapseOne" aria-controls="collapseOne">
                                                        <i class="fi fi-rr-angle-small-right"></i>
                                                        <small>Sort</small>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseOne" class="collapse show p-0" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="card-body py-0">

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="sort"
                                                        value="desc" checked>
                                                        <label class="form-check-label text-uppercase" 
                                                        style="font-size: 12px">Newest</label>
                                                    </div>
                                                    
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="sort"
                                                        value="asc" {{ Request::get('sort') === 'asc' ? 'checked' : '' }}>
                                                        <label class="form-check-label text-uppercase" 
                                                        style="font-size: 12px">Oldest</label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="sort"
                                                        value="views" {{ Request::get('sort') === 'views' ? 'checked' : '' }}>
                                                        <label class="form-check-label text-uppercase" 
                                                        style="font-size: 12px">Popularity</label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="card border-0">
                                            <div class="card-header px-1 py-2 bg-transparent border-0" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <button class="p-0 btn text-dark text-uppercase collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        <i class="fi fi-rr-angle-small-right"></i>
                                                        <small>Category</small>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="category"
                                                        value="all" checked>

                                                        <label class="form-check-label text-uppercase" 
                                                        style="font-size: 12px">All</label>
                                                    </div>
                                                    @foreach($categories as $category)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="category"
                                                            value="{{ strtolower($category->name) }}" 
                                                            {{ (Request::get('category') === strtolower($category->name) ? 'checked' : '') }}>

                                                            <label class="form-check-label text-uppercase" 
                                                            style="font-size: 12px">{{ $category -> name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card border-0">
                                            <div class="card-header px-1 py-2 bg-transparent border-0" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="p-0 btn text-dark text-uppercase" type="button" data-toggle="collapse" data-target="#collapseThree" aria-controls="collapseThree">
                                                        <i class="fi fi-rr-angle-small-right"></i>
                                                        <small>Type</small>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse show p-0" aria-labelledby="collapseThree" data-parent="#accordionExample">
                                                <div class="card-body py-0">

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="type"
                                                        value="all" checked>
                                                        <label class="form-check-label text-uppercase" 
                                                        style="font-size: 12px">All</label>
                                                    </div>
                                                    
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="type"
                                                        value="free" {{ Request::get('type') === 'free' ? 'checked' : '' }}>
                                                        <label class="form-check-label text-uppercase" 
                                                        style="font-size: 12px">Free</label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="type"
                                                        value="premium" {{ Request::get('type') === 'premium' ? 'checked' : '' }}>
                                                        <label class="form-check-label text-uppercase" 
                                                        style="font-size: 12px">Premium</label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary text-uppercase mt-3">
                                        apply
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="p-1 my-3 background-grandient">
                            <div class="rounded-3 p-3" style="background: #fff">
                                <h4 class="text-uppercase mb-4">Populars</h4>
                                @include('article.partials.articles-sm-list')
                            </div>
                        </div>

                        @if ($author -> followers -> count() > 0)
                            <div class="p-1 my-3 background-grandient">
                                <div class="rounded-3 p-3" style="background: #fff">
                                    <h4 class="text-uppercase mb-4">Followers</h4>
                                    @foreach ($author -> followers as $follower)
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
                    </div>
                </div>

            </div>
        </div>
        @endif

    </header>
@endsection

@section('scripts')
    <script src="{{ asset('js/load_article.js') }}"></script>
    <script src="{{ asset('js/like_article.js') }}"></script>
    <script src="{{ asset('js/favorite_article.js') }}"></script>
    <script src="{{ asset('js/search_article.js') }}"></script>
    <script src="{{ asset('js/filter_query.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#follow-btn').click(function(e) {
                $(this).closest('form').submit();
            });
        });
    </script>
@endsection