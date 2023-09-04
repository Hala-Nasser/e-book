@extends('layouts.dashboard_layout')

@section('css')
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
@stop

@section('heading_title')
    <!--begin::Heading-->
    <h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">Books</h1>
    <ul class="breadcrumb breadcrumb-dot fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted">Home</a>
        </li>
        <li class="breadcrumb-item text-dark">Books</li>
    </ul>
    <!--end::Heading-->
@stop

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Add customer-->
                <a href="{{ route('book.create') }}" class="btn btn-primary">Add Book</a>
                <!--end::Add customer-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="data_table">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            #
                        </th>
                        <th class="min-w-200px">Book</th>
                        <th class="min-w-100px">Author name</th>
                        <th class="min-w-70px">Category</th>
                        <th class="min-w-100px">Publish date</th>
                        <th class="min-w-20px">Price</th>
                        <th class="min-w-70px">Actions</th>
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
    <!--end::Products-->
@stop

@section('js')
{{-- <script src="{{ asset('dist/assets/plugins/global/plugins.bundle.js') }}"></script> --}}

    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('dist/assets/js/custom/apps/ecommerce/catalog/products.js') }}"></script>
    <script src="{{ asset('dist/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <!--end::Page Custom Javascript-->

    <script type="text/javascript">
        $(document).ready(function() {
            $(function() {
                var table = $('#data_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('book.index') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'book',
                            name: 'book'
                        },
                        {
                            data: 'author_name',
                            name: 'author_name'
                        },
                        {
                            data: 'category',
                            name: 'category'
                        },
                        {
                            data: 'publish_date',
                            name: 'publish_date'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },

                        //   {data: 'image', name: 'image'},
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: true
                        },
                    ]
                });
            });
        });

    </script>

    <script>
        function DeleteBook(id, element) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will not be able to undo the deletion!",
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
            axios.delete('/dashboard/book/' + id)
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
