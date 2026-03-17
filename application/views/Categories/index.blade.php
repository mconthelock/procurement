@extends('layouts/template')

@section('contents')
<div class="flex justify-between items-center mb-4 w-full">
    <div>
        <h2 class="card-title text-2xl m-0 text-primary">{{ $title }}</h2>
        <p class="text-xs opacity-60">Manage product groupings and department owners</p>
    </div>
    <a href="{{ $_ENV['APP_ENV'] }}/Categories/create" class="btn btn-primary btn-sm px-6">
        <i class="fi fi-rr-plus mr-1"></i> Add Category
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm p-4 border">
    <div class="tableArea">
        @include('layouts/datatable_load')
        
        <table id="table" class="table table-zebra display w-full text-xs"></table>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/categories.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection