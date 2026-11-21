<!-- Section 2: Precision Search & Query Criteria Panel -->
<form id="poReportSearchForm"
    class="bg-base-100 shadow-sm border border-base-300 border-t-4 border-t-primary flex flex-col">
    <!-- Panel Header -->
    <div
        class="px-space-md py-3 bg-base-200 border-b border-base-300 flex flex-wrap items-center justify-between gap-space-sm">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-primary">manage_search</span>
            <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                Search Criteria (เงื่อนไขการค้นหาข้อมูลใบสั่งซื้อ)
            </h2>
            <span id="active-filter-badge" class="badge badge-xs badge-primary font-mono font-bold">0 ACTIVE</span>
        </div>

        <!-- View Mode Switcher -->
        <div class="flex items-center gap-2 text-xs">
            <span class="text-mute font-semibold uppercase">Report Level:</span>
            <div class="join" role="group" aria-label="Report display level">
                <button type="button" data-mode="HEADER"
                    class="js-report-mode join-item btn btn-xs btn-primary font-bold">
                    PO Header
                </button>
                <button type="button" data-mode="LINE_ITEM"
                    class="js-report-mode join-item btn btn-xs btn-outline border-base-300 bg-white font-semibold">
                    Line-Item Detail
                </button>
            </div>
        </div>
    </div>

    <!-- Criteria Grid -->
    <div class="p-space-md space-y-space-md">
        <!-- Row 1: Primary Identifiers -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-space-sm">
            <fieldset class="fieldset p-0 gap-1 lg:col-span-3">
                <label for="rpt-po-no" class="label p-0 text-[11px] uppercase font-bold text-secondary">
                    PO Number / ASN
                </label>
                <input id="rpt-po-no" type="text" placeholder="e.g. PO-2026-0892 or ASN-..."
                    class="input input-sm w-full h-9.5 bg-base-100 border border-base-300 font-mono text-xs focus:border-accent focus:outline-none" />
            </fieldset>

            <fieldset class="fieldset p-0 gap-1 lg:col-span-3">
                <label for="rpt-part-no" class="label p-0 text-[11px] uppercase font-bold text-secondary">
                    Part No. / Description / ECN
                </label>
                <input id="rpt-part-no" type="text" placeholder="e.g. ELV-FRAME-SS304, ECN-..."
                    class="input input-sm w-full h-9.5 bg-base-100 border border-base-300 font-mono text-xs focus:border-accent focus:outline-none" />
            </fieldset>

            <fieldset class="fieldset p-0 gap-1 lg:col-span-3">
                <label for="rpt-vendor" class="label p-0 text-[11px] uppercase font-bold text-secondary">
                    Supplier / Vendor
                </label>
                <select id="rpt-vendor"
                    class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                    <option value="">All Suppliers / Vendors</option>
                </select>
            </fieldset>

            <fieldset class="fieldset p-0 gap-1 lg:col-span-3">
                <label for="rpt-plant" class="label p-0 text-[11px] uppercase font-bold text-secondary">
                    Receiving Plant
                </label>
                <select id="rpt-plant"
                    class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                    <option value="">All Delivery Plants</option>
                </select>
            </fieldset>
        </div>

        <!-- Row 2: Dates, Status, Priority & Buyer -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-space-sm">
            <fieldset class="fieldset p-0 gap-1 lg:col-span-2">
                <label for="rpt-date-type" class="label p-0 text-[11px] uppercase font-bold text-secondary">
                    Date Basis
                </label>
                <select id="rpt-date-type"
                    class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                    <option value="ISSUE_DATE">PO Issue Date</option>
                    <option value="TARGET_DELIVERY">Target Delivery Date</option>
                </select>
            </fieldset>

            <fieldset class="fieldset p-0 gap-1 lg:col-span-2">
                <label for="rpt-date-from" class="label p-0 text-[11px] uppercase font-bold text-secondary">
                    Date From
                </label>
                <input id="rpt-date-from" type="date"
                    class="input input-sm w-full h-9.5 bg-base-100 border border-base-300 font-mono text-xs focus:border-accent focus:outline-none" />
            </fieldset>

            <fieldset class="fieldset p-0 gap-1 lg:col-span-2">
                <label for="rpt-date-to" class="label p-0 text-[11px] uppercase font-bold text-secondary">
                    Date To
                </label>
                <input id="rpt-date-to" type="date"
                    class="input input-sm w-full h-9.5 bg-base-100 border border-base-300 font-mono text-xs focus:border-accent focus:outline-none" />
            </fieldset>

            <fieldset class="fieldset p-0 gap-1 lg:col-span-2">
                <label for="rpt-status" class="label p-0 text-[11px] uppercase font-bold text-secondary">
                    PO Status
                </label>
                <select id="rpt-status"
                    class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                    <option value="">All Statuses</option>
                    <option value="AWAITING_CONFIRMATION">Awaiting Confirmation</option>
                    <option value="IN_PRODUCTION">In Production</option>
                    <option value="READY_TO_SHIP">Ready to Ship</option>
                    <option value="IN_TRANSIT">In Transit (ASN)</option>
                    <option value="DELIVERED">Delivered</option>
                </select>
            </fieldset>

            <fieldset class="fieldset p-0 gap-1 lg:col-span-2">
                <label for="rpt-priority" class="label p-0 text-[11px] uppercase font-bold text-secondary">
                    Priority Level
                </label>
                <select id="rpt-priority"
                    class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                    <option value="">All Priorities</option>
                    <option value="URGENT">Urgent &lt; 24h</option>
                    <option value="EXPEDITED">Expedited</option>
                    <option value="NORMAL">Standard</option>
                </select>
            </fieldset>

            <fieldset class="fieldset p-0 gap-1 lg:col-span-2">
                <label for="rpt-buyer" class="label p-0 text-[11px] uppercase font-bold text-secondary">
                    AMEC Buyer
                </label>
                <select id="rpt-buyer"
                    class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                    <option value="">All Buyers</option>
                </select>
            </fieldset>
        </div>
    </div>

    <!-- Query Action Bar -->
    <div
        class="px-space-md py-3 bg-base-200 border-t border-base-300 flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
        <div class="flex flex-wrap items-center gap-1.5 text-xs">
            <span class="text-mute font-semibold mr-1">Quick Range:</span>
            <button type="button" data-preset="ALL"
                class="js-date-preset btn btn-xs btn-outline border-base-300 bg-white font-mono">
                All Dates
            </button>
            <button type="button" data-preset="THIS_MONTH"
                class="js-date-preset btn btn-xs btn-outline border-base-300 bg-white font-mono">
                This Month
            </button>
            <button type="button" data-preset="LAST_30"
                class="js-date-preset btn btn-xs btn-outline border-base-300 bg-white font-mono">
                Last 30 Days
            </button>
            <button type="button" data-preset="NEXT_7"
                class="js-date-preset btn btn-xs btn-outline border-base-300 bg-white font-mono">
                Due Next 7 Days
            </button>
        </div>

        <div class="flex items-center gap-space-sm shrink-0">
            <button type="button" id="rpt-reset-btn"
                class="btn btn-sm btn-outline border-primary bg-white text-primary gap-1.5">
                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                <span>Reset</span>
            </button>
            <button type="submit" id="rpt-search-btn" class="btn btn-sm btn-primary font-bold gap-1.5">
                <span class="material-symbols-outlined text-[18px]">search</span>
                <span>Search Report</span>
            </button>
        </div>
    </div>
</form>
