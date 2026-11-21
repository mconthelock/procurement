<!-- Tab 3: E-SCM Portal Contacts (Read-Only) -->
<div id="tab-scm" role="tabpanel"
    class="vendor-detail-panel tab-content hidden! p-space-lg space-y-space-md bg-base-100">

    <div class="border border-base-300">
        <div
            class="px-space-md py-3 bg-base-200 border-b border-base-300 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-primary"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    E-SCM Portal Contact Persons &amp; Accounts (รายชื่อผู้ใช้งานระบบ E-SCM)
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <span class="badge badge-xs badge-ghost font-mono uppercase text-mute">Optional in Cover Sheet</span>
                <a href="{{ $_ENV['APP_ENV'] }}/Vendors/users"
                    class="btn btn-xs btn-outline border-primary text-primary gap-1">
                    <span class="material-symbols-outlined text-[13px]">open_in_new</span>
                    <span>Manage All Vendor Users</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-sm w-full border-collapse text-left">
                <thead>
                    <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                        <th class="w-12 text-center">#</th>
                        <th>Contact Name</th>
                        <th>E-Mail Address</th>
                        <th>E-SCM Username</th>
                        <th>Source Cover Form</th>
                        <th class="text-center w-28">Status</th>
                    </tr>
                </thead>
                <tbody id="view-scm-users-container" class="divide-y divide-base-200 text-xs">
                    <tr>
                        <td colspan="6" class="py-6 text-center text-mute italic">
                            No E-SCM contact accounts registered for this vendor.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-base-200 border-l-4 border-info p-space-md flex items-start gap-space-sm text-xs text-secondary">
        <span class="material-symbols-outlined text-info text-[20px] shrink-0">info</span>
        <p class="leading-relaxed">
            <strong>E-SCM Synchronization Note:</strong> E-SCM contact persons and usernames are configured via the
            Cover Sheet Form (PUR-VMM) and synced automatically upon final approval. To add or revoke portal access,
            submit a Cover Sheet Update request or manage via the Vendor Users directory.
        </p>
    </div>
</div>
