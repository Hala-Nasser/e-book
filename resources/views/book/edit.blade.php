@extends('layouts.dashboard_layout')

@section('css')
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('dist/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->

@stop

@section('heading_title')
    <!--begin::Heading-->
    <h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">{{trans('book_create_edit.edit_title')}}</h1>
    <ul class="breadcrumb breadcrumb-dot fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted">{{trans('general.home')}}</a>
        </li>
        <li class="breadcrumb-item text-muted">{{trans('general.books')}}</li>
        <li class="breadcrumb-item text-dark">{{trans('book_create_edit.edit_title')}}</li>
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
                                <h2>{{trans('book_create_edit.thumbnail')}}</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body text-center pt-0">
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true"
                                style="background-image: url({{ Storage::url($book->image) }})">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-150px h-150px"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" id="image" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">{{trans('book_create_edit.thumbnail_description')}}</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Thumbnail settings-->
                    <!--begin::Category & tags-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>{{trans('book_create_edit.book_details')}}</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <!--begin::Label-->
                            <label class="required form-label">{{trans('general.categories')}}</label>
                            <!--end::Label-->
                            <!--begin::Select2-->
                            <select class="form-select mb-2" data-control="select2" data-placeholder="Select an option"
                                id="category_id">
                                @foreach ($categories as $category)
                                    @if ($category->id == $book->subCategory->category_id)
                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <!--end::Select2-->
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <!--begin::Label-->
                            <label class="required form-label">{{trans('general.sub_categories')}}</label>
                            <!--end::Label-->
                            <select class="form-select mb-2" data-control="select2" data-placeholder="Select an option"
                                id="sub_category_id">
                            </select>
                            <!--begin::Description-->
                            <div class="text-muted fs-7 mb-7">{{trans('book_create_edit.sub_category_description')}}</div>
                            <!--end::Description-->
                            <!--end::Input group-->
                        </div>
                        <!--end::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Label-->
                            <label class="required form-label">{{trans('book_create_edit.price')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="price" min="0.1" step="0.1" class="form-control mb-2"
                                placeholder="{{trans('book_create_edit.price')}}" value="{{ $book->price }}" id="price" />
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">{{trans('book_create_edit.price_description')}}</div>
                            <!--end::Description-->
                        </div>
                    </div>
                    <!--end::Category & tags-->
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
                                            <h2>{{trans('book_create_edit.general')}}</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">{{trans('book_create_edit.book_name')}}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="book_name" class="form-control mb-2"
                                                placeholder="{{trans('book_create_edit.book_name')}}" value="{{ $book->name }}" id="name" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">{{trans('book_create_edit.author_name')}}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="author_name" class="form-control mb-2"
                                                placeholder="{{trans('book_create_edit.author_name')}}" value="{{ $book->author_name }}"
                                                id="author_name" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div style="margin-top: 2.5rem">
                                            <!--begin::Label-->
                                            <label class="required form-label">{{trans('book_create_edit.description')}}</label>
                                            <!--end::Label-->
                                            <!--begin::Editor-->
                                            <div id="kt_ecommerce_add_product_description"
                                                name="kt_ecommerce_add_product_description" class="min-h-200px mb-2">
                                                {{ $book->description }}</div>
                                            <!--end::Editor-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">{{trans('book_create_edit.description_description')}}</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div style="margin-top: 2.5rem">
                                            <!--begin::Label-->
                                            <label class="required form-label">{{trans('book_create_edit.publish_date')}}</label>
                                            <!--end::Label-->
                                            <div class="col-xl-9 fv-row">
                                                <div class="position-relative d-flex align-items-center">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                                    <span class="svg-icon position-absolute ms-4 mb-1 svg-icon-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3"
                                                                d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                                                fill="black" />
                                                            <path
                                                                d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                                                fill="black" />
                                                            <path
                                                                d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                                fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <input class="form-control form-control-solid ps-12" name="date"
                                                        id="publish_date" type="date"
                                                        value="{{ $book->publish_date }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::General options-->

                                <!--begin::Media-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>{{trans('book_create_edit.media')}}</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-2">
                                            <!--begin::Dropzone-->
                                            <div class="dropzone" id="dropzone">
                                                <!--begin::Message-->
                                                <div class="dz-message needsclick">
                                                    <!--begin::Icon-->
                                                    <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <div class="ms-4">
                                                        <h3 class="fs-5 fw-bolder text-gray-900 mb-1">{{trans('book_create_edit.drop_media_here')}}</h3>
                                                        <span class="fs-7 fw-bold text-gray-400">{{trans('book_create_edit.upload_files')}}</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                            </div>
                                            <!--end::Dropzone-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">{{trans('book_create_edit.media_description')}}</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                            </div>
                        </div>
                        <!--end::Tab pane-->

                    </div>
                    <!--end::Tab content-->
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="{{ route('book.index') }}" id="kt_ecommerce_add_product_cancel"
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
            <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-body pt-0">
                    <!--begin::Label-->
                    <label class="required form-label">{{trans('book_create_edit.current_media')}}</label>
                    <!--end::Label-->
                    <table>
                        @forelse ($book->media as $media)
                            <tr>
                                <td class="min-w-70px">
                                    <a href="" class="symbol symbol-50px">
                                        <span class="symbol-label"
                                            style="background-image:url({{ Storage::url($media->image) }});"></span>
                                    </a>
                                </td>
                                <td>
                                    <button class="btn" onclick="DeleteMedia({{ $media->id }},this);"
                                        style="background-color: red; width: 20px; height: 30px; align-items: center; display: flex; justify-content: center;">
                                        <i class="fa fa-trash" aria-hidden="true" style="color: white"></i>
                                    </button>
                                </td>
                                <!--end::permission=-->
                            </tr>
                        @empty
                            <p>There is no media</p>
                        @endforelse
                    </table>
                </div>
            </div>
            </div>
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

    <script>
        var quill = new Quill('#kt_ecommerce_add_product_description', {
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, !1]
                    }],
                    ["bold", "italic", "underline"],
                    ["image", "code-block"]
                ]
            },
            theme: "snow"
        });

        let myDropzone = new Dropzone("#dropzone", {
            autoProcessQueue: false,
            url: "/]https://keenthemes.com/scripts/void.php",
            paramName: "file",
            maxFiles: 5,
            maxFilesize: 5,
            acceptedFiles: ".jpeg, .jpg, .png",
            addRemoveLinks: true,
            accept: function(e, t) {
                "wow.jpg" == e.name ? t("Naha, you don't.") : t();
            }
        });

        function Images() {
            return myDropzone.getAcceptedFiles();
        }

        function performUpdate() {
            let formData = new FormData();
            Images().forEach((e) => {
                formData.append('images[]', e);
            });

            formData.append('name', document.getElementById('name').value);
            formData.append('description', quill.getText());
            formData.append('author_name', document.getElementById('author_name').value);
            formData.append('sub_category_id', document.getElementById('sub_category_id').value);
            formData.append('publish_date', document.getElementById('publish_date').value);
            formData.append('price', document.getElementById('price').value);
            formData.append('_method', 'PUT');

            if (document.getElementById('image').files.length > 0) {
                formData.append('image', document.getElementById('image').files[0]);
            }
            axios.post('/dashboard/book/{{ $book->id }}', formData).then(function(response) {

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
                window.location.href = "/dashboard/book";

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

    <script>

        function performDelete(id, element) {
            axios.delete('/dashboard/media-book/' + id)
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

        function DeleteMedia(id, element) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action will delete the current image of this book!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                console.log(id);
                if (result.isConfirmed) {
                    performDelete(id, element)

                }
            })

        }
    </script>
    <script>
        let category = document.getElementById('category_id').value;
        let category_id_select = document.getElementById('sub_category_id');
        axios.get('/sub-categories/' + category).then(function(response) {
            Swal.showLoading();
            $('#sub_category_id').empty();
            for (index in response.data) {
                let name = response.data[index].name;
                let id = response.data[index].id;
                if (response.data[index].id == {{ $book->sub_category_id }}) {
                    category_id_select.options[category_id_select.options.length] = new Option(name, id, true,
                        true);
                } else {
                    category_id_select.options[category_id_select.options.length] = new Option(name, id);
                }
            }
        }).catch(function(error) {

        }).finally(() => {
            Swal.close();
        });

        $('#category_id').on('change', function() {
            let category = document.getElementById('category_id').value;
            axios.get('/sub-categories/' + category).then(function(response) {
                Swal.showLoading();
                $('#sub_category_id').empty();
                for (index in response.data) {
                    let name = response.data[index].name;
                    let id = response.data[index].id;
                    category_id_select.options[category_id_select.options.length] = new Option(name, id);
                }
            }).catch(function(error) {

            }).finally(() => {
                Swal.close();
            });
        });
    </script>

    <script></script>
@stop
