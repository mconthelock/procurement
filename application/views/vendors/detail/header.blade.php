<!-- Section 1: Standard Page Header Component -->
<div
    class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-space-md bg-base-100 p-space-lg shadow-sm border-b border-base-300">
    <div class="space-y-space-xs max-w-3xl">
        <div class="flex flex-wrap items-center gap-2">
            <span class="badge badge-primary font-mono text-[11px] uppercase tracking-wider font-bold">
                AMEC-PRO-SYS-TH
            </span>
            <span id="view-VND_STATUS" class="badge badge-xs badge-success font-mono font-bold uppercase">
                Active
            </span>
        </div>
        <h1 class="text-3xl font-bold tracking-tight text-primary">
            {{ $title ?? 'Vendor Profile & Master Record' }}
        </h1>
        <p class="text-sm text-mute leading-relaxed">
            ข้อมูลรายละเอียดคู่ค้า • Official read-only vendor profile, ERP/SAP vendor codes, payment terms,
            dual-language address registry, and compliance documentation.
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-space-sm shrink-0">
        <a href="{{ $_ENV['APP_ENV'] }}/Vendors" class="btn btn-sm btn-outline gap-1.5">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Back to Directory</span>
        </a>
    </div>
</div>
