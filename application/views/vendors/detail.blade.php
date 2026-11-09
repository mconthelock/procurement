@extends('layouts/template')
@section('contents')
    <main class="w-full pt-[72px] bg-surface min-h-[calc(100vh-72px)]">
        <div class="flex flex-col w-full">
            <!-- Top Breadcrumb & Status Link -->
            <div class="w-full bg-surface-subtle border-b border-border-light">
                <div class="max-w-[1380px] mx-auto px-gutter py-2 flex flex-wrap items-center justify-between gap-space-sm">
                    <nav class="flex items-center gap-space-xs font-meta-tag text-[12px] text-text-muted">
                        <a class="hover:text-secondary transition-colors" href="#">Home</a>
                        <span class="text-outline-variant">/</span>
                        <a class="hover:text-secondary transition-colors" href="#">Supplier Portal</a>
                        <span class="text-outline-variant">/</span>
                        <a class="hover:text-secondary transition-colors" href="list.html">Vendor Directory</a>
                        <span class="text-outline-variant">/</span>
                        <span class="text-primary font-bold">Siam Precision Engineering Co., Ltd. (V-884029-TH)</span>
                    </nav>
                    <div class="flex items-center gap-space-md font-meta-tag text-[11px] text-text-muted">
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-status-success-text"></span>
                            <span>Workflow Status: Approved (CST = 2)</span>
                        </span>
                        <span class="text-outline-variant">|</span>
                        <span class="font-data-mono">Form Ref: NFRMNO 14 (PUR-VMM) / EVANO-2025-0042</span>
                    </div>
                </div>
            </div>

            <!-- Hero Profile Header -->
            <div class="w-full bg-surface border-b border-border-light">
                <div class="max-w-[1380px] mx-auto px-gutter py-space-xl">
                    <div class="flex flex-col xl:flex-row xl:items-start justify-between gap-space-xl">
                        <!-- Identity Block (Data from PURSYS.VENDORS, PURVMM_FORM, PUREVA_FORM) -->
                        <div class="flex items-start gap-space-md max-w-4xl">
                            <div
                                class="w-16 h-16 bg-primary text-on-primary flex items-center justify-center font-h2 text-h2 font-bold tracking-tight flex-shrink-0 shadow-sm">
                                SP
                            </div>
                            <div class="flex flex-col gap-space-xs">
                                <div class="flex flex-wrap items-center gap-space-xs">
                                    <!-- VND_CODE -->
                                    <span
                                        class="bg-primary text-on-primary font-meta-tag text-[11px] px-2 py-0.5 uppercase tracking-wider">
                                        VENDOR CODE: V-884029-TH
                                    </span>
                                    <!-- VENDGROUPTYPE -->
                                    <span
                                        class="bg-surface-container-high text-on-surface font-meta-tag text-[11px] px-2 py-0.5 uppercase font-semibold">
                                        TIER-1 DIRECT (VENDGROUPTYPE: Direct)
                                    </span>
                                    <!-- JUDGEMENT / MJUDGEMENT -->
                                    <span
                                        class="bg-status-success-bg text-status-success-text font-meta-tag text-[11px] px-2 py-0.5 uppercase flex items-center gap-1 font-semibold border border-status-success-border">
                                        <span class="material-symbols-outlined text-[14px]">verified</span>
                                        EVALUATION GRADE A (JUDGEMENT: A)
                                    </span>
                                    <!-- TAXID / VND_TAXNO -->
                                    <span
                                        class="bg-surface-container text-text-muted font-data-mono text-[11px] px-2 py-0.5">
                                        TAX ID: 0105550000000
                                    </span>
                                </div>
                                <!-- VND_NAME / COMNAME -->
                                <h1 class="font-h2 text-h2 text-primary font-bold tracking-tight">
                                    Siam Precision Engineering Co., Ltd.
                                </h1>
                                <!-- VND_TNAME (from PURNVF_ADDRESS Thai / VND_TNAME) -->
                                <div
                                    class="font-body-md text-text-muted font-normal flex flex-wrap items-center gap-space-md">
                                    <span class="text-text-body font-medium">บริษัท สยาม พรีซิชั่น เอ็นจิเนียริ่ง
                                        จำกัด</span>
                                    <span class="text-outline-variant">•</span>
                                    <!-- Primary Address from PURNVF_ADDRESS (E) -->
                                    <span class="inline-flex items-center gap-1 font-body-sm text-[13px]">
                                        <span
                                            class="material-symbols-outlined text-[16px] text-secondary">location_on</span>
                                        Amata City Chonburi Industrial Estate, Don Hua Lo, Chonburi 20000, Thailand
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Matrix -->
                        <div class="flex flex-col sm:flex-row xl:flex-col items-end gap-space-sm flex-shrink-0">
                            <div class="flex flex-wrap items-center justify-end gap-space-sm w-full">
                                <button
                                    class="bg-surface hover:bg-surface-container-low text-text-body font-meta-tag text-[12px] uppercase px-4 py-2 border border-border-medium shadow-sm flex items-center gap-space-xs transition-colors"
                                    type="button">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">description</span>
                                    Evaluation Report (PRO-EVA)
                                </button>
                                <button
                                    class="bg-surface hover:bg-surface-container-low text-text-body font-meta-tag text-[12px] uppercase px-4 py-2 border border-border-medium shadow-sm flex items-center gap-space-xs transition-colors"
                                    type="button">
                                    <span
                                        class="material-symbols-outlined text-[16px] text-status-success-text">folder_zip</span>
                                    Certificates (.ZIP)
                                </button>
                            </div>
                            <div class="flex flex-wrap items-center justify-end gap-space-sm w-full">
                                <button
                                    class="bg-primary hover:bg-neutral-800 text-on-primary font-meta-tag text-[12px] uppercase px-5 py-2 flex items-center gap-space-xs transition-colors shadow-sm"
                                    type="button">
                                    <span class="material-symbols-outlined text-[16px]">edit_note</span>
                                    Request Master Update (PUR-VMM)
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Status Strip (Real fields from PURSYS.VENDORS, PUREVA_FORM, PURVMM_FORM) -->
                    <div
                        class="mt-space-lg pt-space-md bg-surface-container-low px-space-md py-space-sm flex flex-wrap items-center justify-between gap-space-md text-[13px] border border-border-light">
                        <div class="flex flex-wrap items-center gap-space-md">
                            <span
                                class="inline-flex items-center gap-1 font-meta-tag text-[11px] uppercase tracking-wider text-text-muted">
                                <span
                                    class="material-symbols-outlined text-[16px] text-status-success-text">check_circle</span>
                                Status:
                            </span>
                            <span
                                class="font-body-sm font-semibold text-status-success-text bg-status-success-bg border border-status-success-border px-2 py-0.5 uppercase">
                                ACTIVE (VND_STATUS)
                            </span>
                            <span class="text-outline-variant">|</span>
                            <span class="text-text-muted font-body-sm">Operation: <strong
                                    class="text-primary font-semibold">Annual Evaluation (A)</strong></span>
                            <span class="text-outline-variant">|</span>
                            <span class="text-text-muted font-body-sm">Currency: <strong
                                    class="text-primary font-data-mono">THB (฿)</strong></span>
                            <span class="text-outline-variant">|</span>
                            <span class="text-text-muted font-body-sm">Payment Term: <strong
                                    class="text-primary font-data-mono">TERMCODE: N60</strong></span>
                        </div>
                        <div class="flex items-center gap-space-sm font-data-mono text-[12px] text-text-muted">
                            <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                            Registered Date: <strong class="text-primary font-semibold">2018-04-10</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Operational Core Content -->
            <div class="w-full max-w-[1380px] mx-auto px-gutter py-space-xl">
                <!-- Row 1: KPI & Assessment Scorecard (Mapped directly to PUREVA_FORM, PUREVA_SCORE, CAPITAL, PUR_LEVEL) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md mb-space-2xl">
                    <!-- KPI 1: Overall Evaluation Score (PUREVA_FORM.JUDGEMENT & PUREVA_SCORE Total) -->
                    <div class="bg-surface border border-border-light p-space-md shadow-sm flex flex-col justify-between">
                        <div class="flex items-start justify-between mb-space-sm">
                            <span class="font-meta-tag text-[11px] uppercase tracking-wider text-text-muted">PRO-EVA
                                Judgement</span>
                            <span class="material-symbols-outlined text-[18px] text-status-success-text">verified</span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-h1 text-h1 font-bold text-primary tracking-tight">Grade A</span>
                            </div>
                            <p
                                class="font-body-sm text-[12px] text-status-success-text mt-1 font-semibold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">check</span>
                                Score: 88 / 100 (Threshold >= 80)
                            </p>
                        </div>
                        <div class="w-full bg-surface-container-high h-1.5 mt-space-md">
                            <div class="bg-status-success-text h-1.5" style="width: 88%;"></div>
                        </div>
                    </div>

                    <!-- KPI 2: Purchasing Level & Volume (PUREVA_FORM.PUR_LEVEL) -->
                    <div class="bg-surface border border-border-light p-space-md shadow-sm flex flex-col justify-between">
                        <div class="flex items-start justify-between mb-space-sm">
                            <span class="font-meta-tag text-[11px] uppercase tracking-wider text-text-muted">Purchase Volume
                                Level</span>
                            <span class="material-symbols-outlined text-[18px] text-secondary">trending_up</span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-h1 text-h1 font-bold text-primary tracking-tight">Level A</span>
                            </div>
                            <p class="font-body-sm text-[12px] text-text-body mt-1 font-semibold">
                                Volume: &gt;= ฿1,000,000 / Month
                            </p>
                        </div>
                        <div class="w-full bg-surface-container-high h-1.5 mt-space-md">
                            <div class="bg-secondary h-1.5" style="width: 95%;"></div>
                        </div>
                    </div>

                    <!-- KPI 3: Registered Capital (PUREVA_FORM.CAPITAL) -->
                    <div class="bg-surface border border-border-light p-space-md shadow-sm flex flex-col justify-between">
                        <div class="flex items-start justify-between mb-space-sm">
                            <span class="font-meta-tag text-[11px] uppercase tracking-wider text-text-muted">Registered
                                Capital</span>
                            <span class="material-symbols-outlined text-[18px] text-primary">account_balance</span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-h1 text-h1 font-bold text-primary tracking-tight">฿180M</span>
                                <span class="font-meta-tag text-[12px] text-text-muted uppercase">THB</span>
                            </div>
                            <p class="font-data-mono text-[12px] text-text-body mt-1 font-semibold">
                                Fully Paid-Up (Cap. Cur: THB)
                            </p>
                        </div>
                        <div class="w-full bg-surface-container-high h-1.5 mt-space-md">
                            <div class="bg-primary h-1.5" style="width: 100%;"></div>
                        </div>
                    </div>

                    <!-- KPI 4: Compliance Matrix (PUREVA_FORM.QM_STATUS, ENV_STATUS, CSR_STATUS) -->
                    <div class="bg-surface border border-border-light p-space-md shadow-sm flex flex-col justify-between">
                        <div class="flex items-start justify-between mb-space-sm">
                            <span class="font-meta-tag text-[11px] uppercase tracking-wider text-text-muted">Audit &
                                Compliance</span>
                            <span class="material-symbols-outlined text-[18px] text-status-success-text">policy</span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-h1 text-h1 font-bold text-status-success-text tracking-tight">100%</span>
                                <span class="font-meta-tag text-[12px] text-text-muted uppercase">Pass</span>
                            </div>
                            <p
                                class="font-body-sm text-[12px] text-status-success-text mt-1 font-semibold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                QM: PASS | ENV: PASS | CSR: PASS
                            </p>
                        </div>
                        <div class="w-full bg-surface-container-high h-1.5 mt-space-md">
                            <div class="bg-status-success-text h-1.5" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Tabs -->
                <div class="w-full bg-surface border border-border-light mb-space-xl">
                    <div class="flex items-center overflow-x-auto gap-space-md px-space-md h-12">
                        <button
                            class="h-full inline-flex items-center font-meta-tag text-[13px] uppercase tracking-wider text-secondary font-bold shadow-[inset_0_-3px_0_#005cba]">
                            01. Legal Entity & Facility Profile
                        </button>
                        <button
                            class="h-full inline-flex items-center font-meta-tag text-[13px] uppercase tracking-wider text-text-muted hover:text-primary transition-colors">
                            02. Evaluation Scores (PUR-EVA)
                        </button>
                        <button
                            class="h-full inline-flex items-center font-meta-tag text-[13px] uppercase tracking-wider text-text-muted hover:text-primary transition-colors">
                            03. Financials & Stakeholder Relations
                        </button>
                        <button
                            class="h-full inline-flex items-center font-meta-tag text-[13px] uppercase tracking-wider text-text-muted hover:text-primary transition-colors">
                            04. Bank & Commercial Terms
                        </button>
                        <button
                            class="h-full inline-flex items-center font-meta-tag text-[13px] uppercase tracking-wider text-text-muted hover:text-primary transition-colors">
                            05. SCM Users & Attachments
                        </button>
                    </div>
                </div>

                <!-- Dual Column Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl">
                    <!-- Left Column (8 cols) -->
                    <div class="lg:col-span-8 flex flex-col gap-space-xl">
                        <!-- SECTION 1: Legal Entity & Corporate Profile (PUREVA_FORM, PURVMM_FORM) -->
                        <section class="bg-surface border border-border-light p-space-xl shadow-sm">
                            <div
                                class="flex items-center justify-between pb-space-sm mb-space-lg bg-surface-subtle p-3 border-b border-border-light">
                                <div class="flex items-center gap-space-sm">
                                    <span class="w-2.5 h-2.5 bg-primary"></span>
                                    <h2 class="font-h3 text-[18px] text-primary font-bold">Section 1: Legal Entity &
                                        Corporate Structure</h2>
                                </div>
                                <span class="font-data-mono text-[11px] text-text-muted uppercase">PURVMM Ref:
                                    EVANO-2025-0042</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
                                <div class="space-y-space-md">
                                    <div>
                                        <div class="font-meta-tag text-[11px] uppercase text-text-muted tracking-wider">
                                            Registered Corporate Title (EN) [COMNAME]</div>
                                        <div class="font-body-md text-primary font-semibold mt-0.5">Siam Precision
                                            Engineering Co., Ltd.</div>
                                    </div>
                                    <div>
                                        <div class="font-meta-tag text-[11px] uppercase text-text-muted tracking-wider">
                                            Registered Corporate Title (TH) [VND_TNAME]</div>
                                        <div class="font-body-md text-text-body font-medium mt-0.5">บริษัท สยาม พรีซิชั่น
                                            เอ็นจิเนียริ่ง จำกัด</div>
                                    </div>
                                    <div>
                                        <div class="font-meta-tag text-[11px] uppercase text-text-muted tracking-wider">
                                            Commercial Registration & Tax ID [TAX_ID / CORPORATE_ID]</div>
                                        <div class="font-data-mono text-primary font-semibold mt-0.5">0105550000000 (DBD
                                            Registration)</div>
                                    </div>
                                    <div>
                                        <div class="font-meta-tag text-[11px] uppercase text-text-muted tracking-wider">
                                            Legal Entity Type [COM_TYPE / LEGAL_STATUS]</div>
                                        <div class="font-body-md text-text-body font-medium mt-0.5">Company Limited (Co.,
                                            Ltd.) / Active</div>
                                    </div>
                                    <div>
                                        <div class="font-meta-tag text-[11px] uppercase text-text-muted tracking-wider">
                                            Business Type Category [BUSTYPE_REG / BUSTYPE_SUB]</div>
                                        <div class="font-body-sm text-text-body font-medium mt-0.5">Manufacturer &
                                            Fabricator / Elevator Structural Parts</div>
                                    </div>
                                </div>
                                <div class="space-y-space-md">
                                    <div>
                                        <div class="font-meta-tag text-[11px] uppercase text-text-muted tracking-wider">
                                            Registered Capital [CAPITAL & CAPITAL_CUR]</div>
                                        <div class="font-data-mono text-primary font-semibold mt-0.5">฿180,000,000 THB
                                            (Fully Paid-Up)</div>
                                    </div>
                                    <div>
                                        <div class="font-meta-tag text-[11px] uppercase text-text-muted tracking-wider">
                                            Year Established [ESTABLISHED]</div>
                                        <div class="font-body-md text-primary font-semibold mt-0.5">1998 (Operating 28
                                            Years)</div>
                                    </div>
                                    <div>
                                        <div class="font-meta-tag text-[11px] uppercase text-text-muted tracking-wider">
                                            Workforce Headcount [EMPDIRECT / EMPINDIRECT / AVGAGE]</div>
                                        <div class="font-body-md text-primary font-semibold mt-0.5">
                                            450 Staff (Direct: 380, Indirect: 70) • Avg. Age: 34 Yrs
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-meta-tag text-[11px] uppercase text-text-muted tracking-wider">
                                            Factory & Land Footprint [FACTORY / LAND]</div>
                                        <div class="font-body-sm text-text-body font-medium mt-0.5">
                                            Land: 25.0 Rai • Factory Floor Area: 18,500.0 Sq.m.
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-meta-tag text-[11px] uppercase text-text-muted tracking-wider">
                                            Purchase Category [PRODCAT / VENDCAT]</div>
                                        <div class="font-body-sm text-secondary font-semibold mt-0.5">
                                            Sheet Metal, Hoistway Structure & Stamping
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Registered Addresses (PURNVF_ADDRESS: English & Thai) -->
                            <div
                                class="mt-space-lg pt-space-md border-t border-border-light grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                <div class="p-space-md bg-surface-subtle border border-border-light">
                                    <div
                                        class="flex items-center gap-1 font-meta-tag text-[11px] uppercase text-primary font-bold">
                                        <span
                                            class="material-symbols-outlined text-[16px] text-secondary">location_on</span>
                                        Registered Address (English) [ADDRTYPE: E]
                                    </div>
                                    <p class="font-body-sm text-[13px] text-text-body mt-1 leading-relaxed">
                                        700/412 Moo 7, Phase 4, Amata City Chonburi Industrial Estate, Don Hua Lo, Mueang
                                        Chonburi, Chonburi 20000, Thailand
                                    </p>
                                </div>
                                <div class="p-space-md bg-surface-subtle border border-border-light">
                                    <div
                                        class="flex items-center gap-1 font-meta-tag text-[11px] uppercase text-primary font-bold">
                                        <span
                                            class="material-symbols-outlined text-[16px] text-secondary">location_on</span>
                                        ที่อยู่จดทะเบียน (ภาษาไทย) [ADDRTYPE: T]
                                    </div>
                                    <p class="font-body-sm text-[13px] text-text-body mt-1 leading-relaxed">
                                        700/412 หมู่ที่ 7 นิคมอุตสาหกรรมอมตะซิตี้ ชลบุรี เฟส 4 ตำบลดอนหัวฬ่อ
                                        อำเภอเมืองชลบุรี จังหวัดชลบุรี 20000
                                    </p>
                                </div>
                            </div>
                        </section>

                        <!-- SECTION 2: Evaluation Scores Breakdown (PUREVA_SCORE) -->
                        <section class="bg-surface border border-border-light p-space-xl shadow-sm">
                            <div
                                class="flex items-center justify-between pb-space-sm mb-space-lg bg-surface-subtle p-3 border-b border-border-light">
                                <div class="flex items-center gap-space-sm">
                                    <span class="w-2.5 h-2.5 bg-primary"></span>
                                    <h2 class="font-h3 text-[18px] text-primary font-bold">Section 2: Evaluation Score
                                        Breakdown by Topic</h2>
                                </div>
                                <span
                                    class="bg-status-success-bg text-status-success-text border border-status-success-border font-meta-tag text-[11px] px-2 py-0.5 font-bold">
                                    TOTAL SCORE: 88 / 100 (GRADE A)
                                </span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr
                                            class="bg-surface-container text-primary font-meta-tag text-[11px] uppercase tracking-wider border-b border-border-dark">
                                            <th class="py-2.5 px-3">Evaluation Topic [TOPIC]</th>
                                            <th class="py-2.5 px-3">Description [TOPIC_DESC]</th>
                                            <th class="py-2.5 px-3 text-right">Max</th>
                                            <th class="py-2.5 px-3 text-right">Score [SCORE]</th>
                                            <th class="py-2.5 px-3 text-center">Level [SLEVEL]</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-border-light font-body-sm text-[13px]">
                                        <tr>
                                            <td class="py-3 px-3 font-semibold text-primary">Quality Management System</td>
                                            <td class="py-3 px-3 text-text-muted">Process capability, zero-defect control &
                                                QA system</td>
                                            <td class="py-3 px-3 text-right font-data-mono">30</td>
                                            <td
                                                class="py-3 px-3 text-right font-data-mono font-bold text-status-success-text">
                                                28</td>
                                            <td class="py-3 px-3 text-center"><span
                                                    class="bg-status-success-bg text-status-success-text font-bold text-[11px] px-2 py-0.5">S</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-3 px-3 font-semibold text-primary">Delivery & Order Service</td>
                                            <td class="py-3 px-3 text-text-muted">On-time delivery performance, ASN
                                                accuracy & schedule compliance</td>
                                            <td class="py-3 px-3 text-right font-data-mono">25</td>
                                            <td
                                                class="py-3 px-3 text-right font-data-mono font-bold text-status-success-text">
                                                25</td>
                                            <td class="py-3 px-3 text-center"><span
                                                    class="bg-status-success-bg text-status-success-text font-bold text-[11px] px-2 py-0.5">S</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-3 px-3 font-semibold text-primary">Price & Cost Down
                                                Competitiveness</td>
                                            <td class="py-3 px-3 text-text-muted">Cost reduction initiatives, transparent
                                                breakdown & quotation response</td>
                                            <td class="py-3 px-3 text-right font-data-mono">20</td>
                                            <td class="py-3 px-3 text-right font-data-mono font-bold text-primary">18</td>
                                            <td class="py-3 px-3 text-center"><span
                                                    class="bg-surface-container-high text-primary font-bold text-[11px] px-2 py-0.5">A</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-3 px-3 font-semibold text-primary">Environmental & Green
                                                Standards</td>
                                            <td class="py-3 px-3 text-text-muted">ISO 14001, hazardous substance
                                                elimination & RoHS conformity</td>
                                            <td class="py-3 px-3 text-right font-data-mono">15</td>
                                            <td class="py-3 px-3 text-right font-data-mono font-bold text-primary">10</td>
                                            <td class="py-3 px-3 text-center"><span
                                                    class="bg-surface-container-high text-primary font-bold text-[11px] px-2 py-0.5">A</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-3 px-3 font-semibold text-primary">CSR, Safety & Labor Compliance
                                            </td>
                                            <td class="py-3 px-3 text-text-muted">Labor standards, workplace safety
                                                protocols & legal compliance</td>
                                            <td class="py-3 px-3 text-right font-data-mono">10</td>
                                            <td class="py-3 px-3 text-right font-data-mono font-bold text-primary">7</td>
                                            <td class="py-3 px-3 text-center"><span
                                                    class="bg-surface-container-high text-primary font-bold text-[11px] px-2 py-0.5">B</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-surface-subtle font-bold border-t-2 border-border-dark">
                                            <td class="py-2.5 px-3 uppercase font-meta-tag text-primary" colspan="2">
                                                Purchasing Manager Final Judgement [MJUDGEMENT]</td>
                                            <td class="py-2.5 px-3 text-right font-data-mono">100</td>
                                            <td
                                                class="py-2.5 px-3 text-right font-data-mono text-status-success-text text-[15px]">
                                                88</td>
                                            <td class="py-2.5 px-3 text-center text-status-success-text font-bold">GRADE A
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </section>

                        <!-- SECTION 3: 3-Year Turnover & Relations (PUREVA_PROFIT_TURNOVER & PUREVA_VENDOR_RELATION) -->
                        <section class="bg-surface border border-border-light p-space-xl shadow-sm">
                            <div
                                class="flex items-center justify-between pb-space-sm mb-space-lg bg-surface-subtle p-3 border-b border-border-light">
                                <div class="flex items-center gap-space-sm">
                                    <span class="w-2.5 h-2.5 bg-primary"></span>
                                    <h2 class="font-h3 text-[18px] text-primary font-bold">Section 3: Financial History &
                                        Stakeholder Relations</h2>
                                </div>
                                <span class="font-meta-tag text-[11px] uppercase text-text-muted">PUREVA Sub-Tables</span>
                            </div>

                            <!-- Financial Turnover Table (PUREVA_PROFIT_TURNOVER) -->
                            <div class="mb-space-lg">
                                <div class="font-meta-tag text-[11px] uppercase text-primary font-bold mb-2">
                                    Past 3-Year Annual Turnover & Net Profit [PUREVA_PROFIT_TURNOVER]
                                </div>
                                <table class="w-full text-left border-collapse text-[13px]">
                                    <thead>
                                        <tr
                                            class="bg-surface-container-low text-text-body font-meta-tag text-[11px] uppercase tracking-wider border-b border-border-light">
                                            <th class="py-2 px-3">Fiscal Year [MYEAR]</th>
                                            <th class="py-2 px-3 text-right">Annual Turnover [RECORD_TYPE: T]</th>
                                            <th class="py-2 px-3 text-right">Net Profit / Loss [RECORD_TYPE: P]</th>
                                            <th class="py-2 px-3 text-right">Profit Margin</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-border-light font-data-mono">
                                        <tr>
                                            <td class="py-2.5 px-3 font-bold text-primary">2024</td>
                                            <td class="py-2.5 px-3 text-right font-semibold text-primary">฿450,000,000</td>
                                            <td class="py-2.5 px-3 text-right text-status-success-text font-semibold">
                                                +฿38,500,000</td>
                                            <td class="py-2.5 px-3 text-right text-text-muted">8.55%</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2.5 px-3 font-bold text-primary">2023</td>
                                            <td class="py-2.5 px-3 text-right font-semibold text-primary">฿415,000,000</td>
                                            <td class="py-2.5 px-3 text-right text-status-success-text font-semibold">
                                                +฿32,100,000</td>
                                            <td class="py-2.5 px-3 text-right text-text-muted">7.73%</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2.5 px-3 font-bold text-primary">2022</td>
                                            <td class="py-2.5 px-3 text-right font-semibold text-primary">฿380,000,000</td>
                                            <td class="py-2.5 px-3 text-right text-status-success-text font-semibold">
                                                +฿29,400,000</td>
                                            <td class="py-2.5 px-3 text-right text-text-muted">7.73%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Stakeholders & Supplied Products (PUREVA_VENDOR_RELATION) -->
                            <div
                                class="pt-space-md border-t border-border-light grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                <div class="p-space-md bg-surface-subtle border border-border-light">
                                    <div class="font-meta-tag text-[11px] uppercase text-primary font-bold mb-2">
                                        Major Customers & Share [ENTITY_TYPE: C]
                                    </div>
                                    <ul class="space-y-1.5 font-body-sm text-[12px]">
                                        <li class="flex justify-between items-center py-1 border-b border-border-light">
                                            <span class="font-medium text-primary">Mitsubishi Elevator Asia (AMEC)</span>
                                            <span class="font-data-mono font-bold text-secondary">65%</span>
                                        </li>
                                        <li class="flex justify-between items-center py-1 border-b border-border-light">
                                            <span class="font-medium text-primary">Daikin Industries Thailand</span>
                                            <span class="font-data-mono font-bold text-text-body">20%</span>
                                        </li>
                                        <li class="flex justify-between items-center py-1">
                                            <span class="font-medium text-primary">Other Precision Fabrications</span>
                                            <span class="font-data-mono font-bold text-text-body">15%</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="p-space-md bg-surface-subtle border border-border-light">
                                    <div class="font-meta-tag text-[11px] uppercase text-primary font-bold mb-2">
                                        Key Products Supplied [ENTITY_TYPE: P]
                                    </div>
                                    <div class="flex flex-wrap gap-1.5 pt-1">
                                        <span
                                            class="bg-surface text-text-body font-body-sm text-[11px] px-2 py-1 border border-border-light font-medium">Elevator
                                            Hoistway Beams</span>
                                        <span
                                            class="bg-surface text-text-body font-body-sm text-[11px] px-2 py-1 border border-border-light font-medium">Guide
                                            Rail Brackets</span>
                                        <span
                                            class="bg-surface text-text-body font-body-sm text-[11px] px-2 py-1 border border-border-light font-medium">Counterweight
                                            Frames</span>
                                        <span
                                            class="bg-surface text-text-body font-body-sm text-[11px] px-2 py-1 border border-border-light font-medium">800T
                                            Stamping Press Plates</span>
                                        <span
                                            class="bg-surface text-text-body font-body-sm text-[11px] px-2 py-1 border border-border-light font-medium">Laser
                                            Profiling Sheets</span>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Right Column: Governance, Bank, SCM Users, Certs (4 cols) -->
                    <div class="lg:col-span-4 flex flex-col gap-space-xl">
                        <!-- SECTION 4: Quality & Compliance Status (PUREVA_FORM QM/ENV/CSR/LABOR) -->
                        <section class="bg-surface border border-border-light p-space-lg shadow-sm">
                            <div
                                class="flex items-center justify-between pb-space-xs mb-space-md bg-surface-subtle p-2.5 border-b border-border-light">
                                <h3 class="font-meta-tag text-[12px] uppercase text-primary font-bold">Section 4:
                                    Compliance Matrix</h3>
                                <span
                                    class="material-symbols-outlined text-[16px] text-status-success-text">verified_user</span>
                            </div>
                            <div class="space-y-space-sm font-body-sm text-[12px]">
                                <!-- QM_STATUS (ISO 9001) -->
                                <div class="p-space-sm bg-surface-subtle border border-border-light">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-primary">ISO 9001 (Quality) [QM_STATUS]</span>
                                        <span
                                            class="bg-status-success-bg text-status-success-text border border-status-success-border font-meta-tag text-[10px] px-1.5 py-0.5">PASS</span>
                                    </div>
                                    <div class="font-caption text-text-muted mt-1">[QM_REASON] Certified by TUV Rheinland
                                        (Valid)</div>
                                </div>
                                <!-- ENV_STATUS (ISO 14001) -->
                                <div class="p-space-sm bg-surface-subtle border border-border-light">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-primary">ISO 14001 (Env.) [ENV_STATUS]</span>
                                        <span
                                            class="bg-status-success-bg text-status-success-text border border-status-success-border font-meta-tag text-[10px] px-1.5 py-0.5">PASS</span>
                                    </div>
                                    <div class="font-caption text-text-muted mt-1">[ENV_REASON] Certified by SGS Thailand
                                        (Valid)</div>
                                </div>
                                <!-- CSR_STATUS -->
                                <div class="p-space-sm bg-surface-subtle border border-border-light">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-primary">CSR Standard [CSR_STATUS]</span>
                                        <span
                                            class="bg-status-success-bg text-status-success-text border border-status-success-border font-meta-tag text-[10px] px-1.5 py-0.5">PASS</span>
                                    </div>
                                    <div class="font-caption text-text-muted mt-1">[CSR_REASON] Compliant with AMEC Supply
                                        Chain Charter</div>
                                </div>
                                <!-- LABOR_STATUS -->
                                <div class="p-space-sm bg-surface-subtle border border-border-light">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-primary">Labor Standard [LABOR_STATUS]</span>
                                        <span
                                            class="bg-status-success-bg text-status-success-text border border-status-success-border font-meta-tag text-[10px] px-1.5 py-0.5">PASS</span>
                                    </div>
                                    <div class="font-data-mono text-[11px] text-text-muted mt-1">Labor Est. Date:
                                        1998-05-12</div>
                                </div>
                                <!-- COMPLIANCE -->
                                <div class="p-space-sm bg-surface-container-low border border-border-light">
                                    <div class="font-meta-tag text-[10px] uppercase text-text-muted">Statutory Compliance
                                        [COMPLIANCE]</div>
                                    <div class="font-semibold text-primary mt-0.5">RoHS 2.0 / REACH / Conflict-Free
                                        Minerals</div>
                                </div>
                            </div>
                        </section>

                        <!-- SECTION 5: Commercial Terms & Bank Info (PURVMM_FORM, PURSYS.VENDORS) -->
                        <section class="bg-surface border border-border-light p-space-lg shadow-sm">
                            <div
                                class="flex items-center justify-between pb-space-xs mb-space-md bg-surface-subtle p-2.5 border-b border-border-light">
                                <h3 class="font-meta-tag text-[12px] uppercase text-primary font-bold">Section 5: Bank &
                                    Commercial Terms</h3>
                                <span class="material-symbols-outlined text-[16px] text-primary">payments</span>
                            </div>
                            <div class="space-y-space-sm font-body-sm text-[12px]">
                                <div class="flex justify-between py-1 border-b border-border-light">
                                    <span class="text-text-muted">Payment Term [TERMCODE]:</span>
                                    <span class="font-data-mono font-bold text-primary">N60 (Credit 60 Days)</span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-border-light">
                                    <span class="text-text-muted">Settlement Currency [CURCODE]:</span>
                                    <span class="font-data-mono font-bold text-primary">THB (Thai Baht)</span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-border-light">
                                    <span class="text-text-muted">Trade Incoterm [TRADE_CODE]:</span>
                                    <span class="font-data-mono font-bold text-primary">DAP AMEC Chonburi</span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-border-light">
                                    <span class="text-text-muted">Payment Method [VPAYTY]:</span>
                                    <span class="font-semibold text-primary">Direct Bank Transfer</span>
                                </div>
                                <div class="p-space-sm bg-surface-subtle border border-border-light mt-space-sm">
                                    <div class="font-meta-tag text-[10px] uppercase text-text-muted">Bank Information
                                        [BANKNAME & BRANCH]</div>
                                    <div class="font-bold text-primary mt-0.5">Bangkok Bank (BBL)</div>
                                    <div class="text-caption text-text-muted">Branch: Amata City Chonburi</div>
                                    <div class="font-data-mono text-[11px] font-bold text-secondary mt-1">A/C:
                                        128-4-99820-1 [ACCNUMBER]</div>
                                </div>
                            </div>
                        </section>

                        <!-- SECTION 6: Liaison Contacts & SCM Users (PURVMM_FORM, PURVMM_SCMUSR) -->
                        <section class="bg-surface border border-border-light p-space-lg shadow-sm">
                            <div
                                class="flex items-center justify-between pb-space-xs mb-space-md bg-surface-subtle p-2.5 border-b border-border-light">
                                <h3 class="font-meta-tag text-[12px] uppercase text-primary font-bold">Section 6: Contacts
                                    & SCM Accounts</h3>
                                <span class="material-symbols-outlined text-[16px] text-primary">badge</span>
                            </div>

                            <!-- Main Liaison Contact from PURVMM_FORM -->
                            <div
                                class="p-space-sm bg-surface-subtle border border-border-light mb-space-sm font-body-sm text-[12px]">
                                <div class="font-meta-tag text-[10px] uppercase text-secondary font-bold">Primary Liaison
                                    [CONTACT]</div>
                                <div class="font-bold text-primary mt-0.5">Mr. Kittisak Promdee</div>
                                <div class="font-caption text-text-muted">Senior Sales & QA Manager</div>
                                <div class="mt-2 space-y-1 font-data-mono text-[11px]">
                                    <div class="flex items-center gap-1 text-text-body">
                                        <span class="material-symbols-outlined text-[13px] text-text-muted">mail</span>
                                        <span>kitti@siamprecision.co.th [EMAIL]</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-text-body">
                                        <span class="material-symbols-outlined text-[13px] text-text-muted">call</span>
                                        <span>+66 38-450-891 [TELNO]</span>
                                    </div>
                                </div>
                            </div>

                            <!-- SCM Portal Connected Users from PURVMM_SCMUSR -->
                            <div>
                                <div class="font-meta-tag text-[11px] uppercase text-primary font-bold mb-2">
                                    Authorized SCM Portal Users [PURVMM_SCMUSR]
                                </div>
                                <div class="space-y-1.5 font-body-sm text-[11px]">
                                    <div
                                        class="p-2 bg-surface-subtle border border-border-light flex justify-between items-center">
                                        <div>
                                            <div class="font-semibold text-primary">Kittisak Promdee</div>
                                            <div class="font-data-mono text-text-muted text-[10px]">User: kitti_sp</div>
                                        </div>
                                        <span
                                            class="bg-status-success-bg text-status-success-text text-[10px] font-bold px-1.5 py-0.5">ACTIVE</span>
                                    </div>
                                    <div
                                        class="p-2 bg-surface-subtle border border-border-light flex justify-between items-center">
                                        <div>
                                            <div class="font-semibold text-primary">Supaporn Meesuk</div>
                                            <div class="font-data-mono text-text-muted text-[10px]">User: supaporn_sp</div>
                                        </div>
                                        <span
                                            class="bg-status-success-bg text-status-success-text text-[10px] font-bold px-1.5 py-0.5">ACTIVE</span>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- SECTION 7: File Attachments (WEBFORM.PUR_FILE) -->
                        <section class="bg-surface border border-border-light p-space-lg shadow-sm">
                            <div
                                class="flex items-center justify-between pb-space-xs mb-space-md bg-surface-subtle p-2.5 border-b border-border-light">
                                <h3 class="font-meta-tag text-[12px] uppercase text-primary font-bold">Section 7: Certified
                                    Attachments</h3>
                                <span class="material-symbols-outlined text-[16px] text-primary">attachment</span>
                            </div>
                            <div class="space-y-space-xs font-body-sm text-[12px]">
                                <!-- File 1: ISO 9001 (FILE_TYPE = 11) -->
                                <div
                                    class="flex items-center justify-between p-2 border border-border-light hover:bg-surface-subtle transition-colors">
                                    <div class="flex items-center gap-2 overflow-hidden">
                                        <span
                                            class="material-symbols-outlined text-[18px] text-status-reject-text flex-shrink-0">description</span>
                                        <div class="truncate">
                                            <div class="font-semibold text-primary truncate">ISO_9001_Certificate_TUV.pdf
                                            </div>
                                            <div class="font-caption text-[10px] text-text-muted">Type: 11 (Certificate) •
                                                2024-05-10</div>
                                        </div>
                                    </div>
                                    <button class="text-secondary hover:text-accent-blue-hover p-1 flex-shrink-0"
                                        title="Download">
                                        <span class="material-symbols-outlined text-[18px]">download</span>
                                    </button>
                                </div>
                                <!-- File 2: ISO 14001 (FILE_TYPE = 11) -->
                                <div
                                    class="flex items-center justify-between p-2 border border-border-light hover:bg-surface-subtle transition-colors">
                                    <div class="flex items-center gap-2 overflow-hidden">
                                        <span
                                            class="material-symbols-outlined text-[18px] text-status-reject-text flex-shrink-0">description</span>
                                        <div class="truncate">
                                            <div class="font-semibold text-primary truncate">ISO_14001_Certificate_SGS.pdf
                                            </div>
                                            <div class="font-caption text-[10px] text-text-muted">Type: 11 (Certificate) •
                                                2024-06-15</div>
                                        </div>
                                    </div>
                                    <button class="text-secondary hover:text-accent-blue-hover p-1 flex-shrink-0"
                                        title="Download">
                                        <span class="material-symbols-outlined text-[18px]">download</span>
                                    </button>
                                </div>
                                <!-- File 3: Company Registration Por.Por.20 (FILE_TYPE = 11) -->
                                <div
                                    class="flex items-center justify-between p-2 border border-border-light hover:bg-surface-subtle transition-colors">
                                    <div class="flex items-center gap-2 overflow-hidden">
                                        <span
                                            class="material-symbols-outlined text-[18px] text-status-reject-text flex-shrink-0">description</span>
                                        <div class="truncate">
                                            <div class="font-semibold text-primary truncate">DBD_Certificate_PP20.pdf</div>
                                            <div class="font-caption text-[10px] text-text-muted">Type: 11 (VAT/Reg) •
                                                2024-01-12</div>
                                        </div>
                                    </div>
                                    <button class="text-secondary hover:text-accent-blue-hover p-1 flex-shrink-0"
                                        title="Download">
                                        <span class="material-symbols-outlined text-[18px]">download</span>
                                    </button>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Bottom Verification Bar -->
                <div
                    class="mt-space-2xl bg-surface border border-border-light p-space-md shadow-sm flex flex-col md:flex-row items-center justify-between gap-space-md">
                    <div class="flex items-center gap-space-sm text-text-body font-body-sm text-[13px]">
                        <span class="material-symbols-outlined text-[20px] text-status-success-text">verified</span>
                        <span>
                            Master Registry Record verified under AMEC Procurement Governance. Last Sync:
                            <strong>2026-03-15</strong>.
                        </span>
                    </div>
                    <div class="flex items-center gap-space-md font-meta-tag text-[12px]">
                        <span class="text-text-muted uppercase">Evaluation Cycle:</span>
                        <span class="bg-surface-container px-2.5 py-1 text-primary font-bold">Annual (PRO-EVA
                            FY2025)</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
