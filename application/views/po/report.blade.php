@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen mx-auto flex flex-col gap-space-md">
        {{-- Section 0: Breadcrumb & System Status Strip --}}
        @include('layouts/breadcrumb')

        {{-- Section 1: Standard Page Header --}}
        @include('po/report/header')

        {{-- Section 2: Precision Search & Query Criteria Panel --}}
        @include('po/report/criteria')

        {{-- Section 3: Filtered Query Summary KPI Ribbon --}}
        @include('po/report/kpi')

        {{-- Section 4: Enterprise Search Results Data Table --}}
        @include('po/report/table')

        {{-- Section 5: Reporting Directives Banner --}}
        @include('po/report/directives')
    </main>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/po_report.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
