@extends('layouts.dashboard_layout')

@section('css')
    <link href="dist/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@stop

@section('page_title')
    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Change Password</h1>
@stop

@section('content')
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::details View-->
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            {{-- <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bolder m-0">Change Password</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header--> --}}
            <!--begin::Card body-->
            <div class="card-body p-9">
          <!--begin::Form-->
						<form class="form w-100" id="reset_password_form" onsubmit="event.preventDefault(); performChangePassword();" autocomplete="off">
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark mb-3">Setup New Password</h1>
								<!--end::Title-->
								{{-- <!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-4">Already have reset your password ?
								<a href="{{route('login')}}" class="link-primary fw-bolder">Sign in here</a></div>
								<!--end::Link--> --}}
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="mb-10 fv-row" data-kt-password-meter="true">
								<!--begin::Wrapper-->
								<div class="mb-1">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-dark fs-6">Current Password</label>
									<!--end::Label-->
									<!--begin::Input wrapper-->
									<div class="position-relative mb-3">
										<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="off" id="password"/>
										<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
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
								<label class="form-label fw-bolder text-dark fs-6">New Password</label>
								<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="new_password" autocomplete="off" id="new_password"/>
							</div>
							<!--end::Input group=-->
                            <!--begin::Input group=-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-dark fs-6">Confirm New Password</label>
								<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm_new_password" autocomplete="off" id="confirm_new_password"/>
							</div>
							<!--end::Input group=-->
							<!--begin::Actions-->
                            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{route('home')}}" class="btn btn-lg btn-light-primary fw-bolder">Cancel</a>
                            </div>
                            <!--end::Actions-->
						</form>
						<!--end::Form-->

            </div>
            <!--end::Card body-->
        </div>
        <!--end::details View-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
@stop
@section('js')
        <!--begin::Page Custom Javascript(used by this page)-->
		{{-- <script src="dist/assets/js/custom/authentication/password-reset/new-password.js"></script> --}}
		<!--end::Page Custom Javascript-->
        <script>
            function performChangePassword() {
                let formData = new FormData();
                formData.append('password', document.getElementById('password').value);
                formData.append('new_password', document.getElementById('new_password').value);
                formData.append('confirm_new_password', document.getElementById('confirm_new_password').value);

                axios.post('/dashboard/change-password', formData).then(function(response) {

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
                    document.getElementById('reset_password_form').reset();

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

