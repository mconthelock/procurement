<!-- Section 1: Standard Page Header Component -->
<div
    class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-space-md bg-base-100 p-space-lg shadow-sm border-b border-base-300">
    <div class="space-y-space-xs max-w-3xl">
        <div class="flex items-center gap-2">
            <span class="badge badge-primary font-mono text-[11px] uppercase tracking-wider font-bold">
                AMEC-PRO-SYS-TH
            </span>
            <span class="badge badge-xs badge-outline font-mono font-bold uppercase">
                PURCHASE ORDER CONTROL
            </span>
        </div>
        <h1 class="text-3xl font-bold tracking-tight text-primary">
            Purchase Orders Management
        </h1>
        <p class="text-sm text-mute leading-relaxed">
            รายการใบสั่งซื้อ • Electronic Purchase Order tracking, vendor acknowledgment control, delivery milestone
            monitoring, and Advance Shipping Notice (ASN) management across Mitsubishi Elevator Asia manufacturing
            plants.
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-space-sm shrink-0">
        <button type="button" id="export-po-list" class="btn btn-sm btn-outline gap-1.5">
            <span class="material-symbols-outlined text-[18px]">download</span>
            <span>Export XLS / CSV</span>
        </button>
        <button type="button" id="open-bulk-ack-modal" class="btn btn-sm btn-outline gap-1.5">
            <span class="material-symbols-outlined text-[18px]">checklist_rtl</span>
            <span>Bulk Acknowledge</span>
        </button>
        <a href="{{ site_url('purchasereq/create') }}" class="btn btn-sm btn-primary gap-1.5">
            <span class="material-symbols-outlined text-[18px]">add_box</span>
            <span>+ Create PO / PR</span>
        </a>
    </div>
</div>
