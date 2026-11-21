<!-- Section 2: Vendor Metadata & Monitoring KPI Ribbon (4-Tile Architectural Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
    <!-- Tile 1: Vendor Code & 5-Digit Classification -->
    <div id="box-VND_CODE"
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-primary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Vendor Code (5-Digit)</span>
                <span class="material-symbols-outlined text-[20px] text-mute">badge</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div id="view-VND_CODE" class="text-2xl font-bold font-mono text-primary">
                    {{ $id ?: '-' }}
                </div>
                <span id="kpi-vendor-currency" class="badge badge-xs badge-outline font-mono font-bold">-</span>
            </div>
            <p id="kpi-code-decode" class="mt-1 text-xs text-secondary truncate">
                PRO-QP-A-020 Classification
            </p>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Master Registry</span>
            <span class="font-mono text-secondary font-semibold">PURSYS.VENDORS</span>
        </div>
    </div>

    <!-- Tile 2: Latest Evaluation Grade & Purchase Level -->
    <div id="kpi-card-eval"
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-success">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Evaluation Grade (EVA)</span>
                <span class="material-symbols-outlined text-[20px] text-mute">fact_check</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div id="kpi-eval-grade" class="text-2xl font-bold font-mono text-primary">-</div>
                <span id="kpi-eval-score" class="text-xs font-mono text-mute">Score: - / 100</span>
            </div>
            <p id="kpi-eval-level" class="mt-1 text-xs text-secondary truncate">
                Purchase Level: -
            </p>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span id="kpi-eval-fy">Fiscal Year: -</span>
            <span id="kpi-eval-ref" class="font-mono text-primary font-semibold">-</span>
        </div>
    </div>

    <!-- Tile 3: Downstream System Sync Status -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-info">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">System Sync Status</span>
                <span class="material-symbols-outlined text-[20px] text-mute">sync</span>
            </div>
            <div class="mt-2.5 flex flex-wrap items-center gap-1.5">
                <span id="sync-badge-pro" class="badge badge-xs badge-success font-mono font-bold">PRO: SYNCED</span>
                <span id="sync-badge-as400" class="badge badge-xs badge-success font-mono font-bold">AS400: SYNCED</span>
                <span id="sync-badge-scm" class="badge badge-xs badge-ghost font-mono font-bold">E-SCM: N/A</span>
            </div>
            <p class="mt-1.5 text-[11px] text-mute font-mono truncate">
                Last Updated: <span id="view-VND_LASTUPDATE" class="text-primary font-semibold">-</span>
            </p>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Registered By</span>
            <span id="view-VND_REGNAME" class="font-mono text-secondary font-semibold truncate max-w-[140px]">-</span>
        </div>
    </div>

    <!-- Tile 4: Change Audit & Governance Monitoring -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-secondary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Change Monitoring</span>
                <span class="material-symbols-outlined text-[20px] text-mute">history</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div id="kpi-revision-count" class="text-2xl font-bold font-mono text-primary">0</div>
                <span id="kpi-latest-mode" class="badge badge-xs badge-ghost font-mono font-bold uppercase">MODE: -</span>
            </div>
            <p class="mt-1 text-xs text-secondary truncate">
                Registered: <span id="view-VND_REGDATE" class="font-mono">-</span>
            </p>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Approval Flow</span>
            <span class="font-mono text-primary font-semibold">Buyer → SEM → DEM</span>
        </div>
    </div>
</div>
