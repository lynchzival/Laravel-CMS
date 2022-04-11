@extends('main.index', ['title' => 'Privacy', 'favicon' => asset('img/user-black.svg')])

@section('navbrand')
    <img src="{{ asset('img/user.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #ecf0f1;">

        <div class="container-fluid py-5">

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 text-black mb-5">
                    <div class="text-center">
                        <img class="img-fluid rounded-circle mb-4 w-25" 
                        src="{{ asset('img/user-black.svg') }}" 
                        alt="..." />
                        <h1 class="text-uppercase my-5 text-black">Privacy</h1>
                    </div>

                    <div class="d-flex justify-content-between bg-light shadow-sm rounded-3 p-3">
                        <label class="text-uppercase mb-0">Private Profile</label>

                        <form action="{{ route('profile.privacy.toggleVisibility') }}" method="POST">
                            @csrf
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="toggle_private" 
                                {{ (auth()->user()->role_id === 3) ? '' : 'disabled' }}
                                {{ (auth()->user()->visibility === 1) ? '' : 'checked' }}>
                                <label class="custom-control-label" for="toggle_private"></label>
                            </div>
                        </form>
                    </div>

                    @if((auth()->user()->visibility === 1))
                    <div class="form-group mt-5">
                        <label class="text-uppercase text-left">public profile url</label>

                        <div class="bg-info shadow-sm rounded-3 p-3 position-relative">
                            <ul class="list-unstyled text-decoration-none mb-0">
                                {{ route('user.show', Auth::user() -> id) }}
                            </ul>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>

    </header>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#toggle_private').change(function() {
                $(this).closest('form').submit();
            });
        });
    </script>
@endsection