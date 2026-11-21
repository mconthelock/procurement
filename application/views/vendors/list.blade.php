@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen mx-auto flex flex-col gap-space-md">
        {{-- Section 0: Breadcrumb & System Status Strip --}}
        @include('layouts/breadcrumb')

        {{-- Section 1: Standard Page Header (General User Read-Only) --}}
        @include('vendors/list/header')

        {{-- Section 2: Summary KPI Ribbon --}}
        @include('vendors/list/kpi')

        {{-- Section 3: Group Tabs & Precision Filter Strip --}}
        @include('vendors/list/filters')

        {{-- Section 4: General Information Data Table --}}
        @include('vendors/list/table')

        {{-- Section 5: Operational Directives Banner --}}
        @include('vendors/list/directives')
    </main>

    {{-- Overlay: Slide-Over General Information Drawer (Read-Only) --}}
    @include('vendors/list/drawer')
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/vendors_list.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
