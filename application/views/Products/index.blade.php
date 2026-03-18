@extends('layouts/template')

@section('contents')
<div class="flex justify-between items-center mb-4 w-full">
    <div>
        <h2 class="card-title text-2xl m-0">{{ $title ?? 'Products Management' }}</h2>
        <p class="text-xs text-gray-500">View and manage procurement items</p>
    </div>
    
     <input type="hidden" id="USER_PERMISSION" value="{{ $permission ?? 'EDIT' }}"> <!--EDIT, VIEWER-->
    <a href="{{ $_ENV['APP_ENV'] }}/Products/create/{{ $permission ?? 'EDIT' }}" class="btn btn-primary btn-sm" id="ADDBTN">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add New Product
    </a>
</div>

<div class="divider m-0 mb-4"></div>

<div class="bg-white rounded-xl shadow-sm p-4">
    <div class="tableArea">
        @include('layouts/datatable_load')
        <table id="table" class="table table-zebra display w-full text-xs"></table>
    </div>
</div>
@endsection

@section('scripts')
    {{-- เรียกใช้ไฟล์ที่ Rspack bundle ออกมาแล้ว --}}
    <script src="{{ $_ENV['APP_JS'] }}/products.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection