<!-- Slide-Over Detail Drawer: Vendor User Inspection Pane -->
<div class="fixed inset-0 z-[2000] hidden" id="vendorUserDrawer">
    <div class="absolute inset-0 bg-primary/70 js-close-user-drawer"></div>
    <div
        class="absolute top-0 right-0 bottom-0 w-full max-w-[760px] bg-white shadow-2xl flex flex-col z-10 border-l border-primary overflow-hidden">
        <!-- Drawer Header -->
        <div class="px-space-lg py-space-md bg-primary text-white flex items-center justify-between">
            <div class="flex items-center gap-space-sm">
                <div class="w-2.5 h-6 bg-accent"></div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold font-mono" id="drawer-user-login">-</span>
                        <span class="badge badge-xs badge-success font-mono font-bold uppercase"
                            id="drawer-user-status">ACTIVE</span>
                    </div>
                    <div class="text-xs text-white/75 mt-0.5" id="drawer-user-subtitle">
                        Vendor Portal Account • Mitsubishi Elevator Asia Co., Ltd. (AMEC)
                    </div>
                </div>
            </div>
            <button class="btn btn-ghost btn-sm btn-square text-white js-close-user-drawer" type="button"
                aria-label="Close drawer">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <!-- Drawer Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-space-lg space-y-space-lg bg-white">
            <!-- Restricted / Pending Alert (shown dynamically) -->
            <div id="drawer-user-alert"
                class="hidden p-space-md bg-red-50 border-l-4 border-error items-start gap-space-sm">
                <span class="material-symbols-outlined text-error text-[24px] shrink-0 mt-0.5">warning</span>
                <div class="text-xs">
                    <div class="text-sm font-bold text-error" id="drawer-alert-title">ACCOUNT ATTENTION REQUIRED</div>
                    <p class="text-primary mt-1 leading-relaxed" id="drawer-alert-text">-</p>
                </div>
            </div>

            <!-- Account Metadata Grid -->
            <div
                class="grid grid-cols-2 md:grid-cols-4 gap-space-md p-space-md bg-base-200 border border-base-300 text-xs">
                <div>
                    <span class="uppercase text-mute block font-bold">Full Name</span>
                    <span class="font-bold text-primary" id="drawer-user-name">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Position / Duty</span>
                    <span class="font-semibold text-secondary" id="drawer-user-role">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Vendor Code</span>
                    <span class="font-mono font-bold text-primary" id="drawer-user-vndcode">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Last Login</span>
                    <span class="font-mono font-bold text-primary" id="drawer-user-lastlogin">-</span>
                </div>
            </div>

            <!-- Contact & Organization Details -->
            <div class="border border-base-300">
                <div class="bg-base-200 px-space-md py-3 border-b border-base-300 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">
                        Contact &amp; Corporate Assignment
                    </span>
                    <span class="font-mono text-[11px] text-mute">EDI PROFILE</span>
                </div>
                <div class="p-space-md grid grid-cols-1 sm:grid-cols-2 gap-space-md text-xs bg-white">
                    <div>
                        <span class="uppercase text-mute block font-bold">Corporate Vendor Entity</span>
                        <span class="font-bold text-primary text-sm" id="drawer-user-vndname">-</span>
                    </div>
                    <div>
                        <span class="uppercase text-mute block font-bold">Email Address</span>
                        <span class="font-mono font-semibold text-info" id="drawer-user-email">-</span>
                    </div>
                    <div>
                        <span class="uppercase text-mute block font-bold">Phone / Extension</span>
                        <span class="font-mono text-primary" id="drawer-user-phone">-</span>
                    </div>
                    <div>
                        <span class="uppercase text-mute block font-bold">Department / Function</span>
                        <span class="text-primary" id="drawer-user-dept">-</span>
                    </div>
                </div>
            </div>

            <!-- E-SCM Shared Scope Info -->
            <div class="p-space-md bg-base-200 border-l-4 border-primary space-y-1 text-xs">
                <span class="uppercase tracking-wider font-bold text-primary block">
                    E-SCM Portal Access Scope
                </span>
                <p class="text-secondary leading-relaxed">
                    Standard E-SCM supplier access is shared across all Vendor Codes grouped under this corporate vendor
                    (<span class="font-mono font-semibold text-primary">PURSYS.VENDORS_CODE</span>). Position / responsibility is recorded for AMEC coordination reference.
                </p>
            </div>
        </div>

        <!-- Drawer Footer Action Bar -->
        <div
            class="px-space-lg py-space-md bg-base-200 border-t border-base-300 flex flex-wrap items-center justify-between gap-space-sm">
            <button id="drawer-btn-reset-pw"
                class="btn btn-sm btn-outline border-primary bg-white text-primary gap-1.5" type="button">
                <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                <span>Send Password Reset</span>
            </button>
            <div class="flex items-center gap-2">
                <button class="btn btn-sm btn-ghost js-close-user-drawer" type="button">Close</button>
                <button id="drawer-btn-edit" class="btn btn-sm btn-primary gap-1.5 font-bold" type="button">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    <span>Edit Account</span>
                </button>
            </div>
        </div>
    </div>
</div>
