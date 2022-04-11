{{-- 'https://source.unsplash.com/random?sig='.$article->id --}}

@foreach ($articles as $article)

    <div class="card rounded-0 shadow-none text-left text-dark border-0 mb-4" 
    data-id="{{ $article -> id }}" id="category">
        <div class="card-body p-0 article">
            <div class="container">
                <div class="row align-items-center bg-light">
                    
                    <div class="col-12 col-md-4 col-lg-3 p-1 background-grandient">
                        <a href="{{ route((Gate::allows('adminOrOwner', $article) ? "article.view" : "article.show" ), $article->slug) }}">
                            <img src="{{ $article -> getThumbnail() }}" class="rounded-3 img-responsive fit-image">
                        </a>
                        <div class="article-date">
                            <i class="fi fi-rr-clock"></i>
                            <small>{{ $article -> publishedAt() }}</small>
                        </div>
                    </div>

                    <div class="col-12 col-md-8 col-lg-9 p-4 position-relative">
                        <h5 class="card-title text-truncate">{{ $article -> title }}</h5>
                        <p class="card-text text-truncate">
                            {{ strip_tags($article -> brief()) }}
                        </p>

                        <div class="text-uppercase my-3 d-flex align-items-center gap-3">
                            <a class="text-decoration-none" 
                            href="{{ route('author.show', ['user' => $article -> user -> id]) }}">
                                <small class="text-primary">{{ $article -> user -> name }}</small>
                            </a>
                            <a class="text-decoration-none" 
                            href="{{ route('category.show', ['category' => $article -> category -> slug]) }}">
                                <small class="text-secondary">{{ $article -> category -> name }}</small>
                            </a>
                        </div>

                        <div class="text-uppercase mb-1 d-flex align-items-center gap-3">
                            <span class="text-dark text-lowercase mt-0">
                                <span id="like{{$article->id}}-bs3" class="like"> {{ $article->likeCount() }} </span>
                            </span>
                            <span class="text-secondary text-lowercase mt-0">
                                <span class="like"> {{ $article->viewCount() }} </span>
                            </span>
                        </div>

                        <div class="row">
                            <div class="col d-flex">
                                <a href="{{ 
                                    route((Gate::allows('adminOrOwner', $article) ? "article.view" : "article.show" ), $article->slug) }}" class="btn btn-link card-link p-0">

                                    @if ($article -> is_premium)
                                        <i class="fi fi-rr-diamond {{ ($article->published) ? 'text-grandient' : 'text-danger' }}"></i>
                                    @else
                                        <i class="fi fi-rr-eye {{ ($article->published) ? '' : 'text-danger' }}"></i>
                                    @endif
                                </a>

                                @auth
                                    @if ($article->published)
                                    <a href="javascript:void(0)" class="btn btn-link card-link p-0">
                                        <i class="fi fi-rr-thumbs-up {{ auth() -> user() -> hasLiked($article) ? 'text-success' : '' }}" id="like{{$article->id}}" data-like="{{ $article->id }}"></i>
                                    </a>

                                    <a href="javascript:void(0)" class="btn btn-link card-link p-0">
                                        <i class="fi fi-rr-bookmark {{ auth() -> user() -> hasFavorited($article) ? 'text-success' : '' }}" id="favorite{{$article->id}}" data-favorite="{{ $article->id }}"></i>
                                    </a>
                                    @endif
                                @endauth

                                @can('adminOrOwner', $article)
                                    <a href="{{ route('article.edit', ['article' => $article->slug]) }}" 
                                    class="btn btn-link card-link p-0">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>

                                    <form action="
                                    {{ route('article.destroy', ['article' => $article->slug]) }}
                                    " method="POST" class="card-link">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-link p-0" type="submit">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>
                                @endcan

                            </div>
                            <div class="col text-right">
                                <small class="d-block text-uppercase"></small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach