<!-- Section 2: Vendor Metadata KPI Ribbon (4-Tile Architectural Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
    <!-- Tile 1: Vendor Record ID -->
    <div id="box-VND_CODE"
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-primary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Vendor Record ID</span>
                <span class="material-symbols-outlined text-[20px] text-mute">badge</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between">
                <div id="view-VND_CODE" class="text-2xl font-bold font-mono text-primary">
                    {{ $id ?: '-' }}
                </div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Master Registry Key</span>
            <span class="font-mono text-secondary font-semibold">PUR_VENDORS</span>
        </div>
    </div>

    <!-- Tile 2: Registered By -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-secondary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Registered By</span>
                <span class="material-symbols-outlined text-[20px] text-mute">person_check</span>
            </div>
            <div class="mt-2">
                <div id="view-VND_REGNAME" class="text-lg font-bold text-primary truncate">-</div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Procurement Officer</span>
            <span class="font-mono text-primary font-semibold">AMEC</span>
        </div>
    </div>

    <!-- Tile 3: Registered Date -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-info">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Registered Date</span>
                <span class="material-symbols-outlined text-[20px] text-mute">event_available</span>
            </div>
            <div class="mt-2">
                <div id="view-VND_REGDATE" class="text-lg font-bold font-mono text-primary">-</div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Initial Onboarding</span>
            <span class="font-mono text-secondary font-semibold">ICT (UTC+7)</span>
        </div>
    </div>

    <!-- Tile 4: Last Updated -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-success">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Last Updated</span>
                <span class="material-symbols-outlined text-[20px] text-mute">update</span>
            </div>
            <div class="mt-2">
                <div id="view-VND_LASTUPDATE" class="text-lg font-bold font-mono text-primary">-</div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Latest Audit Sync</span>
            <span class="badge badge-xs badge-success font-mono font-bold">SYNCED</span>
        </div>
    </div>
</div>
