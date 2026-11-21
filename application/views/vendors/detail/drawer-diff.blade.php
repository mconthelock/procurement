<!-- Slide-Over Revision Diff Drawer (AMEC GWS v1.4) -->
<div id="revisionDiffDrawer" class="hidden fixed inset-0 z-[2000] flex justify-end" role="dialog" aria-modal="true"
    aria-labelledby="diffDrawerTitle">
    <!-- Backdrop -->
    <div id="diffDrawerBackdrop" class="fixed inset-0 bg-primary/70 transition-opacity"></div>

    <!-- Drawer Panel -->
    <div class="relative w-full max-w-[760px] bg-white border-l border-primary shadow-xl flex flex-col h-full z-10">
        <!-- Sticky Black Corporate Header -->
        <div class="px-space-lg py-space-md bg-primary text-white flex items-start justify-between gap-space-md shrink-0">
            <div class="flex items-start gap-3 min-w-0">
                <span class="w-2.5 h-6 bg-accent shrink-0 mt-0.5"></span>
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <span id="diff-mode-badge" class="badge badge-xs badge-info font-mono font-bold uppercase">UPDATE</span>
                        <span id="diff-status-badge" class="badge badge-xs badge-success font-mono font-bold uppercase">APPROVED</span>
                        <span id="diff-rev-date" class="text-[11px] font-mono text-white/75">-</span>
                    </div>
                    <h2 id="diffDrawerTitle" class="text-lg font-bold tracking-tight mt-1 truncate">
                        Revision Diff — <span id="diff-form-no" class="font-mono">-</span>
                    </h2>
                    <p id="diff-subtitle" class="text-xs text-white/75 truncate">
                        Field-level comparison against previous approved master snapshot
                    </p>
                </div>
            </div>

            <button type="button" id="closeDiffDrawerBtn"
                class="btn btn-sm btn-ghost text-white hover:bg-white/10 p-1 shrink-0" aria-label="Close drawer">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="p-space-lg overflow-y-auto grow space-y-space-lg">
            <!-- Diff View Toggle -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-base-200">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-accent"></span>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-primary">
                        Field-Level Comparison (Before → After)
                    </h3>
                </div>
                <label class="flex items-center gap-2 text-xs text-secondary cursor-pointer select-none">
                    <input type="checkbox" id="toggleChangedOnly" class="checkbox checkbox-xs checkbox-primary" checked />
                    <span class="font-medium">Show changed fields only</span>
                </label>
            </div>

            <!-- Diff Table -->
            <div class="border border-base-300 overflow-x-auto">
                <table class="table table-xs w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-primary text-white text-[11px] uppercase tracking-wider">
                            <th class="w-40">Field</th>
                            <th>Previous Value</th>
                            <th>New Value</th>
                        </tr>
                    </thead>
                    <tbody id="diff-table-body" class="divide-y divide-base-200 text-xs">
                        <tr>
                            <td colspan="3" class="py-6 text-center text-mute italic">No field differences found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Approval Trail Block -->
            <div class="border border-base-300">
                <div class="px-space-md py-2.5 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-primary"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-primary">
                            Approval Signatures &amp; Timestamps
                        </h3>
                    </div>
                    <span class="font-mono text-[11px] text-mute">PRO-QP-A-020</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-xs w-full border-collapse text-left">
                        <thead>
                            <tr class="bg-base-200 text-primary text-[11px] uppercase tracking-wider border-b border-base-300">
                                <th>Role</th>
                                <th>Approver Code / Name</th>
                                <th>Action</th>
                                <th class="text-right">Date &amp; Time</th>
                            </tr>
                        </thead>
                        <tbody id="diff-approval-body" class="divide-y divide-base-200 text-xs">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Post-Approval Email Notification Audit -->
            <div class="border border-base-300">
                <div class="px-space-md py-2.5 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-secondary"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-primary">
                            Post-Approval Notification Dispatch
                        </h3>
                    </div>
                    <span id="diff-email-status" class="badge badge-xs badge-success font-mono font-bold">DISPATCHED</span>
                </div>
                <div id="diff-email-details" class="p-space-md space-y-1.5 text-xs text-secondary font-mono">
                    <div><strong class="text-primary">To (ACC):</strong> Accounting@MitsubishiElevatorAsia.co.th</div>
                    <div><strong class="text-primary">CC (Group):</strong> -</div>
                    <div><strong class="text-primary">Requester:</strong> -</div>
                </div>
            </div>
        </div>

        <!-- Sticky Footer -->
        <div
            class="px-space-lg py-space-md bg-base-200 border-t border-base-300 flex items-center justify-between gap-space-sm shrink-0">
            <a id="diff-open-form-link" href="#" target="_blank" rel="noopener noreferrer"
                class="btn btn-sm btn-outline border-primary bg-white text-primary gap-1.5">
                <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                <span>Open Cover Form</span>
            </a>
            <button type="button" id="closeDiffDrawerFooterBtn" class="btn btn-sm btn-primary">
                Close
            </button>
        </div>
    </div>
</div>
