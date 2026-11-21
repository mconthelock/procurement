<!-- Tab Panel 3: Revision & Audit Trail -->
<div id="tab-history" role="tabpanel" class="po-detail-panel hidden p-space-lg space-y-space-md">
    <div>
        <h2 class="text-sm font-bold uppercase tracking-wider text-primary">
            PO Revision &amp; Electronic Audit Trail (ประวัติการดำเนินการและแก้ไข)
        </h2>
        <p class="text-xs text-mute mt-0.5">
            Complete timestamped log of PO issuance, ECN revisions, supplier acknowledgment, and ASN milestones.
        </p>
    </div>

    <div class="border border-base-300 overflow-x-auto" tabindex="0" role="region"
        aria-label="Purchase Order Audit History">
        <table class="table table-sm w-full border-collapse text-left">
            <thead>
                <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                    <th class="w-40">Timestamp</th>
                    <th class="w-24">Revision</th>
                    <th class="w-48">Action / Event</th>
                    <th>Actor / Department</th>
                    <th>Audit Note</th>
                </tr>
            </thead>
            <tbody id="detail-history-tbody" class="divide-y divide-base-200 text-xs"></tbody>
        </table>
    </div>
</div>
