<!-- Tab 2: Financial, Accounting & ERP (AS400) Controls (Read-Only) -->
<div id="tab-financial" role="tabpanel"
    class="vendor-detail-panel tab-content hidden! p-space-lg space-y-space-lg bg-base-100">

    <!-- Block 1: Settlement, Currency & Governance Controls -->
    <div class="border border-base-300">
        <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-primary"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    Settlement &amp; Currency Controls (เงื่อนไขการชำระเงินและสกุลเงิน)
                </h2>
            </div>
            <span class="font-mono text-[11px] text-mute uppercase">AP / AS400 Master</span>
        </div>

        <div class="p-space-md grid grid-cols-1 md:grid-cols-4 gap-space-md">
            <!-- Currency Code (Locked after Approval) -->
            <div class="space-y-1">
                <div class="flex items-center justify-between gap-1">
                    <span class="text-xs uppercase font-bold text-mute">Currency Code</span>
                    <span class="badge badge-xs badge-error font-mono font-bold gap-0.5">
                        <span class="material-symbols-outlined text-[11px]">lock</span>
                        LOCKED
                    </span>
                </div>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center justify-between">
                    <p id="view-CURCODE" class="text-sm font-mono font-bold text-primary">-</p>
                    <span class="text-[10px] text-mute font-mono">IMMUTABLE</span>
                </div>
            </div>

            <!-- Terms Code -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Terms Code (Payment Term)</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-TERMCODE" class="text-sm font-mono font-semibold text-primary">-</p>
                </div>
            </div>

            <!-- Trade Term / Ship-to -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Trade Term / Ship-to</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-TRADE_CODE" class="text-sm font-mono font-medium text-primary">-</p>
                </div>
            </div>

            <!-- Vendor Type (FIN Controlled) -->
            <div class="space-y-1">
                <div class="flex items-center justify-between gap-1">
                    <span class="text-xs uppercase font-bold text-mute">Vendor Type</span>
                    <span class="badge badge-xs badge-info font-mono font-bold">FIN OWNED</span>
                </div>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VTYPE" class="text-sm font-mono font-semibold text-primary">-</p>
                </div>
            </div>

            <!-- Pay to Vendor -->
            <div class="space-y-1 md:col-span-2">
                <span class="block text-xs uppercase font-bold text-mute">Pay to Vendor</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VPAYTO" class="text-sm font-medium text-primary">-</p>
                </div>
            </div>

            <!-- 1099 Vendor -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">1099 Vendor (PO Origin)</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-V1099" class="text-sm font-mono font-medium text-primary">-</p>
                </div>
            </div>

            <!-- Hold / One-Time Flags -->
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Hold / One-Time Flags</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center gap-2">
                    <span class="text-xs text-mute">Hold:</span>
                    <span id="view-HOLD_VENDOR" class="badge badge-xs badge-ghost font-mono font-bold">N</span>
                    <span class="text-xs text-mute ml-2">1-Time:</span>
                    <span id="view-V1TIME" class="badge badge-xs badge-ghost font-mono font-bold">N</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Block 2: Bank Account Information -->
    <div class="border border-base-300">
        <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-secondary"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    Bank Account Details (ข้อมูลบัญชีธนาคาร)
                </h2>
            </div>
            <span class="font-mono text-[11px] text-mute uppercase">Remittance</span>
        </div>

        <div class="p-space-md grid grid-cols-1 md:grid-cols-3 gap-space-md">
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Bank Name</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-BANKNAME" class="text-sm font-semibold text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Branch Name</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-BRANCH" class="text-sm font-medium text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-xs uppercase font-bold text-mute">Account No.</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-ACCNUMBER" class="text-sm font-mono font-bold text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1 md:col-span-3">
                <span class="block text-xs uppercase font-bold text-mute">Bank Address</span>
                <div class="min-h-9.5 px-3 py-2 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-BANKADDR" class="text-sm font-medium text-primary">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Block 3: AS400 / Accounting Technical Parameters -->
    <div class="border border-base-300">
        <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-primary"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    AS400 / Accounting Technical Parameters (ข้อมูลควบคุมทางบัญชี)
                </h2>
            </div>
            <span class="font-mono text-[11px] text-mute uppercase">Payment Type Removed Per FIN</span>
        </div>

        <div class="p-space-md grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-space-sm">
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">Company</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-COMPANY" class="text-xs font-mono font-semibold text-primary">1</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">Days to Clear</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-DAYS_TO_CLEAR" class="text-xs font-mono text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">G/L Account</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-GL_ACCOUNT" class="text-xs font-mono text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">Price Include Tax</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-PRICE_INC_TAX" class="text-xs font-mono text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">Tax Code</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-TAX_CODE" class="text-xs font-mono text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">Tax ID (AP)</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-AP_TAX_ID" class="text-xs font-mono text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">Generate Inv. No.</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-GEN_INV_NO" class="text-xs font-mono text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">Next Inv. No.</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-NEXT_INV_NO" class="text-xs font-mono text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">Alpha Search Key</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-VNALPH" class="text-xs font-mono text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">S.Security Code</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-SSECURITY_CODE" class="text-xs font-mono text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">Fiscal Code</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-FISCAL_CODE" class="text-xs font-mono text-primary">-</p>
                </div>
            </div>
            <div class="space-y-1">
                <span class="block text-[11px] uppercase font-bold text-mute">Firm / Material Commi</span>
                <div class="min-h-9 px-3 py-1.5 bg-base-200 border border-base-300 flex items-center">
                    <p id="view-COMMI" class="text-xs font-mono text-primary">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Block 4: Multi-Currency / Related Vendor Codes Table -->
    <div class="border border-base-300">
        <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-accent"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    Vendor Codes &amp; Settlement Terms (รหัสคู่ค้าและสกุลเงินที่ผูกอยู่)
                </h2>
            </div>
            <span class="font-mono text-[11px] text-mute uppercase">Multi-Currency Mapping</span>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-sm w-full border-collapse text-left">
                <thead>
                    <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                        <th>Vendor Code</th>
                        <th>Currency</th>
                        <th>Payment Term</th>
                        <th class="text-center w-32">Status</th>
                    </tr>
                </thead>
                <tbody id="view-vendor-code-container" class="divide-y divide-base-200 text-xs">
                    <tr>
                        <td colspan="4" class="py-6 text-center text-mute italic">Loading vendor codes...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
