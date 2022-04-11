@foreach ($users as $user)

    <div class="card rounded-0 shadow-none text-left text-dark border-0 mb-4" data-id="{{ $user -> id }}">
        <div class="card-body p-0 user">
            <div class="container">
                <div class="row align-items-center p-0">
                    <div class="col-12 col-md-4 col-lg-3 p-1 background-grandient">
                        <img src="{{ $user -> getProfileImg() }}" class="rounded-3 img-responsive fit-image">
                        <div class="article-date">
                            <i class="fi fi-rr-clock"></i>
                            <small>{{ $user -> getCreatedAt() }}</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-9 p-4 bg-light">
                        <h5 class="card-title text-uppercase">{{ $user -> role -> name }}</h5>
                        <p class="card-text text-truncate">
                            {{ $user -> name }}
                        </p>

                        <div class="text-uppercase my-3 d-flex flex-column">
                            <a class="text-decoration-none" href="#">
                                <small>{{ $user -> email }}</small>
                            </a>       
                            <small class="text-dark text-uppercase text-secondary">
                                <span> {{ 
                                    ($user->isReader()) ? $user->likes->count()." Liked" : $user->articles->count()." Articles" 
                                }} </span>
                            </small>                 
                        </div>

                        <div class="row">
                            <div class="col d-flex">
                                <a href="{{ ($user->isReader()) ? 
                                route('user.show', $user->id) : 
                                route('author.show', $user->id) }}" 
                                class="btn btn-link card-link p-0">
                                    <i class="fi fi-rr-eye {{ ($user->visibility) ? '' : 'text-danger' }}"></i>
                                </a>

                                <a href="{{ route('user.edit', $user->id) }}" 
                                class="btn btn-link card-link p-0">
                                    <i class="fi fi-rr-edit"></i>
                                </a>

                                <form action="
                                {{ route('user.destroy', $user->id) }}
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