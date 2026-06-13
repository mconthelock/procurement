@extends('layouts/template')

@section('contents')
<div class="flex justify-between items-center mb-2 w-full">
        
        <h2 class="card-title text-2xl m-0">{{ $title ?? 'Vendors Management' }}</h2>
        
        <!-- <button type="button" class="btn btn-primary btn-sm w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Vendor
        </button> -->
    </div>

    <div class="divider m-0"></div>
    <div class="tableArea">
        @include('layouts/datatable_load')
        <table id="table" class="table table-zebra display text-xs"></table>
    </div>
     
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/approval.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
