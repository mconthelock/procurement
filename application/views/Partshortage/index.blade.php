@extends('layouts/template')

@section('contents')
<div class="bg-white rounded-xl shadow-sm p-4">
<!-- Responsive Header Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4 items-start bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <!-- Left Section -->
        <div class="col-span-1 lg:col-span-2">
            <h1 class="header-title uppercase tracking-wider underline decoration-red-600 decoration-4 underline-offset-4 mb-3">Bulk part shortage Report</h1>
            <div class="text-blue-700 font-bold text-lg mb-4 bg-blue-50 inline-block px-3 py-1 rounded-md border border-blue-100">
                Data B/M : 05X/26 (20260424)
            </div>
            
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-2">
                <span class="font-bold text-slate-700 bg-slate-100 px-3 py-1 rounded">(1). Bulk Part shortage</span>
                <div class="flex items-center gap-2">
                    <!--<div class="bg-yellow-300 px-4 py-1 border border-yellow-500 rounded text-sm shadow-inner font-mono">xxxxxx</div>
                    <div class="bg-yellow-300 px-3 py-1 border border-yellow-500 rounded text-sm font-bold shadow-inner">S</div>--->
                    <!--<span class="text-red-600 font-bold ml-2 animate-pulse flex items-center gap-1">
                        <i class="fas fa-exclamation-triangle"></i> Serious shortage
                    </span>--->
                </div>
            </div>
        </div>
        
        <!-- Right Section -->
        <div class="col-span-1 flex flex-col items-start md:items-end w-full">
            <div class="bg-slate-50 border border-slate-300 p-3 rounded-lg text-xs text-left shadow-sm w-full md:w-auto">
                <div class="font-bold mb-2 text-slate-700 border-b border-slate-200 pb-1"><i class="fas fa-info-circle mr-1"></i> Type of reason</div>
                <ul class="space-y-1 text-slate-600">
                    <li><span class="font-bold">A</span> = Usage volume increasing</li>
                    <li><span class="font-bold">B</span> = Vendor delay</li>
                    <li><span class="font-bold">C</span> = Other reason (detail in remark)</li>
                </ul>
            </div>
            <div class="mt-4 text-blue-700 font-semibold bg-blue-50 px-4 py-2 rounded-lg border border-blue-100 flex items-center gap-2">
                <i class="far fa-calendar-alt"></i> Date : {{ date('d-M-Y') }}
            </div>
        </div>
    </div>

    <!-- Table Container -->
        <table id="shortageTable" class="display nowrap w-full text-sm">
            <thead>
                <tr>
                    <th rowspan="2">NO</th>
                    <th rowspan="2">BUYER</th>
                    <th rowspan="2">Job<br>Item</th>
                    <th rowspan="2">ITEM</th>
                    <th rowspan="2">DESCRIPTION</th>
                    <th rowspan="2">DRAWING</th>
                    <th rowspan="2">ONHAND</th>
                    <th rowspan="2">ALLOCATE</th>
                    <th rowspan="2">BALANCE</th>
                    <th colspan="5" class="bg-purple-200 shadow-inner"><i class="fi fi-rr-time-quarter-past text-gray-600 mr-1"></i>SHORTAGE</th>
                    <th rowspan="2">Total<br>Shortage</th>
                    <th rowspan="2">Vender Code</th>
                    <th rowspan="2">Vender Name</th>
                    <th rowspan="2">PO</th>
                    <th rowspan="2">PO QTY</th>
                    <th rowspan="2">PO REMAIN</th>
                    <th rowspan="2">DUE DATE</th>
                    <th colspan="10" class="bg-yellow-100 text-red-600 font-bold tracking-wide shadow-inner"><i class="fi fi-br-square-p text-gray-600 mr-1"></i>INCHARGE BY PUR DEPARTMENT</th>
                </tr>
                <tr>
                    <th class="bg-purple-200">Before 202604X</th>
                    <th class="bg-purple-200">202604A</th>
                    <th class="bg-purple-200">202604B</th>
                    <th class="bg-purple-200">202604C</th>
                    <th class="bg-purple-200">202605X</th>
                    
                    <th class="bg-yellow-100"><i class="fi fi-rr-calendar-days text-gray-500 mr-1"></i>ETD</th>
                    <th class="bg-yellow-100"><i class="fi fi-rr-calendar-days text-gray-500 mr-1"></i>ETA</th>
                    <th class="bg-yellow-100"><i class="fi fi-rs-ship text-gray-500 mr-1"></i>SHIP MODE</th>
                    <th class="bg-yellow-100"><i class="fi fi-rr-calendar-days text-gray-500 mr-1"></i>ARV AMec</th>
                    <th class="bg-yellow-100">ARV Q'TY</th>
                    <th class="bg-yellow-100">Inv.No.</th>
                    <th class="bg-yellow-100">Comment from PUR.</th>
                    <th class="bg-yellow-100"><i class="fi fi-rr-calendar-days text-gray-500 mr-1"></i>Next reply</th>
                    <th class="bg-yellow-100">cause of<br>shortage</th>
                    <th class="bg-yellow-100 text-fuchsia-600">REMARK</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-5 right-5 transform -translate-y-20 opacity-0 transition-all duration-300 z-50 pointer-events-none">
        <div class="bg-white border-l-4 border-green-500 text-slate-700 px-6 py-4 rounded shadow-xl flex items-center gap-3 font-semibold">
            <i class="fas fa-check-circle text-green-500 text-xl"></i>
            <span id="toast-message">Data saved successfully</span>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    {{-- เรียกใช้ไฟล์ที่ Rspack bundle ออกมาแล้ว --}}
    <script src="{{ $_ENV['APP_JS'] }}/partshortage.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection