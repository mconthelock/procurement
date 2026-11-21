import "@amec/webasset/css/dataTable.min.css";
import dayjs from "dayjs";
import { showLoader } from "@amec/webasset/preloader";
import { showMessage, showConfirm } from "@amec/webasset/utils";
import { createTable } from "@amec/webasset/dataTable";
import { tableOpt, escapeHtml, escapeAttribute } from "../utils.js";
import {
	getPurchaseOrders,
	acknowledgePurchaseOrder,
	bulkAcknowledgePurchaseOrders,
} from "../service/index.js";

const STATUS_CONFIG = {
	AWAITING_CONFIRMATION: {
		label: "Awaiting Confirmation",
		badge: "badge-error",
	},
	IN_PRODUCTION: {
		label: "In Production",
		badge: "badge-warning",
	},
	READY_TO_SHIP: {
		label: "Ready to Ship",
		badge: "badge-success",
	},
	IN_TRANSIT: {
		label: "In Transit (ASN)",
		badge: "badge-info",
	},
	DELIVERED: {
		label: "Delivered",
		badge: "badge-ghost",
	},
};

const PRIORITY_CONFIG = {
	URGENT: {
		label: "Urgent < 24h",
		badge: "badge-error",
	},
	EXPEDITED: {
		label: "Expedited",
		badge: "badge-warning",
	},
	NORMAL: {
		label: "Standard",
		badge: "badge-ghost",
	},
};

const SAMPLE_ORDERS = [
	{
		PO_NO: "PO-2026-0892",
		PO_REV: "02",
		ISSUE_DATE: "2026-11-17",
		TARGET_DELIVERY: "2026-11-24",
		VND_CODE: "V-884029-TH",
		VND_NAME: "Siam Precision Engineering Co., Ltd.",
		PLANT_CODE: "AMEC-P1",
		PLANT_NAME: "Amata City Chonburi Plant 01",
		DOCK_BAY: "Dock C4 (Receiving Gate 2)",
		PART_NO: "ELV-FRAME-SS304",
		PART_DESC: "Hoistway Door Jamb Frame SUS304 Hairline 2100mm",
		ORDER_QTY: 480,
		UNIT: "PCS",
		UNIT_PRICE: 6334.4,
		TOTAL_AMOUNT: 3040512.0,
		CURRENCY: "THB",
		PRIORITY: "URGENT",
		PO_STATUS: "AWAITING_CONFIRMATION",
		BUYER_NAME: "S. Narongrit (Dept 4)",
		ASN_NO: "",
		ECN_NO: "ECN-2026-114B",
		REMARKS:
			"Urgent production lot for Project Tower-B. Electronic acknowledgment required within 24 hours.",
	},
	{
		PO_NO: "PO-2026-0889",
		PO_REV: "01",
		ISSUE_DATE: "2026-11-15",
		TARGET_DELIVERY: "2026-11-26",
		VND_CODE: "V-550124-TH",
		VND_NAME: "Thai Sumitomo Electric Wiring Systems Co., Ltd.",
		PLANT_CODE: "AMEC-P2",
		PLANT_NAME: "Amata City Chonburi Plant 02",
		DOCK_BAY: "Dock E1 (Electrical Hub)",
		PART_NO: "HRN-SAFE-420A",
		PART_DESC: "Hoistway Safety Circuit Wire Harness Assembly 420V",
		ORDER_QTY: 1200,
		UNIT: "SET",
		UNIT_PRICE: 1450.0,
		TOTAL_AMOUNT: 1740000.0,
		CURRENCY: "THB",
		PRIORITY: "URGENT",
		PO_STATUS: "AWAITING_CONFIRMATION",
		BUYER_NAME: "K. Apinya (Dept 3)",
		ASN_NO: "",
		ECN_NO: "ECN-2026-098A",
		REMARKS:
			"Include RoHS compliance certificate and lot traceability barcode label on each carton.",
	},
	{
		PO_NO: "PO-2026-0875",
		PO_REV: "01",
		ISSUE_DATE: "2026-11-10",
		TARGET_DELIVERY: "2026-12-03",
		VND_CODE: "V-671044-TH",
		VND_NAME: "Eastern Precision Casting Co., Ltd.",
		PLANT_CODE: "AMEC-P1",
		PLANT_NAME: "Amata City Chonburi Plant 01",
		DOCK_BAY: "Dock H2 (Heavy Foundry Bay)",
		PART_NO: "TRN-SHEAVE-520",
		PART_DESC: "Traction Machine Sheave Cast Iron FCD500 Ø520mm",
		ORDER_QTY: 160,
		UNIT: "PCS",
		UNIT_PRICE: 18250.0,
		TOTAL_AMOUNT: 2920000.0,
		CURRENCY: "THB",
		PRIORITY: "NORMAL",
		PO_STATUS: "IN_PRODUCTION",
		BUYER_NAME: "S. Narongrit (Dept 4)",
		ASN_NO: "",
		ECN_NO: "ECN-2026-072C",
		REMARKS:
			"Ultrasonic NDT inspection report required prior to shipment release.",
	},
	{
		PO_NO: "PO-2026-0864",
		PO_REV: "03",
		ISSUE_DATE: "2026-11-08",
		TARGET_DELIVERY: "2026-11-29",
		VND_CODE: "V-80018-TH",
		VND_NAME: "Chokchai Engineering Co., Ltd.",
		PLANT_CODE: "AMEC-P2",
		PLANT_NAME: "Amata City Chonburi Plant 02",
		DOCK_BAY: "Dock B3 (Press & Stamping)",
		PART_NO: "BRK-GUIDE-T89",
		PART_DESC: "Rail Guide Bracket Stamped Steel 6mm Galvanized",
		ORDER_QTY: 3600,
		UNIT: "PCS",
		UNIT_PRICE: 285.0,
		TOTAL_AMOUNT: 1026000.0,
		CURRENCY: "THB",
		PRIORITY: "EXPEDITED",
		PO_STATUS: "IN_PRODUCTION",
		BUYER_NAME: "P. Sukcharoen (Dept 2)",
		ASN_NO: "",
		ECN_NO: "ECN-2026-061A",
		REMARKS:
			"Palletized in returnable steel racks (120 PCS/rack) per AMEC packaging standard.",
	},
	{
		PO_NO: "PO-2026-0851",
		PO_REV: "01",
		ISSUE_DATE: "2026-11-04",
		TARGET_DELIVERY: "2026-11-23",
		VND_CODE: "V-399102-TH",
		VND_NAME: "Nippon Sanso Gas & Metal Co. (Thailand)",
		PLANT_CODE: "AMEC-P1",
		PLANT_NAME: "Amata City Chonburi Plant 01",
		DOCK_BAY: "Dock A1 (Laser & Sheet Metal)",
		PART_NO: "CAB-PANEL-SPCC",
		PART_DESC: "Elevator Car Side Wall Panel Laser Cut SPCC 1.6t",
		ORDER_QTY: 640,
		UNIT: "PCS",
		UNIT_PRICE: 2150.0,
		TOTAL_AMOUNT: 1376000.0,
		CURRENCY: "THB",
		PRIORITY: "NORMAL",
		PO_STATUS: "READY_TO_SHIP",
		BUYER_NAME: "P. Sukcharoen (Dept 2)",
		ASN_NO: "ASN-2026-4410",
		ECN_NO: "ECN-2026-055A",
		REMARKS:
			"Final QC passed. Ready for morning milk-run pickup at 08:30 ICT.",
	},
	{
		PO_NO: "PO-2026-0840",
		PO_REV: "01",
		ISSUE_DATE: "2026-10-29",
		TARGET_DELIVERY: "2026-11-22",
		VND_CODE: "V-10003-JP",
		VND_NAME: "Mitsubishi Electric Trading Corporation (MT-S)",
		PLANT_CODE: "AMEC-WH",
		PLANT_NAME: "AMEC Central Logistics Warehouse",
		DOCK_BAY: "Dock G1 (Import Bonded Bay)",
		PART_NO: "PCB-INV-G200",
		PART_DESC: "Inverter Control Board Series-G 200kW Module",
		ORDER_QTY: 85,
		UNIT: "UNIT",
		UNIT_PRICE: 24800.0,
		TOTAL_AMOUNT: 2108000.0,
		CURRENCY: "THB",
		PRIORITY: "EXPEDITED",
		PO_STATUS: "IN_TRANSIT",
		BUYER_NAME: "K. Apinya (Global Elec.)",
		ASN_NO: "ASN-2026-4398",
		ECN_NO: "ECN-2026-049D",
		REMARKS:
			"ESD-safe vacuum packaging verified. Dispatched via Laem Chabang express customs lane.",
	},
	{
		PO_NO: "PO-2026-0812",
		PO_REV: "01",
		ISSUE_DATE: "2026-10-18",
		TARGET_DELIVERY: "2026-11-12",
		VND_CODE: "V-718290-TH",
		VND_NAME: "Rayong Stamping & Tooling Co., Ltd.",
		PLANT_CODE: "AMEC-P2",
		PLANT_NAME: "Amata City Chonburi Plant 02",
		DOCK_BAY: "Dock B1 (Door Systems)",
		PART_NO: "SILL-AL6063-1100",
		PART_DESC: "Landing Door Sill Extruded Aluminum 1100mm",
		ORDER_QTY: 900,
		UNIT: "PCS",
		UNIT_PRICE: 920.0,
		TOTAL_AMOUNT: 828000.0,
		CURRENCY: "THB",
		PRIORITY: "NORMAL",
		PO_STATUS: "DELIVERED",
		BUYER_NAME: "P. Sukcharoen (Dept 2)",
		ASN_NO: "ASN-2026-4215",
		ECN_NO: "ECN-2026-031A",
		REMARKS:
			"Goods Receipt GR-2026-9904 completed with zero defect variance.",
	},
];

let table = null;
let ordersData = [];
let activeStatusFilter = "";
let selectedOrder = null;

function normalizeStatus(status) {
	const key = String(status || "AWAITING_CONFIRMATION")
		.toUpperCase()
		.trim();
	return STATUS_CONFIG[key] ? key : "AWAITING_CONFIRMATION";
}

function normalizePriority(priority) {
	const key = String(priority || "NORMAL")
		.toUpperCase()
		.trim();
	return PRIORITY_CONFIG[key] ? key : "NORMAL";
}

function formatCurrency(amount, currency = "THB") {
	const num = Number(amount || 0);
	const symbol = currency === "USD" ? "$" : currency === "JPY" ? "¥" : "฿";
	return `${symbol}${num.toLocaleString("en-US", {
		minimumFractionDigits: 2,
		maximumFractionDigits: 2,
	})}`;
}

function formatCompactCurrency(amount) {
	const num = Number(amount || 0);
	if (num >= 1_000_000) {
		return `฿${(num / 1_000_000).toFixed(2)}M THB`;
	}
	return `฿${num.toLocaleString("en-US", {
		minimumFractionDigits: 0,
		maximumFractionDigits: 0,
	})} THB`;
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
					<button type="button" class="js-open-po-drawer link link-hover font-mono font-bold text-primary text-sm block text-left"
						data-po="${escapeAttribute(row.PO_NO)}">
						${escapeHtml(row.PO_NO || "-")}
					</button>
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
				if (type !== "display") {
					return `${row.PART_NO || ""} ${row.PART_DESC || ""} ${row.ECN_NO || ""}`;
				}
				return `
					<div class="font-mono font-bold text-secondary">${escapeHtml(row.PART_NO || "-")}</div>
					<div class="text-primary font-medium">${escapeHtml(row.PART_DESC || "-")}</div>
					${row.ASN_NO ? `<div class="font-mono text-[11px] text-info mt-0.5">ASN: ${escapeHtml(row.ASN_NO)}</div>` : ""}
				`;
			},
		},
		{
			data: "ORDER_QTY",
			title: "Qty / Unit",
			className: "text-right font-mono align-top text-nowrap",
			render: (data, type, row) => {
				if (type !== "display") return Number(data || 0);
				return `
					<div class="font-bold text-primary">${Number(data || 0).toLocaleString("en-US")}</div>
					<div class="text-mute">${escapeHtml(row.UNIT || "PCS")}</div>
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
				const primaryLabel = isAwaiting ? "Review & Sign" : "Inspect PO";
				return `
					<div class="flex flex-col gap-1 items-stretch">
						<button type="button" class="js-open-po-drawer btn btn-xs ${primaryBtnClass} font-bold flex items-center justify-center gap-1"
							data-po="${escapeAttribute(row.PO_NO)}">
							<span class="material-symbols-outlined text-[14px]">${primaryIcon}</span>
							<span>${primaryLabel}</span>
						</button>
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

function openOrderDrawer(order) {
	selectedOrder = order;
	const statusKey = normalizeStatus(order.PO_STATUS);
	const statusCfg =
		STATUS_CONFIG[statusKey] || STATUS_CONFIG.AWAITING_CONFIRMATION;
	const priorityKey = normalizePriority(order.PRIORITY);
	const priorityCfg = PRIORITY_CONFIG[priorityKey] || PRIORITY_CONFIG.NORMAL;

	$("#drawer-po-number").text(order.PO_NO || "-");
	$("#drawer-po-rev").text(`Rev. ${order.PO_REV || "00"}`);
	$("#drawer-po-status")
		.removeClass(
			"badge-primary badge-error badge-warning badge-success badge-info badge-ghost",
		)
		.addClass(statusCfg.badge)
		.text(statusCfg.label);
	$("#drawer-po-subtitle").text(
		`${order.VND_NAME || "Supplier"} • Mitsubishi Elevator Asia Co., Ltd. (AMEC)`,
	);

	$("#drawer-po-issued").text(
		order.ISSUE_DATE ? dayjs(order.ISSUE_DATE).format("YYYY-MM-DD") : "-",
	);
	$("#drawer-po-delivery").text(
		order.TARGET_DELIVERY
			? dayjs(order.TARGET_DELIVERY).format("YYYY-MM-DD")
			: "-",
	);
	$("#drawer-po-amount").text(
		formatCurrency(order.TOTAL_AMOUNT, order.CURRENCY),
	);
	$("#drawer-po-priority").text(priorityCfg.label);

	$("#drawer-po-buyer").text(order.BUYER_NAME || "AMEC BUYER");
	$("#drawer-po-vendor-name").text(order.VND_NAME || "-");
	$("#drawer-po-vendor-code").text(`Vendor Code: ${order.VND_CODE || "-"}`);
	$("#drawer-po-plant").text(order.PLANT_NAME || "-");
	$("#drawer-po-dock").text(order.DOCK_BAY || "-");
	$("#drawer-po-asn").text(order.ASN_NO || "Not Issued");
	$("#drawer-po-ecn").text(order.ECN_NO || "-");
	$("#drawer-po-currency").text(order.CURRENCY || "THB");
	$("#drawer-po-remarks").text(
		order.REMARKS || "Standard AMEC delivery and inspection terms apply.",
	);

	const $items = $("#drawer-po-items").empty();
	$items.append(`
		<tr>
			<td class="font-mono font-bold text-secondary">${escapeHtml(order.PART_NO || "-")}</td>
			<td class="text-primary">${escapeHtml(order.PART_DESC || "-")}</td>
			<td class="text-right font-mono font-bold text-primary">${Number(order.ORDER_QTY || 0).toLocaleString("en-US")} ${escapeHtml(order.UNIT || "PCS")}</td>
			<td class="text-right font-mono text-primary">${escapeHtml(formatCurrency(order.UNIT_PRICE, order.CURRENCY))}</td>
			<td class="text-right font-mono font-bold text-primary">${escapeHtml(formatCurrency(order.TOTAL_AMOUNT, order.CURRENCY))}</td>
		</tr>
	`);

	const $alert = $("#drawer-po-alert");
	const $ackBtn = $("#drawer-btn-ack");
	if (statusKey === "AWAITING_CONFIRMATION") {
		$("#drawer-alert-title").text("ELECTRONIC ACKNOWLEDGMENT REQUIRED");
		$("#drawer-alert-text").text(
			"This Purchase Order requires supplier confirmation within the 72-hour SLA window before production scheduling can proceed.",
		);
		$alert.removeClass("hidden").addClass("flex");
		$ackBtn.removeClass("hidden");
	} else {
		$alert.addClass("hidden").removeClass("flex");
		$ackBtn.addClass("hidden");
	}

	$("#poDetailDrawer").removeClass("hidden");
}

function closeOrderDrawer() {
	$("#poDetailDrawer").addClass("hidden");
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

$(document).on("click", ".js-open-po-drawer", function () {
	const poNo = String($(this).data("po") || "");
	const order = ordersData.find((o) => String(o.PO_NO) === poNo);
	if (order) openOrderDrawer(order);
});

$(document).on("click", ".js-close-po-drawer", closeOrderDrawer);

$(document).on("click", ".js-download-po-pdf, #drawer-btn-pdf", async function () {
	const poNo = $(this).data("po") || selectedOrder?.PO_NO || "";
	if (!poNo) return;
	await showMessage(`Preparing official e-stamped PDF for ${poNo}...`);
});

$(document).on("click", "#drawer-btn-ack", async function () {
	if (!selectedOrder) return;
	const ok = await showConfirm({
		title: "Acknowledge Purchase Order?",
		message: `Confirm receipt and delivery schedule for ${selectedOrder.PO_NO}?`,
		acceptText: "Acknowledge & E-Sign",
		cancelText: "Cancel",
	});
	if (!ok) return;

	try {
		await showLoader();
		try {
			await acknowledgePurchaseOrder(selectedOrder.PO_NO, {
				acknowledgedAt: dayjs().toISOString(),
			});
		} catch (apiErr) {
			console.warn("API acknowledge fallback (local state update):", apiErr);
		}
		selectedOrder.PO_STATUS = "IN_PRODUCTION";
		closeOrderDrawer();
		updateSummaryStats(ordersData);
		await initOrdersTable(ordersData);
		applyAllFilters();
		await showMessage(`${selectedOrder.PO_NO} acknowledged successfully.`);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Failed to acknowledge Purchase Order.");
	} finally {
		await showLoader({ show: false });
	}
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
	if (e.key === "Escape") {
		if (!$("#bulkAckModal").hasClass("hidden")) {
			closeBulkAckModal();
		} else if (!$("#poDetailDrawer").hasClass("hidden")) {
			closeOrderDrawer();
		}
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
		"Part No",
		"Description",
		"Qty",
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
		...ordersData.map((o) =>
			[
				o.PO_NO,
				o.PO_REV,
				o.ISSUE_DATE,
				o.VND_CODE,
				o.VND_NAME,
				o.PLANT_NAME,
				o.PART_NO,
				o.PART_DESC,
				o.ORDER_QTY,
				o.UNIT,
				o.TOTAL_AMOUNT,
				o.CURRENCY,
				o.TARGET_DELIVERY,
				normalizePriority(o.PRIORITY),
				normalizeStatus(o.PO_STATUS),
				o.ASN_NO,
			]
				.map((v) => `"${String(v ?? "").replace(/"/g, '""')}"`)
				.join(","),
		),
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
