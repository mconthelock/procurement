@extends('layouts/template')

@section('contents')
    <main class="relative pt-[72px] bg-background min-h-screen">
        <div class="max-w-[1280px] mx-auto px-gutter py-space-xl">
            <div class="flex flex-col w-full text-text-body font-body-md">
                <!-- Breadcrumb and System Status Bar -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between pb-space-md gap-space-sm">
                    <div class="flex items-center flex-wrap text-caption font-caption text-text-muted gap-space-xs">
                        <a class="hover:text-primary transition-colors" data-path="portal-overview" href="#">Home</a>
                        <span class="text-outline">/</span>
                        <a class="hover:text-primary transition-colors" data-path="purchase-orders"
                            href="#">Procurement &amp; Requisitions</a>
                        <span class="text-outline">/</span>
                        <a class="hover:text-primary transition-colors" data-path="thai-claim-slips" href="#">Purchase
                            Requisition (PR)</a>
                        <span class="text-outline">/</span>
                        <span class="text-primary font-bold">Create New Requisition
                            (สร้างใบขอซื้อใหม่)</span>
                    </div>
                    <!-- Live Gateway Pill Stream -->
                    <div class="flex items-center flex-wrap gap-space-sm text-caption font-caption">
                        <div class="flex items-center gap-1.5 px-2.5 py-1 bg-surface-container-high text-on-surface">
                            <span class="inline-block w-2 h-2 rounded-full bg-status-success-text"></span>
                            <span class="font-data-mono text-[11px] font-semibold tracking-wider">SAP S/4HANA PR Gateway:
                                LIVE &amp;
                                SYNCED</span>
                        </div>
                        <div class="flex items-center gap-1 px-2.5 py-1 bg-surface-container text-text-muted">
                            <span class="material-symbols-outlined text-[14px]">history</span>
                            <span class="text-[11px]">Draft Auto-saved: Just now</span>
                        </div>
                        <div
                            class="flex items-center gap-1 px-2.5 py-1 bg-status-pending-bg text-status-pending-text font-bold">
                            <span class="material-symbols-outlined text-[14px]">timer</span>
                            <span class="text-[11px]">Standard SLA: 3 Business Days</span>
                        </div>
                    </div>
                </div>
                <!-- Requisition Main Title Header & Actions -->
                <div
                    class="bg-surface p-space-md shadow-sm mb-space-lg flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-accent-red-hover inline-block"></span>
                            <h1 class="text-h2 font-h2 text-primary tracking-tight">
                                Create Purchase Requisition
                                (สร้างใบขอซื้อ / PR)
                            </h1>
                        </div>
                        <p class="font-data-mono text-caption text-text-muted mt-0.5 pl-3.5">
                            Form PR-AMEC-2026-REV3 // Internal
                            Procurement &amp; Subcontractor Component
                            Requisition // Chonburi Works
                        </p>
                    </div>
                    <div class="flex items-center gap-space-sm flex-wrap">
                        <button
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-surface text-primary text-body-sm font-semibold hover:bg-surface-container transition-colors shadow-sm"
                            type="button">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            <span>Save as Draft (บันทึกร่าง)</span>
                        </button>
                        <button
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-surface text-primary text-body-sm font-semibold hover:bg-surface-container transition-colors shadow-sm"
                            type="button">
                            <span class="material-symbols-outlined text-[18px]">file_copy</span>
                            <span>Load Template (โหลดแม่แบบ)</span>
                        </button>
                        <button
                            class="inline-flex items-center gap-1.5 px-5 py-2 bg-primary text-on-primary text-body-sm font-semibold hover:bg-on-surface-variant transition-colors shadow-sm"
                            type="button">
                            <span class="material-symbols-outlined text-[18px]">send</span>
                            <span>Submit for Approval (ส่งขออนุมัติ
                                PR)</span>
                        </button>
                    </div>
                </div>
                <!-- Main 12-Column Layout: 8 Cols (Data Form) + 4 Cols (Approval & Financials) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">
                    <!-- LEFT COLUMN: Requisition Core Forms (8 Cols) -->
                    <div class="lg:col-span-8 flex flex-col gap-space-lg min-w-0">
                        <!-- SECTION A: Header Information -->
                        <div class="bg-surface shadow-sm p-space-lg">
                            <div class="flex items-center justify-between pb-space-sm mb-space-md">
                                <div class="flex items-center gap-2">
                                    <span class="bg-primary text-on-primary text-[11px] font-bold px-2 py-0.5">SEC A</span>
                                    <h2 class="font-h3 text-body-lg text-primary uppercase font-bold tracking-tight">
                                        Header Information
                                        (ข้อมูลทั่วไปของเอกสาร PR)
                                    </h2>
                                </div>
                                <span class="text-caption font-meta-tag text-status-reject-text uppercase">* Mandatory
                                    Fields</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                                <!-- PR Number -->
                                <div>
                                    <label class="block text-caption font-meta-tag uppercase text-text-muted mb-1">
                                        PR Document Number (เลขที่ PR)
                                    </label>
                                    <div
                                        class="h-[38px] px-3 bg-surface-container flex items-center font-data-mono text-body-sm font-bold text-primary">
                                        PR-2026-009412
                                    </div>
                                    <p class="text-[10px] text-text-muted mt-1">
                                        Generated by SAP AMEC Central
                                        Node
                                    </p>
                                </div>
                                <!-- Requisition Date -->
                                <div>
                                    <label class="block text-caption font-meta-tag uppercase text-text-muted mb-1">
                                        Requisition Date (วันที่ขอซื้อ)
                                    </label>
                                    <input
                                        class="w-full h-[38px] px-3 bg-surface-container font-data-mono text-body-sm text-primary focus:outline-none"
                                        readonly="" type="date" value="2026-04-02" />
                                </div>
                                <!-- Target Delivery Date -->
                                <div>
                                    <label class="block text-caption font-meta-tag uppercase text-text-muted mb-1">
                                        Target Delivery Date
                                        (วันที่ต้องการส่งมอบ)
                                        <span class="text-status-reject-text">*</span>
                                    </label>
                                    <input
                                        class="w-full h-[38px] px-3 bg-surface text-primary font-data-mono text-body-sm shadow-sm focus:outline-none focus:bg-surface-subtle"
                                        type="date" value="2026-05-15" />
                                </div>
                            </div>
                            <!-- Requesting Department & Plant Cost Center -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md mt-space-md">
                                <div>
                                    <label class="block text-caption font-meta-tag uppercase text-text-muted mb-1">
                                        Requesting Department
                                        (ฝ่ายงานที่ขอซื้อ)
                                        <span class="text-status-reject-text">*</span>
                                    </label>
                                    <select
                                        class="w-full h-[38px] px-3 bg-surface text-primary font-body-sm shadow-sm focus:outline-none">
                                        <option selected="">
                                            Elevator Hoistway &amp;
                                            Structural Engineering
                                            (ฝ่ายวิศวกรรมโครงสร้างและปล่องลิฟต์)
                                        </option>
                                        <option>
                                            Electrical Traction &amp;
                                            Control Inverter Team
                                            (ฝ่ายระบบขับเคลื่อนและแผงควบคุม)
                                        </option>
                                        <option>
                                            Door Operator &amp; Signal
                                            Fixtures Division
                                            (ฝ่ายระบบประตูลิฟต์และอุปกรณ์ส่งสัญญาณ)
                                        </option>
                                        <option>
                                            Quality Assurance &amp;
                                            Metrology Center
                                            (ศูนย์ทดสอบคุณภาพและมาตรวิทยา)
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-caption font-meta-tag uppercase text-text-muted mb-1">
                                        Plant / Cost Center
                                        (โรงงานและศูนย์ต้นทุน)
                                        <span class="text-status-reject-text">*</span>
                                    </label>
                                    <div
                                        class="h-[38px] px-3 bg-surface-container flex items-center justify-between text-body-sm font-semibold text-primary">
                                        <span>AMEC Amata Plant 1
                                            (Chonburi)</span>
                                        <span
                                            class="font-data-mono text-caption text-text-muted bg-surface px-2 py-0.5">CC-4100-ENG</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Requisition Type Selector -->
                            <div class="mt-space-md">
                                <label class="block text-caption font-meta-tag uppercase text-text-muted mb-2">
                                    Requisition Classification
                                    (ประเภทของรายการจัดซื้อ)
                                    <span class="text-status-reject-text">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                                    <label
                                        class="flex items-start gap-2 p-2.5 bg-surface-container text-primary cursor-pointer hover:bg-surface-container-high transition-colors">
                                        <input checked="" class="mt-0.5 text-primary accent-primary" name="pr_type"
                                            type="radio" />
                                        <div class="text-caption">
                                            <span class="font-bold block">Direct Material</span>
                                            <span class="text-[11px] text-text-muted block">ชิ้นส่วนตรงผลิต
                                                Nexiez/Z</span>
                                        </div>
                                    </label>
                                    <label
                                        class="flex items-start gap-2 p-2.5 bg-surface-subtle text-primary cursor-pointer hover:bg-surface-container transition-colors">
                                        <input class="mt-0.5 text-primary accent-primary" name="pr_type" type="radio" />
                                        <div class="text-caption">
                                            <span class="font-bold block">Tooling &amp;
                                                Fixture</span>
                                            <span class="text-[11px] text-text-muted block">แม่พิมพ์/อุปกรณ์จับยึด</span>
                                        </div>
                                    </label>
                                    <label
                                        class="flex items-start gap-2 p-2.5 bg-surface-subtle text-primary cursor-pointer hover:bg-surface-container transition-colors">
                                        <input class="mt-0.5 text-primary accent-primary" name="pr_type" type="radio" />
                                        <div class="text-caption">
                                            <span class="font-bold block">Consumables &amp;
                                                Supplies</span>
                                            <span class="text-[11px] text-text-muted block">วัสดุสิ้นเปลืองโรงงาน</span>
                                        </div>
                                    </label>
                                    <label
                                        class="flex items-start gap-2 p-2.5 bg-surface-subtle text-primary cursor-pointer hover:bg-surface-container transition-colors">
                                        <input class="mt-0.5 text-primary accent-primary" name="pr_type"
                                            type="radio" />
                                        <div class="text-caption">
                                            <span class="font-bold block">Subcontract
                                                Machining</span>
                                            <span class="text-[11px] text-text-muted block">งานจ้างเหมาแปรรูปนอก</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <!-- Priority Level -->
                            <div
                                class="mt-space-md pt-space-sm flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                                <span class="text-caption font-meta-tag uppercase text-text-muted">Requisition Urgency
                                    Priority
                                    (ระดับความเร่งด่วน)</span>
                                <div class="flex items-center gap-space-sm">
                                    <button
                                        class="px-3 py-1 bg-primary text-on-primary text-caption font-bold tracking-wider"
                                        type="button">
                                        NORMAL (ปกติ)
                                    </button>
                                    <button
                                        class="px-3 py-1 bg-surface-container text-text-muted hover:text-primary text-caption font-bold tracking-wider transition-colors"
                                        type="button">
                                        URGENT (ด่วน)
                                    </button>
                                    <button
                                        class="px-3 py-1 bg-surface-container text-status-reject-text hover:bg-status-reject-bg text-caption font-bold tracking-wider transition-colors"
                                        type="button">
                                        CRITICAL LINE STOP
                                        (วิกฤติเสี่ยงหยุดผลิต)
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- SECTION B: Preferred Supplier & Vendor Sourcing -->
                        <div class="bg-surface shadow-sm p-space-lg">
                            <div class="flex items-center justify-between pb-space-sm mb-space-md">
                                <div class="flex items-center gap-2">
                                    <span class="bg-primary text-on-primary text-[11px] font-bold px-2 py-0.5">SEC B</span>
                                    <h2 class="font-h3 text-body-lg text-primary uppercase font-bold tracking-tight">
                                        Preferred Supplier &amp;
                                        Commercial Terms
                                        (ข้อมูลคู่ค้าและเงื่อนไขการค้า)
                                    </h2>
                                </div>
                                <span
                                    class="px-2 py-0.5 bg-status-success-bg text-status-success-text text-caption font-bold">
                                    Grade A Certified Supplier
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-space-md">
                                <div class="md:col-span-8">
                                    <label class="block text-caption font-meta-tag uppercase text-text-muted mb-1">
                                        Select Preferred Vendor
                                        (เลือกคู่ค้าที่ผ่านการรับรอง)
                                        <span class="text-status-reject-text">*</span>
                                    </label>
                                    <select
                                        class="w-full h-[38px] px-3 bg-surface text-primary font-body-sm shadow-sm focus:outline-none">
                                        <option selected="">
                                            V-884029-TH // Siam
                                            Precision Engineering Co.,
                                            Ltd. (บจก. สยาม พรีซีชั่น
                                            เอ็นจิเนียริ่ง)
                                        </option>
                                        <option>
                                            V-102944-TH // Bangkok Cable
                                            &amp; Wire Ropes Industrial
                                            Public Co., Ltd.
                                        </option>
                                        <option>
                                            V-553198-JP // Mitsubishi
                                            Electric Building Solutions
                                            Corp. (Inazawa Works)
                                        </option>
                                        <option>
                                            V-772109-TH // Chonburi
                                            Metal Stamping &amp; Press
                                            Works Ltd.
                                        </option>
                                    </select>
                                </div>
                                <div class="md:col-span-4">
                                    <label class="block text-caption font-meta-tag uppercase text-text-muted mb-1">
                                        Procurement Currency (สกุลเงิน)
                                    </label>
                                    <div class="grid grid-cols-3 gap-1">
                                        <button
                                            class="h-[38px] bg-primary text-on-primary font-bold text-caption tracking-wider"
                                            type="button">
                                            THB (฿)
                                        </button>
                                        <button
                                            class="h-[38px] bg-surface-container text-text-muted hover:text-primary font-bold text-caption tracking-wider"
                                            type="button">
                                            JPY (¥)
                                        </button>
                                        <button
                                            class="h-[38px] bg-surface-container text-text-muted hover:text-primary font-bold text-caption tracking-wider"
                                            type="button">
                                            USD ($)
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md mt-space-md">
                                <div>
                                    <label class="block text-caption font-meta-tag uppercase text-text-muted mb-1">
                                        Vendor Key Account / Contact
                                    </label>
                                    <div
                                        class="h-[38px] px-3 bg-surface-subtle flex items-center text-body-sm text-primary truncate">
                                        Mr. Kittisak Promdee (+66
                                        38-450-891)
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-caption font-meta-tag uppercase text-text-muted mb-1">
                                        Payment Terms
                                        (เงื่อนไขการชำระเงิน)
                                    </label>
                                    <div
                                        class="h-[38px] px-3 bg-surface-subtle flex items-center text-body-sm text-primary truncate">
                                        T/T 90 Days after B/L Date
                                        (MPA-2024)
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-caption font-meta-tag uppercase text-text-muted mb-1">
                                        Delivery Incoterms &amp;
                                        Destination
                                    </label>
                                    <div
                                        class="h-[38px] px-3 bg-surface-subtle flex items-center text-body-sm text-primary truncate">
                                        DDP AMEC Chonburi Plant (Gate
                                        7B)
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- SECTION C: Line Items & Technical BOM Table -->
                        <div class="bg-surface shadow-sm p-space-lg">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between pb-space-sm mb-space-md gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="bg-primary text-on-primary text-[11px] font-bold px-2 py-0.5">SEC C</span>
                                    <h2 class="font-h3 text-body-lg text-primary uppercase font-bold tracking-tight">
                                        Line Items &amp; Technical Bill
                                        of Materials
                                        (รายการชิ้นส่วนที่ขอซื้อ)
                                    </h2>
                                </div>
                                <span class="text-caption font-data-mono bg-surface-container px-2 py-1 text-primary">3
                                    Active Requisition Lines</span>
                            </div>
                            <!-- Enterprise Tabular Grid -->
                            <div class="overflow-x-auto -mx-space-lg px-space-lg">
                                <table class="w-full text-left font-body-sm">
                                    <thead>
                                        <tr class="bg-surface-subtle text-caption font-meta-tag text-primary uppercase">
                                            <th class="py-2.5 px-3 w-12 text-center">
                                                #
                                            </th>
                                            <th class="py-2.5 px-3 min-w-[150px]">
                                                Part No. / DWG
                                            </th>
                                            <th class="py-2.5 px-3 min-w-[240px]">
                                                Description &amp;
                                                Specifications
                                            </th>
                                            <th class="py-2.5 px-3 text-right">
                                                Qty
                                            </th>
                                            <th class="py-2.5 px-3 text-center">
                                                Unit
                                            </th>
                                            <th class="py-2.5 px-3 text-right min-w-[120px]">
                                                Est. Unit Price
                                            </th>
                                            <th class="py-2.5 px-3 text-right min-w-[130px]">
                                                Total (THB)
                                            </th>
                                            <th class="py-2.5 px-3 text-center w-16">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-border-light text-body-sm">
                                        <!-- Item 1 -->
                                        <tr class="hover:bg-surface-subtle transition-colors">
                                            <td class="py-3 px-3 text-center font-data-mono text-text-muted">
                                                01
                                            </td>
                                            <td class="py-3 px-3 font-data-mono font-bold text-primary">
                                                <span>KA517B647G04</span>
                                                <span class="block text-[11px] font-normal text-text-muted">Rev. C / CAD
                                                    Validated</span>
                                            </td>
                                            <td class="py-3 px-3">
                                                <div class="font-semibold text-primary">
                                                    Car Frame Sheet
                                                    Metal Pressing &amp;
                                                    Guide Brackets
                                                </div>
                                                <div class="text-caption text-text-muted">
                                                    ชุดคานโครงลิฟต์ปั๊มขึ้นรูป
                                                    - Spec ST-41 / JIS
                                                    G3101 Standard
                                                </div>
                                            </td>
                                            <td class="py-3 px-3 text-right font-data-mono font-bold text-primary">
                                                450
                                            </td>
                                            <td class="py-3 px-3 text-center text-caption text-text-muted">
                                                Sets
                                            </td>
                                            <td class="py-3 px-3 text-right font-data-mono text-primary">
                                                8,500.00
                                            </td>
                                            <td class="py-3 px-3 text-right font-data-mono font-bold text-primary">
                                                3,825,000.00
                                            </td>
                                            <td class="py-3 px-3 text-center">
                                                <button
                                                    class="text-text-muted hover:text-status-reject-text transition-colors p-1"
                                                    title="Delete row" type="button">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Item 2 -->
                                        <tr class="hover:bg-surface-subtle transition-colors">
                                            <td class="py-3 px-3 text-center font-data-mono text-text-muted">
                                                02
                                            </td>
                                            <td class="py-3 px-3 font-data-mono font-bold text-primary">
                                                <span>DWG-HW-8821</span>
                                                <span class="block text-[11px] font-normal text-text-muted">Rev. 4.1 /
                                                    High-Stress</span>
                                            </td>
                                            <td class="py-3 px-3">
                                                <div class="font-semibold text-primary">
                                                    Hoistway Guide Rail
                                                    Joint Bracket
                                                    High-Tensile
                                                    Assembly
                                                </div>
                                                <div class="text-caption text-text-muted">
                                                    ตัวยึดรางลิฟต์แรงดึงสูงสำหรับปล่องลิฟต์ความเร็ว
                                                    2.5m/s (Nexiez)
                                                </div>
                                            </td>
                                            <td class="py-3 px-3 text-right font-data-mono font-bold text-primary">
                                                1,200
                                            </td>
                                            <td class="py-3 px-3 text-center text-caption text-text-muted">
                                                Pcs
                                            </td>
                                            <td class="py-3 px-3 text-right font-data-mono text-primary">
                                                1,450.00
                                            </td>
                                            <td class="py-3 px-3 text-right font-data-mono font-bold text-primary">
                                                1,740,000.00
                                            </td>
                                            <td class="py-3 px-3 text-center">
                                                <button
                                                    class="text-text-muted hover:text-status-reject-text transition-colors p-1"
                                                    title="Delete row" type="button">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Item 3 -->
                                        <tr class="hover:bg-surface-subtle transition-colors">
                                            <td class="py-3 px-3 text-center font-data-mono text-text-muted">
                                                03
                                            </td>
                                            <td class="py-3 px-3 font-data-mono font-bold text-primary">
                                                <span>YE103D634-02</span>
                                                <span class="block text-[11px] font-normal text-text-muted">Rev. B / Finish
                                                    Black</span>
                                            </td>
                                            <td class="py-3 px-3">
                                                <div class="font-semibold text-primary">
                                                    Face Plate Stamping
                                                    &amp; Powder Coating
                                                    (RoHS compliant)
                                                </div>
                                                <div class="text-caption text-text-muted">
                                                    แผ่นหน้าปัดปั๊มขึ้นรูปพ่นสีฝุ่นอุตสาหกรรม
                                                    มาตรฐานความปลอดภัย
                                                    RoHS
                                                </div>
                                            </td>
                                            <td class="py-3 px-3 text-right font-data-mono font-bold text-primary">
                                                2,400
                                            </td>
                                            <td class="py-3 px-3 text-center text-caption text-text-muted">
                                                Pcs
                                            </td>
                                            <td class="py-3 px-3 text-right font-data-mono text-primary">
                                                380.00
                                            </td>
                                            <td class="py-3 px-3 text-right font-data-mono font-bold text-primary">
                                                912,000.00
                                            </td>
                                            <td class="py-3 px-3 text-center">
                                                <button
                                                    class="text-text-muted hover:text-status-reject-text transition-colors p-1"
                                                    title="Delete row" type="button">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Add Item Trigger -->
                            <button
                                class="w-full mt-space-md py-2.5 bg-surface-subtle hover:bg-surface-container text-secondary hover:text-accent-blue-hover font-semibold text-body-sm flex items-center justify-center gap-1.5 transition-colors"
                                type="button">
                                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                                <span>+ Add New Line Item (+
                                    เพิ่มรายการสินค้า/รหัสแบบแปลน)</span>
                            </button>
                            <!-- Subtotal / VAT / Total Breakdown Panel -->
                            <div
                                class="mt-space-md pt-space-md bg-surface-subtle p-space-md flex flex-col items-end gap-1 font-body-sm">
                                <div class="flex justify-between w-full max-w-xs text-text-muted">
                                    <span>Subtotal
                                        (มูลค่ารวมก่อนภาษี):</span>
                                    <span class="font-data-mono font-semibold text-primary">฿6,477,000.00</span>
                                </div>
                                <div class="flex justify-between w-full max-w-xs text-text-muted">
                                    <span>Value Added Tax (VAT 7%):</span>
                                    <span class="font-data-mono font-semibold text-primary">฿453,390.00</span>
                                </div>
                                <div class="flex justify-between w-full max-w-xs pt-2 mt-1 text-primary font-bold">
                                    <span class="text-body-md uppercase tracking-tight">Grand Total (ยอดสุทธิ):</span>
                                    <span class="font-data-mono text-body-lg text-primary">฿6,930,390.00 THB</span>
                                </div>
                            </div>
                        </div>
                        <!-- SECTION D: Engineering Drawings & Attachment Upload -->
                        <div class="bg-surface shadow-sm p-space-lg">
                            <div class="flex items-center justify-between pb-space-sm mb-space-md">
                                <div class="flex items-center gap-2">
                                    <span class="bg-primary text-on-primary text-[11px] font-bold px-2 py-0.5">SEC D</span>
                                    <h2 class="font-h3 text-body-lg text-primary uppercase font-bold tracking-tight">
                                        Engineering Drawings &amp;
                                        Supporting Documents
                                        (เอกสารแนบและแบบ CAD)
                                    </h2>
                                </div>
                                <span class="text-caption font-data-mono text-text-muted">Max 50MB / Secure Vault</span>
                            </div>
                            <!-- Drag & Drop Interactive Canvas -->
                            <div
                                class="bg-surface-subtle p-space-lg text-center cursor-pointer hover:bg-surface-container transition-colors">
                                <div
                                    class="w-12 h-12 bg-surface text-secondary mx-auto flex items-center justify-center mb-2 shadow-sm">
                                    <span class="material-symbols-outlined text-[28px]">cloud_upload</span>
                                </div>
                                <div class="font-bold text-body-sm text-primary">
                                    Drag and drop CAD (STEP, DWG, DXF),
                                    Spec Sheets, or Quotations here
                                </div>
                                <div class="text-caption text-text-muted mt-1">
                                    or click to
                                    <span class="text-secondary underline">Browse AMEC local storage</span>
                                    (Supported: STEP, DWG, DXF, PDF,
                                    XLSX)
                                </div>
                            </div>
                            <!-- Validated Files Strip -->
                            <div class="mt-space-md flex flex-col gap-2">
                                <div class="flex items-center justify-between p-2.5 bg-surface-subtle">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="material-symbols-outlined text-secondary text-[22px]">view_in_ar</span>
                                        <div class="min-w-0">
                                            <span
                                                class="font-data-mono text-body-sm font-semibold text-primary block truncate">KA517B647G04_3D_Model.step</span>
                                            <span class="text-caption text-text-muted">14.2 MB // Checksum
                                                verified via Inazawa CAD
                                                Bridge</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="px-2 py-0.5 bg-status-success-bg text-status-success-text text-caption font-bold">Validated</span>
                                        <button class="text-text-muted hover:text-primary" type="button">
                                            <span class="material-symbols-outlined text-[18px]">close</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-2.5 bg-surface-subtle">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="material-symbols-outlined text-accent-red-hover text-[22px]">picture_as_pdf</span>
                                        <div class="min-w-0">
                                            <span
                                                class="font-data-mono text-body-sm font-semibold text-primary block truncate">Siam_Precision_Quotation_Q26-0811.pdf</span>
                                            <span class="text-caption text-text-muted">1.8 MB // Signed
                                                Quotation &amp;
                                                Dimensional Spec
                                                Sheet</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="px-2 py-0.5 bg-surface-container text-text-muted text-caption font-bold">Attached</span>
                                        <button class="text-text-muted hover:text-primary" type="button">
                                            <span class="material-symbols-outlined text-[18px]">close</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-2.5 bg-surface-subtle">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="material-symbols-outlined text-accent-red-hover text-[22px]">picture_as_pdf</span>
                                        <div class="min-w-0">
                                            <span
                                                class="font-data-mono text-body-sm font-semibold text-primary block truncate">AMEC_Material_Spec_ST41.pdf</span>
                                            <span class="text-caption text-text-muted">850 KB // Material
                                                Chemical Analysis
                                                Certification</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="px-2 py-0.5 bg-surface-container text-text-muted text-caption font-bold">Attached</span>
                                        <button class="text-text-muted hover:text-primary" type="button">
                                            <span class="material-symbols-outlined text-[18px]">close</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- SECTION E: Reason & Remarks -->
                        <div class="bg-surface shadow-sm p-space-lg">
                            <div class="flex items-center gap-2 pb-space-sm mb-space-md">
                                <span class="bg-primary text-on-primary text-[11px] font-bold px-2 py-0.5">SEC E</span>
                                <h2 class="font-h3 text-body-lg text-primary uppercase font-bold tracking-tight">
                                    Procurement Justification &amp;
                                    Plant Purpose
                                    (เหตุผลและความจำเป็นในการจัดซื้อ)
                                </h2>
                            </div>
                            <label class="block text-caption font-meta-tag uppercase text-text-muted mb-1">
                                Detailed Justification
                                (โปรดระบุวัตถุประสงค์ รหัสโครงการ
                                หรือรอบการประกอบลิฟต์)
                                <span class="text-status-reject-text">*</span>
                            </label>
                            <textarea
                                class="w-full p-3 bg-surface text-primary font-body-sm shadow-sm focus:outline-none focus:bg-surface-subtle"
                                rows="3">
    Procurement for AMEC Q3/2026 Nexiez-S High-Speed Passenger Elevator project batch #4026. Required for Chonburi assembly line 2 scheduled start on May 20, 2026. Direct delivery to Gate 7B buffer staging warehouse.</textarea>
                            <div class="flex items-center justify-between mt-2 text-caption text-text-muted">
                                <span>Character Count: 248 / 1,000</span>
                                <span>Security Compliance: Confidential
                                    Industrial Data</span>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT COLUMN: Side Summary & Multi-tier DOA Approval Matrix (4 Cols) -->
                    <div class="lg:col-span-4 flex flex-col gap-space-lg min-w-0">
                        <!-- Financial & Budget Validation Card -->
                        <div class="bg-surface shadow-sm p-space-lg">
                            <div class="flex items-center justify-between pb-space-sm mb-space-md">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[20px]">account_balance</span>
                                    <h3 class="font-h3 text-body-md text-primary font-bold uppercase tracking-tight">
                                        Budget &amp; Ledger Check
                                    </h3>
                                </div>
                                <span
                                    class="bg-status-success-bg text-status-success-text text-[11px] font-bold px-2 py-0.5">
                                    BUDGET OK
                                </span>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <div class="bg-surface-subtle p-3">
                                    <span class="text-caption font-meta-tag uppercase text-text-muted block">Requisition
                                        Estimated
                                        Total</span>
                                    <span
                                        class="font-data-mono text-h2 text-primary font-bold block mt-0.5">฿6,930,390.00</span>
                                    <span class="text-caption text-text-muted">Thai Baht (Inclusive of 7%
                                        VAT)</span>
                                </div>
                                <!-- Budget Progress Indicator -->
                                <div class="space-y-1.5 pt-1">
                                    <div class="flex justify-between text-caption font-semibold">
                                        <span class="text-text-muted font-meta-tag uppercase">Allocated Budget Cap:</span>
                                        <span class="font-data-mono text-primary">฿15,000,000.00</span>
                                    </div>
                                    <!-- Progress Bar Visualization -->
                                    <div class="w-full h-2 bg-surface-container overflow-hidden">
                                        <div class="bg-secondary h-full" style="width: 46.2%"></div>
                                    </div>
                                    <div class="flex justify-between text-caption">
                                        <span class="text-status-success-text font-bold">Remaining Post-PR:
                                            ฿8,069,610.00</span>
                                        <span class="text-text-muted font-data-mono">46.2% Utilized</span>
                                    </div>
                                </div>
                                <!-- Metadata table for SAP sync -->
                                <div class="bg-surface-subtle p-3 space-y-1.5 text-caption mt-1">
                                    <div class="flex justify-between">
                                        <span class="text-text-muted">Cost Center:</span>
                                        <span class="font-data-mono font-semibold text-primary">CC-4100-ENG</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-text-muted">GL Account:</span>
                                        <span class="font-data-mono font-semibold text-primary">5120-100 (Direct Prod
                                            Parts)</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-text-muted">Budget Pool ID:</span>
                                        <span
                                            class="font-data-mono font-semibold text-primary">BG-2026-ENG-HOISTWAY-04</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Multi-tier DOA Approval Matrix (สายการบังคับบัญชาและผู้อนุมัติ) -->
                        <div class="bg-surface shadow-sm p-space-lg">
                            <div class="flex items-center justify-between pb-space-sm mb-space-md">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[20px]">schema</span>
                                    <h3 class="font-h3 text-body-md text-primary font-bold uppercase tracking-tight">
                                        AMEC Approval Routing
                                    </h3>
                                </div>
                                <span class="font-meta-tag text-[10px] text-text-muted uppercase">AMEC DOA Level 4
                                    (&gt;฿5M)</span>
                            </div>
                            <div
                                class="relative pl-6 space-y-5 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-border-light">
                                <!-- Stepper Item 1: Requestor -->
                                <div class="relative">
                                    <div
                                        class="absolute -left-6 top-0.5 w-4 h-4 rounded-full bg-status-success-text text-on-primary flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[10px]">check</span>
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-caption font-bold text-primary">1. Requestor
                                                Initiated</span>
                                            <span
                                                class="px-1.5 py-0.2 bg-status-success-bg text-status-success-text text-[10px] font-bold">READY</span>
                                        </div>
                                        <p class="text-body-sm font-semibold text-primary mt-0.5">
                                            S. Narongrit (Dept. 4)
                                        </p>
                                        <p class="text-caption text-text-muted">
                                            Senior Hoistway System
                                            Engineer
                                        </p>
                                    </div>
                                </div>
                                <!-- Stepper Item 2: Dept Manager -->
                                <div class="relative">
                                    <div
                                        class="absolute -left-6 top-0.5 w-4 h-4 rounded-full bg-status-pending-border text-status-pending-text flex items-center justify-center font-bold text-[9px]">
                                        2
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-caption font-bold text-primary">2. Department
                                                Manager</span>
                                            <span
                                                class="px-1.5 py-0.2 bg-status-pending-bg text-status-pending-text text-[10px] font-bold">PENDING</span>
                                        </div>
                                        <p class="text-body-sm font-semibold text-primary mt-0.5">
                                            Mr. Kittipong P.
                                        </p>
                                        <p class="text-caption text-text-muted">
                                            Head of Hoistway Engineering
                                            Dept.
                                        </p>
                                    </div>
                                </div>
                                <!-- Stepper Item 3: Plant GM / Director -->
                                <div class="relative">
                                    <div
                                        class="absolute -left-6 top-0.5 w-4 h-4 rounded-full bg-surface-container text-text-muted flex items-center justify-center font-bold text-[9px]">
                                        3
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-caption font-bold text-primary">3. Plant GM &amp;
                                                Director</span>
                                            <span class="text-[10px] text-text-muted font-bold">REQUIRED
                                                (&gt;฿5M)</span>
                                        </div>
                                        <p class="text-body-sm font-semibold text-primary mt-0.5">
                                            Mr. Katsunori Takahashi
                                        </p>
                                        <p class="text-caption text-text-muted">
                                            General Manager, SCM &amp;
                                            Plant Operations
                                        </p>
                                    </div>
                                </div>
                                <!-- Stepper Item 4: Procurement Lead -->
                                <div class="relative">
                                    <div
                                        class="absolute -left-6 top-0.5 w-4 h-4 rounded-full bg-surface-container text-text-muted flex items-center justify-center font-bold text-[9px]">
                                        4
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-caption font-bold text-primary">4. Final PO
                                                Conversion</span>
                                            <span class="text-[10px] text-text-muted">PROCUREMENT</span>
                                        </div>
                                        <p class="text-body-sm font-semibold text-primary mt-0.5">
                                            Ms. P. Sukcharoen
                                        </p>
                                        <p class="text-caption text-text-muted">
                                            Lead Buyer, Direct SCM
                                            Division
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Compliance & Mandatory Policies Checklist -->
                        <div class="bg-surface shadow-sm p-space-lg">
                            <div class="flex items-center gap-2 pb-space-sm mb-space-md">
                                <span class="material-symbols-outlined text-primary text-[20px]">fact_check</span>
                                <h3 class="font-h3 text-body-md text-primary font-bold uppercase tracking-tight">
                                    Compliance Validation
                                </h3>
                            </div>
                            <div class="space-y-3 text-caption">
                                <label class="flex items-start gap-2.5 cursor-pointer">
                                    <input checked="" class="mt-0.5 text-primary accent-primary" type="checkbox" />
                                    <span class="text-primary">Verified against active Drawing
                                        Revision in Inazawa CAD
                                        Vault</span>
                                </label>
                                <label class="flex items-start gap-2.5 cursor-pointer">
                                    <input checked="" class="mt-0.5 text-primary accent-primary" type="checkbox" />
                                    <span class="text-primary">Compliant with AMEC Green
                                        Procurement Charter (RoHS /
                                        REACH)</span>
                                </label>
                                <label class="flex items-start gap-2.5 cursor-pointer">
                                    <input checked="" class="mt-0.5 text-primary accent-primary" type="checkbox" />
                                    <span class="text-primary">Preferred vendor holds active
                                        MPA and ISO 9001/14001
                                        certification</span>
                                </label>
                                <label class="flex items-start gap-2.5 cursor-pointer text-text-muted">
                                    <input class="mt-0.5 text-primary accent-primary" disabled="" type="checkbox" />
                                    <span>Emergency bypass authorization
                                        (Form LOG-F-088) - Not
                                        applicable</span>
                                </label>
                            </div>
                        </div>
                        <!-- Submit & Confirmation Execution Box -->
                        <div class="bg-surface shadow-sm p-space-lg">
                            <div class="flex flex-col gap-space-sm">
                                <button
                                    class="w-full py-3 bg-accent-red-hover hover:bg-on-tertiary-fixed-variant text-on-tertiary font-bold text-body-sm flex items-center justify-center gap-2 transition-colors shadow-sm"
                                    type="button">
                                    <span class="material-symbols-outlined text-[20px]">send</span>
                                    <span>Submit PR for Approval
                                        (ส่งขออนุมัติ PR)</span>
                                </button>
                                <button
                                    class="w-full py-2.5 bg-surface text-primary hover:bg-surface-container font-semibold text-body-sm flex items-center justify-center gap-2 transition-colors shadow-sm"
                                    type="button">
                                    <span>Save Draft &amp; Close
                                        (บันทึกร่างและปิด)</span>
                                </button>
                            </div>
                            <div class="mt-space-md pt-space-sm flex items-start gap-2 text-caption text-text-muted">
                                <span class="material-symbols-outlined text-[16px] text-secondary">support_agent</span>
                                <div>
                                    Need procurement assistance? Contact
                                    AMEC Internal Buyer
                                    <span class="font-data-mono font-semibold text-primary">Ext. 2401-2408</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Plant Operations Quick Notice Footer Callout -->
                <div
                    class="mt-space-2xl bg-surface p-space-md shadow-sm flex flex-col md:flex-row items-center justify-between text-caption text-text-muted gap-space-sm">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary text-[20px]">info</span>
                        <span>Requisition submissions are synchronized
                            instantaneously with Mitsubishi Electric SAP
                            ERP (ECC/S4 Cluster TH01).</span>
                    </div>
                    <div class="font-data-mono text-[11px] text-primary">
                        AMEC-SYS-NODE: CHONBURI-PL1-PR-GW03 //
                        2026-04-02 14:32:09 ICT
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
