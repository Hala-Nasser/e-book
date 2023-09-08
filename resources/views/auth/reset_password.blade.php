@extends('layouts.auth_layout')

@section('css')
@stop

@section('content')
    <!--begin::Wrapper-->
    <div class="w-lg-550px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
        <!--begin::Form-->
        <form class="form w-100">
            <!--begin::Heading-->
            <div class="text-center mb-10">
                <!--begin::Title-->
                <h1 class="text-dark mb-3">{{ trans('reset_password.title') }}</h1>
                <!--end::Title-->
            </div>
            <!--begin::Heading-->
            <!--begin::Input group-->
            <div class="mb-10 fv-row" data-kt-password-meter="true">
                <!--begin::Wrapper-->
                <div class="mb-1">
                    <!--begin::Label-->
                    <label class="form-label fw-bolder text-dark fs-6">{{ trans('reset_password.password') }}</label>
                    <!--end::Label-->
                    <!--begin::Input wrapper-->
                    <div class="position-relative mb-3">
                        <input class="form-control form-control-lg form-control-solid" type="password" placeholder=""
                            name="password" autocomplete="off" id="password" />
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                            data-kt-password-meter-control="visibility">
                            <i class="bi bi-eye-slash fs-2"></i>
                            <i class="bi bi-eye fs-2 d-none"></i>
                        </span>
                    </div>
                    <!--end::Input wrapper-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Input group=-->
            <!--begin::Input group=-->
            <div class="fv-row mb-10">
                <label class="form-label fw-bolder text-dark fs-6">{{ trans('reset_password.confirm_password') }}</label>
                <input class="form-control form-control-lg form-control-solid" type="password" placeholder=""
                    name="confirm-password" autocomplete="off" id="confirm-password" />
            </div>
            <!--end::Input group=-->
            <!--begin::Action-->
            <div class="text-center">
                <button type="button" onclick="resetPassword();"
                    class="btn btn-lg btn-primary fw-bolder">{{ trans('general.save') }}</button>
            </div>
            <!--end::Action-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Wrapper-->

@stop
@section('js')

    <script>
        function resetPassword() {

            axios.post('/reset-password', {
                email: '{{ $email }}',
                token: '{{ $token }}',
                password: document.getElementById('password').value,
                confirm_password: document.getElementById('confirm-password').value,
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

                window.location.href = "/dashboard/login";
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
