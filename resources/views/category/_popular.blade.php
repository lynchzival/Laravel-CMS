<div class="pins-container shadow-sm rounded-3 p-5 my-5">
    <h2 class="text-uppercase mb-4 category-title">
        <i class="fi fi-rr-heart"></i>
    </h2>
    <div class="band">
        @foreach ($populars as $article)
            <div class="item-2 rounded-0">
                <div class="card rounded-0 border-gradient border-gradient-purple" style="background: #000000">
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
                            <h1 class="text-uppercase text-light mb-2">{{ $article->title }}</h1>
                        </a>
                        <a href="{{ route('author.show', $article->user->id) }}" class="text-decoration-none">
                            <span>{{ $article->user->name }}</span>
                        </a>
                    </article>
                </div>
            </div>
        @endforeach
    </div>
</div>