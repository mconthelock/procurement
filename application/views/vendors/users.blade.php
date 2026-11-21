@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen mx-auto flex flex-col gap-space-md">
        {{-- Section 0: Breadcrumb & System Status Strip --}}
        @include('layouts/breadcrumb')

        {{-- Section 1: Standard Page Header --}}
        @include('vendors/users/header')

        {{-- Section 2: Summary KPI Ribbon --}}
        @include('vendors/users/kpi')

        {{-- Section 3: Status Tabs & Precision Filter Strip --}}
        @include('vendors/users/filters')

        {{-- Section 4: Enterprise Vendor Users Data Table --}}
        @include('vendors/users/table')

        {{-- Section 5: Corporate Operational Directives Banner --}}
        @include('vendors/users/directives')
    </main>

    {{-- Overlays: Slide-Over Detail Drawer & Create/Edit User Modal --}}
    @include('vendors/users/drawer')
    @include('vendors/users/modal')
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/vendors_users.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
