@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen mx-auto flex flex-col gap-space-md">
        <input type="hidden" id="app-env" value="{{ $_ENV['APP_ENV'] }}">

        {{-- Section 0: Breadcrumb & System Status Strip --}}
        @include('layouts/breadcrumb')

        {{-- Section 1: Standard Page Header --}}
        @include('ItemMaster/index/header')

        {{-- Section 2: Summary KPI Ribbon --}}
        @include('ItemMaster/index/kpi')

        {{-- Section 3: Status & Type Tabs + Precision Filter Strip --}}
        @include('ItemMaster/index/filters')

        {{-- Section 4: Enterprise Item Master Data Table --}}
        @include('ItemMaster/index/table')

        {{-- Section 5: Corporate Operational Directives Banner --}}
        @include('ItemMaster/index/directives')
    </main>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/ItemMaster.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
