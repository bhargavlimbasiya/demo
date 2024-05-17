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
                        'route' => 'categories.store',
                        'method' => 'POST',
                        'id' => 'category_form',
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
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Description</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <textarea name="description" lass="form-control form-control-lg form-control-solid" id="" cols="30" rows="10">

                                </textarea>
                                
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
            var categoryURL = "{{ route('categories.store') }}";
            var categoryIndexURL = "{{ route('categories.index') }}";
        </script>
        <script src="{{ asset('assets/js/admin/category.js') }}"></script>
    @endsection
