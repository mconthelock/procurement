@extends('layouts/template')

@section('contents')
    <input type="text" name="VND_ID" id="vnd-id" value="{{ $id }}" class="hidden">
    
    <div class="flex justify-between items-center mb-2 w-full">
        <h2 class="card-title text-2xl m-0">{{ $title ?? 'Vendors Information' }}</h2>
    </div>
    <div class="divider m-0 mb-4"></div>

    <div class="tabs tabs-boxed bg-gray-100 mb-6 p-1">
        <a id="tab-btn-general" class="tab tab-active font-medium text-base h-10 bg-indigo-600 text-white" onclick="switchTab('general')">1. General Info & Attachments</a> 
        <a id="tab-btn-codes" class="tab font-medium text-base h-10" onclick="switchTab('codes')">2. Vendor Codes</a> 
        <a id="tab-btn-address" class="tab font-medium text-base h-10" onclick="switchTab('address')">3. Address Details</a> 
    </div>

    <form action="/vendors/store" method="POST" enctype="multipart/form-data" id="formAddVendor">
        
        <div class="h-[650px] overflow-y-auto overflow-x-hidden custom-scrollbar pr-2 mb-2">
            
            <div id="tab-content-general" class="tab-content block">
                <div class="grid grid-cols-1 gap-6 pb-4">
                    
                    <div class="card bg-base-100 shadow-sm border border-base-200">
                        <div class="card-body">
                            <h3 class="card-title text-lg border-b pb-2">General Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Vendor Name (English)</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-VND_NAME" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>

                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Vendor Name (Thai)</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-VND_TNAME" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>

                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Sales Contact Person</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-VND_SALE" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Phone Number</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_PHONE" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>

                                <div class="form-control w-full md:col-span-2">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Website</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <a id="view-ADDR_WEB" href="#" target="_blank" class="font-medium text-blue-600 hover:underline px-1 break-all">-</a>
                                    </div>
                                </div>

                                <div class="md:col-span-3 divider text-gray-400 text-sm mt-2 mb-0">Record Details</div>

                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Registered By</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-VND_REGNAME" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>

                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Registered Date</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-VND_REGDATE" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>

                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Last Updated</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-VND_LASTUPDATE" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card bg-base-100 shadow-sm border border-base-200">
                        <div class="card-body">
                            <div class="flex justify-between items-center border-b pb-2">
                                <h3 class="card-title text-lg m-0">Attachments</h3>
                            </div>
                            <div id="attachment-container" class="mt-4 space-y-2 px-1">
                                <span class="text-gray-400 italic text-sm">No attachments available.</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
             <div id="tab-content-codes" class="tab-content hidden">
                <div class="grid grid-cols-1 gap-6 pb-4">
                    <div class="card bg-base-100 shadow-sm border border-base-200">
                        <div class="card-body">
                            <h3 class="card-title text-base border-b pb-2">Vendor Codes Details</h3>
                            <div id="view-vendor-code-container" class="mt-2 pr-2">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div id="tab-content-address" class="tab-content hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-4">
                    
                    <div class="card bg-base-100 shadow-sm border border-base-200">
                        <div class="card-body">
                            <h3 class="card-title text-base border-b pb-2">Address Details (Thai)</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium text-gray-500">ที่อยู่ 1 (Address Line 1)</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center"> 
                                        <p id="view-ADDR_TH_LINE1" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium text-gray-500">ที่อยู่ 2 (Address Line 2)</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_TH_LINE2" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium text-gray-500">ที่อยู่ 3 (Address Line 3)</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_TH_LINE3" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">เขต / อำเภอ</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_TH_CITY" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">จังหวัด</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_TH_STATE" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">รหัสไปรษณีย์</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_TH_ZIPCODE" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium text-gray-500">ประเทศ</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_TH_COUNTRY" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-base-100 shadow-sm border border-base-200">
                        <div class="card-body">
                            <h3 class="card-title text-base border-b pb-2">Address Details (English)</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Address Line 1</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_EN_LINE1" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Address Line 2</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_EN_LINE2" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Address Line 3</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_EN_LINE3" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">City / District</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_EN_CITY" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">State / Province</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_EN_STATE" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Zip Code</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_EN_ZIPCODE" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                                
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Country</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_EN_COUNTRY" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> </div> </form>
    
    <div class="btn-container flex justify-end gap-3 border-t pt-4">
    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ $_ENV['APP_JS'] }}/vendors_detail.js?ver={{ $GLOBALS['version'] }}"></script>
    <script>
        // ==============================================
        // ฟังก์ชันสลับ TAB ด้วย Vanilla JS
        // ==============================================
        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(function(el) {
                el.classList.remove('block');
                el.classList.add('hidden');
            });
            
            document.querySelectorAll('.tab').forEach(function(el) {
                el.classList.remove('tab-active', 'bg-indigo-600', 'text-white');
            });

            const activeContent = document.getElementById('tab-content-' + tabName);
            const activeBtn = document.getElementById('tab-btn-' + tabName);

            if (activeContent && activeBtn) {
                activeContent.classList.remove('hidden');
                activeContent.classList.add('block');
                
                activeBtn.classList.add('tab-active', 'bg-indigo-600', 'text-white');
            }
        }
    </script>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
@endsection