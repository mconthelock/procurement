<!-- Section 2: Summary KPI Ribbon (4-Tile Architectural Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
    <!-- KPI 1: Total Portal Users -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-primary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Total Portal Users</span>
                <span class="material-symbols-outlined text-[20px] text-mute">group</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between">
                <div class="text-2xl font-bold text-primary">
                    <span id="kpi-total-users">0</span>
                    <span class="text-xs text-mute font-normal ml-1">Accounts</span>
                </div>
                <div id="kpi-vendor-count" class="font-mono text-xs text-secondary font-semibold">0 Vendors</div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Supplier Portal Directory</span>
            <span class="font-mono text-primary font-semibold">AMEC-EDI</span>
        </div>
    </div>

    <!-- KPI 2: Active Accounts -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-success">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Active Accounts</span>
                <span class="badge badge-xs badge-success font-mono font-bold">VERIFIED</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between">
                <div class="text-2xl font-bold text-success">
                    <span id="kpi-active-users">0</span>
                    <span class="text-xs text-mute font-normal ml-1">Active</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Authorized Portal Access</span>
            <span id="kpi-active-rate" class="font-mono text-success font-semibold">0%</span>
        </div>
    </div>

    <!-- KPI 3: Pending Activation -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-warning">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Pending Activation</span>
                <span class="material-symbols-outlined text-[20px] text-mute">mark_email_unread</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between">
                <div class="text-2xl font-bold text-warning">
                    <span id="kpi-pending-users">0</span>
                    <span class="text-xs text-mute font-normal ml-1">Pending</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Awaiting First Sign-In</span>
            <span class="font-mono text-secondary font-semibold">72h Expiry</span>
        </div>
    </div>

    <!-- KPI 4: Locked / Inactive -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-error">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Locked / Inactive</span>
                <span class="badge badge-xs badge-error font-mono font-bold">RESTRICTED</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between">
                <div class="text-2xl font-bold text-error">
                    <span id="kpi-inactive-users">0</span>
                    <span class="text-xs text-mute font-normal ml-1">Suspended</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Requires Admin Review</span>
            <span class="font-mono text-error font-semibold">AUDIT</span>
        </div>
    </div>
</div>
