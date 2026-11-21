@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen mx-auto flex flex-col gap-space-md">
        @include('layouts/breadcrumb')
        @include('vendors/index/header')
        @include('vendors/index/kpi')
        @include('vendors/index/filters')
        @include('vendors/index/table')
    </main>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/vendors.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
