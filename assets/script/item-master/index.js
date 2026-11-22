import "@amec/webasset/css/dataTable.min.css";
import { createTable } from "@amec/webasset/dataTable";
import { defaultExcel, exportExcel } from "@amec/webasset/excel";
import { showLoader } from "@amec/webasset/preloader";
import { showErrorMessage, showMessage } from "@amec/webasset/utils";
import { tableOpt, escapeHtml, escapeAttribute } from "../utils.js";
import {
	getItemMasterServerSide,
	getItemPlanners,
	getOriginCountries,
	getOriginBulkList,
} from "../service/index.js";
import {
	SAMPLE_IIM_ITEMS,
	getItemTypeMeta,
	isItemActive,
	formatNumber,
	formatCost,
	normalizeIimRecord,
} from "./shared.js";
import { modalUpload } from "./modal-upload.js";

let table = null;
let activeTab = "ALL";
let currentPageRows = [];
let usingFallbackData = false;

function getDetailUrl(iprod) {
	const appEnv = $("#app-env").val() || process.env.APP_ENV || "";
	return `${appEnv}/ItemMaster/detail/${encodeURIComponent(iprod || "")}`;
}

function getTabFilterParams() {
	switch (activeTab) {
		case "IM":
			return { status: "IM", type: "" };
		case "IZ":
			return { status: "IZ", type: "" };
		case "TYPE_1":
			return { status: "", type: "1" };
		case "TYPE_23":
			return { status: "", type: "2,3" };
		case "TYPE_A":
			return { status: "", type: "A" };
		case "TYPE_BC":
			return { status: "", type: "B,C" };
		default:
			return { status: "", type: "" };
	}
}

function updateStats(rows, totalRecords) {
	const normalized = rows.map(normalizeIimRecord);
	const pageCount = normalized.length;
	const activeRows = normalized.filter((r) => isItemActive(r.IID));
	const inactiveRows = normalized.filter((r) => !isItemActive(r.IID));
	const bulkRows = normalized.filter((r) => String(r.IITYP) === "1");
	const jopRows = normalized.filter((r) => ["2", "3"].includes(String(r.IITYP)));
	const stockRows = normalized.filter(
		(r) => String(r.IITYP).toUpperCase() === "A",
	);
	const subconRows = normalized.filter((r) =>
		["B", "C"].includes(String(r.IITYP).toUpperCase()),
	);
	const lowStockRows = normalized.filter(
		(r) => Number(r.IMIN || 0) > 0 && Number(r.ONHAND || 0) < Number(r.IMIN || 0),
	);
	const originMapped = normalized.filter(
		(r) => String(r.COUNTRY || "").trim() !== "",
	);
	const stockValue = normalized.reduce(
		(acc, r) => acc + Number(r.ONHAND || 0) * Number(r.ISCST || 0),
		0,
	);

	const activePct = pageCount
		? Math.round((activeRows.length / pageCount) * 100)
		: 0;
	const originPct = pageCount
		? Math.round((originMapped.length / pageCount) * 100)
		: 0;

	$("#kpi-total-items").text(formatNumber(totalRecords ?? pageCount));
	$("#kpi-active-badge").text(`${activePct}% ACTIVE`);
	$("#kpi-active-count").text(formatNumber(activeRows.length));
	$("#kpi-inactive-count").text(formatNumber(inactiveRows.length));

	$("#kpi-bulk-count").text(formatNumber(bulkRows.length));
	$("#kpi-jop-count").text(formatNumber(jopRows.length));
	$("#kpi-stock-count").text(formatNumber(stockRows.length));
	$("#kpi-subcon-count").text(formatNumber(subconRows.length));

	$("#kpi-lowstock-count").text(formatNumber(lowStockRows.length));
	$("#kpi-stock-value").text(`฿${formatNumber(stockValue, 2)}`);

	$("#kpi-origin-pct").text(`${originPct}%`);
	$("#kpi-origin-missing").text(formatNumber(pageCount - originMapped.length));

	if (usingFallbackData) {
		const all = SAMPLE_IIM_ITEMS.map(normalizeIimRecord);
		$('[data-count="ALL"]').text(all.length);
		$('[data-count="IM"]').text(all.filter((r) => isItemActive(r.IID)).length);
		$('[data-count="IZ"]').text(all.filter((r) => !isItemActive(r.IID)).length);
		$('[data-count="TYPE_1"]').text(
			all.filter((r) => String(r.IITYP) === "1").length,
		);
		$('[data-count="TYPE_23"]').text(
			all.filter((r) => ["2", "3"].includes(String(r.IITYP))).length,
		);
		$('[data-count="TYPE_A"]').text(
			all.filter((r) => String(r.IITYP).toUpperCase() === "A").length,
		);
		$('[data-count="TYPE_BC"]').text(
			all.filter((r) => ["B", "C"].includes(String(r.IITYP).toUpperCase()))
				.length,
		);
	} else {
		$('[data-count="ALL"]').text(formatNumber(totalRecords ?? pageCount));
		$('[data-count="IM"]').text(formatNumber(activeRows.length));
		$('[data-count="IZ"]').text(formatNumber(inactiveRows.length));
		$('[data-count="TYPE_1"]').text(formatNumber(bulkRows.length));
		$('[data-count="TYPE_23"]').text(formatNumber(jopRows.length));
		$('[data-count="TYPE_A"]').text(formatNumber(stockRows.length));
		$('[data-count="TYPE_BC"]').text(formatNumber(subconRows.length));
	}
}

function filterFallbackRows() {
	const purcode = ($("#purcode").val() || "").trim().toLowerCase();
	const drawing = ($("#drawing").val() || "").trim().toLowerCase();
	const partname = ($("#partname").val() || "").trim().toLowerCase();
	const planner = ($("#planner").val() || "").trim().toLowerCase();
	const country = ($("#country").val() || "").trim().toLowerCase();
	const tabFilter = getTabFilterParams();

	return SAMPLE_IIM_ITEMS.map(normalizeIimRecord).filter((row) => {
		if (tabFilter.status && String(row.IID).toUpperCase() !== tabFilter.status) {
			return false;
		}
		if (tabFilter.type) {
			const types = tabFilter.type.split(",");
			if (!types.includes(String(row.IITYP).toUpperCase())) return false;
		}
		if (purcode && !String(row.IPROD || "").toLowerCase().includes(purcode)) {
			return false;
		}
		if (drawing && !String(row.IDRAW || "").toLowerCase().includes(drawing)) {
			return false;
		}
		if (
			partname &&
			!`${row.IDESC || ""} ${row.IDSCE || ""}`
				.toLowerCase()
				.includes(partname)
		) {
			return false;
		}
		if (
			planner &&
			String(row.IBUYC || row.PLANNER_CODE || "").toLowerCase() !== planner
		) {
			return false;
		}
		if (country && !String(row.COUNTRY || "").toLowerCase().includes(country)) {
			return false;
		}
		return true;
	});
}

function getColumns() {
	return [
		{
			data: "IPROD",
			name: "ITEM",
			title: "PURCODE / ITEM",
			width: "145px",
			render: (data, type, row) => {
				const code = row.IPROD || row.ITEM || "-";
				const iclas = row.ICLAS || row.CLASS || "-";
				if (type !== "display") return code;
				return `<div class="flex flex-col gap-0.5">
					<a href="${escapeAttribute(getDetailUrl(code))}" class="font-mono font-bold text-info hover:underline">${escapeHtml(code)}</a>
					<span class="text-[10px] font-mono text-mute">CLASS: ${escapeHtml(iclas)}</span>
				</div>`;
			},
		},
		{
			data: "IDRAW",
			name: "DRAW_FORMULA",
			title: "DRAWING / FORMULA",
			width: "145px",
			render: (data, type, row) => {
				const draw = row.IDRAW || row.DRAW_FORMULA || "-";
				const whs = row.IWHS || "-";
				if (type !== "display") return draw;
				return `<div class="flex flex-col gap-0.5">
					<span class="font-mono font-semibold text-primary text-nowrap">${escapeHtml(draw)}</span>
					<span class="text-[10px] font-mono text-mute">WHS: ${escapeHtml(whs)}</span>
				</div>`;
			},
		},
		{
			data: "IDESC",
			name: "PARTNAME",
			title: "PART DESCRIPTION",
			render: (data, type, row) => {
				const desc = row.IDESC || row.PARTNAME || "-";
				const extra = row.IDSCE || row.EXTRADESC || "";
				if (type !== "display") return desc;
				return `<div class="max-w-xs">
					<div class="font-semibold text-primary leading-snug">${escapeHtml(desc)}</div>
					${extra ? `<div class="text-[11px] text-mute truncate mt-0.5">${escapeHtml(extra)}</div>` : ""}
				</div>`;
			},
		},
		{
			data: "IITYP",
			name: "TYPE",
			title: "TYPE",
			width: "100px",
			render: (data, type, row) => {
				const meta = getItemTypeMeta(row.IITYP ?? row.TYPE);
				if (type !== "display") return meta.label;
				return `<span class="badge badge-xs ${meta.badge} font-mono font-bold uppercase">${escapeHtml(meta.label)}</span>`;
			},
		},
		{
			data: "ONHAND",
			name: "ONHAND",
			title: "ON-HAND / U/M",
			width: "110px",
			className: "text-right",
			render: (data, type, row) => {
				const qty = Number(row.ONHAND ?? row.IOPB ?? 0);
				const min = Number(row.IMIN ?? 0);
				const um = row.IUMS || row.UMSTOCK || "EA";
				const low = min > 0 && qty < min;
				if (type !== "display") return qty;
				return `<div class="font-mono text-right">
					<div class="font-bold ${low ? "text-error" : "text-primary"}">${formatNumber(qty)} <span class="text-[10px] font-normal text-mute">${escapeHtml(um)}</span></div>
					<div class="text-[10px] text-mute">Min: ${formatNumber(min)}</div>
				</div>`;
			},
		},
		{
			data: "ISCST",
			name: "STANDARD_COST",
			title: "STD COST",
			width: "105px",
			className: "text-right",
			render: (data, type, row) => {
				const cost = row.ISCST ?? row.STANDARD_COST ?? 0;
				if (type !== "display") return cost;
				return `<div class="font-mono text-right">
					<div class="font-bold text-primary">${formatCost(cost, 2)}</div>
					<div class="text-[10px] text-mute">LT: ${formatNumber(row.ILEAD ?? 0)}d</div>
				</div>`;
			},
		},
		{
			data: "COUNTRY",
			name: "COUNTRY",
			title: "ORIGIN / VENDOR",
			width: "135px",
			render: (data, type, row) => {
				const country = String(row.COUNTRY || "").trim();
				const vend = row.IVEND || row.VENDOR || "";
				if (type !== "display") return country;
				return `<div class="flex flex-col gap-0.5">
					${
						country
							? `<span class="font-mono font-semibold text-primary">${escapeHtml(country)}</span>`
							: `<span class="badge badge-xs badge-warning font-mono font-bold">MISSING COO</span>`
					}
					<span class="text-[10px] font-mono text-mute">VND: ${escapeHtml(vend || "-")}</span>
				</div>`;
			},
		},
		{
			data: "IBUYC",
			name: "PLANNER_CODE",
			title: "PLANNER",
			width: "120px",
			render: (data, type, row) => {
				const code = row.IBUYC || row.PLANNER_CODE || "-";
				const name = row.PLANNERNAME || "";
				if (type !== "display") return `${code} ${name}`;
				return `<div class="flex flex-col gap-0.5">
					<span class="font-mono font-bold text-primary">${escapeHtml(code)}</span>
					${name ? `<span class="text-[11px] text-mute truncate max-w-[115px]">${escapeHtml(name)}</span>` : ""}
				</div>`;
			},
		},
		{
			data: "IID",
			name: "STATUS",
			title: "STATUS",
			width: "85px",
			render: (data, type, row) => {
				const active = isItemActive(row.IID ?? row.STATUS);
				if (type !== "display") return active ? "IM" : "IZ";
				return active
					? `<span class="badge badge-xs badge-success font-mono font-bold uppercase">Active</span>`
					: `<span class="badge badge-xs badge-error font-mono font-bold uppercase">Inactive</span>`;
			},
		},
		{
			data: null,
			name: "ACTIONS",
			title: "ACTIONS",
			width: "90px",
			searchable: false,
			orderable: false,
			className: "text-center",
			render: (data, type, row) => {
				const code = row.IPROD || row.ITEM || "";
				return `<div class="flex flex-col gap-1 items-stretch">
					<a href="${escapeAttribute(getDetailUrl(code))}" class="btn btn-xs btn-primary gap-1">
						<span class="material-symbols-outlined text-[14px]">visibility</span>
						<span>Detail</span>
					</a>
				</div>`;
			},
		},
	];
}

async function initDataTable() {
	const opt = {
		...tableOpt,
		dom: '<"overflow-x-auto"t><"dt-footer-bar px-space-md py-3 bg-base-100 border-t border-base-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-mute"<"table-info"i><"table-page"p>>',
		columns: getColumns(),
		processing: true,
		serverSide: true,
		ordering: false,
		pageLength: 15,
		lengthMenu: [15, 25, 50, 100],
		ajax: async function (dtParams, callback) {
			try {
				showLoader();
				const tabFilter = getTabFilterParams();
				const enrichedParams = {
					...dtParams,
					order: [{ column: 0, dir: "asc", name: "ITEM" }],
					columns: (dtParams.columns || []).map((col) => {
						const next = { ...col, search: { ...(col.search || { value: "", regex: false }) } };
						if (col.name === "ITEM") next.search.value = $("#purcode").val() || "";
						if (col.name === "DRAW_FORMULA") next.search.value = $("#drawing").val() || "";
						if (col.name === "PARTNAME") next.search.value = $("#partname").val() || "";
						if (col.name === "PLANNER_CODE") next.search.value = $("#planner").val() || "";
						if (col.name === "COUNTRY") next.search.value = $("#country").val() || "";
						if (col.name === "STATUS") next.search.value = tabFilter.status;
						if (col.name === "TYPE") {
							next.search.value = tabFilter.type
								? tabFilter.type.split(",")
								: "";
						}
						return next;
					}),
				};

				const response = await getItemMasterServerSide(enrichedParams);
				if (!response || !Array.isArray(response.data)) {
					throw new Error("Invalid response from item master API");
				}
				usingFallbackData = false;
				$("#dataSourceBadge").addClass("hidden");

				const normalized = response.data.map(normalizeIimRecord);
				currentPageRows = normalized;
				updateStats(normalized, response.recordsFiltered ?? response.recordsTotal);
				$("#activeViewSummary").text(
					`${formatNumber(response.recordsFiltered ?? normalized.length)} matching items`,
				);

				callback({
					draw: dtParams.draw,
					recordsTotal: response.recordsTotal ?? normalized.length,
					recordsFiltered: response.recordsFiltered ?? normalized.length,
					data: normalized,
				});
			} catch (error) {
				console.warn("ItemMaster API unavailable, using sample IIM preview:", error);
				usingFallbackData = true;
				$("#dataSourceBadge").removeClass("hidden");

				const filtered = filterFallbackRows();
				const start = Number(dtParams.start || 0);
				const length = Number(dtParams.length || 15);
				const pageSlice = filtered.slice(start, start + length);
				currentPageRows = pageSlice;

				updateStats(filtered, filtered.length);
				$("#activeViewSummary").text(
					`${formatNumber(filtered.length)} items (Preview Sample)`,
				);

				callback({
					draw: dtParams.draw,
					recordsTotal: SAMPLE_IIM_ITEMS.length,
					recordsFiltered: filtered.length,
					data: pageSlice,
				});
			} finally {
				showLoader({ show: false });
			}
		},
	};

	table = await createTable(opt, { id: "table" });
}

async function populateFilters() {
	try {
		const [plannerRes, countryRes] = await Promise.allSettled([
			getItemPlanners(),
			getOriginCountries(),
		]);

		const $planner = $("#planner");
		const $country = $("#country");

		if (plannerRes.status === "fulfilled" && Array.isArray(plannerRes.value?.data)) {
			plannerRes.value.data.forEach((p) => {
				const code = p.K85M02 || "";
				const label = `${p.K85M04 || ""} ${p.K85M05 || ""} (${code})`.trim();
				$planner.append(
					`<option value="${escapeAttribute(code)}">${escapeHtml(label)}</option>`,
				);
			});
		} else {
			const seen = new Map();
			SAMPLE_IIM_ITEMS.forEach((i) => {
				if (i.IBUYC && !seen.has(i.IBUYC)) {
					seen.set(i.IBUYC, `${i.PLANNERNAME || i.IBUYC} (${i.IBUYC})`);
				}
			});
			seen.forEach((label, code) => {
				$planner.append(
					`<option value="${escapeAttribute(code)}">${escapeHtml(label)}</option>`,
				);
			});
		}

		if (countryRes.status === "fulfilled" && Array.isArray(countryRes.value?.data)) {
			countryRes.value.data.forEach((c) => {
				const val = c.COUNTRY || "";
				if (!val) return;
				$country.append(
					`<option value="${escapeAttribute(val)}">${escapeHtml(val)}</option>`,
				);
			});
		} else {
			const countries = [
				...new Set(
					SAMPLE_IIM_ITEMS.map((i) => i.COUNTRY).filter(Boolean),
				),
			];
			countries.forEach((c) => {
				$country.append(
					`<option value="${escapeAttribute(c)}">${escapeHtml(c)}</option>`,
				);
			});
		}
	} catch (error) {
		console.warn("Filter population warning:", error);
	} finally {
		$("#import-excel, #origin-bulk-list").prop("disabled", false);
	}
}

function bindEvents() {
	$(document).on("click", ".item-status-tab", function () {
		const target = $(this).data("filter-tab");
		if (!target || target === activeTab) return;
		activeTab = target;

		$(".item-status-tab")
			.removeClass("font-bold text-primary border-primary")
			.addClass("font-semibold text-mute border-transparent")
			.attr("aria-selected", "false");

		$(this)
			.removeClass("font-semibold text-mute border-transparent")
			.addClass("font-bold text-primary border-primary")
			.attr("aria-selected", "true");

		if (table) table.ajax.reload();
	});

	$(document).on("submit", "#form-filter", function (e) {
		e.preventDefault();
		if (table) table.ajax.reload();
	});

	$(document).on("change", "#planner, #country", function () {
		if (table) table.ajax.reload();
	});

	$(document).on("click", "#reset-filter", function () {
		$("#purcode, #drawing, #partname").val("");
		$("#planner, #country").val("");
		activeTab = "ALL";
		$(".item-status-tab")
			.removeClass("font-bold text-primary border-primary")
			.addClass("font-semibold text-mute border-transparent")
			.attr("aria-selected", "false");
		$('.item-status-tab[data-filter-tab="ALL"]')
			.removeClass("font-semibold text-mute border-transparent")
			.addClass("font-bold text-primary border-primary")
			.attr("aria-selected", "true");
		if (table) table.ajax.reload();
	});

	$(document).on("click", "#import-excel", function () {
		modalUpload.show(true);
	});

	$(document).on("click", "#origin-bulk-list", async function () {
		try {
			showLoader();
			const res = await getOriginBulkList();
			if (!res?.status) {
				throw new Error(res?.message || "Failed to load Origin BULK list");
			}
			const workbook = await defaultExcel({
				data: res.data,
				column: [
					{ key: "PLANNER", header: "Planner" },
					{ key: "BULK_CODE", header: "BULK Code" },
					{ key: "DRAWING", header: "DWG" },
					{ key: "PARTNAME", header: "Part Name" },
					{ key: "VENDOR", header: "Vendor" },
					{ key: "VENDOR_NAME", header: "Vendor Name" },
					{ key: "TRADING", header: "Trading" },
					{ key: "PROCESS", header: "Process" },
					{ key: "MANUFACTURER", header: "Manufacturer" },
					{ key: "COUNTRY", header: "Country of Origin" },
					{ key: "MFG_NAME", header: "Manufacturer Name" },
					{ key: "MFG_ADDRESS", header: "Manufacturer Address" },
				],
			});
			exportExcel(workbook, "Country_of_Origin_BULK_List.xlsx");
		} catch (error) {
			console.error("Origin Bulk List Error:", error);
			showErrorMessage(error.message);
		} finally {
			showLoader({ show: false });
		}
	});

	$(document).on("click", "#export-item-list", async function () {
		try {
			if (!currentPageRows.length) {
				showMessage("No item records available to export.", "warning");
				return;
			}
			showLoader();
			const workbook = await defaultExcel({
				data: currentPageRows.map((r) => ({
					IPROD: r.IPROD,
					IDRAW: r.IDRAW,
					IDESC: r.IDESC,
					ICLAS: r.ICLAS,
					IITYP: getItemTypeMeta(r.IITYP).label,
					IUMS: r.IUMS,
					ONHAND: r.ONHAND,
					IMIN: r.IMIN,
					ISCST: r.ISCST,
					ILEAD: r.ILEAD,
					IVEND: r.IVEND,
					IBUYC: r.IBUYC,
					COUNTRY: r.COUNTRY || "",
					IID: r.IID,
				})),
				column: [
					{ key: "IPROD", header: "Purcode (IPROD)" },
					{ key: "IDRAW", header: "Drawing (IDRAW)" },
					{ key: "IDESC", header: "Part Name (IDESC)" },
					{ key: "ICLAS", header: "Class (ICLAS)" },
					{ key: "IITYP", header: "Type (IITYP)" },
					{ key: "IUMS", header: "U/M (IUMS)" },
					{ key: "ONHAND", header: "On Hand" },
					{ key: "IMIN", header: "Min Balance (IMIN)" },
					{ key: "ISCST", header: "Std Cost (ISCST)" },
					{ key: "ILEAD", header: "Lead Time (ILEAD)" },
					{ key: "IVEND", header: "Vendor (IVEND)" },
					{ key: "IBUYC", header: "Planner (IBUYC)" },
					{ key: "COUNTRY", header: "Country of Origin" },
					{ key: "IID", header: "Status (IID)" },
				],
			});
			exportExcel(workbook, "AMEC_Item_Master_Export.xlsx");
		} catch (error) {
			console.error("Export Item Master Error:", error);
			showErrorMessage(error.message);
		} finally {
			showLoader({ show: false });
		}
	});
}

$(async function () {
	try {
		await window.appReady;
		modalUpload.init();
		bindEvents();
		await populateFilters();
		await initDataTable();
	} catch (error) {
		console.error("ItemMaster Initialization Error:", error);
		showErrorMessage(error.message || "Failed to initialize Item Master.");
	}
});
