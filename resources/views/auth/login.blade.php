@extends('guest.main')
@section('content')
    <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
        <!--begin::Form-->
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10">
                <!--begin::Form-->
                <form method="POST" action="{{ route('login') }}" method="POST" autocomplete="off" id="validate_form_login">
                    @csrf
                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <!--begin::Title-->
                        <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
                        <!--end::Subtitle=-->
                    </div>
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="text" id="email" name="email" :value="old('email')"
                            placeholder="Enter Email or Phone" autocomplete="email" required
                            data-parsley-required-message="{{ __('messages.custom.required_messages') }}"
                            data-parsley-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]+|[0-9]{10,14}$/"
                            data-parsley-pattern-message="{{ __('messages.custom.email_phone_pattern_messages') }}"
                            data-parsley-trigger="keyup" data-parsley-errors-container="#email_error"
                            class="form-control bg-transparent" />
                        <span id='email_error'></span>
                        <!--end::Email-->
                    </div>
                    <!--end::Input group=-->
                    <div class="fv-row mb-3" data-kt-password-meter="true">
                        <div class="position-relative mb-3">
                            <input id="password" type="password" name="password" placeholder="Enter password"
                                class="form-control bg-transparent" autocomplete="off" required data-parsley-length="[6,32]"
                                data-parsley-pattern="^(?=.*\d)(?=.*[@#$%&!])(?=.*[a-z])(?=.*[A-Z]).{4,}$"
                                data-parsley-required-message="{{ __('messages.custom.password_required_messages') }}"
                                data-parsley-length-message="{{ __('messages.custom.password_length_messages') }}"
                                data-parsley-pattern-message="{{ __('messages.custom.password_pattern_messages') }}"
                                data-parsley-trigger="keyup" name="password" autocomplete="current-password"
                                data-parsley-errors-container="#password_error" />
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                data-kt-password-meter-control="visibility">
                                <i class="bi bi-eye-slash fs-2"></i>
                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span>
                        </div>
                        <span id='password_error'></span>
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <div></div>
                        <!--begin::Link-->

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link-primary">Forgot Password ?</a>
                        @endif

                        <!--end::Link-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Sign In</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                    <!--end::Submit button-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Form-->
    </div>
@endsection
@section('page-js')
    <script>
        var loginURL = `{{ route('login') }}`;
        var homeURL = `{{ route('dashboard') }}`;
    </script>
    <script src="{{ asset('assets/js/admin/login.js') }}"></script>
@endsection
