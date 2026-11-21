<!-- Tab 1: General Information & Attachments (Read-Only) -->
<div id="tab-general" role="tabpanel" class="vendor-detail-panel tab-content block! p-space-lg space-y-space-lg bg-base-100">

    <!-- Corporate Identity & Contact Block -->
    <div class="border border-base-300">
        <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-primary"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    General Information (ข้อมูลทั่วไปของคู่ค้า)
                </h2>
            </div>
            <span class="font-mono text-[11px] text-mute uppercase">Corporate Entity</span>
        </div>

        <div class="p-space-md grid grid-cols-1 md:grid-cols-3 gap-space-md">
            <!-- Vendor Name (EN) -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Vendor Name (English)</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VND_NAME" class="text-sm font-semibold text-primary">-</p>
                </div>
            </div>

            <!-- Vendor Name (TH) -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Vendor Name (Thai)</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VND_TNAME" class="text-sm font-medium text-primary">-</p>
                </div>
            </div>

            <!-- Sales Contact Person -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Sales Contact Person</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VND_SALE" class="text-sm font-medium text-primary">-</p>
                </div>
            </div>

            <!-- Phone Number -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Phone Number</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-ADDR_PHONE" class="text-sm font-mono font-medium text-primary">-</p>
                </div>
            </div>

            <!-- Website -->
            <div class="space-y-1 md:col-span-2">
                <span class="block text-xs uppercase font-bold text-mute">Corporate Website</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <a id="view-ADDR_WEB" href="#" target="_blank" rel="noopener noreferrer"
                        class="link link-hover text-sm font-mono text-info break-all">-</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Compliance Attachments Block -->
    <div class="border border-base-300">
        <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-accent"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    Compliance Attachments (เอกสารแนบคู่ค้า)
                </h2>
            </div>
            <span class="font-mono text-[11px] text-mute uppercase">Verified Files</span>
        </div>

        <div class="p-space-md">
            <div id="existing-files-container" class="space-y-2 max-h-56 overflow-y-auto pr-1 text-xs">
                <span class="text-mute italic">Loading attachments...</span>
            </div>
        </div>
    </div>
</div>
