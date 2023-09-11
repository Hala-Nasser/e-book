@extends('layouts.dashboard_layout')

@section('css')
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
@stop

@section('heading_title')
    <!--begin::Heading-->
    <h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">{{trans('general.admins')}}</h1>
    <ul class="breadcrumb breadcrumb-dot fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted">{{trans('general.home')}}</a>
        </li>
        <li class="breadcrumb-item text-dark">{{trans('general.admins')}}</li>
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
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar" style="float: right">
                <!--begin::Add customer-->
                <a href="{{ route('admin.create') }}" class="btn btn-primary">{{trans('admin_index.add_admin')}}</a>
                <!--end::Add customer-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="date_table">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th class="min-w-10px">#</th>
                        <th class="min-w-180px">{{trans('admin_index.admin')}}</th>
                        <th class="min-w-150px">{{trans('admin_index.email')}}</th>
                        <th class="min-w-80px">{{trans('admin_index.role')}}</th>
                        <th class="min-w-70px">{{trans('admin_index.verification_status')}}</th>
                        <th class="min-w-70px">{{trans('general.actions')}}</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-bold text-gray-600">
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

    <script type="text/javascript">
        $(document).ready(function() {
            $(function() {
                var table = $('#date_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.index') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'admin',
                            name: 'admin',
                            searchable:true,
                        },
                        {
                            data: 'email',
                            name: 'email',
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'verification',
                            name: 'verification'
                        },
                        {
                            data: 'action',
                            name: 'action',
                        },
                    ]
                });
            });
        });
    </script>


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
