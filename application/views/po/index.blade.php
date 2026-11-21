@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen mx-auto flex flex-col gap-space-md">
        {{-- Section 0: Breadcrumb & System Status Strip --}}
        @include('layouts/breadcrumb')

        {{-- Section 1: Standard Page Header --}}
        @include('po/index/header')

        {{-- Section 2: Summary KPI Ribbon --}}
        @include('po/index/kpi')

        {{-- Section 3: Status Tabs & Precision Filter Strip --}}
        @include('po/index/filters')

        {{-- Section 4: Enterprise Purchase Orders Data Table --}}
        @include('po/index/table')

        {{-- Section 5: Corporate Operational Directives Banner --}}
        @include('po/index/directives')
    </main>

    {{-- Overlay: Bulk Acknowledge Modal --}}
    @include('po/index/modal')
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/po.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
