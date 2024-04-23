@extends('guest.main')
@section('content')
<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
    <!--begin::Form-->
    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
        <!--begin::Wrapper-->
        <div class="w-lg-500px p-10">
            <!--begin::Form-->
            <form method="POST" action="{{ route('admin-sent-mail-forgot-password') }}" id="validate_form_email">
                @csrf
                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark fw-bolder mb-3">Forgot Password ?</h1>
                    <!--end::Title-->
                    <!--begin::Link-->
                    <div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.</div>
                    <!--end::Link-->
                </div>
                <!--begin::Heading-->
                <!--begin::Input group=-->
                <div class="fv-row mb-8">
                    <!--begin::Email-->
                    <input id="email" type="text" placeholder="Enter email" name="email"  :value="old('email')" autocomplete="off" class="form-control bg-transparent" required data-parsley-type="email" data-parsley-required-message="{{ __('messages.custom.email_messages') }}" data-parsley-type-message="{{ __('messages.custom.email_type_messages') }}" data-parsley-trigger="keyup" data-parsley-errors-container="#email_error">
                    <span id='email_error'></span>
                    <!--end::Email-->
                </div>
                <!--begin::Actions-->
                <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                    <button type="submit" id="kt_password_reset_submit" class="btn btn-primary me-4">
                        <!--begin::Indicator label-->
                        <span class="indicator-label">Submit</span>
                        <!--end::Indicator label-->
                        <!--begin::Indicator progress-->
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        <!--end::Indicator progress-->
                    </button>
                    <a href="{{ route('login') }}" class="btn btn-light">Cancel</a>
                </div>
                <!--end::Actions-->
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
    var emailURL = `{{ route('password.email') }}`;
</script>
{{-- <script src="{{ asset('assets/js/admin/forgot-password.js') }}"></script> --}}
@endsection
