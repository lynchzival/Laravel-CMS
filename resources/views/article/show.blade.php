@extends('main.index', ['title' => $article -> title, 'favicon' => asset('img/feather.svg')])

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ URL::current() }}">
    <meta property="og:title" content="{{ $article -> title }}">
    <meta property="og:description" content="{{ strip_tags($article -> brief())  }}">
    <meta property="og:image" content="{{ $article -> getThumbnail() }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ URL::current() }}">
    <meta property="twitter:title" content="{{ $article -> title }}">
    <meta property="twitter:description" content="{{ strip_tags($article -> brief()) }}">
    <meta property="twitter:image" content="{{ $article -> getThumbnail() }}">
@endsection

@section('navbrand')
    <img src="{{ asset('img/graduation-cap.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full article">
        <div class="container my-5 text-black">

            <div class="text-center">
                <i class="fi fi-rr-box mr-1"></i>
                <a href="{{ route('category.show', $article -> category -> slug) }}" class="text-decoration-none text-dark">
                    <small>{{ $article -> category -> name }}</small>
                </a>
            </div>

            <div class="card bg-transparent border-0 py-5 px-3">
                <div class="card-body">
                    
                    <h1 class="card-title text-center">
                        {{ ucwords($article -> title) }}
                    </h1>
                    
                    <hr class="my-5 w-50 m-auto">
                    
                    <div class="card-text my-5">
                        {!! $article -> content !!}
                    </div>

                    <div class="col-12 col-md-5 col-lg-3 bg-light shadow-sm rounded-pill p-2 d-block mx-auto text-center" id="article_data">
                        <a href="{{ url()->previous() }}" class="btn btn-link card-link p-0">
                            <i class="fi fi-rr-angle-left"></i>
                        </a>

                        @auth
                            <a href="javascript:void(0)" class="btn btn-link card-link p-0">
                                <i class="fi fi-rr-thumbs-up {{ auth() -> user() -> hasLiked($article) ? 'text-success' : '' }}"
                                data-like="{{ $article->id }}"></i>
                            </a>

                            <a href="javascript:void(0)" class="btn btn-link card-link p-0">
                                <i class="fi fi-rr-bookmark {{ auth() -> user() -> hasFavorited($article) ? 'text-success' : '' }}" data-favorite="{{ $article->id }}"></i>
                            </a>
                        @endauth

                        @can('adminOrOwner', $article)
                            <a href="{{ route('article.edit', ['article' => $article->slug]) }}" 
                            class="btn btn-link card-link p-0">
                                <i class="fi fi-rr-edit"></i>
                            </a>

                            <form action="
                            {{ route('article.destroy', ['article' => $article->slug]) }}
                            " method="POST" class="d-inline card-link">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-link p-0" type="submit">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="mt-5 text-left">
                <i class="fi fi-rr-user mr-1"></i>
                <a href="{{ route('author.show', $article -> user -> id) }}" class="text-decoration-none text-dark">
                    <small>{{ $article -> user -> name }}</small>
                </a>
            </div>

            <div class="row text-left mt-3">
                <div class="col-12 col-lg-9 px-0">

                    <div class="sharethis-inline-share-buttons"></div>

                    <div class="rounded-3 p-3 my-3 bg-transparent">
                        <h4 class="text-uppercase mb-4">Comment 
                            <span>
                                {{ ($article -> comment_status) ? $article -> comments -> count() : '' }}
                            </span>
                        </h4>
                        @if ($article -> comment_status)
                            @comments(['model' => $article])
                        @else
                            <div class="card mb-5">
                                <div class="card-body">
                                    <small class="card-text d-block">Comments are turned off</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-lg-3">
                    <div class="border border-1 rounded-3 p-3 my-3 bg-transparent">
                        <h4 class="text-uppercase mb-4">Related</h4>
                        @include('article.partials.articles-sm-list')
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('scripts')
    <script type="text/javascript"
    src="https://platform-api.sharethis.com/js/sharethis.js#property=6182c76a8afacc001dd07677&product=inline-share-buttons" 
    async="async"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.3/tinymce.min.js" integrity="sha512-ykwx/3dGct2v2AKqqaDCHLt1QFVzdcpad7P5LfgpqY8PJCRqAqOeD4Bj63TKnSQy4Yok/6QiCHiSV/kPdxB7AQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/like_article.js') }}"></script>
    <script src="{{ asset('js/favorite_article.js') }}"></script>
    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: 'textarea',
                height: 135,
                menubar: false,
                branding: false,
                setup: function(editor) {
                    editor.on('init', function(e) {
                        $('textarea').prev().hide();
                        $('textarea').removeClass('d-none');
                    });
                },
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });
        });
    </script>
@endsection