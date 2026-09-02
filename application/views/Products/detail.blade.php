@extends('layouts/template')

@section('contents')
<form id="productForm" class="p-4 md:p-6">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold m-0 text-primary">{{ $title }}</h2>
            <p class="text-xs opacity-60 italic">Fill in all required fields to update procurement data</p>
            <input type="hidden" id="USER_PERMISSION" value="{{ $permission ?? 'EDIT' }}"> <!--EDIT, VIEWER-->
            <input type="hidden" id="prod_id_hidden" value="{{ $id ?? '' }}">
        </div>
        <div class="flex gap-2">
            <a href="{{ $_ENV['APP_ENV'] }}/Products" class="btn btn-ghost btn-sm">Cancel</a>
            @if(isset($permission) && $permission === 'EDIT')
                <button type="submit" class="btn btn-primary btn-sm px-8 shadow-lg">Save Data</button>
            @endif
        </div>
    </div>

    <div role="tablist" class="tabs tabs-lifted bg-base-100 rounded-xl overflow-hidden shadow-sm border">
        
        <input type="radio" name="prod_tabs" role="tab" class="tab font-semibold text-sm" aria-label="📋 General & Images" checked />
        <div role="tabpanel" class="tab-content p-8 bg-white border-base-300">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                
                <div class="space-y-8">
                    <div class="space-y-4">
                        <h3 class="font-bold border-b pb-2 text-primary uppercase text-xs tracking-widest">Base Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div class="form-control w-full">
                                <label class="label py-1"><span class="label-text font-semibold text-gray-600">Product Code</span></label>
                                <input type="text" id="PROD_CODE" class="input input-bordered w-full focus:input-primary" placeholder="e.g. 19GPMBAW">
                            </div>
                            <div class="form-control w-full">
                                <label class="label py-1"><span class="label-text font-semibold text-gray-600">Product Name</span></label>
                                <input type="text" id="PROD_NAME" class="input input-bordered w-full focus:input-primary" placeholder="Enter product name">
                            </div>
                            <div class="form-control col-span-1 md:col-span-2">
                                <label class="label py-1"><span class="label-text font-semibold text-gray-600">Description</span></label>
                                <textarea id="PROD_DESCRIPTION" class="textarea textarea-bordered h-24 focus:textarea-primary w-full" placeholder="Enter product details..."></textarea>
                            </div>
                            <!-- <div class="form-control w-full">
                                <label class="label py-1"><span class="label-text font-semibold text-gray-600">Unit</span></label>
                                <select id="PROD_UNIT" class="select select-bordered w-full">
                                    <option value="กล่อง">กล่อง</option>
                                    <option value="แพ็ค">แพ็ค</option>
                                    <option value="ชิ้น">ชิ้น</option>
                                    <option value="ชุด">ชุด</option>
                                </select>
                            </div> -->
                            <div class="form-control w-full">
                                <label class="label py-1"><span class="label-text font-semibold text-gray-600">Status</span></label>
                                <select id="PROD_STATUS" class="select select-bordered w-full">
                                    <!-- <option value="0">Draft</option> -->
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="form-control w-full">
                                <label class="label py-1"><span class="label-text font-semibold text-gray-600">Category</span></label>
                                <select id="CATEGORY_ID" class="select select-bordered w-full">
                                    <option value="">Loading categories...</option>
                                </select>
                            </div>
                            <div class="form-control w-full">
                                <label class="label py-1"><span class="label-text font-semibold text-gray-600">Hazard Level</span></label>
                                <select id="HAZARD" class="select select-bordered w-full">
                                    <option value="0">Low</option>
                                    <option value="1">Medium</option>
                                    <option value="2">High</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 pt-4">
                        <div class="flex justify-between items-center border-b pb-2">
                            <h3 class="font-bold text-primary uppercase text-xs tracking-widest">Technical Specifications</h3>
                            <button type="button" onclick="addAttributeRow()" class="btn btn-xs btn-outline btn-primary">+ Add Spec</button>
                        </div>
                        <div id="attributes_container" class="space-y-2 bg-gray-50 p-4 rounded-xl border border-dashed min-h-[50px]">
                            </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b pb-2">
                        <h3 class="font-bold text-primary uppercase text-xs tracking-widest">Gallery</h3>
                        <button type="button" onclick="addImageRow()" class="btn btn-xs btn-outline btn-primary">+ Add Image</button>
                    </div>
                    <div id="images_container" class="grid grid-cols-2 gap-4">
                        </div>
                </div>
            </div>
        </div>

        <input type="radio" name="prod_tabs" role="tab" class="tab font-semibold text-sm" aria-label="💰 Pricing & Quotes" />
        <div role="tabpanel" class="tab-content p-8 bg-white border-base-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-primary">Supplier Price Management</h3>
            </div>
            <div class="mb-10 bg-gray-50 p-4 rounded-xl border">
                <h4 class="text-xs font-bold opacity-50 uppercase mb-4 tracking-widest">Price Trend Analysis</h4>
                <div class="h-[300px] w-full">
                    <canvas id="priceChart"></canvas>
                </div>
            </div>
            <div class="overflow-x-auto rounded-lg border">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600">
                            <th width="20%">Vendor & Status</th>
                            <th width="15%">Unit Price</th>
                            <th width="15%">Effective</th>
                            <th width="45%">Quotation Documents</th>
                            </tr>
                    </thead>
                    <tbody id="price_history_container"></tbody>
                </table>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/products_detail.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection