<!-- Tab 6: Change History & Audit Monitoring (Core Monitoring Tab) -->
<div id="tab-history" role="tabpanel"
    class="vendor-detail-panel tab-content hidden! p-space-lg space-y-space-md bg-base-100">

    <!-- Filter Strip for Revision Audit Log -->
    <div class="border border-base-300 bg-base-200/50 p-space-md">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-space-sm items-end">
            <div class="lg:col-span-4 space-y-1">
                <label for="historySearchInput" class="block text-[11px] uppercase font-bold text-mute">
                    Search Form No. / Approver / Field
                </label>
                <div
                    class="flex items-center h-9.5 bg-white border border-base-300 px-2.5 focus-within:border-accent">
                    <span class="material-symbols-outlined text-[18px] text-mute mr-2">search</span>
                    <input type="text" id="historySearchInput" placeholder="e.g. VMM26-089, Address, 97032..."
                        class="w-full bg-transparent text-xs outline-none" />
                </div>
            </div>

            <div class="lg:col-span-2 space-y-1">
                <label for="historyModeFilter" class="block text-[11px] uppercase font-bold text-mute">
                    Revision Mode
                </label>
                <select id="historyModeFilter"
                    class="select select-sm h-9.5 w-full bg-white border-base-300 text-xs font-mono">
                    <option value="">All Modes (A / U / D)</option>
                    <option value="A">A — Add</option>
                    <option value="U">U — Update</option>
                    <option value="D">D — Delete</option>
                </select>
            </div>

            <div class="lg:col-span-2 space-y-1">
                <label for="historyStatusFilter" class="block text-[11px] uppercase font-bold text-mute">
                    Approval Status
                </label>
                <select id="historyStatusFilter"
                    class="select select-sm h-9.5 w-full bg-white border-base-300 text-xs">
                    <option value="">All Statuses</option>
                    <option value="2">Approved</option>
                    <option value="1">In-Progress</option>
                    <option value="3">Rejected</option>
                </select>
            </div>

            <div class="lg:col-span-4 flex items-center justify-end gap-space-sm">
                <button type="button" id="historyFilterReset" class="btn btn-sm btn-primary gap-1">
                    <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                    <span>Reset</span>
                </button>
                <button type="button" id="btn-export-history" class="btn btn-sm btn-outline bg-white gap-1">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    <span>Export Audit Log</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Revision Transaction Approval Table -->
    <div class="border border-base-300 overflow-hidden">
        <div class="px-space-md py-2.5 bg-base-200 border-b border-base-300 flex items-center justify-between text-xs">
            <span id="historySummaryCount" class="font-mono text-secondary font-semibold">
                Showing 0 revision transactions
            </span>
            <span class="text-mute font-mono text-[11px]">
                Click "View Diff" to inspect Before vs. After field changes
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-sm w-full border-collapse text-left">
                <thead>
                    <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                        <th class="w-24">Rev / Mode</th>
                        <th>Cover Form No. &amp; Ref</th>
                        <th>Changed Fields Summary</th>
                        <th>Approval Trail (Buyer → SEM → DEM/DDEM)</th>
                        <th class="text-center w-32">Status</th>
                        <th class="text-center w-28">Action</th>
                    </tr>
                </thead>
                <tbody id="view-history-container" class="divide-y divide-base-200 text-xs">
                    <tr>
                        <td colspan="6" class="py-8 text-center text-mute italic">
                            Loading revision transaction history...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
