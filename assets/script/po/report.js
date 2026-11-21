import "@amec/webasset/css/dataTable.min.css";
import dayjs from "dayjs";
import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { createTable } from "@amec/webasset/dataTable";
import { tableOpt, escapeHtml, escapeAttribute } from "../utils.js";
import { searchPurchaseOrderReport } from "../service/index.js";
import {
	STATUS_CONFIG,
	PRIORITY_CONFIG,
	SAMPLE_ORDERS,
	getOrderItems,
	summarizeOrderItems,
	normalizeStatus,
	normalizePriority,
	formatCurrency,
	formatCompactCurrency,
} from "./shared.js";

let table = null;
let allOrders = [];
let filteredOrders = [];
let reportMode = "HEADER"; // "HEADER" | "LINE_ITEM"

function getDetailUrl(poNo) {
	return `${process.env.APP_ENV}/orders/detail/${encodeURIComponent(poNo || "")}`;
}

function readCriteria() {
	return {
		poNo: ($("#rpt-po-no").val() || "").trim(),
		partNo: ($("#rpt-part-no").val() || "").trim(),
		vendorCode: $("#rpt-vendor").val() || "",
		plantCode: $("#rpt-plant").val() || "",
		dateType: $("#rpt-date-type").val() || "ISSUE_DATE",
		dateFrom: $("#rpt-date-from").val() || "",
		dateTo: $("#rpt-date-to").val() || "",
		status: $("#rpt-status").val() || "",
		priority: $("#rpt-priority").val() || "",
		buyer: $("#rpt-buyer").val() || "",
	};
}

function countActiveCriteria(c) {
	const keys = [
		"poNo",
		"partNo",
		"vendorCode",
		"plantCode",
		"dateFrom",
		"dateTo",
		"status",
		"priority",
		"buyer",
	];
	return keys.filter((k) => Boolean(c[k])).length;
}

function populateCriteriaSelects(orders) {
	const $vendor = $("#rpt-vendor");
	const $plant = $("#rpt-plant");
	const $buyer = $("#rpt-buyer");

	$vendor.find("option:not(:first)").remove();
	$plant.find("option:not(:first)").remove();
	$buyer.find("option:not(:first)").remove();

	const vendorMap = new Map();
	const plantMap = new Map();
	const buyerSet = new Set();

	orders.forEach((o) => {
		if (o.VND_CODE && !vendorMap.has(o.VND_CODE)) {
			vendorMap.set(o.VND_CODE, o.VND_NAME || o.VND_CODE);
		}
		if (o.PLANT_CODE && !plantMap.has(o.PLANT_CODE)) {
			plantMap.set(o.PLANT_CODE, o.PLANT_NAME || o.PLANT_CODE);
		}
		if (o.BUYER_NAME) {
			buyerSet.add(o.BUYER_NAME);
		}
	});

	vendorMap.forEach((name, code) => {
		$vendor.append(
			`<option value="${escapeAttribute(code)}">${escapeHtml(`${code} — ${name}`)}</option>`,
		);
	});
	plantMap.forEach((name, code) => {
		$plant.append(
			`<option value="${escapeAttribute(code)}">${escapeHtml(name)}</option>`,
		);
	});
	buyerSet.forEach((buyer) => {
		$buyer.append(
			`<option value="${escapeAttribute(buyer)}">${escapeHtml(buyer)}</option>`,
		);
	});
}

function filterOrdersLocally(orders, c) {
	const poQuery = c.poNo.toLowerCase();
	const partQuery = c.partNo.toLowerCase();

	return orders.filter((o) => {
		if (poQuery) {
			const hay = `${o.PO_NO || ""} ${o.ASN_NO || ""}`.toLowerCase();
			if (!hay.includes(poQuery)) return false;
		}
		if (partQuery) {
			const items = getOrderItems(o);
			const matched = items.some((it) =>
				`${it.PART_NO || ""} ${it.PART_DESC || ""} ${it.ECN_NO || ""}`
					.toLowerCase()
					.includes(partQuery),
			);
			if (!matched) return false;
		}
		if (c.vendorCode && o.VND_CODE !== c.vendorCode) return false;
		if (c.plantCode && o.PLANT_CODE !== c.plantCode) return false;
		if (c.status && normalizeStatus(o.PO_STATUS) !== c.status) return false;
		if (c.priority && normalizePriority(o.PRIORITY) !== c.priority) return false;
		if (c.buyer && o.BUYER_NAME !== c.buyer) return false;

		const dateField = o[c.dateType];
		if (c.dateFrom && dateField && dayjs(dateField).isBefore(c.dateFrom, "day")) {
			return false;
		}
		if (c.dateTo && dateField && dayjs(dateField).isAfter(c.dateTo, "day")) {
			return false;
		}
		return true;
	});
}

function buildLineItemRows(orders, partQuery = "") {
	const q = partQuery.toLowerCase();
	const rows = [];
	orders.forEach((order) => {
		const items = getOrderItems(order);
		items.forEach((item, idx) => {
			if (q) {
				const text =
					`${item.PART_NO || ""} ${item.PART_DESC || ""} ${item.ECN_NO || ""}`.toLowerCase();
				if (!text.includes(q)) return;
			}
			rows.push({
				PO_NO: order.PO_NO,
				PO_REV: order.PO_REV,
				ISSUE_DATE: order.ISSUE_DATE,
				TARGET_DELIVERY: order.TARGET_DELIVERY,
				VND_CODE: order.VND_CODE,
				VND_NAME: order.VND_NAME,
				PLANT_CODE: order.PLANT_CODE,
				PLANT_NAME: order.PLANT_NAME,
				BUYER_NAME: order.BUYER_NAME,
				ASN_NO: order.ASN_NO,
				PRIORITY: order.PRIORITY,
				PO_STATUS: order.PO_STATUS,
				CURRENCY: order.CURRENCY || "THB",
				LINE_NO: item.LINE_NO || idx + 1,
				PART_NO: item.PART_NO,
				ECN_NO: item.ECN_NO,
				PART_DESC: item.PART_DESC,
				ORDER_QTY: item.ORDER_QTY,
				UNIT: item.UNIT || "PCS",
				UNIT_PRICE: item.UNIT_PRICE,
				LINE_TOTAL: item.LINE_TOTAL,
			});
		});
	});
	return rows;
}

function updateReportKpis(orders) {
	const totalPOs = orders.length;
	const totalLines = orders.reduce(
		(acc, o) => acc + getOrderItems(o).length,
		0,
	);
	const uniqueVendors = new Set(orders.map((o) => o.VND_CODE).filter(Boolean))
		.size;
	const totalAmount = orders.reduce(
		(acc, o) => acc + Number(o.TOTAL_AMOUNT || 0),
		0,
	);
	const awaitingRows = orders.filter(
		(o) => normalizeStatus(o.PO_STATUS) === "AWAITING_CONFIRMATION",
	);
	const urgentAwaiting = awaitingRows.filter(
		(o) => normalizePriority(o.PRIORITY) === "URGENT",
	).length;
	const awaitingAmount = awaitingRows.reduce(
		(acc, o) => acc + Number(o.TOTAL_AMOUNT || 0),
		0,
	);
	const fulfilledRows = orders.filter((o) =>
		["READY_TO_SHIP", "IN_TRANSIT", "DELIVERED"].includes(
			normalizeStatus(o.PO_STATUS),
		),
	);
	const rate =
		totalPOs > 0 ? Math.round((fulfilledRows.length / totalPOs) * 100) : 0;

	$("#rpt-kpi-pos").text(String(totalPOs).padStart(2, "0"));
	$("#rpt-kpi-lines").text(`${totalLines} Lines`);
	$("#rpt-kpi-vendors").text(`${uniqueVendors} Vendors`);

	$("#rpt-kpi-amount").text(
		totalAmount >= 1_000_000
			? `฿${(totalAmount / 1_000_000).toFixed(2)}M`
			: formatCurrency(totalAmount, "THB"),
	);
	$("#rpt-kpi-amount-exact").text(formatCurrency(totalAmount, "THB"));

	$("#rpt-kpi-awaiting").text(String(awaitingRows.length).padStart(2, "0"));
	$("#rpt-kpi-urgent").text(`${urgentAwaiting} URGENT`);
	$("#rpt-kpi-awaiting-amount").text(formatCompactCurrency(awaitingAmount));

	$("#rpt-kpi-fulfilled").text(String(fulfilledRows.length).padStart(2, "0"));
	$("#rpt-kpi-rate").text(`${rate}%`);
}

function getHeaderColumns() {
	return [
		{
			data: "PO_NO",
			title: "PO No. / Rev",
			className: "text-nowrap align-top",
			render: (data, type, row) => {
				if (type !== "display") return `${row.PO_NO || ""} ${row.ISSUE_DATE || ""}`;
				return `
					<a href="${escapeAttribute(getDetailUrl(row.PO_NO))}"
						class="link link-hover font-mono font-bold text-primary block">
						${escapeHtml(row.PO_NO || "-")}
					</a>
					<span class="font-mono text-mute">Rev. ${escapeHtml(row.PO_REV || "00")}</span>
				`;
			},
		},
		{
			data: "ISSUE_DATE",
			title: "Issue Date",
			className: "font-mono text-nowrap align-top",
			render: (data, type) =>
				type === "display" && data ? dayjs(data).format("YYYY-MM-DD") : data || "-",
		},
		{
			data: "VND_NAME",
			title: "Supplier / Vendor",
			className: "align-top",
			render: (data, type, row) => {
				if (type !== "display") return `${row.VND_CODE || ""} ${row.VND_NAME || ""}`;
				return `
					<div class="font-bold text-primary">${escapeHtml(row.VND_NAME || "-")}</div>
					<div class="font-mono text-[11px] text-secondary">${escapeHtml(row.VND_CODE || "-")}</div>
				`;
			},
		},
		{
			data: "PLANT_NAME",
			title: "Plant / Buyer",
			className: "align-top",
			render: (data, type, row) => {
				if (type !== "display") return `${row.PLANT_CODE || ""} ${row.PLANT_NAME || ""} ${row.BUYER_NAME || ""}`;
				return `
					<div class="font-semibold text-primary">${escapeHtml(row.PLANT_NAME || "-")}</div>
					<div class="text-mute">${escapeHtml(row.BUYER_NAME || "-")}</div>
				`;
			},
		},
		{
			data: "PART_NO",
			title: "Part No. &amp; Description",
			className: "align-top",
			render: (data, type, row) => {
				const summary = summarizeOrderItems(row);
				if (type !== "display") {
					return summary.items
						.map((it) => `${it.PART_NO || ""} ${it.PART_DESC || ""} ${it.ECN_NO || ""}`)
						.join(" ");
				}
				const extraBadge =
					summary.extraCount > 0
						? `<a href="${escapeAttribute(getDetailUrl(row.PO_NO))}"
								class="badge badge-xs badge-outline border-primary text-primary font-mono font-bold hover:bg-primary hover:text-white transition-colors">
								+${summary.extraCount} more ${summary.extraCount === 1 ? "item" : "items"}
							</a>`
						: "";
				return `
					<div class="flex flex-wrap items-center gap-1.5">
						<span class="font-mono font-bold text-secondary">${escapeHtml(summary.primary.PART_NO || "-")}</span>
						${extraBadge}
					</div>
					<div class="text-primary truncate max-w-xs" title="${escapeAttribute(summary.primary.PART_DESC || "")}">
						${escapeHtml(summary.primary.PART_DESC || "-")}
					</div>
				`;
			},
		},
		{
			data: "ORDER_QTY",
			title: "Qty / Lines",
			className: "text-right font-mono text-nowrap align-top",
			render: (data, type, row) => {
				const summary = summarizeOrderItems(row);
				if (type !== "display") return summary.totalQty;
				if (summary.lineCount > 1) {
					return `
						<div class="font-bold text-primary">${summary.lineCount} Lines</div>
						<div class="text-mute">${summary.hasMixedUnits ? "Mixed Units" : `${summary.totalQty.toLocaleString("en-US")} ${escapeHtml(summary.sharedUnit)}`}</div>
					`;
				}
				return `
					<div class="font-bold text-primary">${summary.totalQty.toLocaleString("en-US")}</div>
					<div class="text-mute">${escapeHtml(summary.sharedUnit)}</div>
				`;
			},
		},
		{
			data: "TOTAL_AMOUNT",
			title: "Total Amount",
			className: "text-right font-mono text-nowrap align-top",
			render: (data, type, row) => {
				if (type !== "display") return Number(data || 0);
				return `
					<div class="font-bold text-primary">${escapeHtml(formatCurrency(data, row.CURRENCY))}</div>
					<div class="text-mute">${escapeHtml(row.CURRENCY || "THB")}</div>
				`;
			},
		},
		{
			data: "TARGET_DELIVERY",
			title: "Target Delivery",
			className: "text-nowrap align-top",
			render: (data, type, row) => {
				const pKey = normalizePriority(row.PRIORITY);
				if (type !== "display") return `${data || ""} ${pKey}`;
				const pCfg = PRIORITY_CONFIG[pKey] || PRIORITY_CONFIG.NORMAL;
				return `
					<div class="font-mono font-bold ${pKey === "URGENT" ? "text-error" : "text-primary"}">
						${data ? dayjs(data).format("YYYY-MM-DD") : "-"}
					</div>
					<span class="badge badge-xs ${pCfg.badge} font-mono font-bold">${escapeHtml(pCfg.label)}</span>
				`;
			},
		},
		{
			data: "PO_STATUS",
			title: "Status",
			className: "text-nowrap align-top",
			render: (data, type) => {
				const sKey = normalizeStatus(data);
				if (type !== "display") return sKey;
				const cfg = STATUS_CONFIG[sKey] || STATUS_CONFIG.AWAITING_CONFIRMATION;
				return `<span class="badge badge-xs ${cfg.badge} font-bold uppercase">${escapeHtml(cfg.label)}</span>`;
			},
		},
	];
}

function getLineItemColumns() {
	return [
		{
			data: "PO_NO",
			title: "PO No. / Line",
			className: "text-nowrap align-top font-mono",
			render: (data, type, row) => {
				if (type !== "display") return `${row.PO_NO || ""} ${row.LINE_NO || ""}`;
				return `
					<a href="${escapeAttribute(getDetailUrl(row.PO_NO))}"
						class="link link-hover font-bold text-primary block">
						${escapeHtml(row.PO_NO || "-")}
					</a>
					<span class="text-mute">Line #${String(row.LINE_NO || 1).padStart(2, "0")}</span>
				`;
			},
		},
		{
			data: "PART_NO",
			title: "Part No. &amp; ECN",
			className: "text-nowrap align-top font-mono",
			render: (data, type, row) => {
				if (type !== "display") return `${row.PART_NO || ""} ${row.ECN_NO || ""}`;
				return `
					<div class="font-bold text-secondary">${escapeHtml(row.PART_NO || "-")}</div>
					<div class="text-[11px] text-mute">${escapeHtml(row.ECN_NO || "-")}</div>
				`;
			},
		},
		{
			data: "PART_DESC",
			title: "Description",
			className: "align-top",
			render: (data, type) =>
				type === "display"
					? `<div class="text-primary font-medium max-w-xs truncate" title="${escapeAttribute(data || "")}">${escapeHtml(data || "-")}</div>`
					: data || "",
		},
		{
			data: "VND_NAME",
			title: "Supplier",
			className: "align-top",
			render: (data, type, row) => {
				if (type !== "display") return `${row.VND_CODE || ""} ${row.VND_NAME || ""}`;
				return `
					<div class="font-semibold text-primary">${escapeHtml(row.VND_NAME || "-")}</div>
					<div class="font-mono text-[11px] text-mute">${escapeHtml(row.VND_CODE || "-")}</div>
				`;
			},
		},
		{
			data: "ORDER_QTY",
			title: "Qty / Unit",
			className: "text-right font-mono text-nowrap align-top",
			render: (data, type, row) => {
				if (type !== "display") return Number(data || 0);
				return `
					<div class="font-bold text-primary">${Number(data || 0).toLocaleString("en-US")}</div>
					<div class="text-mute">${escapeHtml(row.UNIT || "PCS")}</div>
				`;
			},
		},
		{
			data: "UNIT_PRICE",
			title: "Unit Price",
			className: "text-right font-mono text-nowrap align-top",
			render: (data, type, row) =>
				type === "display"
					? escapeHtml(formatCurrency(data, row.CURRENCY))
					: Number(data || 0),
		},
		{
			data: "LINE_TOTAL",
			title: "Line Total",
			className: "text-right font-mono font-bold text-primary text-nowrap align-top",
			render: (data, type, row) =>
				type === "display"
					? escapeHtml(formatCurrency(data, row.CURRENCY))
					: Number(data || 0),
		},
		{
			data: "TARGET_DELIVERY",
			title: "Target Delivery",
			className: "font-mono text-nowrap align-top",
			render: (data, type) =>
				type === "display" && data ? dayjs(data).format("YYYY-MM-DD") : data || "-",
		},
		{
			data: "PO_STATUS",
			title: "Status",
			className: "text-nowrap align-top",
			render: (data, type) => {
				const sKey = normalizeStatus(data);
				if (type !== "display") return sKey;
				const cfg = STATUS_CONFIG[sKey] || STATUS_CONFIG.AWAITING_CONFIRMATION;
				return `<span class="badge badge-xs ${cfg.badge} font-bold uppercase">${escapeHtml(cfg.label)}</span>`;
			},
		},
	];
}

async function renderReportTable(orders, partQuery = "") {
	const isLineMode = reportMode === "LINE_ITEM";
	const rows = isLineMode ? buildLineItemRows(orders, partQuery) : orders;
	const unitLabel = isLineMode ? "Line Items" : "Purchase Orders";

	$("#rpt-mode-label").text(
		isLineMode ? "Mode: Line-Item Detail" : "Mode: PO Header",
	);

	if (table) {
		table.destroy();
		table = null;
		$("#table").empty();
	}

	const opt = { ...tableOpt };
	opt.data = rows;
	opt.order = [[0, "desc"]];
	opt.dom = `<"overflow-x-auto"t><"dt-footer-bar px-space-md py-3 bg-base-100 border-t border-base-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-mute"<"table-info"i><"table-page"p>>`;
	opt.language = {
		...tableOpt.language,
		info: `Showing <strong class="text-primary">_START_ - _END_</strong> of <strong class="text-primary">_TOTAL_</strong> ${unitLabel}`,
		infoEmpty: `Showing <strong class="text-primary">0 - 0</strong> of <strong class="text-primary">0</strong> ${unitLabel}`,
	};
	opt.columns = isLineMode ? getLineItemColumns() : getHeaderColumns();

	const baseDrawCallback = tableOpt.drawCallback;
	opt.drawCallback = function (settings) {
		if (typeof baseDrawCallback === "function") {
			baseDrawCallback.call(this, settings);
		}
		const info = this.api().page.info();
		$("#rpt-active-summary").text(
			`Showing ${info.recordsDisplay} of ${info.recordsTotal} ${unitLabel}`,
		);
	};

	table = await createTable(opt);

	const quickVal = ($("#rpt-quick-filter").val() || "").trim();
	if (quickVal) {
		table.search(quickVal).draw();
	}
}

async function runReportSearch() {
	const criteria = readCriteria();
	const activeCount = countActiveCriteria(criteria);
	$("#active-filter-badge").text(`${activeCount} ACTIVE`);

	try {
		const res = await searchPurchaseOrderReport(criteria);
		const list = Array.isArray(res) ? res : res?.data || [];
		if (list.length > 0) {
			filteredOrders = list;
		} else {
			filteredOrders = filterOrdersLocally(allOrders, criteria);
		}
	} catch (error) {
		console.warn("Using local PO report filter (API unavailable):", error);
		filteredOrders = filterOrdersLocally(allOrders, criteria);
	}

	updateReportKpis(filteredOrders);
	await renderReportTable(filteredOrders, criteria.partNo);
}

// Event Delegation
$(document).on("submit", "#poReportSearchForm", async function (e) {
	e.preventDefault();
	try {
		await showLoader();
		await runReportSearch();
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error running PO search report.");
	} finally {
		await showLoader({ show: false });
	}
});

$(document).on("click", ".js-report-mode", async function () {
	const nextMode = $(this).data("mode");
	if (!nextMode || nextMode === reportMode) return;
	reportMode = nextMode;

	$(".js-report-mode").each(function () {
		const isCurrent = $(this).data("mode") === reportMode;
		$(this)
			.toggleClass("btn-primary font-bold", isCurrent)
			.toggleClass("btn-outline border-base-300 bg-white font-semibold", !isCurrent);
	});

	await renderReportTable(filteredOrders, ($("#rpt-part-no").val() || "").trim());
});

$(document).on("click", ".js-date-preset", function () {
	const preset = $(this).data("preset");
	const today = dayjs();

	if (preset === "ALL") {
		$("#rpt-date-from").val("");
		$("#rpt-date-to").val("");
	} else if (preset === "THIS_MONTH") {
		$("#rpt-date-type").val("ISSUE_DATE");
		$("#rpt-date-from").val(today.startOf("month").format("YYYY-MM-DD"));
		$("#rpt-date-to").val(today.endOf("month").format("YYYY-MM-DD"));
	} else if (preset === "LAST_30") {
		$("#rpt-date-type").val("ISSUE_DATE");
		$("#rpt-date-from").val(today.subtract(30, "day").format("YYYY-MM-DD"));
		$("#rpt-date-to").val(today.format("YYYY-MM-DD"));
	} else if (preset === "NEXT_7") {
		$("#rpt-date-type").val("TARGET_DELIVERY");
		$("#rpt-date-from").val(today.format("YYYY-MM-DD"));
		$("#rpt-date-to").val(today.add(7, "day").format("YYYY-MM-DD"));
	}

	$("#poReportSearchForm").trigger("submit");
});

$(document).on("click", "#rpt-reset-btn", function () {
	$("#poReportSearchForm")[0].reset();
	$("#rpt-quick-filter").val("");
	$("#poReportSearchForm").trigger("submit");
});

$(document).on("input", "#rpt-quick-filter", function () {
	if (!table) return;
	table.search(($(this).val() || "").trim()).draw();
});

$(document).on("click", "#print-report-btn", function () {
	window.print();
});

$(document).on("click", "#export-report-csv", async function () {
	const isLineMode = reportMode === "LINE_ITEM";
	const criteria = readCriteria();
	const exportRows = isLineMode
		? buildLineItemRows(filteredOrders, criteria.partNo)
		: filteredOrders;

	if (!exportRows.length) {
		await showMessage("No matched records available to export.");
		return;
	}

	let headers;
	let dataRows;

	if (isLineMode) {
		headers = [
			"PO No",
			"Line #",
			"Issue Date",
			"Part No",
			"ECN No",
			"Description",
			"Vendor Code",
			"Vendor Name",
			"Plant",
			"Qty",
			"Unit",
			"Unit Price",
			"Line Total",
			"Currency",
			"Target Delivery",
			"Status",
		];
		dataRows = exportRows.map((r) => [
			r.PO_NO,
			r.LINE_NO,
			r.ISSUE_DATE,
			r.PART_NO,
			r.ECN_NO,
			r.PART_DESC,
			r.VND_CODE,
			r.VND_NAME,
			r.PLANT_NAME,
			r.ORDER_QTY,
			r.UNIT,
			r.UNIT_PRICE,
			r.LINE_TOTAL,
			r.CURRENCY,
			r.TARGET_DELIVERY,
			normalizeStatus(r.PO_STATUS),
		]);
	} else {
		headers = [
			"PO No",
			"Rev",
			"Issue Date",
			"Vendor Code",
			"Vendor Name",
			"Plant",
			"Buyer",
			"Primary Part No",
			"Line Items",
			"Total Qty",
			"Unit",
			"Total Amount",
			"Currency",
			"Target Delivery",
			"Priority",
			"Status",
		];
		dataRows = exportRows.map((o) => {
			const s = summarizeOrderItems(o);
			return [
				o.PO_NO,
				o.PO_REV,
				o.ISSUE_DATE,
				o.VND_CODE,
				o.VND_NAME,
				o.PLANT_NAME,
				o.BUYER_NAME,
				s.primary.PART_NO,
				s.lineCount,
				s.hasMixedUnits ? "" : s.totalQty,
				s.hasMixedUnits ? "Mixed Units" : s.sharedUnit,
				o.TOTAL_AMOUNT,
				o.CURRENCY,
				o.TARGET_DELIVERY,
				normalizePriority(o.PRIORITY),
				normalizeStatus(o.PO_STATUS),
			];
		});
	}

	const csvContent = [
		headers.join(","),
		...dataRows.map((cols) =>
			cols.map((v) => `"${String(v ?? "").replace(/"/g, '""')}"`).join(","),
		),
	].join("\n");

	const blob = new Blob(["\uFEFF" + csvContent], {
		type: "text/csv;charset=utf-8;",
	});
	const url = URL.createObjectURL(blob);
	const a = document.createElement("a");
	a.href = url;
	a.download = `po-report-${isLineMode ? "items" : "header"}-${dayjs().format("YYYYMMDD")}.csv`;
	a.click();
	URL.revokeObjectURL(url);
});

$(document).ready(async () => {
	try {
		await showLoader();
		await window.appReady;
		try {
			const res = await searchPurchaseOrderReport({});
			const list = Array.isArray(res) ? res : res?.data || [];
			allOrders = list.length > 0 ? list : [...SAMPLE_ORDERS];
		} catch (error) {
			console.warn("Using sample PO dataset for report:", error);
			allOrders = [...SAMPLE_ORDERS];
		}
		populateCriteriaSelects(allOrders);
		filteredOrders = [...allOrders];
		updateReportKpis(filteredOrders);
		await renderReportTable(filteredOrders);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error initializing PO Search Report");
	} finally {
		await showLoader({ show: false });
	}
});
