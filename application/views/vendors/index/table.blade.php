<!-- Section 4: Enterprise Vendor Data Table -->
<div class="bg-base-100 shadow-sm overflow-hidden border border-base-300">
    <!-- Table Header Status Bar -->
    <div
        class="px-space-md py-2.5 bg-base-100 border-b border-base-200 flex flex-wrap items-center justify-between gap-space-sm text-xs">
        <div class="flex items-center gap-space-md text-mute">
            <span>Active View: <strong class="text-primary" id="activeViewSummary">Showing 8 of 8 Vendor
                    records</strong></span>
            <span class="w-px h-3 bg-base-300 hidden sm:inline-block"></span>
            <span class="flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px] text-secondary">verified_user</span>
                AMEC Approved Vendor List (AVL) FY2025
            </span>
        </div>
        <div class="flex items-center gap-space-sm">
            <span class="text-mute">Selected: <strong class="text-primary" id="selectedCounter">0
                    items</strong></span>
            <button class="link link-hover text-info font-semibold" id="selectAllPageBtn" type="button">
                Select All On Page
            </button>
        </div>
    </div>

    <!-- Responsive Table -->
    <div class="overflow-x-auto">
        <table id="vendorTable" class="table table-sm w-full border-collapse text-left">
            <thead>
                <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                    <th class="w-10 text-center">
                        <input id="headerCheckbox" type="checkbox"
                            class="checkbox checkbox-xs checkbox-accent border-white"
                            onchange="toggleSelectAll(this)" />
                    </th>
                    <th>Vendor Code</th>
                    <th>Corporate Entity Name &amp; Commodity</th>
                    <th>Tier &amp; Quality</th>
                    <th>Location / Plant</th>
                    <th>Liaison Contact</th>
                    <th>AMEC Buyer</th>
                    <th class="text-right">OTD &amp; PPM</th>
                    <th class="text-center">Status</th>
                    <th class="text-center w-36">Actions</th>
                </tr>
            </thead>
            <tbody id="vendorTableBody" class="divide-y divide-base-200 text-xs">
                <!-- Vendor 1: Siam Precision -->
                <tr class="vendor-row hover:bg-base-200/60 transition-colors" data-status="ACTIVE"
                    data-tier="TIER-1" data-commodity="SHEET_METAL" data-grade="GRADE_A">
                    <td class="text-center align-top py-3">
                        <input type="checkbox" class="row-select checkbox checkbox-xs checkbox-primary"
                            onchange="updateSelectedCount()" />
                    </td>
                    <td class="align-top py-3">
                        <button type="button"
                            onclick="openVendorDetail('V-884029-TH', 'Siam Precision Engineering Co., Ltd.', 'TIER-1 DIRECT', 'GRADE A CERTIFIED', 'ACTIVE', 'Amata City Chonburi (Plant 2, Phase 4)', 'Mr. Kittisak Promdee', 'kitti@siamprecision.co.th', '+66 38-450-891', '99.4%', '0.02%')"
                            class="link link-hover font-mono font-bold text-primary text-sm block text-left">
                            V-884029-TH
                        </button>
                        <span class="font-mono text-mute">SAP: 104882</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Siam Precision Engineering Co., Ltd.</div>
                        <div class="text-mute">บริษัท สยาม พรีซิชั่น เอ็นจิเนียริ่ง จำกัด</div>
                        <div class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-secondary">
                            <span class="material-symbols-outlined text-[14px]">precision_manufacturing</span>
                            <span>Elevator Hoistway &amp; Structural Sheet Metal</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1">
                            <span class="badge badge-xs badge-primary font-mono font-bold">TIER-1 DIRECT</span>
                            <span class="badge badge-xs badge-success font-mono font-bold">GRADE A CERTIFIED</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Amata City Chonburi</div>
                        <div class="text-mute">Plant 2, Phase 4 (Chonburi)</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-semibold text-primary">Mr. Kittisak Promdee</div>
                        <div class="font-mono text-[11px] text-mute">kitti@siamprecision.co.th</div>
                        <div class="font-mono text-[11px] text-mute">+66 38-450-891</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">S. Narongrit</div>
                        <div class="text-mute">Dept 4 (Structural)</div>
                    </td>
                    <td class="align-top py-3 text-right font-mono">
                        <div class="font-bold text-success">99.4% OTD</div>
                        <div class="text-mute">Defect: 0.02% PPM</div>
                    </td>
                    <td class="align-top py-3 text-center">
                        <span class="badge badge-xs badge-success font-bold uppercase">Active</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1 items-stretch">
                            <button type="button"
                                onclick="openVendorDetail('V-884029-TH', 'Siam Precision Engineering Co., Ltd.', 'TIER-1 DIRECT', 'GRADE A CERTIFIED', 'ACTIVE', 'Amata City Chonburi (Plant 2, Phase 4)', 'Mr. Kittisak Promdee', 'kitti@siamprecision.co.th', '+66 38-450-891', '99.4%', '0.02%')"
                                class="btn btn-xs btn-primary font-bold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                View Profile
                            </button>
                            <a href="#"
                                class="btn btn-xs btn-outline border-base-300 font-semibold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">receipt_long</span>
                                Open POs (14)
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Vendor 2: Chokchai Engineering -->
                <tr class="vendor-row hover:bg-base-200/60 transition-colors" data-status="ACTIVE"
                    data-tier="TIER-1" data-commodity="SHEET_METAL" data-grade="GRADE_A">
                    <td class="text-center align-top py-3">
                        <input type="checkbox" class="row-select checkbox checkbox-xs checkbox-primary"
                            onchange="updateSelectedCount()" />
                    </td>
                    <td class="align-top py-3">
                        <button type="button"
                            onclick="openVendorDetail('V-80018-TH', 'Chokchai Engineering Co., Ltd.', 'TIER-1 DIRECT', 'GRADE A CERTIFIED', 'ACTIVE', 'WHA Chonburi 1 (Bo-win, Sriracha)', 'Ms. Voranuch Ch.', 'voranuch@chokchai-eng.com', '+66 38-345-210', '98.7%', '0.05%')"
                            class="link link-hover font-mono font-bold text-primary text-sm block text-left">
                            V-80018-TH
                        </button>
                        <span class="font-mono text-mute">Code: 80018</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Chokchai Engineering Co., Ltd.</div>
                        <div class="text-mute">บริษัท โชคชัย เอ็นจิเนียริ่ง จำกัด</div>
                        <div class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-secondary">
                            <span class="material-symbols-outlined text-[14px]">crop_square</span>
                            <span>Face Plates, Brackets &amp; Stamped Press Parts</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1">
                            <span class="badge badge-xs badge-primary font-mono font-bold">TIER-1 DIRECT</span>
                            <span class="badge badge-xs badge-success font-mono font-bold">GRADE A CERTIFIED</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">WHA Chonburi 1</div>
                        <div class="text-mute">Bo-win, Sriracha</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-semibold text-primary">Ms. Voranuch Ch.</div>
                        <div class="font-mono text-[11px] text-mute">voranuch@chokchai-eng.com</div>
                        <div class="font-mono text-[11px] text-mute">+66 38-345-210</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">P. Sukcharoen</div>
                        <div class="text-mute">Dept 2 (Press/Stamping)</div>
                    </td>
                    <td class="align-top py-3 text-right font-mono">
                        <div class="font-bold text-success">98.7% OTD</div>
                        <div class="text-mute">Defect: 0.05% PPM</div>
                    </td>
                    <td class="align-top py-3 text-center">
                        <span class="badge badge-xs badge-success font-bold uppercase">Active</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1 items-stretch">
                            <button type="button"
                                onclick="openVendorDetail('V-80018-TH', 'Chokchai Engineering Co., Ltd.', 'TIER-1 DIRECT', 'GRADE A CERTIFIED', 'ACTIVE', 'WHA Chonburi 1 (Bo-win, Sriracha)', 'Ms. Voranuch Ch.', 'voranuch@chokchai-eng.com', '+66 38-345-210', '98.7%', '0.05%')"
                                class="btn btn-xs btn-primary font-bold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                View Profile
                            </button>
                            <a href="#"
                                class="btn btn-xs btn-outline border-base-300 font-semibold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">receipt_long</span>
                                Open POs (8)
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Vendor 3: H.T. Sahakij (Action Needed / Remediation) -->
                <tr class="vendor-row hover:bg-base-200/60 transition-colors bg-error/5" data-status="AUDIT_PENDING"
                    data-tier="TIER-2" data-commodity="FASTENERS" data-grade="GRADE_B_REMEDIAL">
                    <td class="text-center align-top py-3">
                        <input type="checkbox" class="row-select checkbox checkbox-xs checkbox-primary"
                            onchange="updateSelectedCount()" />
                    </td>
                    <td class="align-top py-3">
                        <button type="button"
                            onclick="openVendorDetail('V-422605-TH', 'H.T. Sahakij Co., Ltd.', 'TIER-2 SUB', 'GRADE B+ (REMEDIAL)', 'AUDIT_PENDING', 'Samut Prakan (Bang Phli Industrial Est.)', 'Mr. Somchai Tang', 'somchai@ht-sahakij.co.th', '+66 2-705-1990', '92.1%', '0.88%')"
                            class="link link-hover font-mono font-bold text-error text-sm block text-left">
                            V-422605-TH
                        </button>
                        <span class="font-mono text-mute">SAP: 102441</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">H.T. Sahakij Co., Ltd.</div>
                        <div class="text-mute">บริษัท เอช.ที. สหกิจ จำกัด</div>
                        <div class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-secondary">
                            <span class="material-symbols-outlined text-[14px]">handyman</span>
                            <span>Binder, Mounting Clips &amp; Special Fasteners</span>
                        </div>
                        <div class="mt-1">
                            <span class="badge badge-xs badge-error font-mono font-bold gap-1">
                                <span class="material-symbols-outlined text-[12px]">report</span>
                                Claim Slip CLM-2025-081
                            </span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1">
                            <span class="badge badge-xs badge-ghost font-mono font-bold">TIER-2 SUB</span>
                            <span class="badge badge-xs badge-warning font-mono font-bold">GRADE B+ (REMEDIAL)</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Samut Prakan</div>
                        <div class="text-mute">Bang Phli Industrial Est.</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-semibold text-primary">Mr. Somchai Tang</div>
                        <div class="font-mono text-[11px] text-mute">somchai@ht-sahakij.co.th</div>
                        <div class="font-mono text-[11px] text-mute">+66 2-705-1990</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">W. Teerayut</div>
                        <div class="text-mute">Dept 1 (Fasteners)</div>
                    </td>
                    <td class="align-top py-3 text-right font-mono">
                        <div class="font-bold text-warning">92.1% OTD</div>
                        <div class="text-error font-bold">Defect: 0.88% PPM</div>
                    </td>
                    <td class="align-top py-3 text-center">
                        <span class="badge badge-xs badge-error font-bold uppercase">Audit Pending</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1 items-stretch">
                            <button type="button"
                                onclick="openVendorDetail('V-422605-TH', 'H.T. Sahakij Co., Ltd.', 'TIER-2 SUB', 'GRADE B+ (REMEDIAL)', 'AUDIT_PENDING', 'Samut Prakan (Bang Phli Industrial Est.)', 'Mr. Somchai Tang', 'somchai@ht-sahakij.co.th', '+66 2-705-1990', '92.1%', '0.88%')"
                                class="btn btn-xs btn-accent font-bold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">gavel</span>
                                Review CAR
                            </button>
                            <button type="button" onclick="alert('Issuing Corrective Action Request (CAR) for V-422605-TH...')"
                                class="btn btn-xs btn-outline border-error text-error font-semibold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">warning</span>
                                Issue Notice
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Vendor 4: Mitsubishi Electric Trading Corp -->
                <tr class="vendor-row hover:bg-base-200/60 transition-colors" data-status="ACTIVE"
                    data-tier="TIER-1-GLOBAL" data-commodity="ELECTRICAL" data-grade="GRADE_A">
                    <td class="text-center align-top py-3">
                        <input type="checkbox" class="row-select checkbox checkbox-xs checkbox-primary"
                            onchange="updateSelectedCount()" />
                    </td>
                    <td class="align-top py-3">
                        <button type="button"
                            onclick="openVendorDetail('V-10003-JP', 'Mitsubishi Electric Trading Corporation (MT-S)', 'TIER-1 GLOBAL HUB', 'GRADE A CERTIFIED', 'ACTIVE', 'Tokyo / Singapore (Global Sourcing Hub)', 'K. Takahashi (高橋)', 'takahashi.k@mitsubishielectric.com', '+81 3-3218-2111', '99.9%', '0.00%')"
                            class="link link-hover font-mono font-bold text-primary text-sm block text-left">
                            V-10003-JP
                        </button>
                        <span class="font-mono text-mute">Code: 10003 (MT-S)</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Mitsubishi Electric Trading Corporation (MT-S)</div>
                        <div class="text-mute">บริษัท มิตซูบิชิ อิเล็คทริค เทรดดิ้ง คอร์ปอเรชั่น</div>
                        <div class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-secondary">
                            <span class="material-symbols-outlined text-[14px]">cable</span>
                            <span>Intercom Cables, Sensors &amp; Integrated Harness</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1">
                            <span class="badge badge-xs badge-info font-mono font-bold">TIER-1 GLOBAL HUB</span>
                            <span class="badge badge-xs badge-success font-mono font-bold">GRADE A CERTIFIED</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Tokyo / Singapore</div>
                        <div class="text-mute">Global Sourcing Hub (APAC)</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-semibold text-primary">K. Takahashi (高橋)</div>
                        <div class="font-mono text-[11px] text-mute">takahashi.k@mitsubishielectric.com</div>
                        <div class="font-mono text-[11px] text-mute">+81 3-3218-2111</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">K. Apinya</div>
                        <div class="text-mute">Global Electronics</div>
                    </td>
                    <td class="align-top py-3 text-right font-mono">
                        <div class="font-bold text-success">99.9% OTD</div>
                        <div class="text-mute">Defect: 0.00% PPM</div>
                    </td>
                    <td class="align-top py-3 text-center">
                        <span class="badge badge-xs badge-success font-bold uppercase">Active</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1 items-stretch">
                            <button type="button"
                                onclick="openVendorDetail('V-10003-JP', 'Mitsubishi Electric Trading Corporation (MT-S)', 'TIER-1 GLOBAL HUB', 'GRADE A CERTIFIED', 'ACTIVE', 'Tokyo / Singapore (Global Sourcing Hub)', 'K. Takahashi (高橋)', 'takahashi.k@mitsubishielectric.com', '+81 3-3218-2111', '99.9%', '0.00%')"
                                class="btn btn-xs btn-primary font-bold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                View Profile
                            </button>
                            <a href="#"
                                class="btn btn-xs btn-outline border-base-300 font-semibold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">receipt_long</span>
                                Open POs (42)
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Vendor 5: Thai Sumitomo Electric -->
                <tr class="vendor-row hover:bg-base-200/60 transition-colors" data-status="ACTIVE"
                    data-tier="TIER-1" data-commodity="ELECTRICAL" data-grade="GRADE_A">
                    <td class="text-center align-top py-3">
                        <input type="checkbox" class="row-select checkbox checkbox-xs checkbox-primary"
                            onchange="updateSelectedCount()" />
                    </td>
                    <td class="align-top py-3">
                        <button type="button"
                            onclick="openVendorDetail('V-550124-TH', 'Thai Sumitomo Electric Wiring Systems Co., Ltd.', 'TIER-1 DIRECT', 'GRADE A CERTIFIED', 'ACTIVE', 'Amata City Rayong (Zone 2)', 'Mr. Prasert Sakul', 'p-sakul@sews.co.th', '+66 38-892-400', '99.1%', '0.01%')"
                            class="link link-hover font-mono font-bold text-primary text-sm block text-left">
                            V-550124-TH
                        </button>
                        <span class="font-mono text-mute">SAP: 109280</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Thai Sumitomo Electric Wiring Systems Co., Ltd.</div>
                        <div class="text-mute">บริษัท ไทย ซูมิโตโม อิเล็คทริค ไวร์ริ่ง ซิสเต็มส์ จำกัด</div>
                        <div class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-secondary">
                            <span class="material-symbols-outlined text-[14px]">alt_route</span>
                            <span>Wire Harness, Hoistway Sensors &amp; Safety Circuit Looms</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1">
                            <span class="badge badge-xs badge-primary font-mono font-bold">TIER-1 DIRECT</span>
                            <span class="badge badge-xs badge-success font-mono font-bold">GRADE A CERTIFIED</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Amata City Rayong</div>
                        <div class="text-mute">Zone 2 (Rayong Plant)</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-semibold text-primary">Mr. Prasert Sakul</div>
                        <div class="font-mono text-[11px] text-mute">p-sakul@sews.co.th</div>
                        <div class="font-mono text-[11px] text-mute">+66 38-892-400</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">K. Apinya</div>
                        <div class="text-mute">Dept 3 (Electrical)</div>
                    </td>
                    <td class="align-top py-3 text-right font-mono">
                        <div class="font-bold text-success">99.1% OTD</div>
                        <div class="text-mute">Defect: 0.01% PPM</div>
                    </td>
                    <td class="align-top py-3 text-center">
                        <span class="badge badge-xs badge-success font-bold uppercase">Active</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1 items-stretch">
                            <button type="button"
                                onclick="openVendorDetail('V-550124-TH', 'Thai Sumitomo Electric Wiring Systems Co., Ltd.', 'TIER-1 DIRECT', 'GRADE A CERTIFIED', 'ACTIVE', 'Amata City Rayong (Zone 2)', 'Mr. Prasert Sakul', 'p-sakul@sews.co.th', '+66 38-892-400', '99.1%', '0.01%')"
                                class="btn btn-xs btn-primary font-bold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                View Profile
                            </button>
                            <a href="#"
                                class="btn btn-xs btn-outline border-base-300 font-semibold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">receipt_long</span>
                                Open POs (19)
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Vendor 6: Eastern Precision Casting -->
                <tr class="vendor-row hover:bg-base-200/60 transition-colors" data-status="ACTIVE"
                    data-tier="TIER-1" data-commodity="CASTING" data-grade="GRADE_A">
                    <td class="text-center align-top py-3">
                        <input type="checkbox" class="row-select checkbox checkbox-xs checkbox-primary"
                            onchange="updateSelectedCount()" />
                    </td>
                    <td class="align-top py-3">
                        <button type="button"
                            onclick="openVendorDetail('V-671044-TH', 'Eastern Precision Casting Co., Ltd.', 'TIER-1 DIRECT', 'GRADE A CERTIFIED', 'ACTIVE', 'WHA Eastern Seaboard 2 (Chonburi Foundry)', 'Mr. Boonmee Inthira', 'boonmee@epc-casting.co.th', '+66 38-955-112', '98.9%', '0.04%')"
                            class="link link-hover font-mono font-bold text-primary text-sm block text-left">
                            V-671044-TH
                        </button>
                        <span class="font-mono text-mute">SAP: 103980</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Eastern Precision Casting Co., Ltd.</div>
                        <div class="text-mute">บริษัท อีสเทิร์น พรีซิชั่น แคสติ้ง จำกัด</div>
                        <div class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-secondary">
                            <span class="material-symbols-outlined text-[14px]">donut_large</span>
                            <span>Traction Sheave Castings &amp; Counterweight Blocks</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1">
                            <span class="badge badge-xs badge-primary font-mono font-bold">TIER-1 DIRECT</span>
                            <span class="badge badge-xs badge-success font-mono font-bold">GRADE A CERTIFIED</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">WHA Eastern Seaboard 2</div>
                        <div class="text-mute">Chonburi High-Temp Foundry</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-semibold text-primary">Mr. Boonmee Inthira</div>
                        <div class="font-mono text-[11px] text-mute">boonmee@epc-casting.co.th</div>
                        <div class="font-mono text-[11px] text-mute">+66 38-955-112</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">S. Narongrit</div>
                        <div class="text-mute">Dept 4 (Foundry/Heavy)</div>
                    </td>
                    <td class="align-top py-3 text-right font-mono">
                        <div class="font-bold text-success">98.9% OTD</div>
                        <div class="text-mute">Defect: 0.04% PPM</div>
                    </td>
                    <td class="align-top py-3 text-center">
                        <span class="badge badge-xs badge-success font-bold uppercase">Active</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1 items-stretch">
                            <button type="button"
                                onclick="openVendorDetail('V-671044-TH', 'Eastern Precision Casting Co., Ltd.', 'TIER-1 DIRECT', 'GRADE A CERTIFIED', 'ACTIVE', 'WHA Eastern Seaboard 2 (Chonburi Foundry)', 'Mr. Boonmee Inthira', 'boonmee@epc-casting.co.th', '+66 38-955-112', '98.9%', '0.04%')"
                                class="btn btn-xs btn-primary font-bold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                View Profile
                            </button>
                            <a href="#"
                                class="btn btn-xs btn-outline border-base-300 font-semibold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">receipt_long</span>
                                Open POs (7)
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Vendor 7: Nippon Sanso Gas & Metal -->
                <tr class="vendor-row hover:bg-base-200/60 transition-colors" data-status="ACTIVE"
                    data-tier="TIER-1" data-commodity="SHEET_METAL" data-grade="GRADE_A">
                    <td class="text-center align-top py-3">
                        <input type="checkbox" class="row-select checkbox checkbox-xs checkbox-primary"
                            onchange="updateSelectedCount()" />
                    </td>
                    <td class="align-top py-3">
                        <button type="button"
                            onclick="openVendorDetail('V-399102-TH', 'Nippon Sanso Gas & Metal Co. (Thailand)', 'TIER-1 DIRECT', 'GRADE A CERTIFIED', 'ACTIVE', 'Amata City Chonburi (Phase 7 Laser Div.)', 'Mr. Kenji Sudo (工藤)', 'kudo.k@nipponsanso.co.th', '+66 38-214-700', '99.8%', '0.00%')"
                            class="link link-hover font-mono font-bold text-primary text-sm block text-left">
                            V-399102-TH
                        </button>
                        <span class="font-mono text-mute">SAP: 107412</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Nippon Sanso Gas &amp; Metal Co. (Thailand)</div>
                        <div class="text-mute">บริษัท นิปปอน ซันโซ แก๊ส แอนด์ เมทัล (ประเทศไทย) จำกัด</div>
                        <div class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-secondary">
                            <span class="material-symbols-outlined text-[14px]">view_column</span>
                            <span>Precision Laser Cutting &amp; Structural Tubular Profiles</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1">
                            <span class="badge badge-xs badge-primary font-mono font-bold">TIER-1 DIRECT</span>
                            <span class="badge badge-xs badge-success font-mono font-bold">GRADE A CERTIFIED</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Amata City Chonburi</div>
                        <div class="text-mute">Phase 7 (Laser Division)</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-semibold text-primary">Mr. Kenji Sudo (工藤)</div>
                        <div class="font-mono text-[11px] text-mute">kudo.k@nipponsanso.co.th</div>
                        <div class="font-mono text-[11px] text-mute">+66 38-214-700</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">P. Sukcharoen</div>
                        <div class="text-mute">Dept 2 (Machining)</div>
                    </td>
                    <td class="align-top py-3 text-right font-mono">
                        <div class="font-bold text-success">99.8% OTD</div>
                        <div class="text-mute">Defect: 0.00% PPM</div>
                    </td>
                    <td class="align-top py-3 text-center">
                        <span class="badge badge-xs badge-success font-bold uppercase">Active</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1 items-stretch">
                            <button type="button"
                                onclick="openVendorDetail('V-399102-TH', 'Nippon Sanso Gas & Metal Co. (Thailand)', 'TIER-1 DIRECT', 'GRADE A CERTIFIED', 'ACTIVE', 'Amata City Chonburi (Phase 7 Laser Div.)', 'Mr. Kenji Sudo (工藤)', 'kudo.k@nipponsanso.co.th', '+66 38-214-700', '99.8%', '0.00%')"
                                class="btn btn-xs btn-primary font-bold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                View Profile
                            </button>
                            <a href="#"
                                class="btn btn-xs btn-outline border-base-300 font-semibold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">receipt_long</span>
                                Open POs (26)
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Vendor 8: Rayong Stamping & Tooling -->
                <tr class="vendor-row hover:bg-base-200/60 transition-colors" data-status="RECERT_DUE"
                    data-tier="TIER-2" data-commodity="DOOR" data-grade="GRADE_B">
                    <td class="text-center align-top py-3">
                        <input type="checkbox" class="row-select checkbox checkbox-xs checkbox-primary"
                            onchange="updateSelectedCount()" />
                    </td>
                    <td class="align-top py-3">
                        <button type="button"
                            onclick="openVendorDetail('V-718290-TH', 'Rayong Stamping & Tooling Co., Ltd.', 'TIER-2 SUB', 'GRADE B QUALIFIED', 'RECERT_DUE', 'Map Ta Phut, Rayong (Zone C)', 'Ms. Piyaporn S.', 'piyaporn@rst-rayong.com', '+66 38-684-901', '97.4%', '0.12%')"
                            class="link link-hover font-mono font-bold text-primary text-sm block text-left">
                            V-718290-TH
                        </button>
                        <span class="font-mono text-mute">SAP: 101899</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Rayong Stamping &amp; Tooling Co., Ltd.</div>
                        <div class="text-mute">บริษัท ระยอง สแตมป์ปิ้ง แอนด์ ทูลลิ่ง จำกัด</div>
                        <div class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-secondary">
                            <span class="material-symbols-outlined text-[14px]">sensor_door</span>
                            <span>Door Header &amp; Landing Sill Guide Plates</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1">
                            <span class="badge badge-xs badge-ghost font-mono font-bold">TIER-2 SUB</span>
                            <span class="badge badge-xs bg-base-200 border-base-300 text-primary font-mono font-bold">GRADE B QUALIFIED</span>
                        </div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">Map Ta Phut, Rayong</div>
                        <div class="text-mute">Industrial Estate Zone C</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-semibold text-primary">Ms. Piyaporn S.</div>
                        <div class="font-mono text-[11px] text-mute">piyaporn@rst-rayong.com</div>
                        <div class="font-mono text-[11px] text-mute">+66 38-684-901</div>
                    </td>
                    <td class="align-top py-3">
                        <div class="font-bold text-primary">P. Sukcharoen</div>
                        <div class="text-mute">Dept 2 (Door Systems)</div>
                    </td>
                    <td class="align-top py-3 text-right font-mono">
                        <div class="font-bold text-primary">97.4% OTD</div>
                        <div class="text-mute">Defect: 0.12% PPM</div>
                    </td>
                    <td class="align-top py-3 text-center">
                        <span class="badge badge-xs badge-warning font-bold uppercase">Re-cert Due</span>
                    </td>
                    <td class="align-top py-3">
                        <div class="flex flex-col gap-1 items-stretch">
                            <button type="button"
                                onclick="openVendorDetail('V-718290-TH', 'Rayong Stamping & Tooling Co., Ltd.', 'TIER-2 SUB', 'GRADE B QUALIFIED', 'RECERT_DUE', 'Map Ta Phut, Rayong (Zone C)', 'Ms. Piyaporn S.', 'piyaporn@rst-rayong.com', '+66 38-684-901', '97.4%', '0.12%')"
                                class="btn btn-xs btn-primary font-bold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                View Profile
                            </button>
                            <a href="#"
                                class="btn btn-xs btn-outline border-base-300 font-semibold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">receipt_long</span>
                                Open POs (5)
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Table Footer Pagination Bar -->
    <div
        class="px-space-md py-3 bg-base-100 border-t border-base-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-mute">
        <div>Showing <strong class="text-primary">1 - 8</strong> of <strong class="text-primary">148</strong>
            Registered Vendors</div>
        <div class="join">
            <button type="button" class="join-item btn btn-xs btn-outline border-base-300">«</button>
            <button type="button" class="join-item btn btn-xs btn-primary">1</button>
            <button type="button" class="join-item btn btn-xs btn-outline border-base-300">2</button>
            <button type="button" class="join-item btn btn-xs btn-outline border-base-300">3</button>
            <button type="button" class="join-item btn btn-xs btn-outline border-base-300">»</button>
        </div>
    </div>
</div>
