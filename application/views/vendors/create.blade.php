@extends('layouts/template')

@section('contents')
<form action="/vendors/store" method="POST" enctype="multipart/form-data" id="formAddVendor">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold m-0 text-primary">{{ $title ?? 'Create New Vendor' }}</h2>
        <p class="text-xs opacity-60 italic mt-1">Fill in all required fields to create a new vendor</p>
    </div>

    <div role="tablist" class="tabs tabs-lifted bg-base-100 rounded-xl overflow-hidden shadow-sm border">
        
        <input type="radio" name="vendor_tabs" role="tab" class="tab font-semibold text-sm whitespace-nowrap px-6" aria-label="📝General Info" checked />
        <div role="tabpanel" class="tab-content bg-white border-base-300 p-8">
            <div class="min-h-[550px]">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="card bg-base-100 shadow-sm border border-base-200 lg:col-span-2">
                        <div class="card-body">
                            <h3 class="font-bold border-b pb-2 text-primary uppercase text-xs tracking-widest">General Information</h3>
                            
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
                                <h3 class="font-bold  pb-2 text-primary uppercase text-xs tracking-widest">Attachments</h3>
                                <button type="button" id="btnAddFile" class="btn btn-sm btn-outline text-primary hover:bg-primary hover:text-white border-primary">
                                    + Add More File
                                </button>
                            </div>
                            
                            <div id="attachment-container" class="mt-4 space-y-3 max-h-[100px] overflow-y-auto pr-2 custom-scrollbar">
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
        </div>

        <input type="radio" name="vendor_tabs" role="tab" class="tab font-semibold text-sm whitespace-nowrap px-6" aria-label="🔢 Vendor Codes" />
        <div role="tabpanel" class="tab-content bg-white border-base-300 p-8">
            <div class="min-h-[550px]">
                <div class="grid grid-cols-1 gap-6">
                    <div class="card bg-base-100 shadow-sm border border-base-200">
                        <div class="card-body">
                            <div class="flex justify-between items-center border-b pb-2">
                                <h3 class="font-bold pb-2 text-primary uppercase text-xs tracking-widest">Vendor Codes <span class="text-error ml-1">*</span></h3>
                                <button type="button" id="btnAddVendorCode" class="btn btn-sm btn-outline text-primary hover:bg-primary hover:text-white border-primary">
                                    + Add Code
                                </button>
                            </div>
                            
                            <div id="vendor-code-container" class="mt-4 space-y-4 max-h-[450px] overflow-y-auto pr-2 custom-scrollbar">
                                <div class="vendor-code-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-gray-50 p-4 rounded-lg border border-gray-100 relative">
                                    <div class="form-control w-full md:col-span-3">
                                        <label class="label"><span class="label-text font-medium">Code<span class="text-error">*</span></span></label>
                                        <input type="text" name="CODE_NUM[]" class="input input-bordered w-full bg-white" required placeholder="e.g. 60002" />
                                    </div>
                                    <div class="form-control w-full md:col-span-2">
                                        <label class="label"><span class="label-text font-medium">Currency</span></label>
                                        <select name="CODE_CURRENCY[]" class="select select-bordered w-full bg-white currency-select">
                                            <option value="" disabled selected>Select...</option>
                                        </select>
                                    </div>
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
        </div>

        <input type="radio" name="vendor_tabs" role="tab" class="tab font-semibold text-sm whitespace-nowrap px-6" aria-label="🗺️ Address Details" />
 <div role="tabpanel" class="tab-content bg-white border-base-300 p-8">
    <div class="min-h-[550px]">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <div class="card bg-base-100 shadow-sm border border-base-200 h-full">
                <div class="card-body">
                    <h3 class="font-bold border-b pb-2 text-primary uppercase text-xs tracking-widest">Address Details (English)</h3>
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
                            <label class="label"><span class="label-text font-medium">State / Province</span></label>
                            <select name="EN_ADDR_STATE" class="select select-bordered w-full bg-white state-select"">
                                <option value="" disabled selected>Select State / Province</option>
                            </select>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">City / District</span></label>
                            <select name="EN_ADDR_CITY" class="select select-bordered w-full bg-white city-select">
                                <option value="" disabled selected>Select City / District</option>
                            </select>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Subdistrict</span></label>
                            <select name="EN_ADDR_SUBDISTRICT" class="select select-bordered w-full bg-white subdistrict-select">
                                <option value="" disabled selected>Select Subdistrict</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Zip Code</span></label>
                            <input type="text" name="EN_ADDR_ZIPCODE" class="input input-bordered w-full " />
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Country</span></label>
                            <select name="EN_ADDR_COUNTRY" class="select select-bordered w-full">
                            
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm border border-base-200 h-full"> 
                <div class="card-body">
                    <h3 class="font-bold border-b pb-2 text-primary uppercase text-xs tracking-widest">Address Details (Thai)</h3>
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
                            <label class="label"><span class="label-text font-medium">จังหวัด</span></label>
                            <input type="text" name="TH_ADDR_STATE" class="input input-bordered w-full  placeholder="ระบุจังหวัด" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">อำเภอ/เขต</span></label>
                            <input type="text" name="TH_ADDR_CITY" class="input input-bordered w-full" placeholder="ระบุอำเภอ/เขต" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">ตำบล/แขวง</span></label>
                            <input type="text" name="TH_ADDR_SUBDISTRICT" class="input input-bordered w-full" placeholder="ระบุตำบล/แขวง" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                         <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">รหัสไปรษณีย์</span></label>
                            <input type="text" name="TH_ADDR_ZIPCODE" class="input input-bordered w-full bg-white text-base-content" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">ประเทศ</span></label>
                            <input type="text" name="TH_ADDR_COUNTRY" class="input input-bordered w-full" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    </div> 
    
    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end gap-3">
        <a href="{{ $_ENV['APP_ENV'] }}/vendors" class="btn btn-ghost px-6">Cancel</a>
        <button type="submit" class="btn btn-primary px-8 shadow-lg">
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
    <script src="{{ $_ENV['APP_JS'] }}/create.js?ver={{ $GLOBALS['version'] }}"></script>
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