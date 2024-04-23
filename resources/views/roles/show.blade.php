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
                <div class="fv-row mb-7 fv-plugins-icon-container">
                    <strong>Name:</strong>
                    {{ $role->name }}
                </div>
                <div class="fv-row mb-7 fv-plugins-icon-container">
                    <strong>Permissions:</strong>
                    @if (!empty($rolePermissions))
                    @foreach ($rolePermissions as $v)
                    <label class="label label-success">{{ $v->name }},</label>
                    @endforeach
                    @endif
                </div>
                <!--begin::Separator-->
                <div class="separator mb-6"></div>

            </div>
        </div>
        <!--end::Card header-->
    </div>
    <!--end::Card-->
</div>
<!--end::Content container-->
</div>
@endsection