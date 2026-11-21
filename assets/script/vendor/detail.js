import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { getVendors } from "../service/index.js";
import { escapeHtml, escapeAttribute } from "../utils.js";

const statusBadges = {
	0: { class: "badge-warning", text: "Creating" },
	1: { class: "badge-success", text: "Active" },
	2: { class: "badge-error", text: "Inactive" },
};

const setText = (elementId, text) => {
	$(`#${elementId}`).text(text ? text : "-");
};

const formatDate = (dateString) => {
	if (!dateString) return "-";
	const date = new Date(dateString);
	if (Number.isNaN(date.getTime())) return dateString;
	return (
		date.toLocaleDateString("en-GB") +
		" " +
		date.toLocaleTimeString("en-GB", {
			hour: "2-digit",
			minute: "2-digit",
		})
	);
};

function updateVendorStatus(statusCode) {
	const $badge = $("#view-VND_STATUS");
	$badge.removeClass("badge-warning badge-success badge-error badge-ghost");
	if (statusBadges[statusCode]) {
		$badge
			.addClass(statusBadges[statusCode].class)
			.text(statusBadges[statusCode].text);
	} else {
		$badge.addClass("badge-ghost").text("Unknown");
	}
}

function renderAttachments(files = []) {
	const $container = $("#existing-files-container");
	$container.empty();

	if (!files.length) {
		$container.append(
			'<span class="text-mute italic text-xs">No attachments available.</span>',
		);
		return;
	}

	files.forEach((file) => {
		const fileName = escapeHtml(file.FILE_NAME || file.UFILE_NAME || "File");
		const fileUrl = escapeAttribute(`/uploads/${file.UFILE_NAME || ""}`);
		$container.append(`
			<div class="flex items-center justify-between gap-2 px-3 py-2 bg-base-200 border border-base-300">
				<div class="flex items-center gap-2 min-w-0">
					<span class="material-symbols-outlined text-[16px] text-secondary shrink-0">description</span>
					<a href="${fileUrl}" target="_blank" rel="noopener noreferrer"
						class="link link-hover text-xs font-mono text-info truncate">
						${fileName}
					</a>
				</div>
				<a href="${fileUrl}" target="_blank" rel="noopener noreferrer"
					class="btn btn-xs btn-outline border-base-300 shrink-0 gap-1">
					<span class="material-symbols-outlined text-[13px]">open_in_new</span>
					<span>View</span>
				</a>
			</div>
		`);
	});
}

function renderVendorCodes(codes = []) {
	const $tbody = $("#view-vendor-code-container");
	$tbody.empty();

	if (!codes.length) {
		$tbody.append(`
			<tr>
				<td colspan="4" class="py-6 text-center text-mute italic">No vendor codes available.</td>
			</tr>
		`);
		return;
	}

	codes.forEach((item) => {
		const statusHtml =
			item.CODE_STATUS == 1
				? '<span class="badge badge-xs badge-success font-bold uppercase">Active</span>'
				: item.CODE_STATUS == 0
					? '<span class="badge badge-xs badge-error font-bold uppercase">Inactive</span>'
					: '<span class="badge badge-xs badge-ghost font-bold uppercase">-</span>';

		$tbody.append(`
			<tr class="hover:bg-base-200/60 transition-colors">
				<td class="font-mono font-bold text-primary py-3">${escapeHtml(item.CODE_NUM || "-")}</td>
				<td class="font-mono text-secondary py-3">${escapeHtml(item.CODE_CURRENCY || "-")}</td>
				<td class="text-primary py-3">${escapeHtml(item.CODE_PAY || "-")}</td>
				<td class="text-center py-3">${statusHtml}</td>
			</tr>
		`);
	});
}

function renderVendorDetail(vendorData) {
	updateVendorStatus(vendorData.VND_STATUS);
	setText("view-VND_CODE", vendorData.VND_CODE || vendorData.VND_ID);
	setText("view-VND_NAME", vendorData.VND_NAME);
	setText("view-VND_TNAME", vendorData.VND_TNAME);
	setText("view-VND_SALE", vendorData.VND_SALE);
	setText("view-ADDR_PHONE", vendorData.ADDR_PHONE);

	const $web = $("#view-ADDR_WEB");
	if (vendorData.ADDR_WEB) {
		const href = /^https?:\/\//i.test(vendorData.ADDR_WEB)
			? vendorData.ADDR_WEB
			: `https://${vendorData.ADDR_WEB}`;
		$web.attr("href", href).text(vendorData.ADDR_WEB);
	} else {
		$web.attr("href", "#").text("-");
	}

	setText("view-VND_REGNAME", vendorData.VND_REGNAME);
	setText(
		"view-VND_REGDATE",
		formatDate(vendorData.VND_REGDATE || vendorData.VND_REGISTED),
	);
	setText("view-VND_LASTUPDATE", formatDate(vendorData.VND_LASTUPDATE));

	const addresses = vendorData.VENDOR_ADDRESS || [];
	const enAddress = addresses.find((addr) => addr.ADDR_TYPE === "E");
	const thAddress = addresses.find((addr) => addr.ADDR_TYPE === "T");

	if (enAddress) {
		setText("view-ADDR_EN_LINE1", enAddress.ADDR_LINE1);
		setText("view-ADDR_EN_LINE2", enAddress.ADDR_LINE2);
		setText("view-ADDR_EN_LINE3", enAddress.ADDR_LINE3);
		setText("view-ADDR_EN_SUBDISTRICT", enAddress.ADDR_SUBDISTRICT);
		setText("view-ADDR_EN_CITY", enAddress.ADDR_CITY);
		setText("view-ADDR_EN_STATE", enAddress.ADDR_STATE);
		setText("view-ADDR_EN_ZIPCODE", enAddress.ADDR_ZIPCODE);
		setText("view-ADDR_EN_COUNTRY", enAddress.ADDR_COUNTRY);
	} else {
		setText("view-ADDR_EN_LINE1", vendorData.VND_ADDRESS1);
		setText("view-ADDR_EN_LINE2", vendorData.VND_ADDRESS2);
		setText("view-ADDR_EN_LINE3", vendorData.VND_ADDRESS3);
		setText("view-ADDR_EN_CITY", vendorData.VND_CITY);
		setText("view-ADDR_EN_STATE", vendorData.VND_STATE);
		setText("view-ADDR_EN_ZIPCODE", vendorData.VND_ZIPCODE);
		setText("view-ADDR_EN_COUNTRY", vendorData.VND_COUNTRY);
	}

	if (thAddress) {
		setText("view-ADDR_TH_LINE1", thAddress.ADDR_LINE1);
		setText("view-ADDR_TH_LINE2", thAddress.ADDR_LINE2);
		setText("view-ADDR_TH_LINE3", thAddress.ADDR_LINE3);
		setText("view-ADDR_TH_SUBDISTRICT", thAddress.ADDR_SUBDISTRICT);
		setText("view-ADDR_TH_CITY", thAddress.ADDR_CITY);
		setText("view-ADDR_TH_STATE", thAddress.ADDR_STATE);
		setText("view-ADDR_TH_ZIPCODE", thAddress.ADDR_ZIPCODE);
		setText("view-ADDR_TH_COUNTRY", thAddress.ADDR_COUNTRY);
	}

	renderAttachments(vendorData.VENDOR_ATTFILE || []);
	renderVendorCodes(vendorData.VENDOR_CODES || []);
}

$(document).on("click", ".vendor-detail-tab", function () {
	const $tab = $(this);
	const targetId = $tab.data("tab");

	$(".vendor-detail-tab").each(function () {
		const $btn = $(this);
		const isActive = $btn.is($tab);
		$btn.attr("aria-selected", String(isActive))
			.toggleClass("text-primary font-bold border-primary", isActive)
			.toggleClass("text-mute font-semibold border-transparent", !isActive);
	});

	$(".vendor-detail-panel").each(function () {
		const $panel = $(this);
		const show = $panel.attr("id") === targetId;
		$panel.toggleClass("block!", show).toggleClass("hidden!", !show);
	});
});

$(document).ready(async () => {
	try {
		await showLoader();
		await window.appReady;

		const vendorId =
			$("#vnd-id").val() || window.location.pathname.split("/").pop();
		const response = await getVendors();
		const allVendors = Array.isArray(response)
			? response
			: response?.data || [];

		const vendorData = allVendors.find(
			(vendor) => vendor.VND_ID == vendorId || vendor.VND_CODE == vendorId,
		);

		if (!vendorData) {
			await showMessage(`Vendor record (${vendorId}) not found.`);
			return;
		}

		renderVendorDetail(vendorData);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error loading vendor details");
	} finally {
		await showLoader({ show: false });
	}
});
