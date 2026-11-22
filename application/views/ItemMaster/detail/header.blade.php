<!-- Section 1: Operational Sync Strip & Hero Part Header -->
<div class="bg-base-100 shadow-sm border border-base-300 flex flex-col">
    <!-- Operational Sync Strip (Inspired by design/itemmaster/screen.png) -->
    <div class="w-full bg-primary text-primary-content px-space-lg py-2.5 flex flex-wrap items-center justify-between gap-y-2 text-xs font-mono">
        <div class="flex flex-wrap items-center gap-x-5 gap-y-1">
            <div class="flex items-center gap-2">
                <span id="sync-status-dot" class="inline-block w-2 h-2 bg-success"></span>
                <span class="font-bold tracking-wider uppercase">BPCS ITEM MASTER (IIM):</span>
                <span id="sync-source-label" class="text-base-300">LIVE SYNC</span>
            </div>
            <span class="hidden sm:inline-block text-secondary">|</span>
            <div class="flex items-center gap-1.5">
                <span class="text-base-300">RECORD ID:</span>
                <span id="sync-iid-badge" class="bg-neutral text-white px-2 py-0.5 font-bold uppercase">-</span>
            </div>
            <span class="hidden lg:inline-block text-secondary">|</span>
            <div class="flex items-center gap-1.5 text-base-300">
                <span class="material-symbols-outlined text-[15px] text-success">verified</span>
                <span>FACILITY: <strong id="sync-facility" class="text-white">-</strong></span>
            </div>
        </div>
        <div class="flex items-center gap-3 text-base-300">
            <span class="hidden md:inline">Last Maint (ILDTE): <strong id="sync-last-date" class="text-white">-</strong></span>
            <span id="sync-abc-pill" class="bg-neutral px-2 py-0.5 text-white uppercase tracking-wider text-[11px] font-bold">ABC: -</span>
        </div>
    </div>

    <!-- Hero Part Header Block -->
    <div class="p-space-lg flex flex-col lg:flex-row lg:items-start lg:justify-between gap-space-lg">
        <div class="flex-1 min-w-0 space-y-space-sm">
            <!-- Overline Taxonomy -->
            <div class="flex flex-wrap items-center gap-2">
                <span class="badge badge-primary font-mono text-[11px] uppercase tracking-wider font-bold">
                    AMEC-PRO-SYS-TH
                </span>
                <span id="detail-item-type" class="badge badge-xs badge-info font-mono font-bold uppercase">
                    TYPE: -
                </span>
                <span id="detail-item-class" class="badge badge-xs badge-outline border-primary text-primary font-mono font-bold uppercase">
                    CLASS: -
                </span>
                <span id="detail-item-status" class="badge badge-xs badge-success font-mono font-bold uppercase">
                    ACTIVE (IM)
                </span>
                <span id="detail-preview-badge" class="hidden badge badge-xs badge-warning font-mono font-bold uppercase">
                    PREVIEW SAMPLE DATA
                </span>
            </div>

            <!-- Main Item Code & Descriptions -->
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-primary font-mono break-words"
                    id="detail-iprod">
                    {{ $id ?: '-' }}
                </h1>
                <div id="detail-idesc" class="text-lg font-semibold text-primary leading-snug mt-1">
                    Loading Item Master specification...
                </div>
                <p id="detail-idsce" class="text-sm text-mute mt-0.5">
                    -
                </p>
            </div>

            <!-- 4 Quick Spec Chips (Directly adapted from design/itemmaster/screen.png) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1">
                <div class="bg-base-200/70 border border-base-300 p-2.5">
                    <div class="text-[11px] text-mute uppercase tracking-wider font-bold">Drawing / Formula (IDRAW)</div>
                    <div id="chip-idraw" class="font-mono text-sm text-primary font-bold mt-0.5 truncate">-</div>
                </div>
                <div class="bg-base-200/70 border border-base-300 p-2.5">
                    <div class="text-[11px] text-mute uppercase tracking-wider font-bold">Commodity / Group (IMCOM)</div>
                    <div id="chip-imcom" class="font-mono text-sm text-info font-bold mt-0.5 truncate">-</div>
                </div>
                <div class="bg-base-200/70 border border-base-300 p-2.5">
                    <div class="text-[11px] text-mute uppercase tracking-wider font-bold">Unit Weight / U/M (IWGHT)</div>
                    <div id="chip-iwght" class="font-mono text-sm text-primary font-bold mt-0.5 truncate">-</div>
                </div>
                <div class="bg-base-200/70 border border-base-300 p-2.5">
                    <div class="text-[11px] text-mute uppercase tracking-wider font-bold">Warehouse / Loc (IWHS)</div>
                    <div id="chip-iwhs" class="font-mono text-sm text-primary font-bold mt-0.5 truncate">-</div>
                </div>
            </div>
        </div>

        <!-- Quick Action Dock -->
        <div class="w-full lg:w-auto shrink-0 flex flex-col gap-2 lg:min-w-[270px]">
            <button type="button" id="detail-btn-edit-origin" class="btn btn-sm btn-primary w-full gap-1.5">
                <span class="material-symbols-outlined text-[18px]">public</span>
                <span>Manage Country of Origin</span>
            </button>
            <button type="button" id="detail-btn-print" class="btn btn-sm btn-outline border-primary w-full gap-1.5">
                <span class="material-symbols-outlined text-[18px]">print</span>
                <span>Print Technical Spec Sheet</span>
            </button>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" id="detail-btn-copy-code" class="btn btn-sm btn-outline border-base-300 gap-1">
                    <span class="material-symbols-outlined text-[16px]">content_copy</span>
                    <span>Copy Code</span>
                </button>
                <a href="{{ $_ENV['APP_ENV'] }}/ItemMaster" class="btn btn-sm btn-outline border-base-300 gap-1">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Back</span>
                </a>
            </div>
            <div id="detail-notice-box"
                class="bg-warning/10 border border-warning/40 border-l-4 border-l-warning p-2.5 flex items-start gap-2 text-xs">
                <span class="material-symbols-outlined text-warning text-[18px] shrink-0 mt-0.5">info</span>
                <span id="detail-notice-text" class="text-secondary leading-tight">
                    Reference Description (<span class="font-mono font-semibold text-primary">IDSCR</span>): <span
                        id="detail-idscr">-</span>
                </span>
            </div>
        </div>
    </div>
</div>
