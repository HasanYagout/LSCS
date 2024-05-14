@extends('auth.layouts.app')

@push('title') {{ __('Verify') }} @endpush

@section('content')
<div class="register-area">
    <div class="register-wrap">
        <div class="register-left section-bg-img"
            style="background-image: url({{ getSettingImage('login_left_image') }})">
            <div class="register-left-wrap">
                <a class="d-inline-block mb-26 max-w-150" href="{{route('login')}}"><img
                        src="{{ getSettingImage('app_logo') }}" alt="{{ getOption('app_name') }}" /></a>
                <h2 class="fs-36 fw-600 lh-34 text-white pb-8">{{ getOption('sign_up_left_text_title') }}</h2>
                <p class="fs-16 fw-400 lh-24 text-white">{{ getOption('sign_up_left_text_subtitle') }}</p>
            </div>
        </div>
        <div class="register-right">
            <div class="primary-form">
                <!-- Title -->
                <div class="pb-40">
                    <h2 class="fs-32 fw-600 lh-38 text-1b1c17 pb-3">{{ __('Confirm Email') }}</h2>
                    <h4 class="fs-14 fw-400 lh-24">{{ ('Please chcek your email') }} <span> {{ $user->email }} </span>
                        {{ __("and enter the otp below to verify") }}</h4>
                </div>
                <!-- Form -->
                <form action="{{ route('email.verified', $token) }}" method="POST" class="otp-form" name="otp-form">
                    @csrf
                    <div class="otp-input-fields" id="otp-block">
                        <input type="text" name="otp__field__1" id="otp__field__1" maxlength="1" required
                            class="otp__digit otp__field__1" />
                        <input type="text" name="otp__field__2" id="otp__field__2" maxlength="1" required
                            class="otp__digit otp__field__2" />
                        <input type="text" name="otp__field__3" id="otp__field__3" maxlength="1" required
                            class="otp__digit otp__field__3" />
                        <input type="text" name="otp__field__4" id="otp__field__4" maxlength="1" required
                            class="otp__digit otp__field__4" />
                    </div>
                    <p class="fs-12 fw-400 lh-20 text-707070 pt-10 pb-25">{{ __('Send the code again after') }} <span
                            id="send-after-timer"></span></p>
                    <div class="d-none" id="resent-div">
                        <button type="button"
                            onclick="event.preventDefault(); document.getElementById('resent-form').submit();"
                            class="align-items-center bd-ra-12 border-0 d-flex fs-15 fw-500 hover-bg-one justify-content-center lh-20 bg-cdef84  mb-18 mt-30 p-2 pt-10 text-1b1c17 w-100 w-full"
                            title="{{ __('Click here to request another') }}">{{ __('Click here to request another')
                            }}</button>
                    </div>
                    <button id="verify-btn" type="submit"
                        class="d-flex justify-content-center align-items-center w-100 border-0 fs-15 fw-500 lh-25 text-1b1c17 p-13 bd-ra-12 bg-cdef84 hover-bg-one">{{
                        __('Verify') }}</button>
                </form>
                <form method="POST" action="{{ route('email.verify.resend', $token) }}" class="d-none" id="resent-form">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    // Set the date we're counting down to
    var countDownDate = new Date('{{ $user->otp_expiry }}').getTime();
    var currentTime = new Date('{{ now() }}');
    var oldTime = 0;
</script>

<script src="{{ asset('alumni/js/verify_timer.js') }}"></script>
@endpush