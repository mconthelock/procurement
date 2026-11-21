<!-- Tab 4: Vendor Evaluation & Compliance (PUR-EVA) (Read-Only) -->
<div id="tab-evaluation" role="tabpanel"
    class="vendor-detail-panel tab-content hidden! p-space-lg space-y-space-lg bg-base-100">

    <!-- Row 1: Evaluation Judgement & Management Systems / Compliance -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg">
        <!-- Latest Evaluation Summary -->
        <div class="border border-base-300 flex flex-col">
            <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-primary"></span>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                        Latest Evaluation Judgement (ผลการประเมินล่าสุด)
                    </h2>
                </div>
                <span id="eva-form-badge" class="badge badge-xs badge-primary font-mono font-bold">EVA: -</span>
            </div>

            <div class="p-space-md grid grid-cols-2 gap-space-sm text-xs">
                <div class="p-3 bg-base-200 border border-base-300">
                    <span class="block text-[11px] uppercase font-bold text-mute">Final Grade (Manager)</span>
                    <div id="eva-mjudgement" class="mt-1 text-2xl font-bold font-mono text-primary">-</div>
                    <span id="eva-judgement-auto" class="text-[11px] text-mute font-mono">Auto Calc: -</span>
                </div>
                <div class="p-3 bg-base-200 border border-base-300">
                    <span class="block text-[11px] uppercase font-bold text-mute">Purchase Level &amp; Amount</span>
                    <div id="eva-pur-level" class="mt-1 text-lg font-bold font-mono text-primary">-</div>
                    <span id="eva-amount" class="text-[11px] text-secondary font-mono">0.00 THB (FY -)</span>
                </div>
                <div class="p-3 bg-base-200 border border-base-300">
                    <span class="block text-[11px] uppercase font-bold text-mute">Operation Type</span>
                    <div id="eva-operation" class="mt-1 font-semibold text-primary">-</div>
                </div>
                <div class="p-3 bg-base-200 border border-base-300">
                    <span class="block text-[11px] uppercase font-bold text-mute">Reference NVF No.</span>
                    <div id="eva-nvfno" class="mt-1 font-mono font-semibold text-primary">-</div>
                </div>
            </div>
        </div>

        <!-- Management Systems & ISO14001 / Compliance -->
        <div class="border border-base-300 flex flex-col">
            <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-accent"></span>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                        Certifications, ISO &amp; Export Compliance
                    </h2>
                </div>
                <span class="font-mono text-[11px] text-mute uppercase">AMEC-5070 / 6000</span>
            </div>

            <div class="p-space-md space-y-2 text-xs">
                <div class="flex items-center justify-between py-1.5 border-b border-base-200">
                    <span class="font-bold text-secondary">Quality Management (ISO9001)</span>
                    <span id="eva-qm" class="font-mono text-primary">-</span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-base-200">
                    <span class="font-bold text-secondary">Environmental (ISO14001/2015)</span>
                    <span id="eva-env" class="font-mono text-primary">-</span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-base-200">
                    <span class="font-bold text-secondary">CSR Management</span>
                    <span id="eva-csr" class="font-mono text-primary">-</span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-base-200">
                    <span class="font-bold text-secondary">Labor Union</span>
                    <span id="eva-labor" class="font-mono text-primary">-</span>
                </div>
                <div class="pt-1">
                    <span class="block text-[11px] uppercase font-bold text-mute mb-1">Compliance Checklist (Export / UNSC / Terms)</span>
                    <div id="eva-compliance-tags" class="flex flex-wrap gap-1.5">
                        <span class="text-mute italic">No compliance data recorded.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Evaluation Score Breakdown (PUREVA_SCORE) -->
    <div class="border border-base-300">
        <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-primary"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    Evaluation Score Breakdown (คะแนนประเมินรายหัวข้อ)
                </h2>
            </div>
            <span class="font-mono text-[11px] text-mute uppercase">Max 25 pts / Topic</span>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-sm w-full border-collapse text-left">
                <thead>
                    <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                        <th>Evaluation Topic</th>
                        <th>Assessment Criteria / Check Point</th>
                        <th class="text-center w-24">Level</th>
                        <th class="text-right w-28">Score</th>
                        <th class="w-40">Progress</th>
                    </tr>
                </thead>
                <tbody id="eva-score-container" class="divide-y divide-base-200 text-xs">
                    <tr>
                        <td colspan="5" class="py-6 text-center text-mute italic">
                            No evaluation score records available.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Row 3: Corporate Profile, 3-Year Financial Trend & Relations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg">
        <!-- Company Profile & 3-Year Financials -->
        <div class="border border-base-300 flex flex-col">
            <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-secondary"></span>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                        Corporate Profile &amp; 3-Year Financials
                    </h2>
                </div>
                <span class="font-mono text-[11px] text-mute uppercase">DBD / Financial Statement</span>
            </div>
            <div class="p-space-md space-y-space-md text-xs">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-space-sm">
                    <div class="p-2.5 bg-base-200 border border-base-300">
                        <span class="block text-[10px] uppercase font-bold text-mute">Registered Capital</span>
                        <span id="eva-capital" class="font-mono font-bold text-primary">-</span>
                    </div>
                    <div class="p-2.5 bg-base-200 border border-base-300">
                        <span class="block text-[10px] uppercase font-bold text-mute">Established</span>
                        <span id="eva-established" class="font-mono font-bold text-primary">-</span>
                    </div>
                    <div class="p-2.5 bg-base-200 border border-base-300">
                        <span class="block text-[10px] uppercase font-bold text-mute">Employees (D/I)</span>
                        <span id="eva-employees" class="font-mono font-bold text-primary">-</span>
                    </div>
                </div>

                <div class="overflow-x-auto border border-base-300">
                    <table class="table table-xs w-full border-collapse text-left">
                        <thead>
                            <tr class="bg-primary text-white text-[11px] uppercase tracking-wider">
                                <th>Year</th>
                                <th class="text-right">Turnover (THB)</th>
                                <th class="text-right">Net Profit / Loss (THB)</th>
                            </tr>
                        </thead>
                        <tbody id="eva-financials-container" class="divide-y divide-base-200 text-xs">
                            <tr>
                                <td colspan="3" class="py-4 text-center text-mute italic">No 3-year financial data.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Business Relations (Shareholders / Customers / Suppliers / Products) -->
        <div class="border border-base-300 flex flex-col">
            <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-primary"></span>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                        Shareholders, Customers, Suppliers &amp; Products
                    </h2>
                </div>
                <span class="font-mono text-[11px] text-mute uppercase">PUREVA_VENDOR_RELATION</span>
            </div>
            <div class="p-space-md grid grid-cols-1 sm:grid-cols-2 gap-space-sm text-xs">
                <div class="p-3 bg-base-200 border border-base-300">
                    <span class="block text-[11px] uppercase font-bold text-primary mb-1.5">Shareholders (%)</span>
                    <div id="eva-rel-shareholders" class="space-y-1 text-secondary">
                        <span class="text-mute italic">-</span>
                    </div>
                </div>
                <div class="p-3 bg-base-200 border border-base-300">
                    <span class="block text-[11px] uppercase font-bold text-primary mb-1.5">Main Customers (%)</span>
                    <div id="eva-rel-customers" class="space-y-1 text-secondary">
                        <span class="text-mute italic">-</span>
                    </div>
                </div>
                <div class="p-3 bg-base-200 border border-base-300">
                    <span class="block text-[11px] uppercase font-bold text-primary mb-1.5">Main Material Suppliers (%)</span>
                    <div id="eva-rel-suppliers" class="space-y-1 text-secondary">
                        <span class="text-mute italic">-</span>
                    </div>
                </div>
                <div class="p-3 bg-base-200 border border-base-300">
                    <span class="block text-[11px] uppercase font-bold text-primary mb-1.5">Main Products (%)</span>
                    <div id="eva-rel-products" class="space-y-1 text-secondary">
                        <span class="text-mute italic">-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
