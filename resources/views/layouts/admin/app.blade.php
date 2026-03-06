
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/sidebar/lib/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/sidebar/lib/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/sidebar/lib/css/theme.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/styles.css') }}">
    @yield('css_2')
    <script src="{{ asset('admin/sidebar/lib/html5_shiv_3.7.3/dist/html5shiv.min.js') }}"></script>
    <script src="{{ asset('admin/sidebar/lib/respond_1.4.2/dist/respond.min.js') }}"></script>
@endsection

@section('content')
    @include('layouts.admin.sidebar')
    @include('layouts.admin.header')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    @if(View::hasSection('breadcrumb'))
                        @yield('breadcrumb')
                    @else
                        <x-breadcrumb title="{{ __('dashboard.sidebar.dashboard') }}" :items="[]"/>
                    @endif
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="fa-solid fa-arrow-left me-2"></i>
                                <span>{{ __('dashboard.header.back') }}</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <div id="reportranges" class="d-flex align-items-center">
                                <span id="show-date"></span>
                            </div>
                        </div>
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="fa-solid fa-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>
            @yield('content_2')
        </div>
    </main>
@endsection

@section('js')
    <script src="{{ asset('admin/sidebar/lib/js/vendors.min.js') }}"></script>
    <script src="{{ asset('admin/sidebar/lib/js/vendors.min.js') }}"></script>
    <script src="{{ asset('admin/sidebar/lib/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('admin/sidebar/lib/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/sidebar/lib/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('admin/sidebar/lib/js/common-init.min.js') }}"></script>
    <script src="{{ asset('admin/sidebar/lib/js/dashboard-init.min.js') }}"></script>
    <script src="{{ asset('admin/sidebar/lib/js/theme-customizer-init.min.js') }}"></script>
    <script src="{{ asset('admin/sidebar/lib/js/nxlNavigation.min.js') }}"></script>
    @yield('js_2')
    <script>
        const today = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const formattedDate = today.toLocaleDateString('fr-FR', options);
        document.getElementById('show-date').textContent = formattedDate;
    </script>
@endsection
