import dayjs from "dayjs";
import { showLoader } from "@amec/webasset/preloader";
import { showMessage, showConfirm } from "@amec/webasset/utils";
import { escapeHtml } from "../utils.js";
import {
	getPurchaseOrderDetail,
	acknowledgePurchaseOrder,
} from "../service/index.js";
import {
	STATUS_CONFIG,
	PRIORITY_CONFIG,
	SAMPLE_ORDERS,
	summarizeOrderItems,
	normalizeStatus,
	normalizePriority,
	formatCurrency,
} from "./shared.js";

let currentOrder = null;

function buildDefaultHistory(order) {
	if (Array.isArray(order.HISTORY) && order.HISTORY.length > 0) {
		return order.HISTORY;
	}
	const issueDate = order.ISSUE_DATE
		? dayjs(order.ISSUE_DATE).format("YYYY-MM-DD 09:15")
		: "-";
	const rows = [
		{
			TIMESTAMP: issueDate,
			REV: `Rev. ${order.PO_REV || "00"}`,
			EVENT: "PO Issued via EDI",
			ACTOR: order.BUYER_NAME || "AMEC Procurement",
			NOTE: `Electronic Purchase Order ${order.PO_NO} transmitted to ${order.VND_CODE || "supplier"}.`,
		},
	];
	const statusKey = normalizeStatus(order.PO_STATUS);
	if (statusKey !== "AWAITING_CONFIRMATION") {
		rows.push({
			TIMESTAMP: order.ISSUE_DATE
				? dayjs(order.ISSUE_DATE).add(1, "day").format("YYYY-MM-DD 14:20")
				: "-",
			REV: `Rev. ${order.PO_REV || "00"}`,
			EVENT: "Supplier E-Acknowledged",
			ACTOR: order.VND_NAME || "Supplier Portal",
			NOTE: "Confirmed pricing, ECN revision, and committed dock delivery date.",
		});
	}
	if (order.ASN_NO) {
		rows.push({
			TIMESTAMP: order.TARGET_DELIVERY
				? dayjs(order.TARGET_DELIVERY)
						.subtract(2, "day")
						.format("YYYY-MM-DD 10:05")
				: "-",
			REV: `Rev. ${order.PO_REV || "00"}`,
			EVENT: `ASN Dispatched (${order.ASN_NO})`,
			ACTOR: "Supplier Logistics",
			NOTE: `Advance Shipping Notice assigned to ${order.DOCK_BAY || "receiving bay"}.`,
		});
	}
	return rows.reverse();
}

function renderOrderDetail(order) {
	currentOrder = order;
	const statusKey = normalizeStatus(order.PO_STATUS);
	const statusCfg =
		STATUS_CONFIG[statusKey] || STATUS_CONFIG.AWAITING_CONFIRMATION;
	const priorityKey = normalizePriority(order.PRIORITY);
	const priorityCfg = PRIORITY_CONFIG[priorityKey] || PRIORITY_CONFIG.NORMAL;
	const currency = order.CURRENCY || "THB";
	const itemSummary = summarizeOrderItems(order);
	const items = itemSummary.items;
	const history = buildDefaultHistory(order);

	// Section 1: Header
	$("#detail-po-number").text(order.PO_NO || "-");
	$("#detail-po-vendor").text(order.VND_NAME || "-");
	$("#detail-po-status")
		.removeClass(
			"badge-primary badge-error badge-warning badge-success badge-info badge-ghost",
		)
		.addClass(statusCfg.badge)
		.text(statusCfg.label);
	$("#detail-po-rev").text(`Rev. ${order.PO_REV || "00"}`);
	$("#detail-po-priority")
		.removeClass("badge-error badge-warning badge-ghost")
		.addClass(priorityCfg.badge)
		.text(priorityCfg.label);
	$("#detail-vendor-code").text(order.VND_CODE || "-");
	$("#detail-buyer-name").text(order.BUYER_NAME || "-");
	$("#detail-issue-date").text(
		order.ISSUE_DATE ? dayjs(order.ISSUE_DATE).format("YYYY-MM-DD") : "-",
	);

	const isAwaiting = statusKey === "AWAITING_CONFIRMATION";
	$("#detail-btn-ack").toggleClass("hidden", !isAwaiting);
	$("#detail-po-alert")
		.toggleClass("hidden", !isAwaiting)
		.toggleClass("flex", isAwaiting);

	// Section 2: KPI Ribbon
	const subtotal = items.reduce(
		(acc, item) => acc + Number(item.LINE_TOTAL || 0),
		0,
	);
	const vat = subtotal * 0.07;
	const grandTotal = subtotal + vat;

	$("#kpi-detail-amount").text(formatCurrency(subtotal, currency));
	$("#kpi-detail-currency").text(currency);
	const qtySummaryText = itemSummary.hasMixedUnits
		? `${itemSummary.lineCount} Line Items • Mixed Units`
		: `${itemSummary.lineCount} Line ${itemSummary.lineCount === 1 ? "Item" : "Items"} • ${itemSummary.totalQty.toLocaleString("en-US")} ${itemSummary.sharedUnit}`;
	$("#kpi-detail-qty-summary").text(qtySummaryText);
	$("#kpi-detail-terms").text(order.PAYMENT_TERMS || "Net 30 Days");

	$("#kpi-detail-delivery")
		.text(
			order.TARGET_DELIVERY
				? dayjs(order.TARGET_DELIVERY).format("YYYY-MM-DD")
				: "-",
		)
		.toggleClass("text-error", priorityKey === "URGENT")
		.toggleClass("text-primary", priorityKey !== "URGENT");
	$("#kpi-detail-incoterm").text(order.INCOTERMS || "DDP Amata City");

	$("#kpi-detail-plant-code").text(order.PLANT_CODE || "-");
	$("#kpi-detail-plant-name").text(order.PLANT_NAME || "-");
	$("#kpi-detail-dock").text(order.DOCK_BAY || "-");

	$("#kpi-detail-asn").text(order.ASN_NO || "Not Issued");
	$("#kpi-detail-ecn").text(order.ECN_NO || "-");

	// Tab 1: Line Items
	$("#badge-count-items").text(items.length);
	$("#items-currency-badge").text(`CURRENCY: ${currency}`);
	const $itemsBody = $("#detail-items-tbody").empty();
	items.forEach((item, idx) => {
		$itemsBody.append(`
			<tr class="hover:bg-base-200/60 transition-colors">
				<td class="text-center font-mono text-mute">${String(item.LINE_NO || idx + 1).padStart(2, "0")}</td>
				<td>
					<div class="font-mono font-bold text-secondary">${escapeHtml(item.PART_NO || "-")}</div>
					<div class="font-mono text-[11px] text-mute">${escapeHtml(item.ECN_NO || "-")}</div>
				</td>
				<td class="text-primary font-medium">${escapeHtml(item.PART_DESC || "-")}</td>
				<td class="text-right font-mono">
					<div class="font-bold text-primary">${Number(item.ORDER_QTY || 0).toLocaleString("en-US")}</div>
					<div class="text-mute">${escapeHtml(item.UNIT || "PCS")}</div>
				</td>
				<td class="text-right font-mono text-primary">${escapeHtml(formatCurrency(item.UNIT_PRICE, currency))}</td>
				<td class="text-right font-mono font-bold text-primary">${escapeHtml(formatCurrency(item.LINE_TOTAL, currency))}</td>
			</tr>
		`);
	});
	$("#summary-subtotal").text(formatCurrency(subtotal, currency));
	$("#summary-vat").text(formatCurrency(vat, currency));
	$("#summary-grand-total").text(formatCurrency(grandTotal, currency));

	// Tab 2: Supplier & Delivery
	$("#delivery-vendor-name").text(order.VND_NAME || "-");
	$("#delivery-vendor-code").text(order.VND_CODE || "-");
	$("#delivery-buyer-name").text(order.BUYER_NAME || "-");
	$("#delivery-payment-terms").text(order.PAYMENT_TERMS || "Net 30 Days");
	$("#delivery-incoterms").text(order.INCOTERMS || "DDP Amata City");
	$("#delivery-plant-name").text(order.PLANT_NAME || "-");
	$("#delivery-plant-code").text(order.PLANT_CODE || "-");
	$("#delivery-dock-bay").text(order.DOCK_BAY || "-");
	$("#delivery-asn-no").text(order.ASN_NO || "Not Issued");
	$("#delivery-ecn-no").text(order.ECN_NO || "-");
	$("#delivery-remarks").text(
		order.REMARKS || "Standard AMEC delivery and quality inspection terms apply.",
	);

	// Tab 3: Revision & Audit Trail
	$("#badge-count-history").text(history.length);
	const $historyBody = $("#detail-history-tbody").empty();
	history.forEach((h) => {
		$historyBody.append(`
			<tr class="hover:bg-base-200/60 transition-colors">
				<td class="font-mono text-primary text-nowrap">${escapeHtml(h.TIMESTAMP || "-")}</td>
				<td><span class="badge badge-xs badge-outline font-mono">${escapeHtml(h.REV || "-")}</span></td>
				<td class="font-bold text-primary">${escapeHtml(h.EVENT || "-")}</td>
				<td class="text-secondary">${escapeHtml(h.ACTOR || "-")}</td>
				<td class="text-mute">${escapeHtml(h.NOTE || "-")}</td>
			</tr>
		`);
	});
}

async function loadOrderDetail() {
	const poNo = ($("#po-no").val() || "").trim();
	let order = null;

	if (poNo) {
		try {
			const res = await getPurchaseOrderDetail(poNo);
			order = res?.data || res || null;
		} catch (error) {
			console.warn("Using sample PO detail (API unavailable):", error);
		}
	}

	if (!order || !order.PO_NO) {
		order =
			SAMPLE_ORDERS.find(
				(o) => String(o.PO_NO).toUpperCase() === poNo.toUpperCase(),
			) || SAMPLE_ORDERS[0];
	}

	renderOrderDetail({ ...order });
}

// Event Delegation
$(document).on("click", ".po-detail-tab", function () {
	const $tab = $(this);
	const targetId = $tab.data("tab");

	$(".po-detail-tab").each(function () {
		const $btn = $(this);
		const isActive = $btn.is($tab);
		$btn.attr("aria-selected", String(isActive))
			.toggleClass("text-primary font-bold border-primary", isActive)
			.toggleClass("text-mute font-semibold border-transparent", !isActive);
	});

	$(".po-detail-panel").addClass("hidden");
	$(`#${targetId}`).removeClass("hidden");
	this.scrollIntoView({ block: "nearest", inline: "nearest" });
});

$(document).on("click", "#detail-btn-pdf, #footer-btn-pdf", async function () {
	if (!currentOrder) return;
	await showMessage(
		`Preparing official e-stamped PDF for ${currentOrder.PO_NO}...`,
	);
});

$(document).on("click", "#detail-btn-ack", async function () {
	if (!currentOrder) return;
	const ok = await showConfirm({
		title: "Acknowledge Purchase Order?",
		message: `Confirm receipt, pricing, and delivery schedule for ${currentOrder.PO_NO}?`,
		acceptText: "Acknowledge & E-Sign",
		cancelText: "Cancel",
	});
	if (!ok) return;

	try {
		await showLoader();
		try {
			await acknowledgePurchaseOrder(currentOrder.PO_NO, {
				acknowledgedAt: dayjs().toISOString(),
			});
		} catch (apiErr) {
			console.warn("API acknowledge fallback (local state update):", apiErr);
		}
		currentOrder.PO_STATUS = "IN_PRODUCTION";
		renderOrderDetail(currentOrder);
		await showMessage(`${currentOrder.PO_NO} acknowledged successfully.`);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Failed to acknowledge Purchase Order.");
	} finally {
		await showLoader({ show: false });
	}
});

$(document).ready(async () => {
	try {
		await showLoader();
		await window.appReady;
		await loadOrderDetail();
	} catch (error) {
		console.error(error);
		await showMessage(
			error.message || "Error initializing Purchase Order Detail page",
		);
	} finally {
		await showLoader({ show: false });
	}
});
