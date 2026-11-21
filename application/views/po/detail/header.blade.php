<!-- Section 1: Standard Page Header Component -->
<div class="bg-base-100 shadow-sm border border-base-300 flex flex-col">
    <div
        class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-space-md p-space-lg border-b border-base-200">
        <div class="space-y-space-xs max-w-4xl min-w-0">
            <div class="flex flex-wrap items-center gap-2">
                <span class="badge badge-primary font-mono text-[11px] uppercase tracking-wider font-bold">
                    AMEC-PRO-SYS-TH
                </span>
                <span id="detail-po-status" class="badge badge-xs badge-ghost font-mono font-bold uppercase">
                    Loading
                </span>
                <span id="detail-po-rev"
                    class="badge badge-xs badge-outline border-primary text-primary font-mono font-bold uppercase">
                    Rev. 00
                </span>
                <span id="detail-po-priority" class="badge badge-xs badge-ghost font-mono font-bold uppercase">
                    Standard
                </span>
            </div>

            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-primary break-words">
                <span id="detail-po-number" class="font-mono">{{ $id ?: '-' }}</span>
                <span class="text-base-300 font-normal mx-1">—</span>
                <span id="detail-po-vendor">Loading Purchase Order...</span>
            </h1>

            <p class="text-sm text-mute leading-relaxed flex flex-wrap items-center gap-x-3 gap-y-1">
                <span>รายละเอียดใบสั่งซื้อ</span>
                <span class="text-base-300">•</span>
                <span>Vendor Code: <strong id="detail-vendor-code" class="font-mono text-primary">-</strong></span>
                <span class="text-base-300">•</span>
                <span>AMEC Buyer: <strong id="detail-buyer-name" class="text-primary">-</strong></span>
                <span class="text-base-300">•</span>
                <span>Issue Date: <strong id="detail-issue-date" class="font-mono text-primary">-</strong></span>
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-space-sm shrink-0">
            <button type="button" id="detail-btn-ack" class="hidden btn btn-sm btn-accent font-bold gap-1.5">
                <span class="material-symbols-outlined text-[18px]">verified</span>
                <span>Acknowledge PO</span>
            </button>
            <button type="button" id="detail-btn-pdf" class="btn btn-sm btn-outline gap-1.5">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                <span>PO PDF</span>
            </button>
            <a href="{{ $_ENV['APP_ENV'] }}/orders" class="btn btn-sm btn-outline gap-1.5">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Back</span>
            </a>
        </div>
    </div>

    <!-- Conditional Awaiting Confirmation Alert Banner -->
    <div id="detail-po-alert"
        class="hidden px-space-lg py-3 bg-error/10 border-l-4 border-error flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
        <div class="flex items-start sm:items-center gap-space-sm">
            <span class="material-symbols-outlined text-accent text-[22px] shrink-0">error</span>
            <div class="text-xs">
                <span class="font-bold uppercase tracking-wider text-accent" id="detail-alert-title">
                    ELECTRONIC ACKNOWLEDGMENT REQUIRED (72-HOUR SLA)
                </span>
                <p id="detail-alert-text" class="text-secondary mt-0.5">
                    This Purchase Order requires supplier confirmation of pricing, ECN drawing revision, and committed
                    dock delivery schedule.
                </p>
            </div>
        </div>
    </div>
</div>
