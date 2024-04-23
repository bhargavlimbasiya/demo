@extends('admin.main')
@section('content')
    <x-title :titles="$titles" />

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card card-flush py-4">

                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    {!! Form::open([
                        'route' => 'admin-users.store',
                        'method' => 'POST',
                        'id' => 'user_form',
                        'class' => 'form validate_form_role',
                        'enctype' => 'multipart/form-data',
                    ]) !!}

                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Name</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row">
                                        <input type="text" name="name"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="Name" value="" data-parsley-required
                                            data-parsley-required-message="Please enter name"
                                            data-parsley-pattern='^[a-zA-Z_ ]*$'
                                            data-parsley-pattern-message='Please add in correct name'
                                            ,data-parsley-trigger='keyup' />
                                        <span class="text-danger" id="name_error">{{ $errors->first('name') }}</span>
                                    </div>
                                    <!--end::Col-->

                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="email" name="email" class="form-control form-control-lg form-control-solid"
                                    placeholder="Email" value="" data-parsley-trigger="keyup"
                                    data-parsley-required="required"
                                    data-parsley-required-message="Please enter email address"
                                    data-parsley-type-message="Please enter valid email address" />
                                <span class="text-danger" id="name_error">{{ $errors->first('email') }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Phone Number</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row">
                                        <input name="phone_number" minimum="0"
                                            class="form-control form-control-lg form-control-solid" type="digits"
                                            placeholder="Phone Number" data-parsley-required data-parsley-trigger="keyup"
                                            data-parsley-type="digits"
                                            data-parsley-required-message='Please enter mobile number' maxlength="10"
                                            oninput="this.value=this.value.slice(0,this.maxLength)"
                                            data-parsley-type-message="Please enter valid mobile number">
                                        <span class="text-danger"
                                            id="name_error">{{ $errors->first('phone_number') }}</span>
                                    </div>
                                    <!--end::Col-->

                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>

                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Password</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row position-relative mb-3" data-kt-password-meter="true">
                                <input type="password" name="password"
                                    class="form-control form-control-lg form-control-solid" placeholder="Password"
                                    value="" data-parsley-required
                                    data-parsley-pattern="^(?=.*\d)(?=.*[@#$%&!])(?=.*[a-z])(?=.*[A-Z]).{4,}$"
                                    data-parsley-required-message="{{ __('validation.custom.common_required', ['attribute' => 'password']) }}"
                                    data-parsley-minlength="6"
                                    data-parsley-minlength-message="{{ __('messages.custom.password_length_messages') }}"
                                    data-parsley-pattern-message="{{ __('messages.custom.password_pattern_messages') }}"
                                    data-parsley-trigger="keyup" autocomplete="off"
                                    data-parsley-errors-container="#password_error">
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                    data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                                <span class="text-danger" id="password_error">{{ $errors->first('password') }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Select Role</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <!--begin::Input-->

                                <select name="role[]" aria-label="Select Role" data-control="select2"
                                    data-placeholder="Select role..." class="form-select form-select-solid form-select-lg "
                                    multiple required data-parsley-required-message="Please select role"
                                    data-parsley-errors-container='#role_error'>
                                    <option value="">Select Role...</option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="role_error">{{ $errors->first('role') }}</span>
                                <!--end::Input-->

                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                        <!--begin::Actions-->

                        <button type="submit" data-kt-contacts-type="submit" class="btn btn-primary submit">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2">
                                </span>
                            </span>
                        </button>
                        <!--end::Actions-->
                        {{ Form::close() }}
                        <!--end::Form-->
                    </div>

                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
    @endsection
    @section('page-js')
        <script>
            var userURL = '{{ route('admin-users.store') }}';
            var userIndexURL = '{{ route('admin-users.index') }}';
        </script>
        <script src="{{ asset('assets/js/admin/admin-user.js') }}"></script>
    @endsection
