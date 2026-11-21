@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen">
        <div class="w-full mx-auto flex flex-col gap-space-lg">
            @include('vendors/list/header')
            @include('vendors/list/kpi')
            @include('vendors/list/filters')
            @include('vendors/list/table')
            @include('vendors/list/footer')
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/vendors.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
