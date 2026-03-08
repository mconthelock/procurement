@extends('layouts/template')

@section('contents')
    <h2 class="card-title text-2xl">{{ $title ?? 'Vendors Management' }}</h2>
    <div class="divider m-0"></div>
    <div class="tableArea">
        @include('layouts/datatable_load')
        <table id="table" class="table table-zebra display text-xs"></table>
    </div>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/vendors.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
