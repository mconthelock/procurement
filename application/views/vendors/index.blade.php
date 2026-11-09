@extends('layouts/template')

@section('contents')
    @include('layouts/header')
    <div class="flex flex-col">
        <main class="w-full">
            <div class="flex flex-col w-full">
                <!-- Main Work Area -->
                <div class="w-full flex flex-col gap-6">
                    <!-- Header & Action Dock -->
                    <div
                        class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 border-b-2 border-border-dark pb-5">
                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-4 bg-[#FF0000] inline-block"></span>
                                <span class="font-label-sm text-label-sm tracking-wider text-gray-500 uppercase">AMEC
                                    PROCUREMENT MASTER REGISTRY // TIER-1
                                    & TIER-2 PARTNERS</span>
                            </div>
                            <h1 class="font-h1 text-h1 text-black tracking-tight font-bold">
                                Vendor Directory
                                <span
                                    class="font-h2 text-h2 text-gray-500 font-normal tracking-normal">(ทะเบียนรายชื่อคู่ค้าทั้งหมด)</span>
                            </h1>
                            <p class="font-body-sm text-body-sm text-gray-700 max-w-4xl">
                                Official registry of approved tier-1
                                manufacturing fabricators, electrical component
                                suppliers, precision casting specialists, and
                                logistics partners for AMEC Chonburi Works.
                                Governed by Japanese industrial safety and
                                ISO/J-SOX quality mandates.
                            </p>
                        </div>
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap items-center gap-2 pt-2 lg:pt-0">
                            <button
                                class="inline-flex items-center gap-1.5 bg-white text-gray-700 border border-border-medium hover:bg-gray-50 px-3.5 py-2 rounded-[2px] font-body-sm text-caption font-semibold transition-colors shadow-sm"
                                type="button">
                                <span class="material-symbols-outlined text-[17px] text-gray-500">download</span>
                                <span>Download Approved List (.PDF)</span>
                            </button>
                            <button
                                class="inline-flex items-center gap-1.5 bg-white text-gray-700 border border-border-medium hover:bg-gray-50 px-3.5 py-2 rounded-[2px] font-body-sm text-caption font-semibold transition-colors shadow-sm"
                                type="button">
                                <span class="material-symbols-outlined text-[17px] text-gray-500">table_view</span>
                                <span>Export Ledger (.CSV)</span>
                            </button>
                            <button
                                class="inline-flex items-center gap-1.5 bg-[#005cba] hover:bg-[#004d99] text-white px-4 py-2 rounded-[2px] font-body-sm text-caption font-semibold transition-colors shadow-sm"
                                type="button">
                                <span class="material-symbols-outlined text-[18px]">person_add</span>
                                <span>+ Register New Vendor</span>
                            </button>
                        </div>
                    </div>
                    <!-- KPI Metric Blocks (4 Cards with Industrial Precision) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <!-- KPI 1 -->
                        <div
                            class="bg-white border border-border-light p-4 flex flex-col justify-between shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-caption uppercase text-gray-500 tracking-wide">Total Active
                                    Vendors</span>
                                <span class="material-symbols-outlined text-[#005cba] text-[20px]">corporate_fare</span>
                            </div>
                            <div class="mt-2 flex items-baseline gap-2">
                                <span class="font-h1 text-h2 font-bold text-black tracking-tight">148</span>
                                <span class="font-body-sm text-caption text-gray-500">Entities</span>
                            </div>
                            <div
                                class="mt-2 pt-2 border-t border-border-light flex items-center justify-between text-caption font-body-sm text-gray-700">
                                <span>Tier-1:
                                    <strong class="text-black font-semibold">62</strong></span>
                                <span class="text-gray-300">|</span>
                                <span>Tier-2:
                                    <strong class="text-black font-semibold">86</strong></span>
                                <span
                                    class="text-[#1b5e20] text-[11px] font-semibold bg-[#edf7ee] px-1 py-0.5 border border-[#a3d9a5]">100%
                                    Active</span>
                            </div>
                        </div>
                        <!-- KPI 2 -->
                        <div
                            class="bg-white border border-border-light p-4 flex flex-col justify-between shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-caption uppercase text-gray-500 tracking-wide">Quality
                                    Grade A
                                    Certified</span>
                                <span class="material-symbols-outlined text-[#1b5e20] text-[20px]">verified</span>
                            </div>
                            <div class="mt-2 flex items-baseline gap-2">
                                <span class="font-h1 text-h2 font-bold text-black tracking-tight">89.2%</span>
                                <span class="font-body-sm text-caption text-gray-500">(132 Vendors)</span>
                            </div>
                            <div
                                class="mt-2 pt-2 border-t border-border-light flex items-center justify-between text-caption font-body-sm text-gray-700">
                                <span class="text-gray-500">Zero Fatal PPM:
                                    <strong class="text-black font-semibold">124</strong></span>
                                <span class="text-[#1b5e20] text-[11px] font-semibold">+1.8% QoQ</span>
                            </div>
                        </div>
                        <!-- KPI 3 -->
                        <div
                            class="bg-white border border-border-light p-4 flex flex-col justify-between shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-caption uppercase text-gray-500 tracking-wide">J-SOX & ISO
                                    Compliance</span>
                                <span class="material-symbols-outlined text-[#005cba] text-[20px]">policy</span>
                            </div>
                            <div class="mt-2 flex items-baseline gap-2">
                                <span class="font-h1 text-h2 font-bold text-black tracking-tight">100%</span>
                                <span class="font-body-sm text-caption text-[#1b5e20] font-semibold">Audit
                                    Compliant</span>
                            </div>
                            <div
                                class="mt-2 pt-2 border-t border-border-light flex items-center justify-between text-caption font-body-sm text-gray-700">
                                <span class="text-gray-500">ISO 9001 / ISO 14001</span>
                                <span class="font-mono tabular-nums text-[11px] text-gray-500">FY2024 Passed</span>
                            </div>
                        </div>
                        <!-- KPI 4 -->
                        <div
                            class="bg-white border border-border-light p-4 flex flex-col justify-between shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-caption uppercase text-gray-500 tracking-wide">Under Review
                                    /
                                    Action</span>
                                <span class="material-symbols-outlined text-[#8a5800] text-[20px]">warning</span>
                            </div>
                            <div class="mt-2 flex items-baseline gap-2">
                                <span class="font-h1 text-h2 font-bold text-[#8a5800] tracking-tight">4</span>
                                <span class="font-body-sm text-caption text-gray-500">Audits in Progress</span>
                            </div>
                            <div
                                class="mt-2 pt-2 border-t border-border-light flex items-center justify-between text-caption font-body-sm text-gray-700">
                                <span class="text-gray-500">1 Remediation Claim</span>
                                <span
                                    class="text-[#8a5800] text-[11px] font-semibold bg-[#fff8e6] px-1 py-0.5 border border-[#f5c26b]">Action
                                    Req.</span>
                            </div>
                        </div>
                    </div>
                    <!-- Search, Categorization & Filter Toolbar -->
                    <div class="bg-white-subtle border border-border-light p-4 flex flex-col gap-3">
                        <!-- Search Line -->
                        <div class="flex flex-col md:flex-row items-stretch gap-2">
                            <div class="relative flex-1">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-[18px]">search</span>
                                <input
                                    class="w-full bg-white border border-border-medium rounded-none pl-9 pr-3 py-2 text-body-sm text-gray-700 placeholder:text-gray-400 focus:border-[#005cba] focus:outline-none"
                                    id="vendorSearchInput"
                                    placeholder="Search by Vendor Name, Vendor Code (e.g. V-884029-TH, 80018), Tax ID, or Commodity..."
                                    type="text" />
                            </div>
                            <button
                                class="bg-black hover:bg-neutral-800 text-white px-5 py-2 rounded-none font-body-sm text-caption font-semibold flex items-center justify-center gap-1.5 transition-colors"
                                type="button">
                                <span class="material-symbols-outlined text-[16px]">filter_alt</span>
                                <span>Apply Query</span>
                            </button>
                            <button
                                class="bg-white hover:bg-gray-50 text-gray-700 border border-border-medium px-3.5 py-2 rounded-none font-body-sm text-caption font-medium transition-colors"
                                onclick="
									document.getElementById(
										'vendorSearchInput',
									).value = ''
								"
                                type="button">
                                <span>Reset Filters</span>
                            </button>
                        </div>
                        <!-- Filter Dropdowns Row -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 pt-2 border-t border-border-light">
                            <div class="flex flex-col gap-1">
                                <label class="font-label-sm text-[11px] uppercase text-gray-500 tracking-wider">Tier
                                    Level</label>
                                <select
                                    class="bg-white border border-border-medium rounded-none px-2.5 py-1.5 text-body-sm text-gray-700 text-caption focus:border-[#005cba] focus:outline-none">
                                    <option>All Tiers (Tier-1 & Tier-2)</option>
                                    <option>Tier-1 Direct AMEC Partner</option>
                                    <option>
                                        Tier-2 Subcontractor Fabricator
                                    </option>
                                    <option>Tier-1 Global Import Hub</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-label-sm text-[11px] uppercase text-gray-500 tracking-wider">Commodity
                                    Category</label>
                                <select
                                    class="bg-white border border-border-medium rounded-none px-2.5 py-1.5 text-body-sm text-gray-700 text-caption focus:border-[#005cba] focus:outline-none">
                                    <option>All Commodities</option>
                                    <option>
                                        Sheet Metal & Hoistway Structure
                                    </option>
                                    <option>
                                        Electrical Panels & Control Harness
                                    </option>
                                    <option>
                                        Traction Machine & Sheave Casting
                                    </option>
                                    <option>
                                        Fasteners, Binder & Mounting Clips
                                    </option>
                                    <option>
                                        Elevator Door Mechanism & Sills
                                    </option>
                                    <option>
                                        Surface Treatment & Powder Coating
                                    </option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-label-sm text-[11px] uppercase text-gray-500 tracking-wider">Quality
                                    Grade</label>
                                <select
                                    class="bg-white border border-border-medium rounded-none px-2.5 py-1.5 text-body-sm text-gray-700 text-caption focus:border-[#005cba] focus:outline-none">
                                    <option>All Grades</option>
                                    <option>
                                        Grade A Certified (Exemplary)
                                    </option>
                                    <option>
                                        Grade B Qualified (Compliant)
                                    </option>
                                    <option>
                                        Grade B+ (In Corrective Remediation)
                                    </option>
                                    <option>Grade C / Under Probation</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-label-sm text-[11px] uppercase text-gray-500 tracking-wider">Operational
                                    Location</label>
                                <select
                                    class="bg-white border border-border-medium rounded-none px-2.5 py-1.5 text-body-sm text-gray-700 text-caption focus:border-[#005cba] focus:outline-none">
                                    <option>All Locations / Estates</option>
                                    <option>
                                        Amata City Chonburi (Zone 1)
                                    </option>
                                    <option>
                                        WHA Chonburi / Eastern Seaboard
                                    </option>
                                    <option>Amata City Rayong</option>
                                    <option>
                                        Samut Prakan / BKK Industrial
                                    </option>
                                    <option>
                                        Overseas (Japan / Singapore)
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- Result Count & Quick Filter Badges -->
                        <div
                            class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-border-light text-caption">
                            <div class="flex items-center gap-2">
                                <span class="font-label-sm text-gray-500 uppercase text-[11px]">Active View:</span>
                                <span class="font-mono tabular-nums font-semibold text-black">Showing 1 - 8 of 148
                                    Registered
                                    Vendors</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-500 text-[11px]">Quick Views:</span>
                                <button
                                    class="bg-white border border-border-medium text-gray-700 px-2 py-0.5 text-[11px] hover:border-[#005cba]"
                                    type="button">
                                    Chonburi Plant Direct
                                </button>
                                <button
                                    class="bg-white border border-border-medium text-gray-700 px-2 py-0.5 text-[11px] hover:border-[#005cba]"
                                    type="button">
                                    Audit Due < 30 Days </button>
                                        <button
                                            class="bg-white border border-border-medium text-gray-700 px-2 py-0.5 text-[11px] hover:border-[#005cba]"
                                            type="button">
                                            Top 10 Volume Fabricators
                                        </button>
                            </div>
                        </div>
                    </div>
                    <!-- Enterprise Vendor Table (Sharp 0px, Heavy Data Density) -->
                    <div class="w-full bg-white border border-border-light overflow-x-auto shadow-sm">
                        <table class="w-full text-left border-collapse min-w-[1240px]">
                            <thead>
                                <tr
                                    class="bg-white-subtle border-b-2 border-border-dark font-label-sm text-[11px] uppercase tracking-wider text-gray-700">
                                    <th class="py-3 px-3.5 w-32">
                                        Vendor Code
                                    </th>
                                    <th class="py-3 px-3.5">
                                        Corporate Entity Name & Commodity
                                    </th>
                                    <th class="py-3 px-3 w-44">
                                        Tier & Quality
                                    </th>
                                    <th class="py-3 px-3 w-48">
                                        Location / Plant
                                    </th>
                                    <th class="py-3 px-3 w-52">
                                        Liaison Contact
                                    </th>
                                    <th class="py-3 px-3 w-44">AMEC Buyer</th>
                                    <th class="py-3 px-3 w-44 text-right">
                                        OTD & PPM
                                    </th>
                                    <th class="py-3 px-3 w-36 text-center">
                                        Status
                                    </th>
                                    <th class="py-3 px-3.5 w-36 text-right">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-light font-body-sm text-[13px] text-gray-700">
                                <!-- Vendor 1: Siam Precision -->
                                <tr class="hover:bg-[#f0f6ff] transition-colors">
                                    <td class="py-3 px-3.5 align-top">
                                        <span class="font-mono tabular-nums font-bold text-black block">V-884029-TH</span>
                                        <span class="font-caption text-[11px] text-gray-500">SAP: 104882</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top">
                                        <div class="font-semibold text-black">
                                            Siam Precision Engineering Co., Ltd.
                                        </div>
                                        <div class="text-[12px] text-gray-500">
                                            บริษัท สยาม พรีซิชั่น เอ็นจิเนียริ่ง
                                            จำกัด
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-[#005cba]">
                                            <span
                                                class="material-symbols-outlined text-[13px]">precision_manufacturing</span>
                                            <span>Elevator Hoistway & Structural
                                                Sheet Metal</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="inline-block bg-black text-white text-[10px] font-bold px-1.5 py-0.5 w-fit">TIER-1
                                                DIRECT</span>
                                            <span
                                                class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] text-[10px] font-bold px-1.5 py-0.5 w-fit">GRADE
                                                A CERTIFIED</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Amata City Chonburi
                                        </div>
                                        <div class="text-caption text-gray-500">
                                            Plant 2, Phase 4 (Chonburi)
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Mr. Kittisak Promdee
                                        </div>
                                        <div class="font-mono tabular-nums text-[11px] text-gray-500">
                                            kitti@siamprecision.co.th
                                        </div>
                                        <div class="font-caption text-[11px] text-gray-500">
                                            +66 38-450-891
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-semibold text-black">
                                            S. Narongrit
                                        </div>
                                        <div class="font-caption text-gray-500">
                                            Dept 4 (Structural)
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-right font-mono tabular-nums">
                                        <div class="font-bold text-[#1b5e20]">
                                            99.4% OTD
                                        </div>
                                        <div class="text-[11px] text-gray-500">
                                            Defect: 0.02% PPM
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-center">
                                        <span
                                            class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] font-label-sm text-[10px] uppercase px-2 py-0.5">Active</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top text-right">
                                        <div class="flex flex-col items-end gap-1">
                                            <button
                                                class="text-[#005cba] hover:text-[#004d99] font-semibold text-[12px] inline-flex items-center gap-0.5"
                                                type="button">
                                                <span>View Profile</span>
                                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </button>
                                            <a class="text-[11px] text-gray-500 hover:text-black" href="#">View Open
                                                POs (14)</a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Vendor 2: Chokchai Engineering -->
                                <tr class="hover:bg-[#f0f6ff] transition-colors">
                                    <td class="py-3 px-3.5 align-top">
                                        <span class="font-mono tabular-nums font-bold text-black block">V-80018-TH</span>
                                        <span class="font-caption text-[11px] text-gray-500">Code: 80018</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top">
                                        <div class="font-semibold text-black">
                                            Chokchai Engineering Co., Ltd.
                                        </div>
                                        <div class="text-[12px] text-gray-500">
                                            บริษัท โชคชัย เอ็นจิเนียริ่ง จำกัด
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-[#005cba]">
                                            <span class="material-symbols-outlined text-[13px]">crop_square</span>
                                            <span>Face Plates, Brackets & Stamped
                                                Press Parts</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="inline-block bg-black text-white text-[10px] font-bold px-1.5 py-0.5 w-fit">TIER-1
                                                DIRECT</span>
                                            <span
                                                class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] text-[10px] font-bold px-1.5 py-0.5 w-fit">GRADE
                                                A CERTIFIED</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            WHA Chonburi 1
                                        </div>
                                        <div class="text-caption text-gray-500">
                                            Bo-win, Sriracha
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Ms. Voranuch Ch.
                                        </div>
                                        <div class="font-mono tabular-nums text-[11px] text-gray-500">
                                            voranuch@chokchai-eng.com
                                        </div>
                                        <div class="font-caption text-[11px] text-gray-500">
                                            +66 38-345-210
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-semibold text-black">
                                            P. Sukcharoen
                                        </div>
                                        <div class="font-caption text-gray-500">
                                            Dept 2 (Press/Stamping)
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-right font-mono tabular-nums">
                                        <div class="font-bold text-[#1b5e20]">
                                            98.7% OTD
                                        </div>
                                        <div class="text-[11px] text-gray-500">
                                            Defect: 0.05% PPM
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-center">
                                        <span
                                            class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] font-label-sm text-[10px] uppercase px-2 py-0.5">Active</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top text-right">
                                        <div class="flex flex-col items-end gap-1">
                                            <button
                                                class="text-[#005cba] hover:text-[#004d99] font-semibold text-[12px] inline-flex items-center gap-0.5"
                                                type="button">
                                                <span>View Profile</span>
                                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </button>
                                            <a class="text-[11px] text-gray-500 hover:text-black" href="#">View Open
                                                POs (8)</a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Vendor 3: H.T. Sahakij (Action Needed / Remediation) -->
                                <tr class="hover:bg-[#fff9f9] transition-colors bg-[#fffdfb]">
                                    <td class="py-3 px-3.5 align-top">
                                        <span
                                            class="font-mono tabular-nums font-bold text-[#8a5800] block">V-422605-TH</span>
                                        <span class="font-caption text-[11px] text-gray-500">SAP: 102441</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top">
                                        <div class="font-semibold text-black">
                                            H.T. Sahakij Co., Ltd.
                                        </div>
                                        <div class="text-[12px] text-gray-500">
                                            บริษัท เอช.ที. สหกิจ จำกัด
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-gray-500">
                                            <span class="material-symbols-outlined text-[13px]">handyman</span>
                                            <span>Binder, Mounting Clips &
                                                Special Fasteners</span>
                                        </div>
                                        <div
                                            class="mt-1 inline-flex items-center gap-1 text-[11px] text-[#c80010] bg-[#fdecee] px-1.5 py-0.5 border border-[#f5a3ab]">
                                            <span class="material-symbols-outlined text-[12px]">report</span>
                                            <span>Thai Claim Slip Active (Batch
                                                CLM-2025-081)</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="inline-block bg-[#e3e2e2] text-gray-700 text-[10px] font-bold px-1.5 py-0.5 w-fit">TIER-2
                                                SUB</span>
                                            <span
                                                class="inline-block bg-[#fff8e6] text-[#8a5800] border border-[#f5c26b] text-[10px] font-bold px-1.5 py-0.5 w-fit">GRADE
                                                B+ (REMEDIAL)</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Samut Prakan
                                        </div>
                                        <div class="text-caption text-gray-500">
                                            Bang Phli Industrial Est.
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Mr. Somchai Tang
                                        </div>
                                        <div class="font-mono tabular-nums text-[11px] text-gray-500">
                                            somchai@ht-sahakij.co.th
                                        </div>
                                        <div class="font-caption text-[11px] text-gray-500">
                                            +66 2-705-1990
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-semibold text-black">
                                            W. Teerayut
                                        </div>
                                        <div class="font-caption text-gray-500">
                                            Dept 1 (Fasteners)
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-right font-mono tabular-nums">
                                        <div class="font-bold text-[#8a5800]">
                                            92.1% OTD
                                        </div>
                                        <div class="text-[11px] text-[#c80010] font-semibold">
                                            Defect: 0.88% PPM
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-center">
                                        <span
                                            class="inline-block bg-[#fff8e6] text-[#8a5800] border border-[#f5c26b] font-label-sm text-[10px] uppercase px-2 py-0.5">Audit
                                            Pending</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top text-right">
                                        <div class="flex flex-col items-end gap-1">
                                            <button
                                                class="text-[#005cba] hover:text-[#004d99] font-semibold text-[12px] inline-flex items-center gap-0.5"
                                                type="button">
                                                <span>View Profile</span>
                                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </button>
                                            <button class="text-[11px] font-bold text-[#c80010] hover:underline"
                                                type="button">
                                                Issue CAR / Notice
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Vendor 4: Mitsubishi Electric Trading Corp -->
                                <tr class="hover:bg-[#f0f6ff] transition-colors">
                                    <td class="py-3 px-3.5 align-top">
                                        <span class="font-mono tabular-nums font-bold text-black block">V-10003-JP</span>
                                        <span class="font-caption text-[11px] text-gray-500">Code: 10003 (MT-S)</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top">
                                        <div class="font-semibold text-black">
                                            Mitsubishi Electric Trading
                                            Corporation (MT-S)
                                        </div>
                                        <div class="text-[12px] text-gray-500">
                                            บริษัท มิตซูบิชิ อิเล็คทริค เทรดดิ้ง
                                            คอร์ปอเรชั่น
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-[#005cba]">
                                            <span class="material-symbols-outlined text-[13px]">cable</span>
                                            <span>Intercom Cables, Sensors &
                                                Integrated Harness
                                                Assemblies</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="inline-block bg-[#005cba] text-white text-[10px] font-bold px-1.5 py-0.5 w-fit">TIER-1
                                                GLOBAL HUB</span>
                                            <span
                                                class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] text-[10px] font-bold px-1.5 py-0.5 w-fit">GRADE
                                                A CERTIFIED</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Tokyo / Singapore
                                        </div>
                                        <div class="text-caption text-gray-500">
                                            Global Sourcing Hub (APAC)
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            K. Takahashi (高橋)
                                        </div>
                                        <div class="font-mono tabular-nums text-[11px] text-gray-500">
                                            takahashi.k@mitsubishielectric.com
                                        </div>
                                        <div class="font-caption text-[11px] text-gray-500">
                                            +81 3-3218-2111
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-semibold text-black">
                                            K. Apinya
                                        </div>
                                        <div class="font-caption text-gray-500">
                                            Global Electronics
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-right font-mono tabular-nums">
                                        <div class="font-bold text-[#1b5e20]">
                                            99.9% OTD
                                        </div>
                                        <div class="text-[11px] text-gray-500">
                                            Defect: 0.00% PPM
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-center">
                                        <span
                                            class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] font-label-sm text-[10px] uppercase px-2 py-0.5">Active</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top text-right">
                                        <div class="flex flex-col items-end gap-1">
                                            <button
                                                class="text-[#005cba] hover:text-[#004d99] font-semibold text-[12px] inline-flex items-center gap-0.5"
                                                type="button">
                                                <span>View Profile</span>
                                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </button>
                                            <a class="text-[11px] text-gray-500 hover:text-black" href="#">View Open
                                                POs (42)</a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Vendor 5: Thai Sumitomo Electric -->
                                <tr class="hover:bg-[#f0f6ff] transition-colors">
                                    <td class="py-3 px-3.5 align-top">
                                        <span class="font-mono tabular-nums font-bold text-black block">V-550124-TH</span>
                                        <span class="font-caption text-[11px] text-gray-500">SAP: 109280</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top">
                                        <div class="font-semibold text-black">
                                            Thai Sumitomo Electric Wiring
                                            Systems Co., Ltd.
                                        </div>
                                        <div class="text-[12px] text-gray-500">
                                            บริษัท ไทย ซูมิโตโม อิเล็คทริค
                                            ไวร์ริ่ง ซิสเต็มส์ จำกัด
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-[#005cba]">
                                            <span class="material-symbols-outlined text-[13px]">alt_route</span>
                                            <span>Wire Harness, Hoistway Sensors
                                                & Safety Circuit Looms</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="inline-block bg-black text-white text-[10px] font-bold px-1.5 py-0.5 w-fit">TIER-1
                                                DIRECT</span>
                                            <span
                                                class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] text-[10px] font-bold px-1.5 py-0.5 w-fit">GRADE
                                                A CERTIFIED</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Amata City Rayong
                                        </div>
                                        <div class="text-caption text-gray-500">
                                            Zone 2 (Rayong Plant)
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Mr. Prasert Sakul
                                        </div>
                                        <div class="font-mono tabular-nums text-[11px] text-gray-500">
                                            p-sakul@sews.co.th
                                        </div>
                                        <div class="font-caption text-[11px] text-gray-500">
                                            +66 38-892-400
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-semibold text-black">
                                            K. Apinya
                                        </div>
                                        <div class="font-caption text-gray-500">
                                            Dept 3 (Electrical)
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-right font-mono tabular-nums">
                                        <div class="font-bold text-[#1b5e20]">
                                            99.1% OTD
                                        </div>
                                        <div class="text-[11px] text-gray-500">
                                            Defect: 0.01% PPM
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-center">
                                        <span
                                            class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] font-label-sm text-[10px] uppercase px-2 py-0.5">Active</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top text-right">
                                        <div class="flex flex-col items-end gap-1">
                                            <button
                                                class="text-[#005cba] hover:text-[#004d99] font-semibold text-[12px] inline-flex items-center gap-0.5"
                                                type="button">
                                                <span>View Profile</span>
                                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </button>
                                            <a class="text-[11px] text-gray-500 hover:text-black" href="#">View Open
                                                POs (19)</a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Vendor 6: Eastern Precision Casting -->
                                <tr class="hover:bg-[#f0f6ff] transition-colors">
                                    <td class="py-3 px-3.5 align-top">
                                        <span class="font-mono tabular-nums font-bold text-black block">V-671044-TH</span>
                                        <span class="font-caption text-[11px] text-gray-500">SAP: 103980</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top">
                                        <div class="font-semibold text-black">
                                            Eastern Precision Casting Co., Ltd.
                                        </div>
                                        <div class="text-[12px] text-gray-500">
                                            บริษัท อีสเทิร์น พรีซิชั่น แคสติ้ง
                                            จำกัด
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-[#005cba]">
                                            <span class="material-symbols-outlined text-[13px]">donut_large</span>
                                            <span>Traction Sheave Castings &
                                                Counterweight Blocks</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="inline-block bg-black text-white text-[10px] font-bold px-1.5 py-0.5 w-fit">TIER-1
                                                DIRECT</span>
                                            <span
                                                class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] text-[10px] font-bold px-1.5 py-0.5 w-fit">GRADE
                                                A CERTIFIED</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            WHA Eastern Seaboard 2
                                        </div>
                                        <div class="text-caption text-gray-500">
                                            Chonburi High-Temp Foundry
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Mr. Boonmee Inthira
                                        </div>
                                        <div class="font-mono tabular-nums text-[11px] text-gray-500">
                                            boonmee@epc-casting.co.th
                                        </div>
                                        <div class="font-caption text-[11px] text-gray-500">
                                            +66 38-955-112
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-semibold text-black">
                                            S. Narongrit
                                        </div>
                                        <div class="font-caption text-gray-500">
                                            Dept 4 (Foundry/Heavy)
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-right font-mono tabular-nums">
                                        <div class="font-bold text-[#1b5e20]">
                                            98.9% OTD
                                        </div>
                                        <div class="text-[11px] text-gray-500">
                                            Defect: 0.04% PPM
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-center">
                                        <span
                                            class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] font-label-sm text-[10px] uppercase px-2 py-0.5">Active</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top text-right">
                                        <div class="flex flex-col items-end gap-1">
                                            <button
                                                class="text-[#005cba] hover:text-[#004d99] font-semibold text-[12px] inline-flex items-center gap-0.5"
                                                type="button">
                                                <span>View Profile</span>
                                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </button>
                                            <a class="text-[11px] text-gray-500 hover:text-black" href="#">View Open
                                                POs (7)</a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Vendor 7: Nippon Sanso Gas & Metal -->
                                <tr class="hover:bg-[#f0f6ff] transition-colors">
                                    <td class="py-3 px-3.5 align-top">
                                        <span class="font-mono tabular-nums font-bold text-black block">V-399102-TH</span>
                                        <span class="font-caption text-[11px] text-gray-500">SAP: 107412</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top">
                                        <div class="font-semibold text-black">
                                            Nippon Sanso Gas & Metal Co.
                                            (Thailand)
                                        </div>
                                        <div class="text-[12px] text-gray-500">
                                            บริษัท นิปปอน ซันโซ แก๊ส แอนด์ เมทัล
                                            (ประเทศไทย) จำกัด
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-[#005cba]">
                                            <span class="material-symbols-outlined text-[13px]">view_column</span>
                                            <span>Precision Laser Cutting &
                                                Structural Tubular
                                                Profiles</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="inline-block bg-black text-white text-[10px] font-bold px-1.5 py-0.5 w-fit">TIER-1
                                                DIRECT</span>
                                            <span
                                                class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] text-[10px] font-bold px-1.5 py-0.5 w-fit">GRADE
                                                A CERTIFIED</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Amata City Chonburi
                                        </div>
                                        <div class="text-caption text-gray-500">
                                            Phase 7 (Laser Division)
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Mr. Kenji Sudo (工藤)
                                        </div>
                                        <div class="font-mono tabular-nums text-[11px] text-gray-500">
                                            kudo.k@nipponsanso.co.th
                                        </div>
                                        <div class="font-caption text-[11px] text-gray-500">
                                            +66 38-214-700
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-semibold text-black">
                                            P. Sukcharoen
                                        </div>
                                        <div class="font-caption text-gray-500">
                                            Dept 2 (Machining)
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-right font-mono tabular-nums">
                                        <div class="font-bold text-[#1b5e20]">
                                            99.8% OTD
                                        </div>
                                        <div class="text-[11px] text-gray-500">
                                            Defect: 0.00% PPM
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-center">
                                        <span
                                            class="inline-block bg-[#edf7ee] text-[#1b5e20] border border-[#a3d9a5] font-label-sm text-[10px] uppercase px-2 py-0.5">Active</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top text-right">
                                        <div class="flex flex-col items-end gap-1">
                                            <button
                                                class="text-[#005cba] hover:text-[#004d99] font-semibold text-[12px] inline-flex items-center gap-0.5"
                                                type="button">
                                                <span>View Profile</span>
                                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </button>
                                            <a class="text-[11px] text-gray-500 hover:text-black" href="#">View Open
                                                POs (26)</a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Vendor 8: Rayong Stamping & Tooling -->
                                <tr class="hover:bg-[#f0f6ff] transition-colors">
                                    <td class="py-3 px-3.5 align-top">
                                        <span class="font-mono tabular-nums font-bold text-black block">V-718290-TH</span>
                                        <span class="font-caption text-[11px] text-gray-500">SAP: 101899</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top">
                                        <div class="font-semibold text-black">
                                            Rayong Stamping & Tooling Co., Ltd.
                                        </div>
                                        <div class="text-[12px] text-gray-500">
                                            บริษัท ระยอง สแตมป์ปิ้ง แอนด์
                                            ทูลลิ่ง จำกัด
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1 mt-1 text-[11px] font-medium text-[#005cba]">
                                            <span class="material-symbols-outlined text-[13px]">sensor_door</span>
                                            <span>Door Header & Landing Sill
                                                Guide Plates</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="inline-block bg-[#e3e2e2] text-gray-700 text-[10px] font-bold px-1.5 py-0.5 w-fit">TIER-2
                                                SUB</span>
                                            <span
                                                class="inline-block bg-[#efeded] text-gray-700 border border-border-medium text-[10px] font-bold px-1.5 py-0.5 w-fit">GRADE
                                                B QUALIFIED</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Map Ta Phut, Rayong
                                        </div>
                                        <div class="text-caption text-gray-500">
                                            Industrial Estate Zone C
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-medium text-black">
                                            Ms. Piyaporn S.
                                        </div>
                                        <div class="font-mono tabular-nums text-[11px] text-gray-500">
                                            piyaporn@rst-rayong.com
                                        </div>
                                        <div class="font-caption text-[11px] text-gray-500">
                                            +66 38-684-901
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top">
                                        <div class="font-semibold text-black">
                                            P. Sukcharoen
                                        </div>
                                        <div class="font-caption text-gray-500">
                                            Dept 2 (Door Systems)
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-right font-mono tabular-nums">
                                        <div class="font-bold text-gray-700">
                                            97.4% OTD
                                        </div>
                                        <div class="text-[11px] text-gray-500">
                                            Defect: 0.12% PPM
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 align-top text-center">
                                        <span
                                            class="inline-block bg-[#fff8e6] text-[#8a5800] border border-[#f5c26b] font-label-sm text-[10px] uppercase px-2 py-0.5">Re-cert
                                            Due</span>
                                    </td>
                                    <td class="py-3 px-3.5 align-top text-right">
                                        <div class="flex flex-col items-end gap-1">
                                            <button
                                                class="text-[#005cba] hover:text-[#004d99] font-semibold text-[12px] inline-flex items-center gap-0.5"
                                                type="button">
                                                <span>View Profile</span>
                                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </button>
                                            <a class="text-[11px] text-gray-500 hover:text-black" href="#">View Open
                                                POs (5)</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination & Governance Master Statement -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 py-2">
                        <!-- Compliance Footnote -->
                        <div class="flex items-center gap-2 text-gray-500 font-caption text-caption max-w-xl">
                            <span class="material-symbols-outlined text-[#005cba] text-[16px] flex-shrink-0">gavel</span>
                            <span>
                                All listed vendors are governed under AMEC
                                Master Procurement Agreement (MPA) and ISO
                                9001:2015 / ISO 14001 certified procurement
                                governance. Direct inquiries to Procurement
                                Dept. Chonburi Plant.
                            </span>
                        </div>
                        <!-- Pagination Controls (Sharp Industrial Style) -->
                        <div class="flex items-center gap-1 font-mono tabular-nums text-caption">
                            <button
                                class="w-8 h-8 flex items-center justify-center bg-white border border-border-medium text-gray-500 hover:bg-gray-50 transition-colors"
                                disabled="" type="button">
                                <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center bg-black text-white font-bold"
                                type="button">
                                1
                            </button>
                            <button
                                class="w-8 h-8 flex items-center justify-center bg-white border border-border-medium text-gray-700 hover:bg-gray-50 transition-colors"
                                type="button">
                                2
                            </button>
                            <button
                                class="w-8 h-8 flex items-center justify-center bg-white border border-border-medium text-gray-700 hover:bg-gray-50 transition-colors"
                                type="button">
                                3
                            </button>
                            <span class="px-1 text-gray-500 font-bold">...</span>
                            <button
                                class="w-8 h-8 flex items-center justify-center bg-white border border-border-medium text-gray-700 hover:bg-gray-50 transition-colors"
                                type="button">
                                15
                            </button>
                            <button
                                class="w-8 h-8 flex items-center justify-center bg-white border border-border-medium text-gray-700 hover:bg-gray-50 transition-colors"
                                type="button">
                                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                            </button>
                        </div>
                    </div>
                    <!-- Fast Access Quick Panels (Two Cards Mosaic) -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-2">
                        <!-- Panel 1: Fast Procurement Audit Feed -->
                        <div class="bg-white border border-border-light p-4 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between border-b border-border-light pb-2 mb-3">
                                    <span
                                        class="font-label-sm text-caption uppercase tracking-wider text-gray-500">Upcoming
                                        On-Site AMEC Audits</span>
                                    <span class="font-caption text-caption text-[#005cba] font-semibold">Q1/2025
                                        Schedule</span>
                                </div>
                                <div class="flex flex-col gap-2 font-body-sm text-[12px]">
                                    <div
                                        class="flex items-center justify-between p-2 bg-white-subtle border-l-2 border-black">
                                        <div>
                                            <span class="font-bold text-black">Rayong Stamping & Tooling</span>
                                            <span class="text-gray-500 ml-2">(Door Guide Quality
                                                Audit)</span>
                                        </div>
                                        <span class="font-mono tabular-nums text-gray-500">18 Mar 2025</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between p-2 bg-white-subtle border-l-2 border-[#f5c26b]">
                                        <div>
                                            <span class="font-bold text-black">H.T. Sahakij Co., Ltd.</span>
                                            <span class="text-gray-500 ml-2">(Fastener Tensile Strength
                                                Verification)</span>
                                        </div>
                                        <span class="font-mono tabular-nums text-[#8a5800] font-bold">22 Mar 2025</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between p-2 bg-white-subtle border-l-2 border-[#005cba]">
                                        <div>
                                            <span class="font-bold text-black">Siam Precision
                                                Engineering</span>
                                            <span class="text-gray-500 ml-2">(Green Procurement Annual
                                                Review)</span>
                                        </div>
                                        <span class="font-mono tabular-nums text-gray-500">05 Apr 2025</span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="pt-3 mt-2 border-t border-border-light flex justify-between items-center text-caption">
                                <span class="text-gray-500">Lead Auditor: QA-AMEC Division 3</span>
                                <a class="text-[#005cba] font-semibold hover:underline" href="#">View Full Audit
                                    Calendar →</a>
                            </div>
                        </div>
                        <!-- Panel 2: Vendor Document Repositories & Specs -->
                        <div class="bg-white border border-border-light p-4 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between border-b border-border-light pb-2 mb-3">
                                    <span class="font-label-sm text-caption uppercase tracking-wider text-gray-500">AMEC
                                        Standard Procurement
                                        Guidelines</span>
                                    <span class="font-caption text-caption text-gray-500">Mandatory Standards</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[12px] font-body-sm">
                                    <div class="border border-border-light p-2.5 flex items-start gap-2 bg-white-subtle">
                                        <span
                                            class="material-symbols-outlined text-[#005cba] text-[20px]">description</span>
                                        <div>
                                            <div class="font-semibold text-black">
                                                AMEC-STD-004-REV7
                                            </div>
                                            <div class="text-caption text-gray-500">
                                                Sheet Metal Finishing &
                                                Tolerance
                                            </div>
                                            <a class="text-[#005cba] text-[11px] font-semibold hover:underline mt-1 inline-block"
                                                href="#">Download Specification</a>
                                        </div>
                                    </div>
                                    <div class="border border-border-light p-2.5 flex items-start gap-2 bg-white-subtle">
                                        <span
                                            class="material-symbols-outlined text-[#005cba] text-[20px]">verified_user</span>
                                        <div>
                                            <div class="font-semibold text-black">
                                                AMEC Green Standard v4
                                            </div>
                                            <div class="text-caption text-gray-500">
                                                RoHS / REACH Hazardous
                                                Substances
                                            </div>
                                            <a class="text-[#005cba] text-[11px] font-semibold hover:underline mt-1 inline-block"
                                                href="#">Download Guidelines</a>
                                        </div>
                                    </div>
                                    <div class="border border-border-light p-2.5 flex items-start gap-2 bg-white-subtle">
                                        <span
                                            class="material-symbols-outlined text-[#005cba] text-[20px]">fact_check</span>
                                        <div>
                                            <div class="font-semibold text-black">
                                                Thai Claim Form Slip (บข-01)
                                            </div>
                                            <div class="text-caption text-gray-500">
                                                Defect Dispute & Remediation
                                                Form
                                            </div>
                                            <a class="text-[#005cba] text-[11px] font-semibold hover:underline mt-1 inline-block"
                                                href="#">Download Blank Template</a>
                                        </div>
                                    </div>
                                    <div class="border border-border-light p-2.5 flex items-start gap-2 bg-white-subtle">
                                        <span
                                            class="material-symbols-outlined text-[#005cba] text-[20px]">local_shipping</span>
                                        <div>
                                            <div class="font-semibold text-black">
                                                ASN Logistics Protocol
                                            </div>
                                            <div class="text-caption text-gray-500">
                                                Chonburi Plant Gate 3 Delivery
                                                Guide
                                            </div>
                                            <a class="text-[#005cba] text-[11px] font-semibold hover:underline mt-1 inline-block"
                                                href="#">View Unloading Protocols</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="pt-3 mt-2 border-t border-border-light flex justify-between items-center text-caption">
                                <span class="text-gray-500">Last Updated: 15 Feb 2025</span>
                                <a class="text-[#005cba] font-semibold hover:underline" href="#">Access Full
                                    Documentation Vault →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/vendors.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
