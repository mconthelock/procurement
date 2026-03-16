@extends('layouts/template')

@section('contents')
    <input type="text" name="VND_ID" id="vnd-id" value="{{ $id }}" class="hidden">
    
    <div class="flex justify-between items-center mb-2 w-full">
        <h2 class="card-title text-2xl m-0">{{ $title ?? 'Vendors Information' }}</h2>
        <div id="view-VND_STATUS" class="badge badge-success text-white px-3 py-3 rounded-full font-medium">
                Active
        </div>
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
                                        <p id="view-VND_NAME" class="view-mode font-medium text-base px-1">-</p>
                                        <input type="text" id="input-VND_NAME" name="VND_NAME" class="edit-mode input input-bordered w-full hidden" >
                                    </div>
                                    
                                </div>

                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Vendor Name (Thai)</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-VND_TNAME" class="view-mode font-medium text-base px-1">-</p>
                                        <input type="text" id="input-VND_TNAME" name="VND_TNAME" class="edit-mode input input-bordered w-full hidden" >
                                    </div>
                                 
                                </div>

                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Sales Contact Person</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-VND_SALE" class="view-mode font-medium text-base px-1">-</p>
                                        <input type="text" id="input-VND_SALE" name="VND_SALE" class="edit-mode input input-bordered w-full hidden" >
                                    </div>
                                    
                                </div>
                                
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Phone Number</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-ADDR_PHONE" class="view-mode font-medium text-base px-1">-</p>
                                        <input type="text" id="input-ADDR_PHONE" name="ADDR_PHONE" class="edit-mode input input-bordered w-full hidden" >
                                    </div>
                                </div>

                                <div class="form-control w-full md:col-span-2">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Website</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <a id="view-ADDR_WEB" href="#" target="_blank" class="view-mode font-medium text-blue-600 hover:underline px-1 break-all">-</a>
                                        <input type="text" id="input-ADDR_WEB" name="ADDR_WEB" class="edit-mode input input-bordered w-full hidden" >
                                    </div>
                                 
                                </div>

                                <div class="view-mode md:col-span-3 divider text-gray-400 text-sm mt-2 mb-0">Record Details</div>
                                <div class="view-mode form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Registered By</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-VND_REGNAME" class="font-medium text-base px-1">-</p>
                                    </div>

                                </div>

                                <div class="view-mode form-control w-full">
                                    <label class="label"><span class="label-text font-medium text-gray-500">Registered Date</span></label>
                                    <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <p id="view-VND_REGDATE" class="font-medium text-base px-1">-</p>
                                    </div>
                                </div>

                                <div class="view-mode form-control w-full">
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
                                <button type="button" id="btnAddFile" class="edit-mode btn btn-sm btn-outline text-indigo-600 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 outline-none hidden">
                                + Add More File
                            </button>
                            </div>
                         
                            <div id="existing-files-container" class="mt-4 space-y-3 max-h-[200px] overflow-y-auto pr-2      custom-scrollbar">
                            </div>
                            <div id="edit-attachment-container" class="edit-mode mt-4 space-y-3 max-h-[200px] overflow-y-auto pr-2 custom-scrollbar hidden">
                            <div class="form-control w-full flex-row items-center gap-3 file-row">
                                <input type="file" name="vendor_file[]" class="file-input file-input-bordered file-input-primary w-full max-w-md" />
                                <button type="button" class="btn btn-error btn-sm btn-square btn-remove-file hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </div>
                        </div>
                    </div>

                </div>
            </div>
        <div id="tab-content-codes" class="tab-content hidden">
            <div class="grid grid-cols-1 gap-6 pb-4">
                <div class="card bg-base-100 shadow-sm border border-base-200">
                    <div class="card-body">
                        
                        <div class="flex justify-between items-center border-b pb-2">
                            <h3 class="card-title text-base m-0">Vendor Codes Details</h3>
                            
                            <button type="button" id="btnAddVendorCode" class="edit-mode hidden btn btn-sm btn-outline text-indigo-600 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 outline-none">
                                + Add Code
                            </button>
                        </div>
                        
                        <div id="view-vendor-code-container" class="mt-4 pr-2">
                        </div>
                        <div id="edit-vendor-code-container" class="edit-mode mt-4 pr-2 hidden">
                        <div class="vendor-code-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-gray-50 p-4 rounded-lg border border-gray-100 relative mb-4">
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium">Code<span class="text-error">*</span></span></label>
                                    <input type="text" name="CODE_NUM[]" class="input input-bordered w-full bg-white" required placeholder="e.g. VND001" />
                                </div>
                                <div class="form-control w-full md:col-span-2">
                                    <label class="label"><span class="label-text font-medium">Currency</span></label>
                                    <select name="CODE_CURRENCY[]" class="select select-bordered w-full bg-white currency-select">
                                 <option value="" disabled selected>Select Currency...</option>
                                    </select>
                                </div>
                                <!-- <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium">Shipping Term</span></label>
                                    <input type="text" name="CODE_SHIP[]" class="input input-bordered w-full bg-white" placeholder="e.g. FOB" />
                                </div> -->
                                                <div class="form-control w-full md:col-span-3">
                                                    <label class="label"><span class="label-text font-medium">Payment Term</span></label>
                                        <select name="CODE_PAY[]" class="select select-bordered w-full bg-white payment-select" required>
                        <option value="" disabled selected>Select Payment Term...</option>
                    </select>
                                                </div>
                                                <div class="form-control md:col-span-1 pb-1">
                                                    <button type="button" class="btn btn-error btn-square btn-remove-code">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                        </div>
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
                            <p id="view-ADDR_TH_LINE1" class="view-mode font-medium text-base px-1">-</p>
                            <input type="text" id="input-ADDR_TH_LINE1" name="ADDR_TH_LINE1" class="edit-mode input input-bordered w-full hidden">
                        </div>
                    </div>

                    <div class="form-control w-full md:col-span-3">
                        <label class="label"><span class="label-text font-medium text-gray-500">ที่อยู่ 2 (Address Line 2)</span></label>
                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                            <p id="view-ADDR_TH_LINE2" class="view-mode font-medium text-base px-1">-</p>
                            <input type="text" id="input-ADDR_TH_LINE2" name="ADDR_TH_LINE2" class="edit-mode input input-bordered w-full hidden"> 
                        </div>
                    </div>

                    <div class="form-control w-full md:col-span-3">
                        <label class="label"><span class="label-text font-medium text-gray-500">ที่อยู่ 3 (Address Line 3)</span></label>
                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                            <p id="view-ADDR_TH_LINE3" class="view-mode font-medium text-base px-1">-</p>
                            <input type="text" id="input-ADDR_TH_LINE3" name="ADDR_TH_LINE3" class="edit-mode input input-bordered w-full hidden">
                        </div>
                       
                    </div>
                </div>

                <div class="view-mode grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-medium text-gray-500">ตำบล/แขวง</span></label>
                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                            <p id="view-ADDR_TH_SUBDISTRICT" class="font-medium text-base px-1">-</p>
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
                    <div class="form-control w-full md:col-span-2">
                        <label class="label"><span class="label-text font-medium text-gray-500">ประเทศ</span></label>
                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                            <p id="view-ADDR_TH_COUNTRY" class="font-medium text-base px-1">-</p>
                        </div>
                    </div>
                </div>

                <div class="edit-mode hidden grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 bg-indigo-50/50 p-4 rounded-lg border border-indigo-100">
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-medium text-indigo-700">จังหวัด</span></label>
                        <select id="input-ADDR_TH_STATE" name="ADDR_TH_STATE" class="select select-bordered w-full font-normal state-select">
                        </select>
                    </div>
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-medium text-indigo-700">อำเภอ/เขต</span></label>
                        <select id="input-ADDR_TH_CITY" name="ADDR_TH_CITY" class="select select-bordered w-full font-normal city-select">
                            <option value="" disabled selected>เลือกอำเภอ</option>
                        </select>
                    </div>
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-medium text-indigo-700">ตำบล/แขวง</span></label>
                        <select id="input-ADDR_TH_SUBDISTRICT" name="ADDR_TH_SUBDISTRICT" class="select select-bordered w-full font-normal subdistrict-select">
                            <option value="" disabled selected>เลือกตำบล</option>
                        </select>
                    </div>
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-medium text-indigo-700">รหัสไปรษณีย์</span></label>
                        <input type="text" id="input-ADDR_TH_ZIPCODE" name="ADDR_ZIPCODE" class="input input-bordered w-full">
                    </div>
                    <div class="form-control w-full md:col-span-2">
                        <label class="label"><span class="label-text font-medium text-indigo-700">ประเทศ</span></label>
                              <select name="ADDR_TH_COUNTRY" class="select select-bordered w-full">
                                    <option value="66">Thailand</option>
                                    <option value="1">United States</option>
                                    <option value="81">Japan</option>
                                </select>
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
                            <p id="view-ADDR_EN_LINE1" class="view-mode font-medium text-base px-1">-</p>
                              <input type="text" id="input-ADDR_EN_LINE1" name="ADDR_EN_LINE1" class="edit-mode input input-bordered w-full hidden">
                        </div>
                    </div>

                    <div class="form-control w-full md:col-span-3">
                        <label class="label"><span class="label-text font-medium text-gray-500">Address Line 2</span></label>
                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                            <p id="view-ADDR_EN_LINE2" class="view-mode font-medium text-base px-1">-</p>
                            <input type="text" id="input-ADDR_EN_LINE2" name="ADDR_EN_LINE2" class="edit-mode input input-bordered w-full hidden">
                        </div>
                    </div>

                    <div class="form-control w-full md:col-span-3">
                        <label class="label"><span class="label-text font-medium text-gray-500">Address Line 3</span></label>
                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                            <p id="view-ADDR_EN_LINE3" class="view-mode font-medium text-base px-1">-</p>
                            <input type="text" id="input-ADDR_EN_LINE3" name="ADDR_EN_LINE3" class="edit-mode input input-bordered w-full hidden">
                        </div>
                      
                    </div>
                </div>

                <div class="view-mode grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-medium text-gray-500">Sub-district</span></label>
                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                            <p id="view-ADDR_EN_SUBDISTRICT" class="font-medium text-base px-1">-</p>
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
                    <div class="form-control w-full md:col-span-2">
                        <label class="label"><span class="label-text font-medium text-gray-500">Country</span></label>
                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                            <p id="view-ADDR_EN_COUNTRY" class="font-medium text-base px-1">-</p>
                        </div>
                    </div>
                </div>

                <div class="edit-mode hidden grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 bg-indigo-50/50 p-4 rounded-lg border border-indigo-100">
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-medium text-indigo-700">State / Province</span></label>
                        <input type="text" id="input-ADDR_EN_STATE" name="ADDR_EN_STATE" class="input input-bordered w-full" >
                    </div>
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-medium text-indigo-700">City / District</span></label>
                        <input type="text" id="input-ADDR_EN_CITY" name="ADDR_EN_CITY" class="input input-bordered w-full" >
                    </div>
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-medium text-indigo-700">Sub-district</span></label>
                        <input type="text" id="input-ADDR_EN_SUBDISTRICT" name="ADDR_EN_SUBDISTRICT" class="input input-bordered w-full" placeholder="Sub-district">
                    </div>
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-medium text-indigo-700">Zip Code</span></label>
                        <input type="text" id="input-ADDR_EN_ZIPCODE" name="ADDR_EN_ZIPCODE" class="input input-bordered w-full">
                    </div>
                    <div class="form-control w-full md:col-span-2">
                        <label class="label"><span class="label-text font-medium text-indigo-700">Country</span></label>
                            <select name="ADDR_EN_COUNTRY" class="select select-bordered w-full">
                                    <option value="66">Thailand</option>
                                    <option value="1">United States</option>
                                    <option value="81">Japan</option>
                                </select>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
        </div> 
    </form>
    
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