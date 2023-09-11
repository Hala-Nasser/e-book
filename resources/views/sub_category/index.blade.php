@extends('layouts.dashboard_layout')

@section('css')
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
@stop

@section('heading_title')
    <!--begin::Heading-->
    <h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">{{trans('general.sub_categories')}}</h1>
    <ul class="breadcrumb breadcrumb-dot fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted">{{trans('general.home')}}</a>
        </li>
        <li class="breadcrumb-item text-dark">{{trans('general.sub_categories')}}</li>
    </ul>
    <!--end::Heading-->
@stop

@section('content')
    <!--begin::Category-->
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
                <a href="{{ route('sub-category.create') }}" class="btn btn-primary">{{trans('sub_category_index.add_sub_category')}}</a>
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
                        <th class="min-w-200px">{{trans('sub_category_index.sub_category')}}</th>
                        <th class="min-w-150px">{{trans('sub_category_index.category')}}</th>
                        <th class="min-w-150px">{{trans('sub_category_index.status')}}</th>
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
    <!--end::Category-->
@stop

@section('js')

    <script type="text/javascript">
        $(document).ready(function() {
            $(function() {
                var table = $('#date_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('sub-category.index') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'subCategory',
                            name: 'subCategory',
                            orderable: false,
                        },
                        {
                            data: 'category',
                            name: 'category',
                            orderable: false,
                            searchable: true
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                        },
                    ]
                });
            });
        });
    </script>

    <script>
        function DeleteSubCategory(id, element) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action will delete all books belongs to this sub category!",
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
            axios.delete('/dashboard/sub-category/' + id)
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
