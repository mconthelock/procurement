@extends('layouts/template')

@section('contents')
<div class="p-6 md:p-10 bg-base-100 min-h-screen">
    <form id="categoryForm" class="max-w-4xl mx-auto space-y-8">
        <input type="hidden" id="USER_PERMISSION" value="{{ $permission ?? 'EDIT' }}"> <!--EDIT, VIEWER-->
        <input type="hidden" id="cat_id_hidden" value="{{ $id ?? '' }}">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-4 border-b">
            <div>
                <h2 class="text-3xl font-extrabold text-primary tracking-tight">{{ $title }}</h2>
                <p class="text-sm opacity-70 mt-1">Define the groupings and organizational ownership for categories.</p>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <a href="{{ $_ENV['APP_ENV'] }}/Categories" class="btn btn-ghost btn-sm">
                    <i class="fi fi-rr-arrow-small-left mr-2"></i> Cancel
                </a>
                
                @if(isset($permission) && $permission === 'EDIT')
                    <button type="submit" class="btn btn-primary btn-sm px-8 shadow-md">
                        <i class="fi fi-rr-disk mr-2"></i> Save Changes
                    </button>
                @endif
            </div>
        </div>

        <div class="card bg-white border shadow-lg rounded-2xl">
            <div class="card-body gap-6 p-8">
                <div class="flex items-center gap-4 pb-4 border-b">
                    <div class="avatar placeholder">
                        <div class="bg-primary/10 text-primary rounded-full w-14 h-14 text-2xl">
                            <i class="fi fi-rr-settings"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-xl text-neutral">Category Specifications</h3>
                        <p class="text-xs opacity-60">Fields marked with <span class="text-error">*</span> are required</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="form-control w-full md:col-span-2">
                        <label class="label py-1"><span class="label-text font-semibold text-gray-700">Category Name <span class="text-error">*</span></span></label>
                        <input type="text" id="CATEGORY_NAME" placeholder="e.g. Electronics" class="input input-bordered focus:input-primary w-full shadow-inner" required>
                    </div>

                    <div class="form-control w-full">
                        <label class="label py-1"><span class="label-text font-semibold text-gray-700">Department Owner Code <span class="text-error">*</span></span></label>
                        <input type="text" id="CATEGORY_OWNER" placeholder="e.g. 090401" class="input input-bordered focus:input-primary w-full font-mono shadow-inner" required>
                    </div>
                    <div class="form-control w-full">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-gray-700">Parent Category</span>
                        </label>
                        <select id="CATEGORY_PARENT" class="select select-bordered focus:select-primary w-full shadow-inner font-bold">
                            <option value="">-- No Parent (Root Level) --</option>
                        </select>
                        <label class="label -mt-1">
                            <span class="label-text-alt opacity-50 italic">Determines the hierarchy level.</span>
                        </label>
                    </div>

                    <div class="form-control w-full">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-gray-700 font-mono">Current Level</span>
                        </label>
                        <input type="text" id="CATEGORY_LEVEL_DISPLAY" class="input input-bordered w-full bg-base-200 text-gray-500 cursor-not-allowed font-bold" value="1" readonly>
                        <input type="hidden" id="CATEGORY_LEVEL" value="1">
                    </div>
                    <div class="form-control w-full">
                        <label class="label py-1"><span class="label-text font-semibold text-gray-700">Usage Status</span></label>
                        <select id="CATEGORY_STATUS" class="select select-bordered focus:select-primary w-full shadow-inner">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="form-control w-full md:col-span-2">
                        <label class="label py-1"><span class="label-text font-semibold text-gray-700">Detailed Description</span></label>
                        <textarea id="DESCRIPTION" placeholder="Explain the scope of this category..." class="textarea textarea-bordered h-32 focus:textarea-primary shadow-inner w-full"></textarea>
                    </div>
                    <div class="form-control w-full md:col-span-2 mt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="label-text font-semibold text-gray-700">Category Specific Attributes</span>
                            <button type="button" onclick="addCategoryAttrTag()" class="btn btn-xs btn-outline">+ Add Spec Title</button>
                        </div>
                        <div id="category_attr_tags" class="flex flex-wrap gap-2 p-4 border rounded-xl bg-gray-50 min-h-[60px]">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- @if(isset($id))
        <div class="card bg-base-200 border-dashed border-2 rounded-2xl">
            <div class="card-body p-6 flex flex-row items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="text-error bg-error/10 p-3 rounded-xl"><i class="fi fi-rr-shield-exclamation text-xl"></i></div>
                    <div>
                        <h4 class="font-bold">Deactivate Category</h4>
                        <p class="text-xs opacity-60">This will hide the category from active selection.</p>
                    </div>
                </div>
                <button type="button" onclick="deleteCategory('{{ $id }}')" class="btn btn-error btn-sm px-6">Deactivate</button>
            </div>
        </div>
        @endif -->
    </form>
</div>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/categories_detail.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection