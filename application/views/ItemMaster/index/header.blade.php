<!-- Section 1: Standard Page Header Component -->
<div
    class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-space-md bg-base-100 p-space-lg shadow-sm border-b border-base-300">
    <div class="space-y-space-xs max-w-3xl">
        <div class="flex flex-wrap items-center gap-2">
            <span class="badge badge-primary font-mono text-[11px] uppercase tracking-wider font-bold">
                AMEC-PRO-SYS-TH
            </span>
            <span class="badge badge-xs badge-outline font-mono font-bold uppercase">
                BPCS IIM MASTER
            </span>
        </div>
        <h1 class="text-3xl font-bold tracking-tight text-primary">
            Item Master Catalog
        </h1>
        <p class="text-sm text-mute leading-relaxed">
            ทะเบียนรายการชิ้นส่วนและวัตถุดิบหลัก • Central Item Master Repository (AS400 / BPCS <span
                class="font-mono text-primary font-semibold">IIM</span>) for engineering drawings, inventory balances,
            standard costing, MRP planning parameters, and Country of Origin compliance.
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-space-sm shrink-0">
        <button type="button" id="import-excel" class="btn btn-sm btn-outline gap-1.5" disabled>
            <span class="material-symbols-outlined text-[18px]">upload_file</span>
            <span>Import Origin Excel</span>
        </button>
        <button type="button" id="origin-bulk-list" class="btn btn-sm btn-outline gap-1.5" disabled>
            <span class="material-symbols-outlined text-[18px]">public</span>
            <span>Origin BULK List</span>
        </button>
        <button type="button" id="export-item-list" class="btn btn-sm btn-primary gap-1.5">
            <span class="material-symbols-outlined text-[18px]">download</span>
            <span>Export XLS / CSV</span>
        </button>
    </div>
</div>
