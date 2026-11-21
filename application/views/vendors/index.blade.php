@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen mx-auto flex flex-col gap-space-md">
        @include('layouts/breadcrumb')
        @include('vendors/index/header')
        @include('vendors/index/kpi')
        @include('vendors/index/filters')
        @include('vendors/index/table')
        {{-- @include('vendors/index/footer') --}}
    </main>

    @include('vendors/index/drawer')
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/vendors.js?ver={{ $GLOBALS['version'] }}"></script>
    {{-- <script>
        (function() {
            var activeTab = "";

            function applyVendorFilters() {
                var searchInput = document.getElementById("vendorSearchInput");
                var tierFilter = document.getElementById("vendorTierFilter");
                var commodityFilter = document.getElementById("vendorCommodityFilter");
                var gradeFilter = document.getElementById("vendorGradeFilter");

                var query = (searchInput ? searchInput.value : "").toLowerCase().trim();
                var tier = tierFilter ? tierFilter.value : "";
                var commodity = commodityFilter ? commodityFilter.value : "";
                var grade = gradeFilter ? gradeFilter.value : "";
                var rows = document.querySelectorAll("#vendorTableBody .vendor-row");
                var visible = 0;

                rows.forEach(function(row) {
                    var matchTab = !activeTab ||
                        row.dataset.status === activeTab ||
                        (activeTab === "TIER-1" && (row.dataset.tier === "TIER-1" || row.dataset.tier ===
                            "TIER-1-GLOBAL")) ||
                        (activeTab === "TIER-2" && row.dataset.tier === "TIER-2");
                    var matchTier = !tier || row.dataset.tier === tier;
                    var matchCommodity = !commodity || row.dataset.commodity === commodity;
                    var matchGrade = !grade || row.dataset.grade === grade;
                    var matchSearch = !query || row.textContent.toLowerCase().indexOf(query) !== -1;

                    var show = matchTab && matchTier && matchCommodity && matchGrade && matchSearch;
                    row.classList.toggle("hidden", !show);
                    if (show) visible++;
                });

                var summary = document.getElementById("activeViewSummary");
                if (summary) summary.textContent = "Showing " + visible + " of " + rows.length + " Vendor records";
            }

            document.querySelectorAll(".vendor-status-tab").forEach(function(tab) {
                tab.addEventListener("click", function() {
                    activeTab = tab.dataset.status || "";
                    document.querySelectorAll(".vendor-status-tab").forEach(function(btn) {
                        var isActive = btn === tab;
                        btn.classList.toggle("text-primary", isActive);
                        btn.classList.toggle("font-bold", isActive);
                        btn.classList.toggle("border-primary", isActive);
                        btn.classList.toggle("text-mute", !isActive);
                        btn.classList.toggle("font-semibold", !isActive);
                        btn.classList.toggle("border-transparent", !isActive);
                    });
                    applyVendorFilters();
                });
            });

            ["vendorSearchInput", "vendorTierFilter", "vendorCommodityFilter", "vendorGradeFilter"].forEach(function(
                id) {
                var el = document.getElementById(id);
                if (el) {
                    el.addEventListener("input", applyVendorFilters);
                    el.addEventListener("change", applyVendorFilters);
                }
            });

            var resetBtn = document.getElementById("vendorFilterReset");
            if (resetBtn) {
                resetBtn.addEventListener("click", function() {
                    ["vendorSearchInput", "vendorTierFilter", "vendorCommodityFilter", "vendorGradeFilter"]
                    .forEach(function(id) {
                        var el = document.getElementById(id);
                        if (el) el.value = "";
                    });
                    activeTab = "";
                    var firstTab = document.querySelector('.vendor-status-tab[data-status=""]');
                    if (firstTab) firstTab.click();
                });
            }

            var selectAllBtn = document.getElementById("selectAllPageBtn");
            if (selectAllBtn) {
                selectAllBtn.addEventListener("click", function() {
                    var master = document.getElementById("headerCheckbox");
                    if (master) {
                        master.checked = !master.checked;
                        window.toggleSelectAll(master);
                    }
                });
            }

            window.updateSelectedCount = function() {
                var boxes = document.querySelectorAll("#vendorTableBody .row-select");
                var checked = document.querySelectorAll("#vendorTableBody .row-select:checked");
                var counter = document.getElementById("selectedCounter");
                var master = document.getElementById("headerCheckbox");
                if (counter) counter.textContent = checked.length + " items";
                if (master) {
                    master.checked = boxes.length > 0 && checked.length === boxes.length;
                    master.indeterminate = checked.length > 0 && checked.length < boxes.length;
                }
            };

            window.toggleSelectAll = function(master) {
                document.querySelectorAll("#vendorTableBody .row-select").forEach(function(cb) {
                    cb.checked = Boolean(master && master.checked);
                });
                window.updateSelectedCount();
            };

            window.openVendorDetail = function(code, name, tier, grade, status, location, contact, email, phone, otd,
                ppm) {
                var setText = function(id, val) {
                    var el = document.getElementById(id);
                    if (el && val !== undefined) el.textContent = val;
                };
                setText("drawerVendorCode", code);
                setText("drawerVendorName", name + " • Mitsubishi Elevator Asia Co., Ltd. (AMEC)");
                setText("drawerVendorTier", tier);
                setText("drawerVendorGrade", grade);
                setText("drawerVendorLocation", location);
                setText("drawerVendorContact", contact);
                setText("drawerVendorEmail", email);
                setText("drawerVendorPhone", phone);
                setText("drawerVendorOtd", otd);
                setText("drawerVendorPpm", ppm);

                var statusBadge = document.getElementById("drawerVendorStatus");
                var alertBox = document.getElementById("drawerVendorAlert");
                if (statusBadge) {
                    statusBadge.textContent = status.replace("_", " ");
                    statusBadge.className = "badge badge-xs font-mono font-bold " +
                        (status === "ACTIVE" ? "badge-success" : (status === "AUDIT_PENDING" ? "badge-error" :
                            "badge-warning"));
                }
                if (alertBox) {
                    var needsAttention = status !== "ACTIVE";
                    alertBox.classList.toggle("hidden", !needsAttention);
                    alertBox.classList.toggle("flex", needsAttention);
                }

                var drawer = document.getElementById("vendorDetailDrawer");
                if (drawer) drawer.classList.remove("hidden");
            };

            window.closeVendorDetail = function() {
                var drawer = document.getElementById("vendorDetailDrawer");
                if (drawer) drawer.classList.add("hidden");
            };
        })();
    </script> --}}
@endsection
