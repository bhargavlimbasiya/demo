@extends('guest.main')
@section('content')
    <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
            <div class="w-lg-500px p-10">
                <form method="POST" action="{{ route('otp-verify') }}" id="validate_form_otp">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <x-input id="email" class="block mt-1 w-full" type="hidden" name="email" :value="old('email', $request->email)"
                        required autofocus autocomplete="username" />
                    <div class="text-center mb-10">
                        <h1 class="text-dark fw-bolder mb-3">OTP verification</h1>
                        <div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ?
                            <a href="{{ route('login') }}" class="link-primary fw-bold">Sign in</a>
                        </div>
                    </div>
                    <div class="fv-row mb-8">
                        <input id="otp" type="text" class="form-control bg-transparent"
                            onkeypress='validate(event)' autocomplete="off" required data-parsley-pattern="^[0-9]{6,6}$"
                            data-parsley-required-message="{{ __('messages.custom.otp_required_messages') }}"
                            data-parsley-pattern-message="{{ __('messages.custom.otp_pattern_messages') }}"
                            data-parsley-trigger="keyup" data-parsley-errors-container="#otp_error" name="otp"
                            placeholder="Enter otp">
                        <span id='otp_error'></span>
                    </div>
                    <div class="d-grid mb-10">
                        <button type="submit" id="otp_submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>

                <form method="POST" class="d-none" action="{{ route('reset-password-new') }}" id="validate_form_reset">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <x-input id="email" class="block mt-1 w-full" type="hidden" name="email" :value="old('email', $request->email)"
                        required autofocus autocomplete="username" />
                    <div class="text-center mb-10">
                        <h1 class="text-dark fw-bolder mb-3">Setup New Password</h1>
                        <div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ?
                            <a href="{{ route('login') }}" class="link-primary fw-bold">Sign in</a>
                        </div>
                    </div>
                    <div class="fv-row mb-8" data-kt-password-meter="true">
                        <div class="mb-1">
                            <div class="position-relative mb-3">
                                <input id="password" type="password" class="form-control bg-transparent" name="password"
                                    autocomplete="off" placeholder="Enter password" required
                                    data-parsley-pattern="^(?=.*\d)(?=.*[@#$%&!])(?=.*[a-z])(?=.*[A-Z]).{4,}$" required
                                    data-parsley-length="[6,32]"
                                    data-parsley-required-message="{{ __('messages.custom.new_password_required_messages') }}"
                                    data-parsley-length-message="{{ __('messages.custom.password_length_messages') }}"
                                    data-parsley-pattern-message="{{ __('messages.custom.password_pattern_messages') }}"
                                    data-parsley-trigger="keyup" data-parsley-errors-container="#password_error" />
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                    data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                            </div>
                            <span id='password_error'></span>
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                        </div>
                        <div class="text-muted">Use 6 or more characters with a mix of letters, numbers & symbols.</div>
                    </div>
                    <div class="fv-row mb-8">
                        <input id="password_confirmation" type="password" class="form-control bg-transparent"
                            autocomplete="off" required
                            data-parsley-pattern="^(?=.*\d)(?=.*[@#$%&!])(?=.*[a-z])(?=.*[A-Z]).{6,}$"
                            parsley-equalto="#password"
                            data-parsley-required-message="{{ __('messages.custom.confirm_password_required_messages') }}"
                            data-parsley-pattern-message="{{ __('messages.custom.password_pattern_messages') }}"
                            data-parsley-trigger="keyup" data-parsley-errors-container="#confirm_password_error"
                            name="password_confirmation" placeholder="Enter confirm password">
                        <span id='confirm_password_error'></span>
                    </div>
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_new_password_submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex flex-center flex-wrap px-5">
            <div class="d-flex fw-semibold text-primary fs-base">
                <a href="../../demo1/dist/pages/team.html" class="px-5" target="_blank">Terms</a>
                <a href="../../demo1/dist/pages/pricing/column.html" class="px-5" target="_blank">Plans</a>
                <a href="../../demo1/dist/pages/contact.html" class="px-5" target="_blank">Contact Us</a>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
    <script>
        var resetURL = `{{ route('reset-password-new') }}`;
        var verifyURL = `{{ route('otp-verify') }}`;
        var homeURL = `{{ route('dashboard') }}`;
    </script>
    <script src="{{ asset('assets/js/admin/otp.js') }}"></script>
    <script src="{{ asset('assets/js/admin/reset.js') }}"></script>
    <script src="{{ asset('assets/js/custom/authentication/reset-password/new-password.js') }}"></script>
@endsection
