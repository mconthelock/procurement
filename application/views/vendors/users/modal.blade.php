<!-- Slide-Over Action Drawer: Add / Edit Vendor Portal User (AMEC GWS v1.4) -->
<div class="fixed inset-0 z-[2100] hidden justify-end" id="vendorUserModal" role="dialog" aria-modal="true"
    aria-labelledby="modal-user-title">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-primary/70 transition-opacity js-close-user-modal"></div>

    <!-- Drawer Panel -->
    <form id="vendorUserForm"
        class="relative w-full max-w-[640px] bg-white border-l border-primary shadow-xl flex flex-col h-full z-10">
        <input type="hidden" id="modal-user-id" name="USER_ID" value="" />
        <input type="hidden" id="modal-user-status" name="USER_STATUS" value="PENDING" />

        <!-- Sticky Black Corporate Header -->
        <div class="px-space-lg py-space-md bg-primary text-white flex items-start justify-between gap-space-md shrink-0">
            <div class="flex items-start gap-3 min-w-0">
                <span class="w-2.5 h-6 bg-accent shrink-0 mt-0.5"></span>
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="badge badge-xs badge-info font-mono font-bold uppercase">E-SCM PORTAL</span>
                        <span class="badge badge-xs badge-warning font-mono font-bold uppercase">DEFAULT: PENDING</span>
                    </div>
                    <h2 id="modal-user-title" class="text-lg font-bold tracking-tight mt-1 truncate">
                        Provision New Vendor User
                    </h2>
                    <p class="text-xs text-white/75">
                        Assign a corporate supplier account to a registered vendor entity and record their job position / responsibility.
                    </p>
                </div>
            </div>

            <button class="btn btn-sm btn-ghost text-white hover:bg-white/10 p-1 shrink-0 js-close-user-modal"
                type="button" aria-label="Close drawer">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <!-- Scrollable Body (Unified Single Card) -->
        <div class="p-space-lg overflow-y-auto grow space-y-space-md">
            <div class="border border-base-300">
                <div class="px-space-md py-2.5 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-primary"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-primary">
                            Vendor User Account Details
                        </h3>
                    </div>
                    <span class="font-mono text-[11px] text-mute">REQUIRED (*)</span>
                </div>

                <div class="p-space-md space-y-space-md">
                    <fieldset class="fieldset p-0 gap-1">
                        <label for="modal-user-vendor" class="label p-0 text-xs uppercase font-bold text-primary">
                            Registered Vendor <span class="text-error">*</span>
                        </label>
                        <select id="modal-user-vendor" name="VND_CODE" required
                            class="select select-sm h-9.5 w-full bg-base-200 border border-base-300 text-xs focus:border-accent focus:outline-none">
                            <option value="">Select Vendor...</option>
                        </select>
                    </fieldset>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm">
                        <fieldset class="fieldset p-0 gap-1">
                            <label for="modal-user-name" class="label p-0 text-xs uppercase font-bold text-primary">
                                Full Name <span class="text-error">*</span>
                            </label>
                            <input id="modal-user-name" name="USER_NAME" type="text" required
                                placeholder="e.g. Mr. Kittisak Promdee"
                                class="input input-sm h-9.5 w-full bg-base-200 border border-base-300 text-xs focus:border-accent focus:outline-none" />
                        </fieldset>
                        <fieldset class="fieldset p-0 gap-1">
                            <label for="modal-user-login" class="label p-0 text-xs uppercase font-bold text-primary">
                                Login ID / Username <span class="text-error">*</span>
                            </label>
                            <input id="modal-user-login" name="USER_LOGIN" type="text" required
                                placeholder="e.g. vnd_kittisak"
                                class="input input-sm h-9.5 w-full bg-base-200 border border-base-300 font-mono text-xs focus:border-accent focus:outline-none" />
                        </fieldset>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm">
                        <fieldset class="fieldset p-0 gap-1">
                            <label for="modal-user-email" class="label p-0 text-xs uppercase font-bold text-primary">
                                Corporate Email <span class="text-error">*</span>
                            </label>
                            <input id="modal-user-email" name="USER_EMAIL" type="email" required
                                placeholder="name@vendor.co.th"
                                class="input input-sm h-9.5 w-full bg-base-200 border border-base-300 font-mono text-xs focus:border-accent focus:outline-none" />
                        </fieldset>
                        <fieldset class="fieldset p-0 gap-1">
                            <label for="modal-user-phone" class="label p-0 text-xs uppercase font-bold text-primary">
                                Phone Number
                            </label>
                            <input id="modal-user-phone" name="USER_PHONE" type="text"
                                placeholder="+66 38-XXX-XXX"
                                class="input input-sm h-9.5 w-full bg-base-200 border border-base-300 font-mono text-xs focus:border-accent focus:outline-none" />
                        </fieldset>
                    </div>

                    <fieldset class="fieldset p-0 gap-1">
                        <label for="modal-user-role" class="label p-0 text-xs uppercase font-bold text-primary">
                            Position / Responsibility (ตำแหน่ง / หน้าที่) <span class="text-error">*</span>
                        </label>
                        <select id="modal-user-role" name="USER_ROLE" required
                            class="select select-sm h-9.5 w-full bg-base-200 border border-base-300 text-xs focus:border-accent focus:outline-none">
                            <option value="">Select or type position...</option>
                            <option value="Sales / Coordinator">Sales / Coordinator</option>
                            <option value="Production / Planning">Production / Planning</option>
                            <option value="Logistics / Delivery">Logistics / Delivery</option>
                            <option value="Quality Assurance (QA)">Quality Assurance (QA)</option>
                            <option value="Accounting / Finance">Accounting / Finance</option>
                            <option value="Management / Director">Management / Director</option>
                        </select>
                    </fieldset>
                </div>
            </div>

            <div class="bg-base-200 border-l-4 border-warning p-space-md flex items-start gap-space-sm text-xs text-secondary">
                <span class="material-symbols-outlined text-warning text-[18px] shrink-0">pending_actions</span>
                <p class="leading-relaxed">
                    New user accounts are automatically created with status <strong class="font-mono text-primary">PENDING</strong>
                    and will become active upon completion of the approval process.
                </p>
            </div>
        </div>

        <!-- Sticky Footer -->
        <div
            class="px-space-lg py-space-md bg-base-200 border-t border-base-300 flex items-center justify-between gap-space-sm shrink-0">
            <span class="text-[11px] font-mono text-mute">
                Shared across all Vendor Codes in the same group
            </span>
            <div class="flex items-center gap-2">
                <button class="btn btn-sm btn-outline border-primary bg-white text-primary js-close-user-modal"
                    type="button">Cancel</button>
                <button id="modal-user-submit" class="btn btn-sm btn-primary font-bold gap-1.5" type="submit">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Save User Account</span>
                </button>
            </div>
        </div>
    </form>
</div>
