@extends('layouts/template')

@section('contents')
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/apps/vendors.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
