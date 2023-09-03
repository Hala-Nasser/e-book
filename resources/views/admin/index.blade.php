@extends('layouts.dashboard_layout')

@section('css')
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
@stop

@section('heading_title')
    <!--begin::Heading-->
    <h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">Admins</h1>
    <ul class="breadcrumb breadcrumb-dot fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted">Home</a>
        </li>
        <li class="breadcrumb-item text-dark">Admins</li>
    </ul>
    <!--end::Heading-->
@stop

@section('content')
    <!--begin::admin-->
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
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search admin" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar" style="float: right">
                <!--begin::Add customer-->
                <a href="{{ route('admin.create') }}" class="btn btn-primary">Add Admin</a>
                <!--end::Add customer-->
            </div>
            <!--end::Card toolbar-->
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
                        <th class="min-w-200px">Admin</th>
                        <th class="min-w-150px">Email</th>
                        <th class="min-w-150px">Role</th>
                        <th class="min-w-70px">Is_verified</th>
                        <th class="min-w-70px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-bold text-gray-600">
                    <!--begin::Table row-->
                    @if ($admins->isEmpty())
                        <tr>
                            <td valign="top" colspan="8" style="text-align: center">There is no admins yet</td>
                        </tr>
                    @else
                        @foreach ($admins as $admin)
                            <tr>
                                <!--begin::Checkbox-->
                                <td>
                                    {{ $admin->id }}
                                </td>
                                <!--end::Checkbox-->
                                <!--begin::admin=-->
                                <td>
                                    <div class="d-flex">
                                        <!--begin::Thumbnail-->
                                        <a href="{{ URL('admin/' . $admin->id) }}" class="symbol symbol-50px">
                                            @if ($admin->image)
                                                <span class="symbol-label"
                                                    style="background-image:url({{ Storage::url($admin->image) }});"></span>
                                            @else
                                                <span class="symbol-label"
                                                    style="background-image:url({{ asset('dist/assets/media/person.png') }});"></span>
                                            @endif

                                        </a>
                                        <!--end::Thumbnail-->
                                        <div class="ms-5" style="padding: 15px 0;">
                                            <!--begin::Title-->
                                            <a href="{{ URL('admin/' . $admin->id) }}"
                                                class="text-gray-800 text-hover-primary fs-5 fw-bolder mb-1"
                                                data-kt-ecommerce-category-filter="name">{{ $admin->name }}</a>
                                            <!--end::Title-->
                                        </div>
                                    </div>
                                </td>
                                <!--end::admin=-->
                                <!--begin::Type=-->
                                <td>
                                    <span class="fw-bolder text-dark">{{ $admin->email }}</span>
                                </td>
                                <!--end::Type=-->
                                 <!--begin::Type=-->
                                 <td>
                                    <span class="fw-bolder text-dark">{{ $admin->role->name }}</span>
                                </td>
                                <!--end::Type=-->
                                <td>
                                     <!--begin::Badges-->
                                     @if ($admin->email_verified_at)
                                     <div class="badge badge-light-success" style="font-size:1.15rem">Verified</div>
                                 @else
                                     <div class="badge badge-light-primary" style="font-size:1.15rem">Unverified</div>
                                 @endif
                                 <!--end::Badges-->
                                </td>
                                <!--begin::Action=-->
                                <td>
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon--></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('admin.edit', ['admin' => $admin->id]) }}"
                                                class="menu-link px-3">Edit</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <button class="btn menu-link px-3"
                                                onclick="DeleteAdmin({{ $admin->id }},this)"
                                                style="font-size: .95rem; color:#7e8299; text-align: left; padding-left:0px">
                                                Delete
                                            </button>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                                <!--end::Action=-->
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
    <!--end::admin-->
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

    <script>
        function DeleteAdmin(id, element) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action will delete the account of this admin!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                if (result.isConfirmed) {
                    performDelete(id, element)

                }
            })

        }

        function performDelete(id, element) {
            axios.delete('/dashboard/admin/' + id)
                .then(function(response) {
                    console.log(response);
                    Swal.fire({
                        position: 'center',
                        icon: response.data.icon,
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    element.closest('tr').remove();
                })
                .catch(function(error) {
                    console.log(error);
                    Swal.fire({
                        position: 'center',
                        icon: error.response.data.icon,
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                });
        }
    </script>
@stop
