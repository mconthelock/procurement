<!-- Tab 1: Overview, Corporate Identity & Dual-Language Address (Read-Only) -->
<div id="tab-overview" role="tabpanel"
    class="vendor-detail-panel tab-content block! p-space-lg space-y-space-lg bg-base-100">

    <!-- Block 1: Corporate Identity & Regulatory Classification -->
    <div class="border border-base-300">
        <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-primary"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    Corporate Identity &amp; Classification (ข้อมูลนิติบุคคลและการจำแนกประเภท)
                </h2>
            </div>
            <span class="font-mono text-[11px] text-mute uppercase">Master Entity</span>
        </div>

        <div class="p-space-md grid grid-cols-1 md:grid-cols-3 gap-space-md">
            <!-- Vendor Name (EN) -->
            <div class="space-y-1 md:col-span-2">
                <span class="block text-xs uppercase font-bold text-mute">Vendor Name (English)</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VND_NAME" class="text-sm font-semibold text-primary">-</p>
                </div>
            </div>

            <!-- Vendor Group Type -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Vendor Group Type</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center justify-between">
                    <p id="view-VENDGROUPTYPE" class="text-sm font-mono font-bold text-primary">-</p>
                    <span class="text-[10px] font-mono text-mute uppercase">Direct / Indirect / Subcon</span>
                </div>
            </div>

            <!-- Vendor Name (TH) -->
            <div class="space-y-1 md:col-span-2">
                <span class="block text-xs uppercase font-bold text-mute">Vendor Name (Thai / ชื่อภาษาไทย)</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VND_TNAME" class="text-sm font-medium text-primary">-</p>
                </div>
            </div>

            <!-- Vendor Category -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Vendor Category</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VND_CATEGORY" class="text-sm font-medium text-primary">-</p>
                </div>
            </div>

            <!-- Vendor Class (Manufacturing / Trader / Other) -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Vendor Class (ประเภทธุรกิจ)</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center justify-between">
                    <p id="view-VND_CLASS" class="text-sm font-mono font-bold text-primary">-</p>
                    <span class="text-[10px] font-mono text-mute uppercase">Mfg / Trader / Other</span>
                </div>
            </div>

            <!-- Vendor Origin (Supply Origin Country) -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Vendor Origin (ประเทศต้นทางสินค้า)</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px] text-secondary">local_shipping</span>
                    <p id="view-VND_ORIGIN" class="text-sm font-mono font-bold text-primary">-</p>
                </div>
            </div>

            <!-- TAX ID / Swift Code -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">TAX. ID / Swift Code</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VND_TAXNO" class="text-sm font-mono font-semibold text-primary">-</p>
                </div>
            </div>

            <!-- CA No. -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">CA No. (Control Agreement)</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VND_CANO" class="text-sm font-mono font-medium text-primary">-</p>
                </div>
            </div>

            <!-- BA No. -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">BA No. (Basic Agreement)</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VND_BANO" class="text-sm font-mono font-medium text-primary">-</p>
                </div>
            </div>

            <!-- Legal Status & Corporate ID -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Legal Status</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-LEGAL_STATUS" class="text-sm font-medium text-primary">-</p>
                </div>
            </div>

            <!-- Corporate Registration ID -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Corporate Registration ID</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-CORPORATE_ID" class="text-sm font-mono font-medium text-primary">-</p>
                </div>
            </div>

            <!-- Corporate Vendor (Parent) -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Corporate Vendor (Parent Group)</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-CORPORATE_VENDOR" class="text-sm font-mono font-medium text-primary">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Block 2: Primary Contact Information -->
    <div class="border border-base-300">
        <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-secondary"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    Primary Contact Information (ข้อมูลผู้ติดต่อหลัก)
                </h2>
            </div>
            <span class="font-mono text-[11px] text-mute uppercase">Commercial Contact</span>
        </div>

        <div class="p-space-md grid grid-cols-1 md:grid-cols-3 gap-space-md">
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Contact Person Name</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VND_SALE" class="text-sm font-medium text-primary">-</p>
                </div>
            </div>

            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Email Address</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <a id="view-VND_EMAIL" href="#" class="link link-hover text-sm font-mono text-info break-all">-</a>
                </div>
            </div>

            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Telephone No.</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-ADDR_PHONE" class="text-sm font-mono font-medium text-primary">-</p>
                </div>
            </div>

            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Fax No.</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VND_FAX" class="text-sm font-mono font-medium text-primary">-</p>
                </div>
            </div>

            <div class="space-y-1 md:col-span-2">
                <span class="block text-xs uppercase font-bold text-mute">Corporate Website</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <a id="view-ADDR_WEB" href="#" target="_blank" rel="noopener noreferrer"
                        class="link link-hover text-sm font-mono text-info break-all">-</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Block 3: Dual-Language Registered Address (EN / TH) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg">
        <!-- English Address Card -->
        <div class="border border-base-300 flex flex-col">
            <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-primary"></span>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                        Registered Address (English)
                    </h2>
                </div>
                <span class="badge badge-xs badge-primary font-mono font-bold">EN • AS400 SYNC</span>
            </div>

            <div class="p-space-md space-y-space-sm">
                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-xs uppercase font-bold text-mute">Address Line 1</span>
                        <span id="char-en-line1" class="text-[10px] font-mono text-mute">0 / 30 chars</span>
                    </div>
                    <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                        <p id="view-ADDR_EN_LINE1" class="text-sm font-medium text-primary">-</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-xs uppercase font-bold text-mute">Address Line 2</span>
                        <span id="char-en-line2" class="text-[10px] font-mono text-mute">0 / 30 chars</span>
                    </div>
                    <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                        <p id="view-ADDR_EN_LINE2" class="text-sm font-medium text-primary">-</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-sm pt-2 border-t border-base-200">
                    <div class="space-y-1">
                        <span class="block text-xs uppercase font-bold text-mute">City (เขต/อำเภอ)</span>
                        <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                            <p id="view-ADDR_EN_CITY" class="text-xs font-medium text-primary">-</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-xs uppercase font-bold text-mute">State (รัฐ/จังหวัด)</span>
                        <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                            <p id="view-ADDR_EN_STATE" class="text-xs font-medium text-primary">-</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-xs uppercase font-bold text-mute">Postcode</span>
                        <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                            <p id="view-ADDR_EN_ZIPCODE" class="text-xs font-mono font-bold text-primary">-</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-xs uppercase font-bold text-mute">Country</span>
                        <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                            <p id="view-ADDR_EN_COUNTRY" class="text-xs font-medium text-primary">-</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thai Address Card -->
        <div class="border border-base-300 flex flex-col">
            <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-secondary"></span>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                        Registered Address (Thai / ที่อยู่ภาษาไทย)
                    </h2>
                </div>
                <span class="badge badge-xs badge-secondary font-mono font-bold">TH • PP.20</span>
            </div>

            <div class="p-space-md space-y-space-sm">
                <div class="space-y-1">
                    <span class="block text-xs uppercase font-bold text-mute">ที่อยู่ 1 (บ้านเลขที่, หมู่บ้าน, อาคาร, ซอย, ถนน)</span>
                    <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                        <p id="view-ADDR_TH_LINE1" class="text-sm font-medium text-primary">-</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <span class="block text-xs uppercase font-bold text-mute">ที่อยู่ 2 / แขวง / ตำบล</span>
                    <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                        <p id="view-ADDR_TH_LINE2" class="text-sm font-medium text-primary">-</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-sm pt-2 border-t border-base-200">
                    <div class="space-y-1">
                        <span class="block text-xs uppercase font-bold text-mute">อำเภอ / เขต</span>
                        <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                            <p id="view-ADDR_TH_CITY" class="text-xs font-medium text-primary">-</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-xs uppercase font-bold text-mute">จังหวัด</span>
                        <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                            <p id="view-ADDR_TH_STATE" class="text-xs font-medium text-primary">-</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-xs uppercase font-bold text-mute">รหัสไปรษณีย์</span>
                        <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                            <p id="view-ADDR_TH_ZIPCODE" class="text-xs font-mono font-bold text-primary">-</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <span class="block text-xs uppercase font-bold text-mute">ประเทศ</span>
                        <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                            <p id="view-ADDR_TH_COUNTRY" class="text-xs font-medium text-primary">-</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Block 4: Categorized Compliance Documents & Attachments (PUR_FILE) -->
    <div class="border border-base-300">
        <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-accent"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    Compliance Documents &amp; Attachments (เอกสารแนบคู่ค้า)
                </h2>
                <span id="badge-count-docs" class="badge badge-xs badge-primary font-mono font-bold">0</span>
            </div>
            <span class="font-mono text-[11px] text-mute uppercase">Auto-Synced from EVA &amp; VMM</span>
        </div>

        <div class="p-space-md grid grid-cols-1 lg:grid-cols-2 gap-space-md">
            <!-- Category 11: Company Certification / VAT Register / Company Profile -->
            <div class="border border-base-300 flex flex-col">
                <div class="px-3 py-2 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">
                        Company Cert. / VAT Register (PP.20) / Profile
                    </span>
                    <span class="badge badge-xs badge-primary font-mono">TYPE 11</span>
                </div>
                <div id="docs-group-11" class="p-3 space-y-2 text-xs">
                    <span class="text-mute italic">No files in this category.</span>
                </div>
            </div>

            <!-- Category 12: IE's Evaluation Document -->
            <div class="border border-base-300 flex flex-col">
                <div class="px-3 py-2 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">
                        IE's Evaluation Documents
                    </span>
                    <span class="badge badge-xs badge-secondary font-mono">TYPE 12</span>
                </div>
                <div id="docs-group-12" class="p-3 space-y-2 text-xs">
                    <span class="text-mute italic">No files in this category.</span>
                </div>
            </div>

            <!-- Category 13: QA's Evaluation Document -->
            <div class="border border-base-300 flex flex-col">
                <div class="px-3 py-2 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">
                        QA's Evaluation Documents
                    </span>
                    <span class="badge badge-xs badge-secondary font-mono">TYPE 13</span>
                </div>
                <div id="docs-group-13" class="p-3 space-y-2 text-xs">
                    <span class="text-mute italic">No files in this category.</span>
                </div>
            </div>

            <!-- Category 2: Other Supporting Documents -->
            <div class="border border-base-300 flex flex-col">
                <div class="px-3 py-2 bg-base-200 border-b border-base-300 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">
                        Other Supporting Documents
                    </span>
                    <span class="badge badge-xs badge-ghost font-mono">TYPE 2 / OTHER</span>
                </div>
                <div id="docs-group-other" class="p-3 space-y-2 text-xs">
                    <span class="text-mute italic">No files in this category.</span>
                </div>
            </div>
        </div>
    </div>
</div>
