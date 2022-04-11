@foreach ($categories as $category)

    <div class="card rounded-0 shadow-none text-left text-dark border-0 mb-4" data-id="{{ $category -> id }}">
        <div class="card-body p-0 category">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4 col-lg-3 p-1 background-grandient">
                        <img src="https://source.unsplash.com/random?{{ $category->name }}&sig={{ $category->id }}" class="img-responsive fit-image rounded-3">
                    </div>
                    <div class="col-12 col-md-8 col-lg-9 p-4">
                        <h5 class="card-title text-uppercase">{{ $category -> name }}</h5>
                        {{-- <p class="card-text">
                            {{ $category -> description }}
                        </p> --}}
    
                        <div class="text-uppercase my-3 d-flex flex-column">
                            <small class="text-dark text-uppercase">
                                <span> {{ $category -> articles -> count() }} Articles </span>
                            </small>
                            @if ($category -> articles -> count() > 0)
                            <a class="text-decoration-none" 
                            href="{{ route('article.show', $category -> articles -> first() -> slug) }}">
                                <small class="text-primary">last uploaded</small>
                            </a>
                            @endif
                        </div>
    
                        <div class="row">
                            <div class="col d-flex">
                                <a href="" 
                                class="btn btn-link card-link p-0">
                                    <i class="fi fi-rr-eye"></i>
                                </a>
    
                                <a href="{{ route('category.edit', $category->slug) }}" 
                                class="btn btn-link card-link p-0">
                                    <i class="fi fi-rr-edit"></i>
                                </a>
    
                                <form action="
                                {{ route('category.destroy', $category->id) }}
                                " method="POST" class="card-link">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-link p-0" type="submit">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
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