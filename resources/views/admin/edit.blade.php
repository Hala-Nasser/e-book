@extends('layouts.dashboard_layout')

@section('css')
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->

@stop

@section('heading_title')
    <!--begin::Heading-->
    <h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">{{trans('admin_create_edit.edit_title')}}</h1>
    <ul class="breadcrumb breadcrumb-dot fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted">{{trans('general.home')}}</a>
        </li>
        <li class="breadcrumb-item text-muted">{{trans('general.admins')}}</li>
        <li class="breadcrumb-item text-dark">{{trans('admin_create_edit.edit_title')}}</li>
    </ul>
    <!--end::Heading-->
@stop

@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-fluid" id="kt_content_container">
            <!--begin::Form-->
            <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row"
                onsubmit="event.preventDefault(); performUpdate();">
                <!--begin::Aside column-->
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>{{trans('admin_create_edit.thumbnail')}}</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body text-center pt-0">
                            <!--begin::Image input-->
                            @if ($admin->image)
                            <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true"
                                style="background-image: url({{ Storage::url($admin->image) }})">
                                @else
                                <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true"
                                style="background-image: url({{ asset('dist/assets/media/person.png') }})">
                            @endif

                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-150px h-150px"></div>
                            </div>
                            <!--end::Image input-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Thumbnail settings-->
                </div>
                <!--end::Aside column-->
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::General options-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>{{trans('admin_create_edit.general')}}</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">{{trans('admin_create_edit.name')}}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name" class="form-control mb-2"
                                                placeholder="{{trans('admin_create_edit.name')}}" value="{{$admin->name}}" id="name" readonly/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">{{trans('admin_create_edit.email')}}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="email" class="form-control mb-2"
                                                placeholder="{{trans('admin_create_edit.email')}}" value="{{$admin->email}}" id="email" readonly/>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">{{trans('admin_create_edit.role')}}</label>
                                            <!--end::Label-->
                                            <select class="form-select mb-2" data-control="select2"
                                                data-placeholder="Select an option" id="role_id">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}" @selected($admin->role->id == $role->id)>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::General options-->
                            </div>
                        </div>
                        <!--end::Tab pane-->

                    </div>
                    <!--end::Tab content-->
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="{{ route('admin.index') }}" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5">{{trans('general.cancel')}}</a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                            {{trans('general.save_changes')}}
                        </button>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Main column-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->
@stop
@section('js')
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('dist/assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    {{-- <script src="{{ asset('dist/assets/js/custom/apps/ecommerce/catalog/save-product.js') }}"></script> --}}
    <script src="{{ asset('dist/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('dist/assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->

    <script>
        function performUpdate() {
            axios.put('/dashboard/admin/{{ $admin->id }}', {
                'role_id' : document.getElementById('role_id').value,
            }).then(function(response) {

                console.log(response);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                })
                document.getElementById('kt_ecommerce_add_product_form').reset();
                document.getElementById('cancel_thumbnail').click();

            }).catch(function(error) {
                console.log(error);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'error',
                    title: error.response.data.message
                })
            });
        }
    </script>
@stop
