<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-wide" dir="ltr" data-theme="theme-default" data-assets-path="https://hadziqmtqn.github.io/materialize/assets/" data-template="front-pages">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Kelulusan | {{ config('app.name') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo-mikurkid.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/fonts/materialdesignicons.css') }}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/css/pages/front-page.css') }}" />
    <!-- Vendors CSS -->

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/css/pages/front-page-help-center.css') }}" />

    <!-- Helpers -->
    <script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/js/front-config.js') }}"></script>
</head>

<body>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/dropdown-hover.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/mega-dropdown.js') }}"></script>

<nav class="layout-navbar container shadow-none py-0">
    <div class="navbar navbar-expand-lg landing-navbar border-top-0 px-3 px-md-4">
        <!-- Menu logo wrapper: Start -->
        <div class="navbar-brand app-brand demo d-flex py-0 py-lg-2 me-4">
            <!-- Mobile menu toggle: Start-->
            <button class="navbar-toggler border-0 px-0 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="tf-icons mdi mdi-menu mdi-24px align-middle"></i>
            </button>
            <!-- Mobile menu toggle: End-->
            <a href="/" class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img src="{{ asset('assets/logo-mikurkid.png') }}" alt="logo" style="max-width: 50px">
                </span>
            </a>
        </div>
        <!-- Menu logo wrapper: End -->
        <!-- Menu wrapper: Start -->
        <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
            <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="tf-icons mdi mdi-close"></i>
            </button>
            <ul class="navbar-nav me-auto p-3 p-lg-0">
            </ul>
        </div>
        <div class="landing-menu-overlay d-lg-none"></div>
        <!-- Menu wrapper: End -->
        <!-- Toolbar: Start -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Style Switcher -->
            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="mdi mdi-24px mdi-weather-sunny"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);" data-theme="light">
                            <span class="align-middle"><i class="mdi mdi-weather-sunny me-2"></i>Light</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);" data-theme="dark">
                            <span class="align-middle"><i class="mdi mdi-weather-night me-2"></i>Dark</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);" data-theme="system">
                            <span class="align-middle"><i class="mdi mdi-monitor me-2"></i>System</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- / Style Switcher-->

            <!-- navbar button: Start -->
            <li>
                <a href="{{ route('login') }}" class="btn btn-primary px-2 px-sm-4 px-lg-2 px-xl-4 waves-effect waves-light" target="_blank"><span class="tf-icons mdi mdi-account me-md-1"></span><span class="d-none d-md-block">Login</span></a>
            </li>
            <!-- navbar button: End -->
        </ul>
        <!-- Toolbar: End -->
    </div>
</nav>

<section class="section-py first-section-pt help-center-header">
    <div class="container">
        <h3 class="text-center mb-2">Pengumuman Kelulusan {{ config('app.name') }}</h3>
        <h4 class="text-center mb-2">Tahun Ajaran {{ $schoolYearActive['year'] }}</h4>
        <div data-start-date="{{ $schoolYearActive['announcementStartDate'] }}" data-end-date="{{ $schoolYearActive['announcementEndDate'] }}"></div>

        <h1 class="text-center text-primary display-6 fw-semibold" id="countdown-title" style="margin-top: 3em"></h1>
        <div id="countdown-timer" class="text-center mt-3"></div>

        @if($schoolYearActive['announcementIsOpen'])
            <form action="#" method="get">
                <div class="input-wrapper my-3 input-group input-group-lg input-group-merge position-relative mx-auto">
                    <span class="input-group-text" id="basic-addon1"><i class="tf-icons mdi mdi-magnify"></i></span>
                    <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                    <button type="submit" class="btn btn-primary waves-light waves-effect">Cari</button>
                </div>
            </form>
        @endif
    </div>
</section>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/node-waves/node-waves.js') }}"></script>

<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/js/front-main.js') }}"></script>

<!-- Page JS -->
{{--<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/js/front-page-pricing.js') }}"></script>--}}
<script src="{{ asset('js/home/countdown-time.js') }}"></script>
</body>
</html>
