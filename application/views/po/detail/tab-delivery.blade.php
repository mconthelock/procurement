<!-- Tab Panel 2: Supplier, Delivery & ASN -->
<div id="tab-delivery" role="tabpanel" class="po-detail-panel hidden p-space-lg space-y-space-lg">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-md">
        <!-- Supplier Information -->
        <div class="border border-base-300">
            <div class="bg-base-200 px-space-md py-3 border-b border-base-300 flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-primary">
                    Supplier Corporate Entity (ข้อมูลคู่ค้า)
                </span>
                <span class="font-mono text-[11px] text-mute">VENDOR PROFILE</span>
            </div>
            <div class="p-space-md grid grid-cols-1 sm:grid-cols-2 gap-space-md text-xs bg-white">
                <div class="sm:col-span-2">
                    <span class="uppercase text-mute block font-bold">Supplier Name</span>
                    <span id="delivery-vendor-name" class="font-bold text-primary text-sm">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Vendor Code</span>
                    <span id="delivery-vendor-code" class="font-mono font-bold text-primary">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">AMEC Buyer In-Charge</span>
                    <span id="delivery-buyer-name" class="font-semibold text-primary">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Payment Terms</span>
                    <span id="delivery-payment-terms" class="font-mono text-primary">Net 30 Days</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Incoterms</span>
                    <span id="delivery-incoterms" class="font-mono text-primary">DDP Amata City</span>
                </div>
            </div>
        </div>

        <!-- Receiving Plant & Logistics -->
        <div class="border border-base-300">
            <div class="bg-base-200 px-space-md py-3 border-b border-base-300 flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-primary">
                    Receiving Plant &amp; ASN Logistics (สถานที่จัดส่ง)
                </span>
                <span class="font-mono text-[11px] text-mute">DOCK SCHEDULE</span>
            </div>
            <div class="p-space-md grid grid-cols-1 sm:grid-cols-2 gap-space-md text-xs bg-white">
                <div class="sm:col-span-2">
                    <span class="uppercase text-mute block font-bold">Destination Plant</span>
                    <span id="delivery-plant-name" class="font-bold text-primary text-sm">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Plant Code</span>
                    <span id="delivery-plant-code" class="font-mono font-bold text-primary">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Assigned Receiving Dock</span>
                    <span id="delivery-dock-bay" class="font-semibold text-primary">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">ASN / Shipment Reference</span>
                    <span id="delivery-asn-no" class="font-mono font-semibold text-info">Not Issued</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">ECN / Drawing Reference</span>
                    <span id="delivery-ecn-no" class="font-mono font-semibold text-primary">-</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Procurement Remarks -->
    <div class="p-space-md bg-base-200 border-l-4 border-primary space-y-1 text-xs">
        <span class="uppercase tracking-wider font-bold text-primary block">
            Procurement Remarks &amp; Special Delivery Instructions
        </span>
        <p id="delivery-remarks" class="text-secondary leading-relaxed">-</p>
    </div>
</div>
