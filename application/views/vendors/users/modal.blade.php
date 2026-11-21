<!-- Corporate Action Modal: Add / Edit Vendor Portal User -->
<div class="fixed inset-0 z-[2100] hidden items-center justify-center p-4" id="vendorUserModal">
    <div class="absolute inset-0 bg-primary/70 js-close-user-modal"></div>
    <div class="card relative bg-white w-full max-w-lg shadow-2xl border border-base-300 border-t-4 border-t-accent">
        <form id="vendorUserForm" class="card-body p-6 space-y-4 gap-0">
            <input type="hidden" id="modal-user-id" name="USER_ID" value="" />

            <div class="flex items-center justify-between border-b border-base-300 pb-3">
                <h2 id="modal-user-title" class="text-base text-primary font-bold uppercase tracking-wide">
                    Provision New Vendor User
                </h2>
                <button class="btn btn-ghost btn-xs btn-square text-mute js-close-user-modal" type="button"
                    aria-label="Close modal">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <p class="text-xs text-mute">
                Assign a corporate supplier account to a registered vendor entity and define their portal access role.
            </p>

            <div class="space-y-3">
                <fieldset class="fieldset p-0 gap-1">
                    <label class="label p-0 text-xs uppercase font-bold text-primary">
                        Registered Vendor <span class="text-error">*</span>
                    </label>
                    <select id="modal-user-vendor" name="VND_CODE" required
                        class="select select-sm w-full bg-base-200 border border-base-300 text-xs focus:border-accent focus:outline-none">
                        <option value="">Select Vendor...</option>
                    </select>
                </fieldset>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <fieldset class="fieldset p-0 gap-1">
                        <label class="label p-0 text-xs uppercase font-bold text-primary">
                            Full Name <span class="text-error">*</span>
                        </label>
                        <input id="modal-user-name" name="USER_NAME" type="text" required
                            placeholder="e.g. Mr. Kittisak Promdee"
                            class="input input-sm w-full bg-base-200 border border-base-300 text-xs focus:border-accent focus:outline-none" />
                    </fieldset>
                    <fieldset class="fieldset p-0 gap-1">
                        <label class="label p-0 text-xs uppercase font-bold text-primary">
                            Login ID / Username <span class="text-error">*</span>
                        </label>
                        <input id="modal-user-login" name="USER_LOGIN" type="text" required
                            placeholder="e.g. vnd_kittisak"
                            class="input input-sm w-full bg-base-200 border border-base-300 font-mono text-xs focus:border-accent focus:outline-none" />
                    </fieldset>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <fieldset class="fieldset p-0 gap-1">
                        <label class="label p-0 text-xs uppercase font-bold text-primary">
                            Corporate Email <span class="text-error">*</span>
                        </label>
                        <input id="modal-user-email" name="USER_EMAIL" type="email" required
                            placeholder="name@vendor.co.th"
                            class="input input-sm w-full bg-base-200 border border-base-300 font-mono text-xs focus:border-accent focus:outline-none" />
                    </fieldset>
                    <fieldset class="fieldset p-0 gap-1">
                        <label class="label p-0 text-xs uppercase font-bold text-primary">
                            Phone Number
                        </label>
                        <input id="modal-user-phone" name="USER_PHONE" type="text"
                            placeholder="+66 38-XXX-XXX"
                            class="input input-sm w-full bg-base-200 border border-base-300 font-mono text-xs focus:border-accent focus:outline-none" />
                    </fieldset>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <fieldset class="fieldset p-0 gap-1">
                        <label class="label p-0 text-xs uppercase font-bold text-primary">
                            Portal Role <span class="text-error">*</span>
                        </label>
                        <select id="modal-user-role" name="USER_ROLE" required
                            class="select select-sm w-full bg-base-200 border border-base-300 text-xs focus:border-accent focus:outline-none">
                            <option value="ADMIN">Vendor Admin</option>
                            <option value="SALES">Sales / PO Handler</option>
                            <option value="LOGISTICS">Logistics / ASN</option>
                            <option value="QA">Quality / Claim</option>
                        </select>
                    </fieldset>
                    <fieldset class="fieldset p-0 gap-1">
                        <label class="label p-0 text-xs uppercase font-bold text-primary">
                            Account Status
                        </label>
                        <select id="modal-user-status" name="USER_STATUS"
                            class="select select-sm w-full bg-base-200 border border-base-300 text-xs focus:border-accent focus:outline-none">
                            <option value="ACTIVE">Active</option>
                            <option value="PENDING">Pending Activation</option>
                            <option value="INACTIVE">Locked / Inactive</option>
                        </select>
                    </fieldset>
                </div>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-base-300">
                <button class="btn btn-sm btn-outline border-primary bg-white text-primary js-close-user-modal"
                    type="button">Cancel</button>
                <button id="modal-user-submit" class="btn btn-sm btn-primary font-bold gap-1.5" type="submit">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Save User Account</span>
                </button>
            </div>
        </form>
    </div>
</div>
