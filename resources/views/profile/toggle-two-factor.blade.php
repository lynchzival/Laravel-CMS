@extends('main.index', ['title' => '2FA setting', 'favicon' => asset('img/user-black.svg')])

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
                        <h1 class="text-uppercase my-5 text-black">2FA setting</h1>
                    </div>

                    <div class="d-flex justify-content-between bg-light shadow-sm rounded-3 p-3">
                        <label class="text-uppercase mb-0">2FA is
                            <span class="text-{{ auth() -> user() -> two_factor_secret ? 'success' : 'danger' }}">
                                {{ auth() -> user() -> two_factor_secret ? 'Enabled' : 'Disabled' }}
                            </span>
                        </label>

                        <form action="{{ url('user/two-factor-authentication') }}" method="POST">
                            @csrf
                            {{ auth() -> user() -> two_factor_secret ? method_field('DELETE') : '' }}

                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="two_factor_switch"
                                {{ auth() -> user() -> two_factor_secret ? 'checked' : '' }}>
                                <label class="custom-control-label" for="two_factor_switch"></label>
                            </div>
                        </form>
                    </div>

                    @if (auth() -> user() -> two_factor_secret)
                        <div class="form-group mt-5">
                            <label class="text-uppercase text-left">recovery codes</label>

                            <div class="bg-light shadow-sm rounded-3 p-3 position-relative" id="recovery_codes">
                                <div class="d-flex gap-2 position-absolute" style="right: 0.8em;">
                                    <form action="{{ url('user/two-factor-recovery-codes') }}" method="POST">
                                        @csrf
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fi fi-rr-refresh"></i>
                                        </button>
                                    </form>
                                    <button class="btn btn-info btn-sm" id="btn_copy">
                                        <i class="fi fi-rr-duplicate"></i>
                                    </button>
                                </div>
                                <ul class="list-unstyled text-decoration-none mb-0">
                                    @foreach (auth() -> user() -> recoveryCodes() as $codes)
                                        <li><small>{{ $codes }}</small></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group mt-5">
                            <label class="text-uppercase text-left">qr codes</label>
                            <div class="bg-light shadow-sm rounded-3 p-3">
                                {!! auth() -> user() -> twoFactorQrCodeSvg() !!}
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
            $('#btn_copy').click(function() {
                let codes = $('#recovery_codes ul li small');
                let text = '';
                codes.each(function(index, element) {
                    text += $(element).text() + '\n';
                });
                navigator.clipboard.writeText(text);
            });

            $('#two_factor_switch').change(function() {
                $(this).closest('form').submit();
            });
        });
    </script>
@endsection