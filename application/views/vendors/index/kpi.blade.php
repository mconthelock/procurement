<!-- Section 2: Summary KPI Ribbon (4-Tile Architectural Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
    <!-- KPI 1: Total Registered Vendors -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-primary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Total Registered Vendors</span>
                <span class="material-symbols-outlined text-[20px] text-mute">corporate_fare</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-total-vendors">0</span>
                    <span class="text-xs text-mute font-sans font-normal ml-1">Entities</span>
                </div>
                <span id="kpi-active-badge" class="badge badge-xs badge-success font-mono font-bold">0% ACTIVE</span>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Active: <strong id="kpi-active-count" class="text-primary font-mono font-semibold">0</strong></span>
            <span>Inactive/Hold: <strong id="kpi-inactive-count" class="text-error font-mono font-semibold">0</strong></span>
        </div>
    </div>

    <!-- KPI 2: Domestic vs Overseas Mix -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-info">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Domestic / Overseas Mix</span>
                <span class="material-symbols-outlined text-[20px] text-info">public</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-domestic-count">0</span>
                    <span class="text-base-300 font-normal mx-1">/</span>
                    <span id="kpi-oversea-count" class="text-info">0</span>
                </div>
                <span class="badge badge-xs badge-outline font-mono">1099 SPLIT</span>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Countries Covered</span>
            <strong id="kpi-country-count" class="font-mono text-primary font-semibold">0</strong>
        </div>
    </div>

    <!-- KPI 3: Sub-Contractors & Non-Production -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-success">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Subcon &amp; Non-Production</span>
                <span class="material-symbols-outlined text-[20px] text-success">precision_manufacturing</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-subcon-count">0</span>
                    <span class="text-xs text-mute font-sans font-normal ml-1">Subcon (8)</span>
                </div>
                <span id="kpi-nonprod-count" class="badge badge-xs badge-ghost font-mono font-bold">0 Non-Prod</span>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Currencies Mapped</span>
            <strong id="kpi-currency-count" class="font-mono text-primary font-semibold">0</strong>
        </div>
    </div>

    <!-- KPI 4: Data Completeness / Tax & Category -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-warning">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Master Completeness</span>
                <span class="material-symbols-outlined text-[20px] text-warning">verified_user</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-tax-pct">0%</span>
                    <span class="text-xs text-mute font-sans font-normal ml-1">Tax ID Verified</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>With CA / BA No.</span>
            <strong id="kpi-agreement-count" class="font-mono text-primary font-semibold">0</strong>
        </div>
    </div>
</div>
