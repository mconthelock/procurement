<!-- Section 1: Standard Page Header Component -->
<div
    class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-space-md bg-base-100 p-space-lg shadow-sm border-b border-base-300">
    <div class="space-y-space-xs max-w-3xl">
        <div class="flex items-center gap-2">
            <span class="badge badge-primary font-mono text-[11px] uppercase tracking-wider font-bold">
                AMEC-PRO-SYS-TH
            </span>
            <span class="badge badge-xs badge-outline font-mono font-bold uppercase">
                PORTAL ACCESS CONTROL
            </span>
        </div>
        <h1 class="text-3xl font-bold tracking-tight text-primary">
            Vendor Users Management
        </h1>
        <p class="text-sm text-mute leading-relaxed">
            จัดการบัญชีผู้ใช้งานคู่ค้า • Provision supplier portal accounts, assign role-based permissions, monitor
            login activity, and enforce Mitsubishi Electric EDI access compliance.
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-space-sm shrink-0">
        <button type="button" id="export-vendor-users" class="btn btn-sm btn-outline gap-1.5">
            <span class="material-symbols-outlined text-[18px]">download</span>
            <span>Export User List</span>
        </button>
        <button type="button" id="open-create-user-modal" class="btn btn-sm btn-primary gap-1.5">
            <span class="material-symbols-outlined text-[18px]">person_add</span>
            <span>+ Add Vendor User</span>
        </button>
    </div>
</div>
