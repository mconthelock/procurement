@extends('layouts/template')

@section('contents')
<div class="w-11/12 mx-auto px-4 md:px-8 pb-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h2 class="text-2xl font-bold m-0 text-primary">Form Vendor Approval</h2>
            </div>
            <p class="text-xs opacity-60 italic mt-1">Review changes and vendor details before taking action</p>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-200 mb-8">
        <div class="card-body">
            <h3 class="font-bold border-b pb-2 text-primary uppercase text-xs tracking-widest">Form Detail</h3>
            
            <div class="grid grid-cols-1 gap-4 mt-4">
                <div class="flex flex-row items-center gap-3">
                    <label class="font-medium text-gray-500 w-24 shrink-0">Form No.</label>
                    <div class="w-full min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                        <p id="FRM_NO" class="view-mode font-medium text-base m-0">PUR_VND26-000098</p>
                    </div>
                </div>

                <div class="flex flex-row items-center gap-3">
                    <label class="font-medium text-gray-500 w-24 shrink-0">Vendor Name</label>
                    <div class="w-full min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-between">
                        <p id="view-VND_NAME" class="view-mode font-bold text-base text-gray-800 m-0">บริษัท ตัวอย่าง จำกัด</p>
                        <button type="button" class="btn btn-xs btn-outline text-primary hover:bg-primary hover:text-white border-primary" onclick="document.getElementById('vendor_detail_modal').showModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            View Details
                        </button>
                    </div>
                </div>

                <div class="flex flex-row items-center gap-3">
                    <label class="font-medium text-gray-500 w-24 shrink-0">Requester</label>
                    <div class="w-full min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                        <p id="REQNO" class="view-mode font-medium text-base m-0">(08035) AMPIKA POKAEW</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-200 mb-8">
        <div class="card-body p-0">
            <div class="p-4 border-b bg-indigo-50/50 rounded-t-2xl flex items-center gap-2">
                <h3 class="font-bold text-primary uppercase text-xs tracking-widest m-0">Change Summary</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="w-1/4 text-sm font-semibold">Field Name</th>
                            <th class="w-1/3 text-sm font-semibold">Original Value</th>
                            <th class="w-1/3 text-sm font-semibold">New Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-50">
                            <td class="font-medium text-gray-700">Sales Contact Person</td>
                            <td class="text-red-500 line-through opacity-70">Mr. John Doe</td>
                            <td class="text-emerald-600 font-bold flex items-center gap-2">
                                Ms. Jane Smith
                                <span class="badge badge-success badge-sm text-white border-none">Updated</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="font-medium text-gray-700">Website</td>
                            <td class="text-gray-400 italic">- (Empty) -</td>
                            <td class="text-blue-600 font-bold flex items-center gap-2">
                                www.newvendor.com
                                <span class="badge badge-info badge-sm text-white border-none">Added</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="font-medium text-gray-700">Payment Term</td>
                            <td class="text-red-500 line-through opacity-70">Net 30 Days</td>
                            <td class="text-gray-400 italic flex items-center gap-2">
                                - (Removed) -
                                <span class="badge badge-error badge-sm text-white border-none">Removed</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-200 mb-8">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-gray-50 text-gray-600 border-b">
                        <tr>
                            <th class="text-center w-16">Status</th>
                            <th>Step</th>
                            <th>Employee</th>
                            <th>Date & Time</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover">
                            <td class="text-center">
                                <div class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </div>
                            </td>
                            <td class="font-bold text-gray-700">Requester</td>
                            <td>
                                <div class="font-medium text-gray-800">AMPIKA POKAEW</div>
                                <div class="text-xs text-gray-500">ID: 08035</div>
                            </td>
                            <td>
                                <div class="text-sm text-gray-800">08-Dec-2025</div>
                                <div class="text-xs text-gray-500">14:34:38</div>
                            </td>
                            <td class="text-gray-400 italic text-sm">-</td>
                        </tr>
                        <tr class="hover">
                            <td class="text-center">
                                <div class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </div>
                            </td>
                            <td class="font-bold text-gray-700">SEM</td>
                            <td>
                                <div class="font-medium text-gray-800">PIYAMIT PULSIRI</div>
                                <div class="text-xs text-gray-500">ID: 10001</div>
                            </td>
                            <td>
                                <div class="text-sm text-gray-800">08-Dec-2025</div>
                                <div class="text-xs text-gray-500">14:57:39</div>
                            </td>
                            <td class="text-gray-400 italic text-sm">-</td>
                        </tr>
                        <tr class="hover">
                            <td class="text-center">
                                <div class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </div>
                            </td>
                            <td class="font-bold text-gray-700">DEM</td>
                            <td>
                                <div class="font-medium text-gray-800">PIYAMIT PULSIRI</div>
                                <div class="text-xs text-gray-500">ID: 10001</div>
                            </td>
                            <td>
                                <div class="text-sm text-gray-800">08-Dec-2025</div>
                                <div class="text-xs text-gray-500">14:57:52</div>
                            </td>
                            <td class="text-gray-400 italic text-sm">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="flex justify-center items-center p-4 border-t bg-gray-50 rounded-b-2xl">
                <div class="text-emerald-600 font-bold border-none text-lg">Status: Approved</div>
            </div>
        </div>
    </div>



</div> <dialog id="vendor_detail_modal" class="modal">
    <div class="modal-box w-11/12 max-w-5xl bg-gray-50 p-0">
        
        <div class="sticky top-0 bg-white z-10 px-6 py-4 border-b flex justify-between items-center shadow-sm">
            <h3 class="font-bold text-lg text-primary m-0">Full Vendor Profile</h3>
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost outline-none">✕</button>
            </form>
        </div>

        <div class="p-6 space-y-6">
            
            <div class="card bg-white shadow-sm border border-base-200">
                <div class="card-body p-6">
                    <h4 class="font-bold border-b pb-2 text-gray-700 uppercase text-xs tracking-widest mb-4">General Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label py-1"><span class="label-text font-medium text-gray-500">Vendor Name (English)</span></label>
                            <div class="px-4 py-2 bg-gray-50 border rounded-lg"><p id="modal-VND_NAME" class="m-0 text-gray-800">-</p></div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label py-1"><span class="label-text font-medium text-gray-500">Vendor Name (Thai)</span></label>
                            <div class="px-4 py-2 bg-gray-50 border rounded-lg"><p id="modal-VND_TNAME" class="m-0 text-gray-800">-</p></div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label py-1"><span class="label-text font-medium text-gray-500">Sales Contact Person</span></label>
                            <div class="px-4 py-2 bg-gray-50 border rounded-lg"><p id="modal-VND_SALE" class="m-0 text-gray-800">-</p></div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label py-1"><span class="label-text font-medium text-gray-500">Phone Number</span></label>
                            <div class="px-4 py-2 bg-gray-50 border rounded-lg"><p id="modal-ADDR_PHONE" class="m-0 text-gray-800">-</p></div>
                        </div>
                        <div class="form-control w-full md:col-span-2">
                            <label class="label py-1"><span class="label-text font-medium text-gray-500">Website</span></label>
                            <div class="px-4 py-2 bg-gray-50 border rounded-lg"><a href="#" id="modal-ADDR_WEB" target="_blank" class="m-0 text-blue-600 hover:underline">-</a></div>
                        </div>
                    </div>

                    <h4 class="font-bold border-b pb-2 text-gray-700 uppercase text-xs tracking-widest mt-6 mb-4">Attachments</h4>
                    <div id="modal-attachment-container" class="space-y-2">
                        <div class="p-3 bg-gray-50 border rounded-lg flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                <span class="text-sm font-medium text-gray-700">company_profile.pdf</span>
                            </div>
                            <a href="#" class="btn btn-xs btn-outline text-indigo-600">Download</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-base-200">
                <div class="card-body p-6">
                    <h4 class="font-bold border-b pb-2 text-gray-700 uppercase text-xs tracking-widest mb-4">Vendor Codes</h4>
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="table w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th>Code</th>
                                    <th>Currency</th>
                                    <th>Payment Term</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="modal-vendor-code-tbody">
                                <tr>
                                    <td>VND001</td>
                                    <td>THB</td>
                                    <td>Net 30 Days</td>
                                    <td><span class="badge badge-success badge-sm text-white">Active</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-base-200">
                <div class="card-body p-6">
                    <h4 class="font-bold border-b pb-2 text-gray-700 uppercase text-xs tracking-widest mb-4">Address Details</h4>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <h5 class="text-sm font-bold text-gray-600 mb-3 bg-gray-100 p-2 rounded">Thai Address</h5>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">ที่อยู่ 1 (Address Line 1)</p>
                                    <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-TH_ADDR_LINE1" class="m-0 text-sm">-</p></div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">ที่อยู่ 2 (Address Line 2)</p>
                                    <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-TH_ADDR_LINE2" class="m-0 text-sm">-</p></div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">ที่อยู่ 3 (Address Line 3)</p>
                                    <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-TH_ADDR_LINE3" class="m-0 text-sm">-</p></div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">จังหวัด</p>
                                        <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-TH_ADDR_STATE" class="m-0 text-sm">-</p></div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">อำเภอ/เขต</p>
                                        <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-TH_ADDR_CITY" class="m-0 text-sm">-</p></div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">ตำบล/แขวง</p>
                                        <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-TH_ADDR_SUBDISTRICT" class="m-0 text-sm">-</p></div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">รหัสไปรษณีย์</p>
                                        <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-TH_ADDR_ZIP" class="m-0 text-sm">-</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h5 class="text-sm font-bold text-gray-600 mb-3 bg-gray-100 p-2 rounded">English Address</h5>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Address Line 1</p>
                                    <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-EN_ADDR_LINE1" class="m-0 text-sm">-</p></div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Address Line 2</p>
                                    <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-EN_ADDR_LINE2" class="m-0 text-sm">-</p></div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Address Line 3</p>
                                    <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-EN_ADDR_LINE3" class="m-0 text-sm">-</p></div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">State / Province</p>
                                        <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-EN_ADDR_STATE" class="m-0 text-sm">-</p></div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">City / District</p>
                                        <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-EN_ADDR_CITY" class="m-0 text-sm">-</p></div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Subdistrict</p>
                                        <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-EN_ADDR_SUBDISTRICT" class="m-0 text-sm">-</p></div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Zip Code</p>
                                        <div class="px-3 py-2 bg-gray-50 border rounded"><p id="modal-EN_ADDR_ZIP" class="m-0 text-sm">-</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        
        <div class="bg-gray-100 px-6 py-4 border-t flex justify-end">
            <form method="dialog">
                <button class="btn btn-outline text-gray-600 bg-white shadow-sm">Close</button>
            </form>
        </div>
        
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/approval.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection