<!-- Section 1: Standard Page Header Component -->
<div
    class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-space-md bg-base-100 p-space-lg shadow-sm border-b border-base-300">
    <div class="space-y-space-xs max-w-3xl">
        <div class="flex items-center gap-2">
            <span class="badge badge-primary font-mono text-[11px] uppercase tracking-wider font-bold">
                AMEC-PRO-SYS-TH
            </span>
            <span class="badge badge-xs badge-outline font-mono font-bold uppercase">
                PO SEARCH &amp; REPORT
            </span>
        </div>
        <h1 class="text-3xl font-bold tracking-tight text-primary">
            Purchase Order Search &amp; Report
        </h1>
        <p class="text-sm text-mute leading-relaxed">
            ค้นหาและรายงานข้อมูลใบสั่งซื้อ • Multi-criteria query engine for Purchase Orders, line-item part
            specifications, supplier spend analysis, and delivery schedule reporting across AMEC plants.
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-space-sm shrink-0">
        <button type="button" id="export-report-csv" class="btn btn-sm btn-primary gap-1.5">
            <span class="material-symbols-outlined text-[18px]">download</span>
            <span>Export Result (CSV)</span>
        </button>
        <button type="button" id="print-report-btn" class="btn btn-sm btn-outline gap-1.5">
            <span class="material-symbols-outlined text-[18px]">print</span>
            <span>Print</span>
        </button>
        <a href="{{ base_url('orders') }}" class="btn btn-sm btn-outline gap-1.5">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>PO List</span>
        </a>
    </div>
</div>
