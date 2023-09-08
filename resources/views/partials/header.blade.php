<!--begin::Header-->
<div id="kt_header" class="header">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-center flex-wrap justify-content-between"
        id="kt_header_container">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-2 pb-5 pb-lg-0 pt-7 pt-lg-0"
            data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
            @yield('heading_title')
        </div>
        <!--end::Page title=-->
        <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                    <a rel="alternate" hreflang="{{ $localeCode }}"
                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                        @if ($localeCode == LaravelLocalization::getCurrentLocale()) ?
                        style="color: #181c32;"
                        @else
                        style="color: #858ba9c4;"
                        @endif>
                        {{ strtoupper($localeCode) }}
                    </a>
                    @endforeach

                </li>
        </ul>
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->
