<!-- =========================================================================
     SLIDE-OVER DETAIL DRAWER: Vendor Profile Inspection Pane
     ========================================================================= -->
<div class="fixed inset-0 z-[2000] hidden" id="vendorDetailDrawer">
    <div class="absolute inset-0 bg-primary/70" onclick="closeVendorDetail()"></div>
    <div
        class="absolute top-0 right-0 bottom-0 w-full max-w-[760px] bg-white shadow-2xl flex flex-col z-10 border-l border-primary overflow-hidden">
        <!-- Drawer Header -->
        <div class="px-space-lg py-space-md bg-primary text-white flex items-center justify-between">
            <div class="flex items-center gap-space-sm">
                <div class="w-2.5 h-6 bg-accent"></div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold font-mono" id="drawerVendorCode">V-884029-TH</span>
                        <span class="badge badge-xs badge-success font-mono font-bold" id="drawerVendorStatus">ACTIVE</span>
                    </div>
                    <div class="text-xs text-white/75 mt-0.5" id="drawerVendorName">
                        Siam Precision Engineering Co., Ltd. • Mitsubishi Elevator Asia Co., Ltd. (AMEC)
                    </div>
                </div>
            </div>
            <button class="btn btn-ghost btn-sm btn-square text-white" onclick="closeVendorDetail()" type="button">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <!-- Drawer Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-space-lg space-y-space-lg bg-white">
            <!-- Alert Banner (Shown for Audit Pending / Remedial Vendors) -->
            <div class="hidden p-space-md bg-red-50 border-l-4 border-error items-start gap-space-sm"
                id="drawerVendorAlert">
                <span class="material-symbols-outlined text-error text-[24px] shrink-0 mt-0.5">error</span>
                <div class="text-xs">
                    <div class="text-sm font-bold text-error">
                        ACTION REQUIRED: Quality Remediation / Audit Follow-Up
                    </div>
                    <p class="text-primary mt-1 leading-relaxed">
                        This vendor has an open quality compliance flag or upcoming re-certification deadline. Review
                        corrective action documents before issuing new high-volume POs.
                    </p>
                </div>
            </div>

            <!-- Vendor Metadata Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-space-md p-space-md bg-base-200 border border-base-300 text-xs">
                <div>
                    <span class="uppercase text-mute block font-bold">Tier Classification</span>
                    <span class="font-mono font-bold text-primary" id="drawerVendorTier">TIER-1 DIRECT</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Quality Grade</span>
                    <span class="font-mono font-bold text-success" id="drawerVendorGrade">GRADE A CERTIFIED</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Payment Terms</span>
                    <span class="font-mono font-bold text-secondary">Net 60 Days</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">J-SOX / ISO Status</span>
                    <span class="font-mono font-bold text-primary">ISO 9001 / 14001</span>
                </div>
            </div>

            <!-- Performance & Facility Summary -->
            <div class="border border-base-300">
                <div class="bg-base-200 p-space-md border-b border-base-300 flex flex-col md:flex-row justify-between gap-2">
                    <div>
                        <div class="font-mono text-xs font-bold text-secondary">Manufacturing Location / Plant</div>
                        <div class="text-base text-primary font-bold" id="drawerVendorLocation">
                            Amata City Chonburi (Plant 2, Phase 4)
                        </div>
                        <div class="text-xs text-mute mt-1">
                            Liaison: <strong class="text-primary" id="drawerVendorContact">Mr. Kittisak Promdee</strong>
                            &bull; <span class="font-mono" id="drawerVendorEmail">kitti@siamprecision.co.th</span>
                            &bull; <span class="font-mono" id="drawerVendorPhone">+66 38-450-891</span>
                        </div>
                    </div>
                    <div>
                        <span class="badge bg-green-100 border-0 text-green-800 font-mono text-xs font-bold">
                            AVL VERIFIED
                        </span>
                    </div>
                </div>
                <div class="p-space-md grid grid-cols-2 sm:grid-cols-4 gap-space-sm bg-white text-xs">
                    <div class="border-r border-base-200 pr-2">
                        <span class="text-mute block">On-Time Delivery</span>
                        <span class="font-mono text-lg font-bold text-success" id="drawerVendorOtd">99.4%</span>
                        <span class="text-mute block">12-Month Avg</span>
                    </div>
                    <div class="border-r border-base-200 pr-2">
                        <span class="text-mute block">Defect Rate</span>
                        <span class="font-mono text-lg font-bold text-primary" id="drawerVendorPpm">0.02%</span>
                        <span class="text-mute block">PPM Threshold &lt; 0.50%</span>
                    </div>
                    <div class="border-r border-base-200 pr-2">
                        <span class="text-mute block">Currency</span>
                        <span class="font-mono text-lg font-bold text-primary">THB</span>
                        <span class="text-mute block">Local Settlement</span>
                    </div>
                    <div>
                        <span class="text-mute block">EDI Channel</span>
                        <span class="font-mono text-lg font-bold text-info">ACTIVE</span>
                        <span class="text-mute block">Protocol v4.2</span>
                    </div>
                </div>
            </div>

            <!-- Compliance & Audit Notes -->
            <div class="p-space-md bg-base-200 border-l-4 border-primary space-y-1 text-xs">
                <span class="uppercase tracking-wider font-bold text-primary">
                    Procurement &amp; Quality Directives (ข้อกำหนดคู่ค้า)
                </span>
                <p class="text-mute leading-relaxed">
                    Vendor is authorized to supply structural and electro-mechanical assemblies under AMEC-STD-004-REV7.
                    All shipments must include JIS-compliant Code 128 barcode labels and RoHS/REACH batch certificates.
                </p>
            </div>
        </div>

        <!-- Drawer Footer Action Bar -->
        <div
            class="px-space-lg py-space-md bg-base-200 border-t border-base-300 flex flex-wrap items-center justify-between gap-space-sm">
            <button class="btn btn-sm btn-outline border-primary bg-white text-primary gap-1.5"
                onclick="alert('Downloading Vendor Qualification Dossier (.PDF)...')" type="button">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                <span>Vendor Dossier (.PDF)</span>
            </button>
            <div class="flex items-center gap-2">
                <button class="btn btn-sm btn-ghost" onclick="closeVendorDetail()" type="button">Close</button>
                <a class="btn btn-sm btn-primary gap-1.5 font-bold" href="{{ $_ENV['APP_ENV'] }}/Vendors/create">
                    <span class="material-symbols-outlined text-[18px]">edit_document</span>
                    <span>Edit Vendor Master</span>
                </a>
            </div>
        </div>
    </div>
</div>
