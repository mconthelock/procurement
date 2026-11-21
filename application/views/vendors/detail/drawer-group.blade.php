<!-- Slide-Over Vendor Code Group Manager Drawer (PURSYS.VENDORS_CODE) -->
<div id="vendorGroupDrawer" class="hidden fixed inset-0 z-[2000] flex justify-end" role="dialog" aria-modal="true"
    aria-labelledby="groupDrawerTitle">
    <!-- Backdrop -->
    <div id="groupDrawerBackdrop" class="fixed inset-0 bg-primary/70 transition-opacity"></div>

    <!-- Drawer Panel -->
    <div class="relative w-full max-w-[760px] bg-white border-l border-primary shadow-xl flex flex-col h-full z-10">
        <!-- Sticky Black Corporate Header -->
        <div class="px-space-lg py-space-md bg-primary text-white flex items-start justify-between gap-space-md shrink-0">
            <div class="flex items-start gap-3 min-w-0">
                <span class="w-2.5 h-6 bg-accent shrink-0 mt-0.5"></span>
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <span id="group-drawer-id" class="badge badge-xs badge-info font-mono font-bold uppercase">NEW GROUP</span>
                        <span class="text-[11px] font-mono text-white/75 uppercase">PURSYS.VENDORS_CODE • Shared E-SCM Scope</span>
                    </div>
                    <h2 id="groupDrawerTitle" class="text-lg font-bold tracking-tight mt-1 truncate">
                        Vendor Code Group Manager
                    </h2>
                    <p class="text-xs text-white/75">
                        Group multiple Vendor Codes belonging to the same corporate supplier to share E-SCM accounts &amp; reporting.
                    </p>
                </div>
            </div>

            <button type="button" id="closeGroupDrawerBtn"
                class="btn btn-sm btn-ghost text-white hover:bg-white/10 p-1 shrink-0" aria-label="Close drawer">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="p-space-lg overflow-y-auto grow space-y-space-lg">
            <!-- Section 1: Group Name & Metadata -->
            <div class="border border-base-300">
                <div class="px-space-md py-2.5 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-primary"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-primary">
                            Group Identity (ข้อมูลกลุ่มผู้ขาย)
                        </h3>
                    </div>
                    <button type="button" id="btn-save-group-meta" class="btn btn-xs btn-primary gap-1">
                        <span class="material-symbols-outlined text-[13px]">save</span>
                        <span>Save Group Info</span>
                    </button>
                </div>
                <div class="p-space-md grid grid-cols-1 md:grid-cols-2 gap-space-sm">
                    <div class="space-y-1">
                        <label for="input-group-name" class="block text-[11px] uppercase font-bold text-mute">
                            Corporate Group Name
                        </label>
                        <input id="input-group-name" type="text" placeholder="e.g. Mitsubishi Electric Trading Corp."
                            class="input input-sm h-9.5 w-full bg-base-200 border border-base-300 text-xs focus:border-accent" />
                    </div>
                    <div class="space-y-1">
                        <label for="input-group-remark" class="block text-[11px] uppercase font-bold text-mute">
                            Grouping Remark / Reference
                        </label>
                        <input id="input-group-remark" type="text" placeholder="e.g. Multi-currency codes (THB / USD / JPY)"
                            class="input input-sm h-9.5 w-full bg-base-200 border border-base-300 text-xs focus:border-accent" />
                    </div>
                </div>
            </div>

            <!-- Section 2: Current Linked Vendor Codes -->
            <div class="border border-base-300">
                <div class="px-space-md py-2.5 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-accent"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-primary">
                            Linked Vendor Codes in This Group
                        </h3>
                        <span id="group-member-count" class="badge badge-xs badge-primary font-mono font-bold">0</span>
                    </div>
                    <span class="font-mono text-[11px] text-mute">Shared E-SCM Access</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-xs w-full border-collapse text-left">
                        <thead>
                            <tr class="bg-primary text-white text-[11px] uppercase tracking-wider">
                                <th>Code</th>
                                <th>Vendor Name</th>
                                <th>Currency / Term</th>
                                <th class="text-center">Role</th>
                                <th class="text-center w-36">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="group-members-body" class="divide-y divide-base-200 text-xs">
                            <tr>
                                <td colspan="5" class="py-6 text-center text-mute italic">
                                    Standalone vendor — add another Vendor Code below to form a group.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 3: Smart Auto-Suggestions (Same Tax ID / Similar Name) -->
            <div class="border border-base-300">
                <div class="px-space-md py-2.5 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-info"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-primary">
                            Smart Suggestions (รหัสที่ Tax ID หรือชื่อคล้ายกัน)
                        </h3>
                    </div>
                    <span class="badge badge-xs badge-info font-mono font-bold">AUTO MATCH</span>
                </div>
                <div id="group-suggestions-list" class="p-space-md space-y-2 text-xs">
                    <span class="text-mute italic">No ungrouped matching vendor codes detected.</span>
                </div>
            </div>

            <!-- Section 4: Manual Link Vendor Code -->
            <div class="border border-base-300">
                <div class="px-space-md py-2.5 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-secondary"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-primary">
                            Link Additional Vendor Code Manually
                        </h3>
                    </div>
                    <span class="font-mono text-[11px] text-mute">UNIQUE PER GROUP</span>
                </div>
                <div class="p-space-md flex flex-col sm:flex-row items-stretch sm:items-center gap-space-sm">
                    <div class="flex items-center h-9.5 grow bg-white border border-base-300 px-2.5 focus-within:border-accent">
                        <span class="material-symbols-outlined text-[18px] text-mute mr-2">pin</span>
                        <input id="input-manual-vnd-code" type="text" placeholder="Enter 5-digit Vendor Code (e.g. 60002)"
                            class="w-full bg-transparent text-xs font-mono outline-none" />
                    </div>
                    <button type="button" id="btn-link-manual-code" class="btn btn-sm btn-primary gap-1 shrink-0">
                        <span class="material-symbols-outlined text-[18px]">add_link</span>
                        <span>Link to Group</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sticky Footer -->
        <div
            class="px-space-lg py-space-md bg-base-200 border-t border-base-300 flex items-center justify-between gap-space-sm shrink-0">
            <span class="text-[11px] font-mono text-mute">
                Changes apply immediately to Shared E-SCM &amp; Approved List Grouping
            </span>
            <button type="button" id="closeGroupDrawerFooterBtn" class="btn btn-sm btn-primary">
                Done
            </button>
        </div>
    </div>
</div>
