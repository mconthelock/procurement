@extends('layouts/template')

@section('contents')
    <input type="text" name="VND_ID" id="vnd-id" value="{{ $id }}" class="hidden">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold m-0 text-primary">{{ $title ?? 'Vendors Information' }}</h2>
            <p class="text-xs opacity-60 italic mt-1">View and manage vendor details</p>
        </div>
        <div id="view-VND_STATUS" class="badge badge-success text-white px-4 py-3 rounded-full font-medium shadow-sm">
            Active
        </div>
    </div>

    <form action="/vendors/store" method="POST" enctype="multipart/form-data" id="formAddVendor">
        
        <div role="tablist" class="tabs tabs-lifted bg-base-100 rounded-xl overflow-hidden shadow-sm border">
            
            <input type="radio" name="vendor_tabs" role="tab" class="tab font-semibold text-sm whitespace-nowrap px-6" aria-label="📝General Info" checked />
            <div role="tabpanel" class="tab-content bg-white border-base-300 p-8">
                <div class="min-h-[550px] content-start">
                    <div class="grid grid-cols-1 gap-6 pb-4">
                        
                        <div class="card bg-base-100 shadow-sm border border-base-200">
                            <div class="card-body">
                                <h3 class="font-bold border-b pb-2 text-primary uppercase text-xs tracking-widest">General Information</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                    
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Vendor Name (English)</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-VND_NAME" class="view-mode font-medium text-sm px-1">-</p>
                                            <input type="text" id="input-VND_NAME" name="VND_NAME" class="edit-mode input input-bordered w-full hidden" >
                                        </div>
                                    </div>

                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Vendor Name (Thai)</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-VND_TNAME" class="view-mode font-medium text-sm  px-1">-</p>
                                            <input type="text" id="input-VND_TNAME" name="VND_TNAME" class="edit-mode input input-bordered w-full hidden" >
                                        </div>
                                    </div>

                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Sales Contact Person</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-VND_SALE" class="view-mode font-medium text-sm  px-1">-</p>
                                            <input type="text" id="input-VND_SALE" name="VND_SALE" class="edit-mode input input-bordered w-full hidden" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Phone Number</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_PHONE" class="view-mode font-medium text-sm  px-1">-</p>
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
                                            <p id="view-VND_REGNAME" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>

                                    <div class="view-mode form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Registered Date</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-VND_REGDATE" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>

                                    <div class="view-mode form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Last Updated</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-VND_LASTUPDATE" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card bg-base-100 shadow-sm border border-base-200">
                            <div class="card-body">
                                <div class="flex justify-between items-center border-b pb-2">
                                    <h3 class="font-bold pb-2 text-primary uppercase text-xs tracking-widest">Attachments</h3>
                                    <button type="button" id="btnAddFile" class="edit-mode btn btn-sm btn-outline text-primary hover:bg-primary hover:text-white border-primary outline-none hidden">
                                        + Add More File
                                    </button>
                                </div>
                                
                                <div id="existing-files-container" class="mt-4 space-y-3 max-h-[130px] overflow-y-auto pr-2 custom-scrollbar">
                                </div>
                                
                                <div id="edit-attachment-container" class="edit-mode mt-4 space-y-3 max-h-[130px] overflow-y-auto pr-2 custom-scrollbar hidden">
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
                <div class="min-h-[550px] content-start ">
                    <div class="grid grid-cols-1 gap-6 pb-4">
                        <div class="card bg-base-100 shadow-sm border border-base-200">
                            <div class="card-body">
                                
                                <div class="flex justify-between items-center border-b pb-2">
                                    <h3 class="font-bold pb-2 text-primary uppercase text-xs tracking-widest">Vendor Codes Details</h3>
                                    <button type="button" id="btnAddVendorCode" class="edit-mode hidden btn btn-sm btn-outline text-primary hover:bg-primary hover:text-white border-primary outline-none">
                                        + Add Code
                                    </button>
                                </div>
                                
                                <div id="view-vendor-code-container" class="mt-4 pr-2">
                                </div>
                                
                                <div id="edit-vendor-code-container" class="edit-mode mt-4 pr-2 max-h-[270px] overflow-y-auto pr-2 custom-scrollbar hidden">
                                    <div class="vendor-code-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-gray-50 p-4 rounded-lg border border-gray-100 relative mb-4">
                                        <div class="form-control w-full md:col-span-3">
                                            <label class="label"><span class="label-text font-medium">Code<span class="text-error">*</span></span></label>
                                            <input type="text" name="CODE_NUM[]" class="input input-bordered w-full bg-white" required placeholder="e.g. VND001" />
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
                <div class="min-h-[550px] content-start">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-4">
                        
                        <div class="card bg-base-100 shadow-sm border border-base-200">
                            <div class="card-body">
                                <h3 class="font-bold border-b pb-2 text-primary uppercase text-xs tracking-widest">Address Details (English)</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                    <div class="form-control w-full md:col-span-3">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Address Line 1</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_EN_LINE1" class="view-mode font-medium text-sm  px-1">-</p>
                                            <input type="text" id="input-ADDR_EN_LINE1" name="ADDR_EN_LINE1" class="edit-mode input input-bordered w-full hidden">
                                        </div>
                                    </div>

                                    <div class="form-control w-full md:col-span-3">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Address Line 2</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_EN_LINE2" class="view-mode font-medium text-sm  px-1">-</p>
                                            <input type="text" id="input-ADDR_EN_LINE2" name="ADDR_EN_LINE2" class="edit-mode input input-bordered w-full hidden">
                                        </div>
                                    </div>

                                    <div class="form-control w-full md:col-span-3">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Address Line 3</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_EN_LINE3" class="view-mode font-medium text-sm  px-1">-</p>
                                            <input type="text" id="input-ADDR_EN_LINE3" name="ADDR_EN_LINE3" class="edit-mode input input-bordered w-full hidden">
                                        </div>
                                    </div>
                                </div>

                                <div class="view-mode grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Sub-district</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_EN_SUBDISTRICT" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">City / District</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_EN_CITY" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">State / Province</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_EN_STATE" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Zip Code</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_EN_ZIPCODE" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>
                                    <div class="form-control w-full md:col-span-2">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Country</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_EN_COUNTRY" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="edit-mode hidden  grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">State / Province</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <select name="EN_ADDR_STATE" class="select select-bordered w-full bg-white state-select">
                                        <option value="" disabled selected>Select State / Province</option>
                                         </select>
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">City / District</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <select name="EN_ADDR_CITY" class="select select-bordered w-full bg-white city-select">
                                         <option value="" disabled selected>Select City / District</option>
                                         </select>
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Sub-district</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <select name="EN_ADDR_SUBDISTRICT" class="select select-bordered w-full bg-white subdistrict-select">
                                            <option value="" disabled selected>Select Subdistrict</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Zip Code</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <input type="text" id="input-EN_ADDR_ZIPCODE" name="EN_ADDR_ZIPCODE" class="input input-bordered w-full">
                                        </div>
                                    </div>
                                    <div class="form-control w-full md:col-span-2">
                                        <label class="label"><span class="label-text font-medium text-gray-500">Country</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
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
                        
                        <div class="card bg-base-100 shadow-sm border border-base-200">
                            <div class="card-body">
                                <h3 class="font-bold border-b pb-2 text-primary uppercase text-xs tracking-widest">Address Details (Thai)</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                    <div class="form-control w-full md:col-span-3">
                                        <label class="label"><span class="label-text font-medium text-gray-500">ที่อยู่ 1 (Address Line 1)</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center"> 
                                            <p id="view-ADDR_TH_LINE1" class="view-mode font-medium text-sm  px-1">-</p>
                                            <input type="text" id="input-ADDR_TH_LINE1" name="ADDR_TH_LINE1" class="edit-mode input input-bordered w-full hidden">
                                        </div>
                                    </div>

                                    <div class="form-control w-full md:col-span-3">
                                        <label class="label"><span class="label-text font-medium text-gray-500">ที่อยู่ 2 (Address Line 2)</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_TH_LINE2" class="view-mode font-medium text-sm  px-1">-</p>
                                            <input type="text" id="input-ADDR_TH_LINE2" name="ADDR_TH_LINE2" class="edit-mode input input-bordered w-full hidden"> 
                                        </div>
                                    </div>

                                    <div class="form-control w-full md:col-span-3">
                                        <label class="label"><span class="label-text font-medium text-gray-500">ที่อยู่ 3 (Address Line 3)</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_TH_LINE3" class="view-mode font-medium text-sm e px-1">-</p>
                                            <input type="text" id="input-ADDR_TH_LINE3" name="ADDR_TH_LINE3" class="edit-mode input input-bordered w-full hidden">
                                        </div>
                                    </div>
                                </div>

                                <div class="view-mode grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">ตำบล/แขวง</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_TH_SUBDISTRICT" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">เขต / อำเภอ</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_TH_CITY" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">จังหวัด</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_TH_STATE" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">รหัสไปรษณีย์</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_TH_ZIPCODE" class="font-medium text-sm  px-1">-</p>
                                        </div>
                                    </div>
                                    <div class="form-control w-full md:col-span-2">
                                        <label class="label"><span class="label-text font-medium text-gray-500">ประเทศ</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <p id="view-ADDR_TH_COUNTRY" class="font-medium text-sm e px-1">-</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="edit-mode hidden grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 ">
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">จังหวัด</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <input type="text" name="TH_ADDR_STATE" class="input input-bordered w-full"  placeholder="ระบุจังหวัด" />
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">อำเภอ/เขต</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                        <input type="text" name="TH_ADDR_CITY" class="input input-bordered w-full" placeholder="ระบุอำเภอ/เขต" />
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">ตำบล/แขวง</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                             <input type="text" name="TH_ADDR_SUBDISTRICT" class="input input-bordered w-full" placeholder="ระบุตำบล/แขวง" />
                                        </div>
                                    </div>
                                    <div class="form-control w-full">
                                        <label class="label"><span class="label-text font-medium text-gray-500">รหัสไปรษณีย์</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                            <input type="text" name="TH_ADDR_ZIPCODE" class="input input-bordered w-full bg-white text-base-content" />
                                        </div>
                                    </div>
                                    <div class="form-control w-full md:col-span-2">
                                        <label class="label"><span class="label-text font-medium text-gray-500">ประเทศ</span></label>
                                        <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                                         <input type="text" name="TH_ADDR_COUNTRY" class="input input-bordered w-full" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="btn-container flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
            </div>

    </form>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ $_ENV['APP_JS'] }}/vendors_detail.js?ver={{ $GLOBALS['version'] }}"></script>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
@endsection