<!-- Slide-Over General Information Drawer (Read-Only for General Users) -->
<div id="vendorGeneralDrawer" class="hidden fixed inset-0 z-[2000] flex justify-end" role="dialog" aria-modal="true"
    aria-labelledby="generalDrawerTitle">
    <!-- Backdrop -->
    <div id="generalDrawerBackdrop" class="fixed inset-0 bg-primary/70 transition-opacity"></div>

    <!-- Drawer Panel -->
    <div class="relative w-full max-w-[640px] bg-white border-l border-primary shadow-xl flex flex-col h-full z-10">
        <!-- Sticky Black Corporate Header -->
        <div class="px-space-lg py-space-md bg-primary text-white flex items-start justify-between gap-space-md shrink-0">
            <div class="flex items-start gap-3 min-w-0">
                <span class="w-2.5 h-6 bg-accent shrink-0 mt-0.5"></span>
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <span id="drawer-gen-code" class="badge badge-xs badge-info font-mono font-bold">-</span>
                        <span id="drawer-gen-group" class="badge badge-xs badge-warning font-mono font-bold uppercase">-</span>
                        <span id="drawer-gen-status" class="badge badge-xs badge-success font-mono font-bold uppercase">-</span>
                    </div>
                    <h2 id="generalDrawerTitle" class="text-lg font-bold tracking-tight mt-1 break-words">
                        Vendor General Information
                    </h2>
                    <p class="text-xs text-white/75">
                        Read-only general profile • Commercial contact &amp; registered address
                    </p>
                </div>
            </div>

            <button type="button" id="closeGeneralDrawerBtn"
                class="btn btn-sm btn-ghost text-white hover:bg-white/10 p-1 shrink-0" aria-label="Close drawer">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <!-- Scrollable Body (Strictly General Information Only) -->
        <div class="p-space-lg overflow-y-auto grow space-y-space-lg">
            <!-- Block 1: Corporate General Info -->
            <div class="border border-base-300">
                <div class="px-space-md py-2.5 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-primary"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-primary">
                            General Information (ข้อมูลทั่วไป)
                        </h3>
                    </div>
                    <span class="font-mono text-[11px] text-mute">PUBLIC PROFILE</span>
                </div>
                <div class="p-space-md grid grid-cols-1 sm:grid-cols-2 gap-space-sm text-xs">
                    <div class="sm:col-span-2 space-y-1">
                        <span class="block text-[11px] uppercase font-bold text-mute">Vendor Name</span>
                        <div class="min-h-9 px-3 py-2 bg-base-200 border border-base-300 font-semibold text-primary" id="drawer-gen-name">-</div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-[11px] uppercase font-bold text-mute">Vendor Code</span>
                        <div class="min-h-9 px-3 py-2 bg-base-200 border border-base-300 font-mono font-bold text-primary" id="drawer-gen-code-val">-</div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-[11px] uppercase font-bold text-mute">Vendor Category</span>
                        <div class="min-h-9 px-3 py-2 bg-base-200 border border-base-300 text-primary" id="drawer-gen-category">-</div>
                    </div>
                </div>
            </div>

            <!-- Block 2: Liaison Contact -->
            <div class="border border-base-300">
                <div class="px-space-md py-2.5 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-secondary"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-primary">
                            Contact Information (ข้อมูลผู้ติดต่อ)
                        </h3>
                    </div>
                </div>
                <div class="p-space-md grid grid-cols-1 sm:grid-cols-2 gap-space-sm text-xs">
                    <div class="sm:col-span-2 space-y-1">
                        <span class="block text-[11px] uppercase font-bold text-mute">Contact Person</span>
                        <div class="min-h-9 px-3 py-2 bg-base-200 border border-base-300 font-semibold text-primary" id="drawer-gen-contact">-</div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-[11px] uppercase font-bold text-mute">Telephone No.</span>
                        <div class="min-h-9 px-3 py-2 bg-base-200 border border-base-300 font-mono text-primary" id="drawer-gen-phone">-</div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-[11px] uppercase font-bold text-mute">Fax No.</span>
                        <div class="min-h-9 px-3 py-2 bg-base-200 border border-base-300 font-mono text-primary" id="drawer-gen-fax">-</div>
                    </div>
                </div>
            </div>

            <!-- Block 3: Registered Address -->
            <div class="border border-base-300">
                <div class="px-space-md py-2.5 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-primary"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-primary">
                            Location &amp; Address (ที่อยู่ผู้ขาย)
                        </h3>
                    </div>
                </div>
                <div class="p-space-md grid grid-cols-1 sm:grid-cols-2 gap-space-sm text-xs">
                    <div class="sm:col-span-2 space-y-1">
                        <span class="block text-[11px] uppercase font-bold text-mute">Address Line 1</span>
                        <div class="min-h-9 px-3 py-2 bg-base-200 border border-base-300 text-primary" id="drawer-gen-addr1">-</div>
                    </div>
                    <div class="sm:col-span-2 space-y-1">
                        <span class="block text-[11px] uppercase font-bold text-mute">Address Line 2</span>
                        <div class="min-h-9 px-3 py-2 bg-base-200 border border-base-300 text-primary" id="drawer-gen-addr2">-</div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-[11px] uppercase font-bold text-mute">City / District</span>
                        <div class="min-h-9 px-3 py-2 bg-base-200 border border-base-300 text-primary" id="drawer-gen-city">-</div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-[11px] uppercase font-bold text-mute">State / Province</span>
                        <div class="min-h-9 px-3 py-2 bg-base-200 border border-base-300 text-primary" id="drawer-gen-state">-</div>
                    </div>
                    <div class="sm:col-span-2 space-y-1">
                        <span class="block text-[11px] uppercase font-bold text-mute">Country</span>
                        <div class="min-h-9 px-3 py-2 bg-base-200 border border-base-300 font-semibold text-primary" id="drawer-gen-country">-</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Footer -->
        <div
            class="px-space-lg py-space-md bg-base-200 border-t border-base-300 flex items-center justify-between gap-space-sm shrink-0">
            <span class="text-[11px] font-mono text-mute">AMEC Vendor List • General Info Only</span>
            <button type="button" id="closeGeneralDrawerFooterBtn" class="btn btn-sm btn-primary">
                Close
            </button>
        </div>
    </div>
</div>
