<div class="shadow-sm rounded-3 p-5 my-5 category-container" style="background: #000000">
    <h1 class="text-uppercase mb-4 category-title">
        {{ $category -> name }}
    </h1>
    <div class="band category">
        @foreach ($category -> articles as $i => $article)            
            @if ($i > 6) @break @endif
            <div class="item-{{ $i + 1 }}">
                <div class="card rounded-0" style="background: #000000">
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
                            <h1 class="text-light">
                                @if ($article -> is_premium)
                                    <i class="fi fi-rr-diamond text-grandient"></i>
                                @endif
                                {{ $article->title }}
                            </h1>
                        </a>
                        <a href="{{ route('author.show', $article->user->id) }}" class="text-decoration-none">
                            <span>{{ $article->user->name }}</span>
                        </a>
                    </article>
                </div>
            </div>
        @endforeach
    </div>
    <a href="{{ route('category.show', $category->slug) }}" 
    class="d-flex align-items-center mt-4 gap-2 text-decoration-none text-secondary category-button">
        <span class="text-uppercase">see more</span>
        <i class="fi fi-rr-arrow-right ml-1"></i>
    </a>
</div>