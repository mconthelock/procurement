@extends('layouts/template')

@section('contents')
    <input type="text" name="VND_ID" id="vnd-id" value="{{ $id }}" class="hidden">
    <h2 class="card-title text-2xl">{{ $title ?? 'Vendors Information' }}</h2>
    <div class="divider m-0"></div>
    <div class="btn-container flex gap-3"></div>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/vendors_detail.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
