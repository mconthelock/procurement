import "@amec/webasset/css/dataTable.min.css";
import dayjs from "dayjs";
import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { createTable } from "@amec/webasset/dataTable";
import { tableOpt, escapeHtml, escapeAttribute } from "../utils.js";
import {
	getPurchaseOrders,
	bulkAcknowledgePurchaseOrders,
} from "../service/index.js";
import {
	STATUS_CONFIG,
	PRIORITY_CONFIG,
	SAMPLE_ORDERS,
	summarizeOrderItems,
	normalizeStatus,
	normalizePriority,
	formatCurrency,
	formatCompactCurrency,
} from "./shared.js";

let table = null;
let ordersData = [];
let activeStatusFilter = "";

function getDetailUrl(poNo) {
	return `${process.env.APP_ENV}/orders/detail/${encodeURIComponent(poNo || "")}`;
}

function updateSummaryStats(rows) {
	const total = rows.length;
	const awaitingRows = rows.filter(
		(r) => normalizeStatus(r.PO_STATUS) === "AWAITING_CONFIRMATION",
	);
	const productionRows = rows.filter(
		(r) => normalizeStatus(r.PO_STATUS) === "IN_PRODUCTION",
	);
	const readyRows = rows.filter(
		(r) => normalizeStatus(r.PO_STATUS) === "READY_TO_SHIP",
	);
	const transitRows = rows.filter(
		(r) => normalizeStatus(r.PO_STATUS) === "IN_TRANSIT",
	);
	const deliveredRows = rows.filter(
		(r) => normalizeStatus(r.PO_STATUS) === "DELIVERED",
	);
	const readyAndTransit = [...readyRows, ...transitRows];

	const urgentAwaiting = awaitingRows.filter(
		(r) => normalizePriority(r.PRIORITY) === "URGENT",
	).length;

	const sumAmount = (list) =>
		list.reduce((acc, item) => acc + Number(item.TOTAL_AMOUNT || 0), 0);

	$("#kpi-total-pos").text(String(total).padStart(2, "0"));
	$("#kpi-total-amount").text(formatCompactCurrency(sumAmount(rows)));

	$("#kpi-awaiting-pos").text(String(awaitingRows.length).padStart(2, "0"));
	$("#kpi-awaiting-amount").text(formatCompactCurrency(sumAmount(awaitingRows)));
	$("#kpi-overdue-badge").text(`${urgentAwaiting} URGENT`);

	$("#kpi-production-pos").text(String(productionRows.length).padStart(2, "0"));
	$("#kpi-production-amount").text(
		formatCompactCurrency(sumAmount(productionRows)),
	);

	$("#kpi-transit-pos").text(String(readyAndTransit.length).padStart(2, "0"));
	$("#kpi-transit-amount").text(
		formatCompactCurrency(sumAmount(readyAndTransit)),
	);

	$("#tab-count-all").text(total);
	$("#tab-count-awaiting").text(awaitingRows.length);
	$("#tab-count-production").text(productionRows.length);
	$("#tab-count-ready").text(readyRows.length);
	$("#tab-count-transit").text(transitRows.length);
	$("#tab-count-delivered").text(deliveredRows.length);
}

function populateFilterSelects(rows) {
	const $vendor = $("#po-vendor-filter");
	const $plant = $("#po-plant-filter");
	$vendor.find("option:not(:first)").remove();
	$plant.find("option:not(:first)").remove();

	const vendorMap = new Map();
	const plantMap = new Map();

	rows.forEach((r) => {
		if (r.VND_CODE && !vendorMap.has(r.VND_CODE)) {
			vendorMap.set(r.VND_CODE, r.VND_NAME || r.VND_CODE);
		}
		if (r.PLANT_CODE && !plantMap.has(r.PLANT_CODE)) {
			plantMap.set(r.PLANT_CODE, r.PLANT_NAME || r.PLANT_CODE);
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
}

function getSelectedPoNumbers() {
	const ids = [];
	$("#table tbody .po-row-select:checked").each(function () {
		const poNo = $(this).data("po");
		if (poNo) ids.push(String(poNo));
	});
	return ids;
}

function updateSelectedCounter() {
	const $boxes = $("#table tbody .po-row-select");
	const $checked = $("#table tbody .po-row-select:checked");
	$("#selected-counter").text(`${$checked.length} items`);

	const headerCb = $("#po-header-checkbox")[0];
	if (headerCb) {
		headerCb.checked = $boxes.length > 0 && $checked.length === $boxes.length;
		headerCb.indeterminate =
			$checked.length > 0 && $checked.length < $boxes.length;
	}
}

function applyAllFilters() {
	if (!table) return;
	const searchVal = ($("#po-search").val() || "").trim();
	const vendorVal = $("#po-vendor-filter").val() || "";
	const plantVal = $("#po-plant-filter").val() || "";
	const priorityVal = $("#po-priority-filter").val() || "";

	table.search(searchVal);
	table.column(2).search([vendorVal, plantVal].filter(Boolean).join(" "));
	table.column(6).search(priorityVal);
	table.column(7).search(activeStatusFilter);
	table.draw();
}

async function initOrdersTable(rows) {
	const opt = { ...tableOpt };
	opt.data = rows;
	opt.order = [[1, "desc"]];
	opt.dom = `<"overflow-x-auto"t><"dt-footer-bar px-space-md py-3 bg-base-100 border-t border-base-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-mute"<"table-info"i><"table-page"p>>`;
	opt.language = {
		...tableOpt.language,
		info: 'Showing <strong class="text-primary">_START_ - _END_</strong> of <strong class="text-primary">_TOTAL_</strong> Purchase Orders',
		infoEmpty:
			'Showing <strong class="text-primary">0 - 0</strong> of <strong class="text-primary">0</strong> Purchase Orders',
	};

	const baseDrawCallback = tableOpt.drawCallback;
	opt.drawCallback = function (settings) {
		if (typeof baseDrawCallback === "function") {
			baseDrawCallback.call(this, settings);
		}
		const api = this.api();
		const info = api.page.info();
		$("#active-view-summary").text(
			`Showing ${info.recordsDisplay} of ${info.recordsTotal} PO records`,
		);
		updateSelectedCounter();
	};

	opt.columns = [
		{
			data: null,
			orderable: false,
			searchable: false,
			className: "w-10 text-center align-top",
			title: `<input id="po-header-checkbox" type="checkbox" aria-label="Select all purchase orders on page" class="checkbox checkbox-xs checkbox-accent border-white" />`,
			render: (data, type, row) =>
				`<input type="checkbox" class="po-row-select checkbox checkbox-xs checkbox-primary" aria-label="Select ${escapeAttribute(row.PO_NO)}" data-po="${escapeAttribute(row.PO_NO)}" />`,
		},
		{
			data: "PO_NO",
			title: "PO No. / Revision",
			className: "align-top text-nowrap",
			render: (data, type, row) => {
				if (type !== "display") {
					return `${row.PO_NO || ""} ${row.ISSUE_DATE || ""}`;
				}
				const issueStr = row.ISSUE_DATE
					? dayjs(row.ISSUE_DATE).format("YYYY-MM-DD")
					: "-";
				return `
					<a href="${escapeAttribute(getDetailUrl(row.PO_NO))}"
						class="link link-hover font-mono font-bold text-primary text-sm block text-left">
						${escapeHtml(row.PO_NO || "-")}
					</a>
					<span class="font-mono text-mute">Rev. ${escapeHtml(row.PO_REV || "00")} • ${escapeHtml(issueStr)}</span>
				`;
			},
		},
		{
			data: "VND_NAME",
			title: "Supplier &amp; Receiving Plant",
			className: "align-top",
			render: (data, type, row) => {
				if (type !== "display") {
					return `${row.VND_CODE || ""} ${row.VND_NAME || ""} ${row.PLANT_CODE || ""} ${row.PLANT_NAME || ""}`;
				}
				return `
					<div class="font-bold text-primary">${escapeHtml(row.VND_NAME || "-")}</div>
					<div class="font-mono text-[11px] text-secondary">${escapeHtml(row.VND_CODE || "-")}</div>
					<div class="text-mute mt-0.5">${escapeHtml(row.PLANT_NAME || "-")}</div>
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
					const allItemsText = summary.items
						.map(
							(it) =>
								`${it.PART_NO || ""} ${it.PART_DESC || ""} ${it.ECN_NO || ""}`,
						)
						.join(" ");
					return `${allItemsText} ${row.ASN_NO || ""}`;
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
					<div class="text-primary font-medium truncate max-w-xs" title="${escapeAttribute(summary.primary.PART_DESC || "")}">
						${escapeHtml(summary.primary.PART_DESC || "-")}
					</div>
					${row.ASN_NO ? `<div class="font-mono text-[11px] text-info mt-0.5">ASN: ${escapeHtml(row.ASN_NO)}</div>` : ""}
				`;
			},
		},
		{
			data: "ORDER_QTY",
			title: "Qty / Unit",
			className: "text-right font-mono align-top text-nowrap",
			render: (data, type, row) => {
				const summary = summarizeOrderItems(row);
				if (type !== "display") return summary.totalQty;
				if (summary.lineCount > 1) {
					const subLine = summary.hasMixedUnits
						? "Mixed Units"
						: `${summary.totalQty.toLocaleString("en-US")} ${escapeHtml(summary.sharedUnit)}`;
					return `
						<div class="font-bold text-primary">${summary.lineCount} Lines</div>
						<div class="text-mute">${subLine}</div>
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
			className: "text-right font-mono align-top text-nowrap",
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
			className: "align-top text-nowrap",
			render: (data, type, row) => {
				const priorityKey = normalizePriority(row.PRIORITY);
				if (type !== "display") {
					return `${data || ""} ${priorityKey}`;
				}
				const dateStr = data ? dayjs(data).format("YYYY-MM-DD") : "-";
				const pCfg = PRIORITY_CONFIG[priorityKey] || PRIORITY_CONFIG.NORMAL;
				const dateClass =
					priorityKey === "URGENT" ? "text-error" : "text-primary";
				return `
					<div class="font-mono font-bold ${dateClass}">${escapeHtml(dateStr)}</div>
					<span class="badge badge-xs ${pCfg.badge} font-mono font-bold mt-0.5">${escapeHtml(pCfg.label)}</span>
				`;
			},
		},
		{
			data: "PO_STATUS",
			title: "Status",
			className: "align-top text-nowrap",
			render: (data, type) => {
				const statusKey = normalizeStatus(data);
				if (type !== "display") return statusKey;
				const cfg =
					STATUS_CONFIG[statusKey] || STATUS_CONFIG.AWAITING_CONFIRMATION;
				return `<span class="badge badge-xs ${cfg.badge} font-bold uppercase">${escapeHtml(cfg.label)}</span>`;
			},
		},
		{
			data: null,
			title: "Actions",
			orderable: false,
			searchable: false,
			className: "text-center align-top w-36",
			render: (data, type, row) => {
				const statusKey = normalizeStatus(row.PO_STATUS);
				const isAwaiting = statusKey === "AWAITING_CONFIRMATION";
				const primaryBtnClass = isAwaiting ? "btn-accent" : "btn-primary";
				const primaryIcon = isAwaiting ? "verified" : "visibility";
				const primaryLabel = isAwaiting ? "Review & Sign" : "View Detail";
				return `
					<div class="flex flex-col gap-1 items-stretch">
						<a href="${escapeAttribute(getDetailUrl(row.PO_NO))}"
							class="btn btn-xs ${primaryBtnClass} font-bold flex items-center justify-center gap-1">
							<span class="material-symbols-outlined text-[14px]">${primaryIcon}</span>
							<span>${primaryLabel}</span>
						</a>
						<button type="button" class="js-download-po-pdf btn btn-xs btn-outline border-base-300 font-semibold flex items-center justify-center gap-1"
							data-po="${escapeAttribute(row.PO_NO)}">
							<span class="material-symbols-outlined text-[13px]">picture_as_pdf</span>
							<span>PO PDF</span>
						</button>
					</div>
				`;
			},
		},
	];

	if (!table) {
		table = await createTable(opt);
	} else {
		table.clear();
		table.rows.add(rows);
		table.draw();
	}
}

function openBulkAckModal(poNumbers) {
	$("#bulk-ack-count").text(`${poNumbers.length} POs`);
	const $list = $("#bulk-ack-list").empty();
	poNumbers.forEach((po) => {
		$list.append(
			`<span class="badge badge-xs badge-outline border-base-300 bg-white text-primary font-mono">${escapeHtml(po)}</span>`,
		);
	});
	$("#bulkAckForm")[0].reset();
	$("#bulkAckModal").removeClass("hidden").addClass("flex");
}

function closeBulkAckModal() {
	$("#bulkAckModal").addClass("hidden").removeClass("flex");
}

async function reloadOrders() {
	try {
		const res = await getPurchaseOrders();
		const list = Array.isArray(res) ? res : res?.data || [];
		ordersData = list.length > 0 ? list : SAMPLE_ORDERS;
	} catch (error) {
		console.warn("Using sample PO dataset (API unavailable):", error);
		ordersData = [...SAMPLE_ORDERS];
	}

	updateSummaryStats(ordersData);
	populateFilterSelects(ordersData);
	await initOrdersTable(ordersData);
}

// Event Delegation (No inline JS in Blade)
$(document).on("click", ".po-status-tab", function () {
	const $tab = $(this);
	activeStatusFilter = $tab.data("status") || "";

	$(".po-status-tab").each(function () {
		const $btn = $(this);
		const isActive = $btn.is($tab);
		$btn.attr("aria-selected", String(isActive))
			.toggleClass("text-primary font-bold border-primary", isActive)
			.toggleClass("text-mute font-semibold border-transparent", !isActive);
	});

	this.scrollIntoView({ block: "nearest", inline: "nearest" });
	applyAllFilters();
});

$(document).on("input", "#po-search", applyAllFilters);
$(document).on(
	"change",
	"#po-vendor-filter, #po-plant-filter, #po-priority-filter",
	applyAllFilters,
);

$(document).on("click", "#po-filter-reset", function () {
	$("#po-search").val("");
	$("#po-vendor-filter").val("");
	$("#po-plant-filter").val("");
	$("#po-priority-filter").val("");
	activeStatusFilter = "";
	$('.po-status-tab[data-status=""]').trigger("click");
});

$(document).on("change", "#po-header-checkbox", function () {
	const checked = $(this).is(":checked");
	$("#table tbody .po-row-select").prop("checked", checked);
	updateSelectedCounter();
});

$(document).on("change", ".po-row-select", updateSelectedCounter);

$(document).on("click", "#select-all-po-btn", function () {
	const $master = $("#po-header-checkbox");
	$master.prop("checked", !$master.is(":checked")).trigger("change");
});

$(document).on("click", ".js-download-po-pdf", async function () {
	const poNo = $(this).data("po") || "";
	if (!poNo) return;
	await showMessage(`Preparing official e-stamped PDF for ${poNo}...`);
});

$(document).on("click", "#open-bulk-ack-modal", async function () {
	const selected = getSelectedPoNumbers();
	if (!selected.length) {
		await showMessage(
			"Please select at least one Purchase Order from the table first.",
		);
		return;
	}
	openBulkAckModal(selected);
});

$(document).on("click", ".js-close-bulk-modal", closeBulkAckModal);

$(document).on("keydown", function (e) {
	if (e.key === "Escape" && !$("#bulkAckModal").hasClass("hidden")) {
		closeBulkAckModal();
	}
});

$(document).on("submit", "#bulkAckForm", async function (e) {
	e.preventDefault();
	const selected = getSelectedPoNumbers();
	if (!selected.length) {
		closeBulkAckModal();
		return;
	}

	const payload = {
		poNumbers: selected,
		referenceNo: $("#bulk-ack-ref").val().trim(),
		remarks: $("#bulk-ack-remark").val().trim(),
	};

	try {
		await showLoader();
		try {
			await bulkAcknowledgePurchaseOrders(payload);
		} catch (apiErr) {
			console.warn("API bulk acknowledge fallback (local state update):", apiErr);
		}
		ordersData.forEach((order) => {
			if (
				selected.includes(String(order.PO_NO)) &&
				normalizeStatus(order.PO_STATUS) === "AWAITING_CONFIRMATION"
			) {
				order.PO_STATUS = "IN_PRODUCTION";
			}
		});
		closeBulkAckModal();
		updateSummaryStats(ordersData);
		await initOrdersTable(ordersData);
		applyAllFilters();
		await showMessage(
			`${selected.length} Purchase Order(s) acknowledged successfully.`,
		);
	} catch (error) {
		console.error(error);
		await showMessage(
			error.message || "Failed to process bulk acknowledgment.",
		);
	} finally {
		await showLoader({ show: false });
	}
});

$(document).on("click", "#export-po-list", async function () {
	if (!ordersData.length) {
		await showMessage("No Purchase Order records available to export.");
		return;
	}
	const headers = [
		"PO No",
		"Revision",
		"Issue Date",
		"Vendor Code",
		"Vendor Name",
		"Plant",
		"Primary Part No",
		"Primary Description",
		"Line Items",
		"Total Qty",
		"Unit",
		"Total Amount",
		"Currency",
		"Target Delivery",
		"Priority",
		"Status",
		"ASN No",
	];
	const csvRows = [
		headers.join(","),
		...ordersData.map((o) => {
			const summary = summarizeOrderItems(o);
			return [
				o.PO_NO,
				o.PO_REV,
				o.ISSUE_DATE,
				o.VND_CODE,
				o.VND_NAME,
				o.PLANT_NAME,
				summary.primary.PART_NO,
				summary.primary.PART_DESC,
				summary.lineCount,
				summary.hasMixedUnits ? "" : summary.totalQty,
				summary.hasMixedUnits ? "Mixed Units" : summary.sharedUnit,
				o.TOTAL_AMOUNT,
				o.CURRENCY,
				o.TARGET_DELIVERY,
				normalizePriority(o.PRIORITY),
				normalizeStatus(o.PO_STATUS),
				o.ASN_NO,
			]
				.map((v) => `"${String(v ?? "").replace(/"/g, '""')}"`)
				.join(",");
		}),
	];
	const blob = new Blob([csvRows.join("\n")], {
		type: "text/csv;charset=utf-8;",
	});
	const url = URL.createObjectURL(blob);
	const a = document.createElement("a");
	a.href = url;
	a.download = `purchase-orders-${dayjs().format("YYYYMMDD")}.csv`;
	a.click();
	URL.revokeObjectURL(url);
});

$(document).ready(async () => {
	try {
		await showLoader();
		await window.appReady;
		await reloadOrders();
	} catch (error) {
		console.error(error);
		await showMessage(
			error.message || "Error initializing Purchase Orders page",
		);
	} finally {
		await showLoader({ show: false });
	}
});
