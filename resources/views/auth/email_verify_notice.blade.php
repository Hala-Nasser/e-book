<link href="{{ asset('dist/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--sweetalert-->
<link rel="stylesheet" href="sweetalert2.min.css">

<style>
    html,
    body {
        padding: 0;
        margin: 0;
    }
</style>
<div
    style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
        <tbody>
            <tr>
                <td align="center" valign="center" style="text-align:center; padding: 40px">
                    <a href="https://keenthemes.com" rel="noopener" target="_blank">
                        <img alt="Logo" src="{{ asset('dist/assets/media/logos/logo_aside.png') }}"
                            style="height:40px;" />
                    </a>
                </td>
            </tr>
            <tr>
                <td align="left" valign="center">
                    <div
                        style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px">
                        <!--begin:Email content-->
                        <div style="padding-bottom: 30px; font-size: 17px;">
                            <strong>Welcome to E-book!</strong>
                        </div>
                        <div style="padding-bottom: 30px">To activate your account, please click on the button below to
                            verify your email address. Once activated, you’ll .</div>
                        <form>
                            <div style="padding-bottom: 40px; text-align:center;">
                                <button type="button" onclick="sendVerificationEmail();" class="btn btn-primary btn-block">Send
                                    verification email</button>
                            </div>
                        </form>

                        <!--end:Email content-->
                        <div style="padding-bottom: 10px">Kind regards,
                            <br>The E-book Team.
            <tr>
                <td align="center" valign="center"
                    style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
                    <p>Copyright ©
                        <a href="" rel="noopener" target="_blank">E-book</a>.
                    </p>
                </td>
            </tr></br>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>

<!--axios and swwetalert-->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function sendVerificationEmail() {

        axios.post('/dashboard/verification-notification')
            .then(function(response) {

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
                // document.getElementById('login_form').reset();
                // window.location.href = "/dashboard/home";

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
