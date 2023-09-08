<!DOCTYPE html>
@if(LaravelLocalization::getCurrentLocale() == "ar")
<html lang="ar" dir="rtl">
@else
<html>
@endif

<html>
<!--begin::Head-->

<head>
    <base href="../../../">
    <title>E-book</title>
    <meta charset="utf-8" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{ asset('dist/assets/media/logos/logo_icon.png') }}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('dist/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!--sweetalert-->
    <link rel="stylesheet" href="sweetalert2.min.css">
    <!--end::Global Stylesheets Bundle-->
    @yield('css')
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-body">
    <div id="kt_header" class="header" style="margin-top: 10px;">
        <!--begin::Container-->
        <div class="container-fluid d-flex align-items-center flex-wrap justify-content-between" id="kt_header_container">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a rel="alternate" hreflang="{{ $localeCode }}"
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                            @if ($localeCode == LaravelLocalization::getCurrentLocale()) ?
                style="color: #181c32;"
                @else
                style="color: #858ba9c4;" @endif>
                            {{ strtoupper($localeCode) }}
                        </a>
                    @endforeach

                </li>
            </ul>
        </div>
    </div>
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication-->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
            style="background-image: url({{ asset('dist/assets/media/illustrations/dozzy-1/14.png') }})">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <a href="{{ route('home') }}" class="mb-12">
                    <img alt="Logo" src="{{ asset('dist/assets/media/logos/logo_aside.png') }}" class="h-40px" />
                </a>
                <!--end::Logo-->
                @yield('content')
            </div>
            <!--end::Content-->

        </div>
        <!--end::Authentication -->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('dist/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('dist/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    <!--axios and swwetalert-->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('js')
</body>
<!--end::Body-->

</html>
