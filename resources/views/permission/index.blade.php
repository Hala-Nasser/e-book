@extends('layouts.dashboard_layout')

@section('css')
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
@stop

@section('heading_title')
    <!--begin::Heading-->
    <h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">Permissions</h1>
    <ul class="breadcrumb breadcrumb-dot fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted">Home</a>
        </li>
        <li class="breadcrumb-item text-dark">Permissions</li>
    </ul>
    <!--end::Heading-->
@stop

@section('content')
    <!--begin::permission-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                transform="rotate(45 17.0365 15.1223)" fill="black" />
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-ecommerce-category-filter="search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search permission" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th class="min-w-10px">#</th>
                        <th class="min-w-400px">Permission Name</th>
                        <th class="min-w-350px">User Type</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-bold text-gray-600">
                    <!--begin::Table row-->
                    @if ($permissions->isEmpty())
                        <tr>
                            <td valign="top" colspan="8" style="text-align: center">There is no permissions yet</td>
                        </tr>
                    @else
                        @foreach ($permissions as $permission)
                            <tr>
                                <!--begin::Checkbox-->
                                <td>
                                    {{ $permission->id }}
                                </td>
                                <!--end::Checkbox-->
                                <!--begin::permission=-->
                                <td class="pe-0">
                                    <span class="fw-bolder text-dark">{{ $permission->name }}</span>
                                </td>
                                <td class="pe-0" data-order="21">
                                    <!--begin::Badges-->
                                    <div class="badge @if ($permission->guard_name == 'admin') badge-light-success @else badge-light-primary @endif"
                                        style="font-size:1.15rem">{{ $permission->guard_name }}</div>
                                </td>
                                <!--end::permission=-->
                            </tr>
                        @endforeach
                    @endif
                    <!--end::Table row-->
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::permission-->
@stop

@section('js')
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    {{-- <script src="{{ asset('dist/assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script> --}}
    <script src="{{ asset('dist/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <!--end::Page Custom Javascript-->
@stop
