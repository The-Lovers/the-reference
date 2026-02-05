@extends('layouts.admin.app')

@section('content_2')
    @include('layouts.admin.sidebar')
    @include('layouts.admin.header')
    <main class="nxl-container">
        <div class="nxl-content">
            @include('layouts.admin.head')
            @include('layouts.admin.card-report')
        </div>
    </main>
@endsection
