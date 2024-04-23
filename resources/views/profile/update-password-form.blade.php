<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Sign-in Method</h3>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_signin_method" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body border-top p-9">
            <!--begin::Email Address-->
            <div class="d-flex flex-wrap align-items-center">
                <!--begin::Label-->
                <div id="kt_signin_email">
                    <div class="fs-6 fw-bold mb-1">Password</div>
                    <div class="fw-semibold text-gray-600">************</div>
                </div>
                <!--end::Label-->
                <!--begin::Edit-->
                <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                    <!--begin::Form-->
                    <form id="validate_form_password" class="form" novalidate="novalidate" autocomplete="off" action="{{ route('update-password') }}" method="POST">
                        @csrf
                        <div class="row mb-1">
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="current_password" class="form-label fs-6 fw-bold mb-3">Current Password</label>
                                    <input id="current_password" type="password" name="current_password" placeholder="Enter current password" class="form-control form-control-lg form-control-solid" autocomplete="off" required data-parsley-pattern="^(?=.*\d)(?=.*[@#$%&!])(?=.*[a-z])(?=.*[A-Z]).{8,}$" data-parsley-required-message='Please enter current password.' data-parsley-pattern-message='Password Content at least 1 lowercase, 1 uppercase, 1 special character and 1 number.' data-parsley-trigger="keyup" autocomplete="off" data-parsley-errors-container="#current_password_error">
                                    <span id='current_password_error'></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="new_password" class="form-label fs-6 fw-bold mb-3">New Password</label>
                                    <input id="new_password" type="password" name="new_password" placeholder="Enter new password" class="form-control form-control-lg form-control-solid" autocomplete="off" required data-parsley-pattern="^(?=.*\d)(?=.*[@#$%&!])(?=.*[a-z])(?=.*[A-Z]).{8,}$" data-parsley-required-message='Please enter new password.' data-parsley-pattern-message='Password Content at least 1 lowercase, 1 uppercase, 1 special character and 1 number.' data-parsley-trigger="keyup" autocomplete="off" data-parsley-errors-container="#new_password_error">
                                    <span id='new_password_error'></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="confirm_password" class="form-label fs-6 fw-bold mb-3">Confirm New Password</label>
                                    <input id="confirm_password" type="password" name="confirm_password" placeholder="Enter confirm password" class="form-control form-control-lg form-control-solid" autocomplete="off" required data-parsley-pattern="^(?=.*\d)(?=.*[@#$%&!])(?=.*[a-z])(?=.*[A-Z]).{8,}$" data-parsley-required-message='Please enter confirm password.' data-parsley-pattern-message='Password Content at least 1 lowercase, 1 uppercase, 1 special character and 1 number.' data-parsley-trigger="keyup" autocomplete="off" data-parsley-errors-container="#confirm_password_error">
                                    <span id='confirm_password_error'></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-text mb-5">Password must be at least 8 character and contain symbols</div>
                        <div class="d-flex">
                            <button id="kt_password_submit" type="submit" class="btn btn-primary me-2 px-6">Update Password</button>
                            <button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Edit-->
                <!--begin::Action-->
                <div id="kt_signin_email_button" class="ms-auto">
                    <button type="submit" class="btn btn-light btn-active-light-primary">Reset Password</button>
                </div>
                <!--end::Action-->
            </div>
            <!--end::Email Address-->
            <!--begin::Separator-->
            <div class="separator separator-dashed my-6"></div>
            <!--end::Separator-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Content-->
</div>