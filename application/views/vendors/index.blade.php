@extends('layouts/template')

@section('contents')
    <div class="w-full mx-auto mb-8 flex flex-col gap-5">
        @include('layouts/header')
        @include('vendors/filters')
        <div class="tableArea">
            @include('layouts/datatable_load')
            <table id="table" class="table table-zebra display text-xs"></table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/vendors.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
