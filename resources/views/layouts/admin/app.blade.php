
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/sidebar/lib/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/sidebar/lib/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/sidebar/lib/css/theme.min.css') }}" />
    @yield('css_2')
    <script src="{{ asset('admin/sidebar/lib/html5_shiv_3.7.3/dist/html5shiv.min.js') }}"></script>
    <script src="{{ asset('admin/sidebar/lib/respond_1.4.2/dist/respond.min.js') }}"></script>
@endsection

@section('content')
    @yield('content_2')
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
    <script src="{{ asset('admin/sidebar/lib/js') }}"></script>
    @yield('js_2')
@endsection
