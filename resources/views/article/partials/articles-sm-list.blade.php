@foreach ($list as $item)
    <a href="{{ route('article.show', $item -> slug) }}" 
    class="text-decoration-none text-dark">
        <div class="d-flex align-items-center p-1">
            <div class="mr-3">
                <img src="{{ $item->getThumbnail() }}" class="rounded float-left" alt="..." width="50px" height="50px" style="object-fit: cover">
            </div>
            <div class="text-truncate">
                <span>{{ $item->title }}</span>
                <span class="d-block text-uppercase" style="font-size: 12px; color: #2c3e50;">
                    {{ $item->viewCount() }}
                </span>
            </div>
        </div>
    </a>
@endforeach