@extends('admin.main')
@section('content')
<x-title :titles="$titles" />

<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush py-4">

            <!--begin::Card body-->
            <div class="card-body pt-5">
                <!--begin::Form-->
                {!! Form::model($role, [
                'method' => 'POST',
                'route' => ['roles.update', $role->id],
                'id'=>'kt_ecommerce_settings_general_form', 'class' => 'form fv-plugins-bootstrap5 fv-plugins-framework validate_form_role'
                ]) !!}
                <!--begin::Input group-->
                <div class="fv-row mb-7 fv-plugins-icon-container">
                    <!--begin::Label-->
                    {!! Form::hidden('id', $role->id) !!}
                    <label class="fs-6 fw-semibold form-label mt-3">
                        <span class="required">Name</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" aria-label="Enter the contact's name." data-kt-initialized="1"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    {!! Form::text('name', null, ['placeholder' => 'Enter Name', 'class' => 'form-control form-control-solid', 'id' => 'name','required data-parsley-pattern'=> '^[a-zA-Z_ ]*$',
                    'data-parsley-required-message'=>'Please enter Name.','data-parsley-pattern-message'=>'Enter a valid Name.' ,'data-parsley-trigger'=>'keyup','data-parsley-errors-container'=>'#name_error']) !!}
                    <span class="text-danger" id="name_error">{{ $errors->first('name') }}</span>
                    <!--end::Input-->
                    <div class="fv-plugins-message-container invalid-feedback"></div>
                </div>

                <div class="fv-row mb-7 fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold form-label mt-3">
                        <span class="required">Permission</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" aria-label="Enter the contact's name." data-kt-initialized="1"></i>
                    </label><br />
                    <!--end::Label-->
                    @foreach ($permission as $value)
                    <label class="mt-3">{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'form-check-input name','data-parsley-required'=>'true' ,'data-parsley-required-message'=>'Please Select Permission.','data-parsley-errors-container'=>'#permission_error','data-parsley-trigger'=> 'click']) }}
                        {{ $value->name }}</label>
                    <br />
                    @endforeach
                    <span class="text-danger" id="permission_error">{{ $errors->first('permission') }}</span>
                    <div class="fv-plugins-message-container invalid-feedback"></div>
                </div>
                <!--end::Input group-->
                <!--begin::Separator-->
                <div class="separator mb-6"></div>
                <!--end::Separator-->
                <!--begin::Action buttons-->
                <div class="d-flex justify-content-end">
                    <!--begin::Button-->
                    <button type="submit" id="submit" data-kt-contacts-type="submit" class="btn btn-primary">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Action buttons-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content container-->
</div>
@endsection
@section('page-js')
<script>
    var roleURL = `{{ route('roles.store') }}`;
    var roleIndexURL = `{{ route('roles.index') }}`;
</script>
<script src="{{ asset('assets/js/admin/role.js') }}"></script>
@endsection
