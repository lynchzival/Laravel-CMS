@foreach ($articles as $i => $article)
    <div class="item-{{ $i + 1 }}">
        <div class="card rounded-0" style="background: #000000" data-id="{{ $article -> id }}">
            <a href="{{ route('article.show', $article->slug) }}" class="text-decoration-none">
                <div class="thumb position-relative" style="background-image: url({{ $article->getThumbnail() }});">
                    <div class="article-date">
                        <i class="fi fi-rr-clock"></i>
                        <small>{{ $article -> publishedAt() }}</small>
                    </div>
                </div>
            </a>
            <article>
                <a href="{{ route('article.show', $article->slug) }}" class="text-decoration-none">
                    <h1 class="text-light">{{ $article->title }}</h1>
                </a>
                <a href="{{ route('author.show', $article->user->id) }}" class="text-decoration-none">
                    <span>{{ $article->user->name }}</span>
                </a>
                <small class="text-light text-lowercase">
                    <span id="like{{$article->id}}-bs3"> {{ $article->likeCount() }} </span>
                </small>
            </article>
            <div class="actions actions-container">
                <a href="{{ 
                    route((Gate::allows('adminOrOwner', $article) ? "article.view" : "article.show" ), $article->slug) }}" class="btn btn-link card-link p-0">
                    <i class="fi fi-rr-eye {{ ($article->published) ? '' : 'text-danger' }}"></i>
                </a>

                @auth
                    <a href="javascript:void(0)" class="btn btn-link card-link p-0">
                        <i class="fi fi-rr-thumbs-up {{ auth() -> user() -> hasLiked($article) ? 'text-success' : '' }}" id="like{{$article->id}}" data-like="{{ $article->id }}"></i>
                    </a>

                    <a href="javascript:void(0)" class="btn btn-link card-link p-0">
                        <i class="fi fi-rr-bookmark {{ auth() -> user() -> hasFavorited($article) ? 'text-success' : '' }}" id="favorite{{$article->id}}" data-favorite="{{ $article->id }}"></i>
                    </a>
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
                        <button class="btn btn-link card-link p-0" type="submit">
                            <i class="fi fi-rr-trash" style="color: #FF3CAC;"></i>
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
@endforeach