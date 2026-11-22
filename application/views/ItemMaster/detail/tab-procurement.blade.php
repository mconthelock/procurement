<!-- TAB 5: Procurement, Vendors & Country of Origin Compliance -->
<div id="tab-procurement" class="item-tab-panel hidden p-space-lg flex-col gap-space-md">
    <!-- Card 5A: Sourcing & Vendor Assignment -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-success text-[18px]">corporate_fare</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Approved Vendor Assignment &amp; Purchasing Codes</span>
            </div>
            <span class="font-mono text-[11px] text-mute">IIM SOURCING</span>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-xs w-full border-collapse text-left">
                <thead>
                    <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                        <th class="py-2.5 px-space-md">Role</th>
                        <th class="py-2.5 px-space-md">Vendor Code</th>
                        <th class="py-2.5 px-space-md">Vendor / Reference Info</th>
                        <th class="py-2.5 px-space-md text-right">Action</th>
                    </tr>
                </thead>
                <tbody id="proc-vendors-tbody" class="divide-y divide-base-200 text-xs">
                    <tr>
                        <td colspan="4" class="py-4 text-center text-mute">Loading vendor assignment...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-space-md bg-base-200/40 border-t border-base-200 grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
            <div class="bg-base-100 border border-base-300 p-2.5">
                <div class="text-[10px] font-bold uppercase text-mute">Buyer / Planner Code (<span class="font-mono">IBUYC</span>)</div>
                <div id="proc-IBUYC" class="font-mono text-sm font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="bg-base-100 border border-base-300 p-2.5">
                <div class="text-[10px] font-bold uppercase text-mute">Purchasing Code (<span class="font-mono">IPURC</span>)</div>
                <div id="proc-IPURC" class="font-mono text-sm font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="bg-base-100 border border-base-300 p-2.5">
                <div class="text-[10px] font-bold uppercase text-mute">FE / Contract No. (<span class="font-mono">IFENO</span>)</div>
                <div id="proc-IFENO" class="font-mono text-sm font-bold text-primary mt-0.5">-</div>
            </div>
        </div>
    </div>

    <!-- Card 5B: Country of Origin & Manufacturer Registry -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-info text-[18px]">public</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Country of Origin (COO) &amp; Manufacturer Registry</span>
            </div>
            <button type="button" id="btn-edit-origin-inline" class="btn btn-xs btn-primary gap-1">
                <span class="material-symbols-outlined text-[14px]">edit</span>
                <span>Edit Origin</span>
            </button>
        </div>

        <!-- Read-Only View -->
        <div id="origin-view-panel" class="p-space-md grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] font-bold uppercase text-mute">Origin Mode</div>
                <div id="origin-view-mode" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] font-bold uppercase text-mute">Country of Origin</div>
                <div id="origin-view-country" class="font-mono font-bold text-success mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] font-bold uppercase text-mute">Origin Type</div>
                <div id="origin-view-type" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] font-bold uppercase text-mute">Manufacturer Name</div>
                <div id="origin-view-mfg-name" class="text-primary font-semibold mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5 md:col-span-2">
                <div class="text-[10px] font-bold uppercase text-mute">Manufacturer Address</div>
                <div id="origin-view-mfg-addr" class="text-primary mt-0.5">-</div>
            </div>
        </div>

        <!-- Inline Edit Form -->
        <form id="origin-edit-form" class="hidden p-space-md bg-base-200/30 border-t border-base-200 flex-col gap-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="fieldset">
                    <label class="fieldset-legend text-xs font-bold uppercase text-mute">Country Mode</label>
                    <div class="flex items-center gap-5 pt-1">
                        <label class="flex items-center gap-2 text-xs text-primary cursor-pointer">
                            <input type="radio" name="origin-mode" value="0" class="radio radio-xs radio-primary" checked />
                            <span>Single Country</span>
                        </label>
                        <label class="flex items-center gap-2 text-xs text-primary cursor-pointer">
                            <input type="radio" name="origin-mode" value="1" class="radio radio-xs radio-primary" />
                            <span>Group / Multiple</span>
                        </label>
                    </div>
                </div>
                <div class="fieldset">
                    <label class="fieldset-legend text-xs font-bold uppercase text-mute" for="origin-edit-type">Origin Type</label>
                    <select id="origin-edit-type"
                        class="select select-sm w-full bg-base-100 border border-base-300 text-xs focus:border-accent">
                        <option value="">-- Select Origin Type --</option>
                        <option value="1">1 — Trading</option>
                        <option value="2">2 — Process</option>
                        <option value="3">3 — Manufacturing</option>
                    </select>
                </div>
                <div class="fieldset md:col-span-2">
                    <label class="fieldset-legend text-xs font-bold uppercase text-mute" for="origin-edit-country">Country of Origin</label>
                    <input id="origin-edit-country" type="text"
                        placeholder="e.g. THAILAND or JAPAN/THAILAND (for group mode)"
                        class="input input-sm w-full bg-base-100 border border-base-300 text-xs font-mono uppercase focus:border-accent" />
                </div>
                <div class="fieldset md:col-span-2">
                    <label class="fieldset-legend text-xs font-bold uppercase text-mute" for="origin-edit-mfg-name">Manufacturer Name</label>
                    <input id="origin-edit-mfg-name" type="text" placeholder="Enter Manufacturer Name"
                        class="input input-sm w-full bg-base-100 border border-base-300 text-xs focus:border-accent" />
                </div>
                <div class="fieldset md:col-span-2">
                    <label class="fieldset-legend text-xs font-bold uppercase text-mute" for="origin-edit-mfg-addr">Manufacturer Address</label>
                    <textarea id="origin-edit-mfg-addr" rows="2" placeholder="Enter Manufacturer Address"
                        class="textarea textarea-sm w-full bg-base-100 border border-base-300 text-xs focus:border-accent"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-base-200">
                <button type="button" id="btn-cancel-origin-inline" class="btn btn-sm btn-outline border-base-300">
                    Cancel
                </button>
                <button type="submit" id="btn-save-origin-inline" class="btn btn-sm btn-primary gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Save Origin Data</span>
                </button>
            </div>
        </form>
    </div>
</div>
