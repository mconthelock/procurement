<!-- Section 1: Standard Page Header Component -->
<div class="bg-base-100 shadow-sm border border-base-300 flex flex-col">
    <div
        class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-space-md p-space-lg border-b border-base-200">
        <div class="space-y-space-xs max-w-4xl min-w-0">
            <div class="flex flex-wrap items-center gap-2">
                <span class="badge badge-primary font-mono text-[11px] uppercase tracking-wider font-bold">
                    AMEC-PRO-VMM
                </span>
                <span id="view-VND_STATUS" class="badge badge-xs badge-success font-mono font-bold uppercase">
                    Active
                </span>
                <span id="view-VENDGROUPTYPE_BADGE"
                    class="badge badge-xs badge-outline border-primary text-primary font-mono font-bold uppercase">
                    -
                </span>
                <span id="view-V1099_BADGE"
                    class="badge badge-xs badge-ghost font-mono uppercase text-secondary">
                    1099: -
                </span>
                <a id="link-ref-eva" href="#"
                    class="hidden badge badge-xs badge-info font-mono font-bold gap-1 hover:opacity-80 transition-opacity">
                    <span class="material-symbols-outlined text-[13px]">link</span>
                    <span id="view-REF_EVANO">EVA: -</span>
                </a>
                <span id="badge-ref-nvf"
                    class="hidden badge badge-xs badge-outline border-base-300 text-mute font-mono">
                    NVF: -
                </span>
            </div>

            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-primary break-words">
                <span id="header-VND_CODE" class="font-mono">{{ $id ?: '-' }}</span>
                <span class="text-base-300 font-normal mx-1">—</span>
                <span id="header-VND_NAME">Loading Vendor Profile...</span>
            </h1>

            <p class="text-sm text-mute leading-relaxed flex flex-wrap items-center gap-x-3 gap-y-1">
                <span id="header-VND_TNAME" class="text-secondary font-medium">-</span>
                <span class="text-base-300">•</span>
                <span>Tax ID / Swift: <strong id="header-TAXID" class="font-mono text-primary">-</strong></span>
                <span class="text-base-300">•</span>
                <span>Category: <strong id="header-CATEGORY" class="text-primary">-</strong></span>
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-space-sm shrink-0">
            <a id="btn-request-update" href="{{ $_ENV['APP_ENV'] }}/Vendors/create?mode=U&code={{ $id }}"
                class="btn btn-sm btn-primary gap-1.5">
                <span class="material-symbols-outlined text-[18px]">edit_document</span>
                <span>Request Update (Cover Sheet)</span>
            </a>
            <a id="btn-request-delete" href="{{ $_ENV['APP_ENV'] }}/Vendors/create?mode=D&code={{ $id }}"
                class="btn btn-sm btn-outline border-error text-error hover:bg-error hover:text-white gap-1.5">
                <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                <span>Request Delete</span>
            </a>
            <button type="button" id="btn-export-profile" class="btn btn-sm btn-outline gap-1.5">
                <span class="material-symbols-outlined text-[18px]">download</span>
                <span>Export</span>
            </button>
            <a href="{{ $_ENV['APP_ENV'] }}/Vendors" class="btn btn-sm btn-outline gap-1.5">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Back</span>
            </a>
        </div>
    </div>

    <!-- Conditional Pending Cover Sheet Request Alert Banner -->
    <div id="pending-cover-banner"
        class="hidden px-space-lg py-3 bg-warning/10 border-l-4 border-warning flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
        <div class="flex items-start sm:items-center gap-space-sm">
            <span class="material-symbols-outlined text-warning text-[22px] shrink-0">pending_actions</span>
            <div class="text-xs">
                <span class="font-bold uppercase tracking-wider text-primary">
                    Pending Cover Sheet Request In Progress
                </span>
                <p class="text-secondary mt-0.5">
                    Form <strong id="pending-form-no" class="font-mono text-primary">-</strong>
                    (Mode: <strong id="pending-form-mode" class="font-mono uppercase">-</strong>)
                    is currently awaiting <strong id="pending-form-step" class="text-primary">-</strong> approval.
                    New modification requests are locked until this revision completes.
                </p>
            </div>
        </div>
        <button type="button" id="btn-inspect-pending-form"
            class="btn btn-xs btn-outline border-primary text-primary shrink-0 gap-1">
            <span class="material-symbols-outlined text-[14px]">visibility</span>
            <span>Inspect Pending Revision</span>
        </button>
    </div>

    <!-- Conditional DO NOT USE / Hold Warning Banner -->
    <div id="hold-vendor-banner"
        class="hidden px-space-lg py-3 bg-error/10 border-l-4 border-error flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
        <div class="flex items-start sm:items-center gap-space-sm">
            <span class="material-symbols-outlined text-accent text-[22px] shrink-0">block</span>
            <div class="text-xs">
                <span class="font-bold uppercase tracking-wider text-accent">
                    Vendor Restricted / Hold Status
                </span>
                <p id="hold-vendor-reason" class="text-secondary mt-0.5">
                    This vendor is flagged as Hold or DO NOT USE. Verify compliance status before issuing any Purchase Orders.
                </p>
            </div>
        </div>
    </div>
</div>
