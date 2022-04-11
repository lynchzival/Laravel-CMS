@extends('main.index', ['title' => 'Login', 'favicon' => asset('img/sign-in-black.svg')])

@section('navbrand')
    <img src="{{ asset('img/sign-in.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #ecf0f1;">

        <div class="container-fluid py-5">

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 text-black mb-5">

                    <div class="text-center">
                        <img class="img-fluid rounded-circle mb-4 w-25" 
                        src="{{ asset('img/exclamation-black.svg') }}" 
                        alt="..." />
                        <h1 class="text-uppercase my-5 text-black">2F authentication</h1>
                    </div>

                    <form action="{{ url('two-factor-challenge') }}" method="POST">

                        @csrf

                        <div class="form-group">
                            <label>2FA Code</label>
                            <input type="text" name="code" class="form-control" placeholder="Enter 2FA code" autocomplete="off">
                        </div>

                        <div class="text-right">
                            <a href="#recoveryModal" data-toggle="modal" data-target="#recoveryModal" role="button"
                            class="text-uppercase text-decoration-none">use recovery code</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3 text-uppercase">Submit</button>
                    </form>

                    <div class="modal fade" id="recoveryModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-uppercase">recovery option</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form action="{{ url('two-factor-challenge') }}" method="POST">

                                    @csrf

                                    <div class="modal-body bg-light p-3">

                                        <div class="input-group my-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fi fi-rr-key"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control shadow-sm" 
                                            placeholder="Enter 2FA recovery code" name="recovery_code" autocomplete="off" >
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary text-uppercase">Submit</button>
                                        <button type="button" class="btn btn-secondary text-uppercase" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </header>
@endsection