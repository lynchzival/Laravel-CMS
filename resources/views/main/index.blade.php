<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        @yield('meta')

        <title> {{ ucwords($title) }} </title>

        <link rel="shortcut icon" 
        href="{{ $favicon ?? asset('img/document.svg') }}" 
        type="image/x-icon">

        <!-- Core theme CSS (includes Bootstrap)-->

        <link rel="stylesheet" href="{{ asset('css/core/bootstrap.min.css') }}">
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;1,200;1,300;1,400;1,500&display=swap" rel="stylesheet">

        @yield('styles')
    </head>
    <body>
        <!-- Responsive navbar-->
        {{-- <div class="container-fluid row align-items-center" 
        style="background: #000 url({{ asset('img/wallhaven-q6ojxl.png') }}) no-repeat center center;
        background-size: cover; height: 250px;">
            <img src="{{ asset('img/info.svg') }}" alt="" width="50" height="50">
        </div> --}}

        <nav class="navbar navbar-expand-lg navbar-dark text-light">
            <div class="container">
                <span class="navbar-brand">
                    @yield('navbrand')
                </span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                        <li class="nav-item mx-0 mx-lg-2 mt-2 mt-lg-0">
                            <a class="nav-link text-uppercase {{ (request()->is('/')) ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">
                                <i class="d-none d-lg-block fi fi-rr-home"></i> 
                                <span class="d-block d-lg-none">Home</span>
                            </a>
                        </li>

                        @foreach ($categories as $category)
                            @if($category -> articles -> count() > 0)
                                <li class="nav-item mx-0 mx-lg-2">
                                    <a class="nav-link text-uppercase 
                                    {{ (request()->is("category/".$category->slug)) ? 'active' : '' }}" 
                                    href="{{ route('category.show', $category->slug) }}">
                                        <span class="d-block">{{ $category->name }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach

                        <li class="nav-item mx-0 mx-lg-2 mt-2 mt-lg-0">
                            <a class="nav-link text-uppercase" data-toggle="modal" data-target="#search">
                                <i class="d-none d-lg-block fi fi-rr-search"></i> 
                                <span class="d-block d-lg-none">Search</span>
                            </a>
                        </li>

                        <div class="modal fade" id="search" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content rounded-1">
                                    <div class="modal-header border-0 pb-0">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i class="fi fi-rr-cross" style="font-size: 12px"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <input type="text" name="searh" id="search" class="py-4 main-search form-control"
                                        placeholder="search..." autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @can('adminOrAuthor')
                        <li class="nav-item mx-0 mx-lg-2">
                            <a class="nav-link text-uppercase {{ (request()->is('article')) ? 'active' : '' }}" href="{{ route('article.index') }}">
                                <i class="d-none d-lg-block fi fi-rr-document"></i>
                                <span class="d-block d-lg-none">Article</span>
                            </a>
                        </li>
                        @endcan

                        @can('admin')
                        <li class="nav-item mx-0 mx-lg-2">
                            <a class="nav-link text-uppercase {{ (request()->is('category')) ? 'active' : '' }}" href="{{ route('category.index') }}">
                                <i class="d-none d-lg-block fi fi-rr-box"></i>
                                <span class="d-block d-lg-none">Category</span>
                            </a>
                        </li>

                        <li class="nav-item mx-0 mx-lg-2">
                            <a class="nav-link text-uppercase {{ (request()->is('user')) ? 'active' : '' }}" href="{{ route('user.index') }}">
                                <i class="d-none d-lg-block fi fi-rr-user-add"></i>
                                <span class="d-block d-lg-none">User</span>
                            </a>
                        </li>
                        @endcan

                        @guest
                            <li class="nav-item mx-0 mx-lg-2">
                                <a class="nav-link text-uppercase {{ (request()->is('login')) ? 'active' : '' }}" href="{{ route('login') }}">
                                    <i class="d-none d-lg-block fi fi-rr-sign-in-alt"></i>
                                    <span class="d-block d-lg-none">Login</span>
                                </a>
                            </li>
                        @endguest

                        @auth
                            <li class="nav-item mx-0 mx-lg-2">
                                <a class="nav-link text-uppercase {{ (request()->is('profile')) ? 'active' : '' }}" href="{{ route('profile') }}">
                                    <i class="d-none d-lg-block fi fi-rr-user
                                    text-{{ (auth()->user()->isAdmin()) ? 'danger' : ((auth()->user()->isAuthor()) ? 'warning' : 'light' ) }}"></i>
                                    <span class="d-block d-lg-none">Profile</span>
                                </a>
                            </li>
                        @endauth

                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header - set the background image for the header in the line below-->

        @yield('content')

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright {{ strtoupper(config('app.name')) }} &copy; {{ date('Y') }}</p></div>
        </footer>

        <!-- Bootstrap core JS-->
        <script src="{{ asset('js/core/jquery.min.js') }}"></script>
        <script src="{{ asset('js/core/popper.min.js') }}"></script>
        <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/core/bootstrap.bundle.min.js') }}"></script>
        <script>
            $(document).ready(function(){

                $('input#search').keypress(function(e) {
                    let url = "{{ route('search') }}";
                    if(e.which == 13) {
                        e.preventDefault();
                        let keyword = $(this).val();
                        url += '/' + keyword;
                        window.location.href = url;
                    }
                });

            });
        </script>
        @yield('scripts')
    </body>
</html>