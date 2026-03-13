@extends('layouts/template')

@section('contents')
<div class="flex justify-between items-center mb-2 w-full">
    <h2 class="card-title text-2xl m-0">{{ $title ?? 'Create New Vendor' }}</h2>
</div>
<div class="divider m-0"></div>

<div class="tabs tabs-boxed bg-gray-100 mb-6 p-1">
    <a id="tab-btn-general" class="tab tab-active font-medium text-base h-10 bg-indigo-600 text-white" onclick="switchTab('general')">1. General Info</a> 
    <a id="tab-btn-codes" class="tab font-medium text-base h-10" onclick="switchTab('codes')">2. Vendor Codes</a> 
    <a id="tab-btn-address" class="tab font-medium text-base h-10" onclick="switchTab('address')">3. Address Details</a> 
</div>

<form action="/vendors/store" method="POST" enctype="multipart/form-data" id="formAddVendor">
    
    <div class="min-h-[650px]">
        
        <div id="tab-content-general" class="tab-content block">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <div class="card bg-base-100 shadow-sm border border-base-200 lg:col-span-2">
                    <div class="card-body">
                        <h3 class="card-title text-lg border-b pb-2">General Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">Vendor Name (English) <span class="text-error">*</span></span></label>
                                <input type="text" name="VND_NAME" class="input input-bordered w-full" required placeholder="Company Name Ltd." />
                            </div>

                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">Vendor Name (Thai)</span></label>
                                <input type="text" name="VND_TNAME" class="input input-bordered w-full" placeholder="บริษัท ตัวอย่าง จำกัด" />
                            </div>

                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">Sales Contact Person</span></label>
                                <input type="text" name="VND_SALE" class="input input-bordered w-full" />
                            </div>
                            
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">Phone Number</span></label>
                                <input type="text" name="ADDR_PHONE" class="input input-bordered w-full" />
                            </div>

                            <div class="form-control w-full md:col-span-2">
                                <label class="label"><span class="label-text font-medium">Website</span></label>
                                <input type="text" name="ADDR_WEB" class="input input-bordered w-full" placeholder="www.example.com" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-sm border border-base-200 lg:col-span-2">
                    <div class="card-body">
                        <div class="flex justify-between items-center border-b pb-2">
                            <h3 class="card-title text-lg m-0">Attachments</h3>
                            <button type="button" id="btnAddFile" class="btn btn-sm btn-outline text-indigo-600 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 outline-none">
                                + Add More File
                            </button>
                        </div>
                        
                        <div id="attachment-container" class="mt-4 space-y-3 max-h-[200px] overflow-y-auto pr-2 custom-scrollbar">
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
        </div> <div id="tab-content-codes" class="tab-content hidden">
            <div class="grid grid-cols-1 gap-6">
                
                <div class="card bg-base-100 shadow-sm border border-base-200">
                    <div class="card-body">
                        <div class="flex justify-between items-center border-b pb-2">
                            <h3 class="card-title text-lg m-0">Vendor Codes <span class="text-error ml-1">*</span></h3>
                            <button type="button" id="btnAddVendorCode" class="btn btn-sm btn-outline text-indigo-600 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 outline-none">
                                + Add Code
                            </button>
                        </div>
                        
                        <div id="vendor-code-container" class="mt-4 space-y-4 max-h-[450px] overflow-y-auto pr-2 custom-scrollbar">
                            <div class="vendor-code-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-gray-50 p-4 rounded-lg border border-gray-100 relative">
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium">Code<span class="text-error">*</span></span></label>
                                    <input type="text" name="CODE_NUM[]" class="input input-bordered w-full bg-white" required placeholder="e.g. VND001" />
                                </div>
                                <div class="form-control w-full md:col-span-2">
                                    <label class="label"><span class="label-text font-medium">Currency</span></label>
                                    <select name="CODE_CURRENCY[]" class="select select-bordered w-full bg-white">
                                        <option value="THB">THB</option>
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="JPY">JPY</option>
                                    </select>
                                </div>
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium">Shipping Term</span></label>
                                    <input type="text" name="CODE_SHIP[]" class="input input-bordered w-full bg-white" placeholder="e.g. FOB" />
                                </div>
                                <div class="form-control w-full md:col-span-3">
                                    <label class="label"><span class="label-text font-medium">Payment Term</span></label>
                                    <input type="text" name="CODE_PAY[]" class="input input-bordered w-full bg-white" placeholder="e.g. 30 Days" />
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
        </div> <div id="tab-content-address" class="tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <div class="card bg-base-100 shadow-sm border border-base-200">
                    <div class="card-body">
                        <h3 class="card-title text-lg border-b pb-2">Address Details (Thai)</h3>
                        <input type="hidden" name="TH_ADDR_TYPE" value="T"> 
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">ที่อยู่ 1 (Address Line 1) <span class="text-error">*</span></span></label>
                            <input type="text" name="TH_ADDR_LINE1" class="input input-bordered w-full" required />
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">ที่อยู่ 2 (Address Line 2)</span></label>
                            <input type="text" name="TH_ADDR_LINE2" class="input input-bordered w-full" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">ที่อยู่ 3 (Address Line 3)</span></label>
                            <input type="text" name="TH_ADDR_LINE3" class="input input-bordered w-full" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">เขต / อำเภอ</span></label>
                                <input type="text" name="TH_ADDR_CITY" class="input input-bordered w-full" />
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">จังหวัด</span></label>
                                <input type="text" name="TH_ADDR_STATE" class="input input-bordered w-full" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">รหัสไปรษณีย์</span></label>
                                <input type="text" name="TH_ADDR_ZIPCODE" class="input input-bordered w-full" />
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">ประเทศ</span></label>
                                <select name="TH_ADDR_COUNTRY" class="select select-bordered w-full">
                                    <option value="66">ไทย</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-sm border border-base-200">
                    <div class="card-body">
                        <h3 class="card-title text-lg border-b pb-2">Address Details (English)</h3>
                        <input type="hidden" name="EN_ADDR_TYPE" value="E"> 
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Address Line 1</span></label>
                            <input type="text" name="EN_ADDR_LINE1" class="input input-bordered w-full" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Address Line 2</span></label>
                            <input type="text" name="EN_ADDR_LINE2" class="input input-bordered w-full" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Address Line 3</span></label>
                            <input type="text" name="EN_ADDR_LINE3" class="input input-bordered w-full" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">City / District</span></label>
                                <input type="text" name="EN_ADDR_CITY" class="input input-bordered w-full" />
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">State / Province</span></label>
                                <input type="text" name="EN_ADDR_STATE" class="input input-bordered w-full" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">Zip Code</span></label>
                                <input type="text" name="EN_ADDR_ZIPCODE" class="input input-bordered w-full" />
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-medium">Country</span></label>
                                <select name="EN_ADDR_COUNTRY" class="select select-bordered w-full">
                                    <option value="66">Thailand</option>
                                    <option value="1">United States</option>
                                    <option value="81">Japan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> </div> <div class="mt-4 flex justify-end gap-3 border-t pt-4">
        <a href="{{ $_ENV['APP_ENV'] }}/vendors" class="btn btn-outline">Cancel</a>
        <button type="submit" class="btn btn-primary px-8 bg-indigo-600 hover:bg-indigo-700 border-none text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
            </svg>
            Save & Send Approve
        </button>
    </div>

</form>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ $_ENV['APP_JS'] }}/vendors.js?ver={{ $GLOBALS['version'] }}"></script>
    <script>
        // ==============================================
        // ฟังก์ชันสลับ 3 TABS
        // ==============================================
        function switchTab(tabName) {
            $('.tab-content').removeClass('block').addClass('hidden');
            $('.tab').removeClass('tab-active bg-indigo-600 text-white');

            if(tabName === 'general') {
                $('#tab-content-general').removeClass('hidden').addClass('block');
                $('#tab-btn-general').addClass('tab-active bg-indigo-600 text-white');
            } 
            else if (tabName === 'codes') {
                $('#tab-content-codes').removeClass('hidden').addClass('block');
                $('#tab-btn-codes').addClass('tab-active bg-indigo-600 text-white');
            }
            else if (tabName === 'address') {
                $('#tab-content-address').removeClass('hidden').addClass('block');
                $('#tab-btn-address').addClass('tab-active bg-indigo-600 text-white');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            
            // ==============================================
            // สคริปต์เพิ่ม Vendor Code
            // ==============================================
            const codeContainer = document.getElementById('vendor-code-container');
            const btnAddCode = document.getElementById('btnAddVendorCode');

            if (btnAddCode && codeContainer) {
                btnAddCode.addEventListener('click', function () {
                    const row = document.createElement('div');
                    row.className = 'vendor-code-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-gray-50 p-4 rounded-lg border border-gray-100 relative mt-4';
                    
                    row.innerHTML = `
                        <div class="form-control w-full md:col-span-3">
                            <label class="label"><span class="label-text font-medium">Code Number <span class="text-error">*</span></span></label>
                            <input type="text" name="CODE_NUM[]" class="input input-bordered w-full bg-white" required placeholder="e.g. VND001" />
                        </div>
                        <div class="form-control w-full md:col-span-2">
                            <label class="label"><span class="label-text font-medium">Currency</span></label>
                            <select name="CODE_CURRENCY[]" class="select select-bordered w-full bg-white">
                                <option value="THB">THB</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <option value="JPY">JPY</option>
                            </select>
                        </div>
                        <div class="form-control w-full md:col-span-3">
                            <label class="label"><span class="label-text font-medium">Shipping Term</span></label>
                            <input type="text" name="CODE_SHIP[]" class="input input-bordered w-full bg-white" placeholder="e.g. FOB" />
                        </div>
                        <div class="form-control w-full md:col-span-3">
                            <label class="label"><span class="label-text font-medium">Payment Term</span></label>
                            <input type="text" name="CODE_PAY[]" class="input input-bordered w-full bg-white" placeholder="e.g. 30 Days" />
                        </div>
                        <div class="form-control md:col-span-1 pb-1">
                            <button type="button" class="btn btn-error btn-square btn-remove-code">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    `;
                    
                    row.querySelector('.btn-remove-code').addEventListener('click', function() {
                        row.remove();
                    });

                    codeContainer.appendChild(row);
                    codeContainer.scrollTop = codeContainer.scrollHeight;
                });

                document.querySelectorAll('.btn-remove-code').forEach(btn => {
                    btn.addEventListener('click', function() {
                        this.closest('.vendor-code-row').remove();
                    });
                });
            }

            // ==============================================
            // สคริปต์การแนบไฟล์
            // ==============================================
            const fileContainer = document.getElementById('attachment-container');
            const btnAddFile = document.getElementById('btnAddFile');

            if (btnAddFile && fileContainer) {
                btnAddFile.addEventListener('click', function () {
                    const row = document.createElement('div');
                    row.className = 'form-control w-full flex-row items-center gap-3 file-row mt-3';
                    
                    row.innerHTML = `
                        <input type="file" name="vendor_file[]" class="file-input file-input-bordered file-input-primary w-full max-w-md" />
                        <button type="button" class="btn btn-error btn-sm btn-square btn-remove-file">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    `;
                    
                    row.querySelector('.btn-remove-file').addEventListener('click', function() {
                        row.remove();
                    });

                    fileContainer.appendChild(row);
                    fileContainer.scrollTop = fileContainer.scrollHeight;
                });
            }
        });
    </script>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9; 
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>
@endsection