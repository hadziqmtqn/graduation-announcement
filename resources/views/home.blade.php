<!doctype html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{ url('https://hadziqmtqn.github.io/materialize/assets/') }}" data-template="vertical-menu-template">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Pengumuman Kelulusan | {{ config('app.name') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo-mikurkid.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/fonts/materialdesignicons.css') }}" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/typeahead-js/typeahead.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/css/pages/page-misc.css') }}" />

    <!-- Helpers -->
    <script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/js/config.js') }}"></script>
</head>

<body>
<!-- Content -->
<div class="misc-wrapper">
    <img src="{{ asset('assets/logo-mikurkid.png') }}" alt="logo" class="mb-4" style="width: 130px">
    <h4 class="mb-2 mx-2">Pengumuman Kelulusan {{ config('app.name') }}</h4>
    <h4 class="mb-2 mx-2">Tahun Ajaran {{ $schoolYearActive['year'] }}</h4>
    <div class="alert alert-danger alert-dismissible text-center mx-2" style="margin-top: 6em" role="alert">
        <h4 class="alert-heading d-flex align-items-center mb-0">
            <i class="mdi mdi-clock-outline mdi-24px me-2"></i>
            <span id="countdown-title">Waktu Pengumuman Kelulusan</span>
        </h4>
        <div id="countdown-timer" class="mt-3"></div>
    </div>
    {{--start date formated Y-m-d H:i:s--}}
    <div data-start-date="{{ $schoolYearActive['announcementStartDateFormated'] }}" data-end-date="{{ $schoolYearActive['announcementEndDateFormated'] }}"></div>
    
    <div class="d-flex justify-content-center mt-5">
        <img src="{{ url('https://hadziqmtqn.github.io/materialize/assets/img/illustrations/misc-under-maintenance-object.png') }}" alt="misc-under-maintenance" class="img-fluid misc-object d-none d-lg-inline-block" width="170" />
        <img src="{{ url('https://hadziqmtqn.github.io/materialize/assets/img/illustrations/misc-bg-light.png') }}" alt="misc-under-maintenance" class="misc-bg d-none d-lg-inline-block" data-app-light-img="illustrations/misc-bg-light.png" data-app-dark-img="illustrations/misc-bg-dark.png" />
    </div>
</div>
<!-- / Content -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/menu.js') }}"></script>

<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('js/home/countdown-time.js') }}"></script>
</body>
</html>
