@extends('admin.main')

@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <x-title :titles="$titles" />

        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">

                        </div>
                        <!--to do-->
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                            <!-- working letter -->
                                <!-- <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                   Filter</button> -->
                                <!-- <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                    </div>

                                    <div class="separator border-gray-200"></div>

                                    <div class="px-7 py-5" data-kt-user-table-filter="form">

                                        <div class="mb-10">
                                            <label class="form-label fs-6 fw-semibold">Role:</label>
                                            <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true">
                                                <option></option>
                                            </select>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                                            <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
                                        </div>
                                    </div>
                                </div> -->
                               <!--to do end-->
                                <!--begin::Add role-->
                                @can('role-create')
                                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Add Role</a>
                                    @endcan
                                <!--end::Add role-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-125px">ID</th>
                                    <th class="min-w-125px">Role</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>

                                    <td>
                                        <div style="float:right;">
                                            @can('role-show')
                                            <a href="{{ route('roles.show', $role->id) }}" title="Show" class="navi-link" style="margin-right: 7px;">
                                                <span class="navi-icon">
                                                    <i class="fa fa-eye text-success" style="font-size:1.5rem;"></i>
                                                </span>
                                            </a>
                                            @endcan

                                            @can('role-edit')
                                            <a href="{{ route('roles.edit', $role->id) }}" title="Edit" class="navi-link" style="margin-right: 7px;">
                                                <span class="navi-icon">
                                                    <i class="fa fa-edit text-primary" style="font-size:1.5rem;"></i>
                                                </span>
                                            </a>
                                            @endcan

                                            @can('role-delete')
                                            <a href="javascript:void(0);"  data-id="{{$role->id}}" class="navi-link
                                            delToolType deleteRole" title="Delete">
                                            <span class="navi-icon">
                                                <i class="fa fa-trash text-danger" style="font-size:1.5rem;"></i>
                                            </span>
                                            </a>
                                            @endcan
                                    </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>

                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <div class="card-footer">
                        {!! $roles->render() !!}
                    </div>

                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
</div>
@endsection
@section('page-js')
<script>
    var roleURL = `{{ route('roles.store') }}`;
</script>
<script src="{{ asset('assets/js/admin/role.js') }}"></script>
@endsection

