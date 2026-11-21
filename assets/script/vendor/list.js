import "@amec/webasset/css/dataTable.min.css";
import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { createTable } from "@amec/webasset/dataTable";
import { tableOpt, escapeHtml, escapeAttribute } from "../utils.js";
import { getVendors } from "../service/index.js";

let table = null;
let scopedVendors = [];
let activeTab = "ALL";

function isIndirectVendor(row) {
	const code = String(row.VND_CODE || "").trim();
	const type1 = String(row.VND_TYPE1 || "").toUpperCase().trim();
	return code.startsWith("6") || type1 === "INDIRECT";
}

function isSubconVendor(row) {
	const code = String(row.VND_CODE || "").trim();
	const type1 = String(row.VND_TYPE1 || "").toUpperCase().trim();
	return code.startsWith("8") || type1 === "SUBCON";
}

function isActiveStatus(status) {
	if (status === 1 || status === "1") return true;
	const s = String(status || "").toUpperCase().trim();
	return s === "ACTIVE" || s === "A" || s === "";
}

// Project strictly to General Information fields only (no financial/confidential data)
function toGeneralRecord(row) {
	const code = String(row.VND_CODE || "").trim();
	const isSubcon = isSubconVendor(row);
	return {
		VND_CODE: code,
		VND_NAME: row.VND_NAME || "-",
		VND_CATEGORY: row.VND_CATEGORY || "",
		VND_CLASS: row.VND_CLASS || "",
		VND_ORIGIN: row.VND_ORIGIN || "",
		VND_ADDRESS1: row.VND_ADDRESS1 || "",
		VND_ADDRESS2: row.VND_ADDRESS2 || "",
		VND_CITY: row.VND_CITY || "",
		VND_STATE: row.VND_STATE || "",
		VND_COUNTRY: row.VND_COUNTRY || "",
		VND_CONTACTNAME: row.VND_CONTACTNAME || "",
		VND_PHONE: row.VND_PHONE || "",
		VND_FAX: row.VND_FAX || "",
		VND_STATUS: row.VND_STATUS ?? "ACTIVE",
		GROUP_KEY: isSubcon ? "SUBCON" : "INDIRECT",
		GROUP_LABEL: isSubcon
			? "Subcontractor"
			: code.startsWith("69")
				? "Indirect (Oversea)"
				: "Indirect",
	};
}

function getStatusBadge(status) {
	const s = String(status ?? "").toUpperCase().trim();
	if (s === "1" || s === "ACTIVE" || s === "") {
		return '<span class="badge badge-xs badge-success font-mono font-bold uppercase">Active</span>';
	}
	if (s === "HOLD") {
		return '<span class="badge badge-xs badge-warning font-mono font-bold uppercase">Hold</span>';
	}
	return '<span class="badge badge-xs badge-error font-mono font-bold uppercase">Inactive</span>';
}

function getGroupBadge(record) {
	const cls = record.GROUP_KEY === "SUBCON" ? "badge-warning" : "badge-info";
	return `<span class="badge badge-xs ${cls} font-mono font-bold uppercase">${escapeHtml(record.GROUP_LABEL)}</span>`;
}

function updateTabCounts(data) {
	const total = data.length;
	const indirect = data.filter((r) => r.GROUP_KEY === "INDIRECT").length;
	const subcon = data.filter((r) => r.GROUP_KEY === "SUBCON").length;
	const active = data.filter((r) => isActiveStatus(r.VND_STATUS)).length;

	$('#vendorListTabs [data-count="ALL"]').text(total.toLocaleString());
	$('#vendorListTabs [data-count="INDIRECT"]').text(indirect.toLocaleString());
	$('#vendorListTabs [data-count="SUBCON"]').text(subcon.toLocaleString());
	$('#vendorListTabs [data-count="ACTIVE"]').text(active.toLocaleString());
}

function updateKpi(data) {
	const total = data.length;
	const indirectRows = data.filter((r) => r.GROUP_KEY === "INDIRECT");
	const indirectLocal = indirectRows.filter((r) => !r.VND_CODE.startsWith("69")).length;
	const indirectOversea = indirectRows.length - indirectLocal;
	const subcon = data.filter((r) => r.GROUP_KEY === "SUBCON").length;
	const active = data.filter((r) => isActiveStatus(r.VND_STATUS)).length;
	const activePct = total ? Math.round((active / total) * 100) : 0;
	const categories = new Set(data.map((r) => r.VND_CATEGORY.trim().toUpperCase()).filter(Boolean)).size;
	const countries = new Set(data.map((r) => r.VND_COUNTRY.trim().toUpperCase()).filter(Boolean)).size;

	$("#kpi-list-total").text(total.toLocaleString());
	$("#kpi-list-indirect").text(indirectRows.length.toLocaleString());
	$("#kpi-list-indirect-split").text(`${indirectLocal} / ${indirectOversea}`);
	$("#kpi-list-subcon").text(subcon.toLocaleString());
	$("#kpi-list-categories").text(categories.toLocaleString());
	$("#kpi-list-active").text(active.toLocaleString());
	$("#kpi-list-active-pct").text(`${activePct}%`);
	$("#kpi-list-countries").text(countries.toLocaleString());

	updateTabCounts(data);
}

function populateDropdowns(data) {
	const categories = [...new Set(data.map((r) => r.VND_CATEGORY.trim()).filter(Boolean))].sort();
	const countries = [...new Set(data.map((r) => r.VND_COUNTRY.trim()).filter(Boolean))].sort();

	const $cat = $("#listCategoryFilter");
	$cat.find("option:not(:first)").remove();
	categories.forEach((c) => {
		$cat.append(`<option value="${escapeAttribute(c)}">${escapeHtml(c)}</option>`);
	});

	const $country = $("#listCountryFilter");
	$country.find("option:not(:first)").remove();
	countries.forEach((c) => {
		$country.append(`<option value="${escapeAttribute(c)}">${escapeHtml(c)}</option>`);
	});
}

function applyFilters() {
	if (!table) return;

	const query = ($("#listSearchInput").val() || "").toString().toLowerCase().trim();
	const category = ($("#listCategoryFilter").val() || "").toString().trim().toUpperCase();
	const country = ($("#listCountryFilter").val() || "").toString().trim().toUpperCase();

	const baseFiltered = scopedVendors.filter((row) => {
		if (category && row.VND_CATEGORY.trim().toUpperCase() !== category) return false;
		if (country && row.VND_COUNTRY.trim().toUpperCase() !== country) return false;
		if (query) {
			const hay = [
				row.VND_CODE,
				row.VND_NAME,
				row.VND_CATEGORY,
				row.VND_CONTACTNAME,
				row.VND_PHONE,
				row.VND_CITY,
				row.VND_STATE,
				row.VND_COUNTRY,
				row.GROUP_LABEL,
			]
				.filter(Boolean)
				.join(" ")
				.toLowerCase();
			if (!hay.includes(query)) return false;
		}
		return true;
	});

	updateTabCounts(baseFiltered);

	const filtered = baseFiltered.filter((row) => {
		if (activeTab === "INDIRECT") return row.GROUP_KEY === "INDIRECT";
		if (activeTab === "SUBCON") return row.GROUP_KEY === "SUBCON";
		if (activeTab === "ACTIVE") return isActiveStatus(row.VND_STATUS);
		return true;
	});

	table.clear();
	table.rows.add(filtered);
	table.draw();

	$("#listActiveSummary").text(
		`Showing ${filtered.length.toLocaleString()} of ${scopedVendors.length.toLocaleString()} Indirect & Subcontractor records`,
	);
}

function openGeneralDrawer(vndCode) {
	const rec = scopedVendors.find((r) => r.VND_CODE === String(vndCode));
	if (!rec) return;

	const setVal = (id, val) => {
		$(`#${id}`).text(val && String(val).trim() !== "" ? val : "-");
	};

	setVal("drawer-gen-code", rec.VND_CODE);
	setVal("drawer-gen-code-val", rec.VND_CODE);
	setVal("drawer-gen-group", rec.GROUP_LABEL);
	setVal("drawer-gen-name", rec.VND_NAME);
	setVal("generalDrawerTitle", rec.VND_NAME);
	setVal("drawer-gen-category", rec.VND_CATEGORY);
	setVal("drawer-gen-class", rec.VND_CLASS);
	setVal("drawer-gen-origin", rec.VND_ORIGIN);
	setVal("drawer-gen-contact", rec.VND_CONTACTNAME);
	setVal("drawer-gen-phone", rec.VND_PHONE);
	setVal("drawer-gen-fax", rec.VND_FAX);
	setVal("drawer-gen-addr1", rec.VND_ADDRESS1);
	setVal("drawer-gen-addr2", rec.VND_ADDRESS2);
	setVal("drawer-gen-city", rec.VND_CITY);
	setVal("drawer-gen-state", rec.VND_STATE);
	setVal("drawer-gen-country", rec.VND_COUNTRY);

	const $status = $("#drawer-gen-status");
	$status.removeClass("badge-success badge-warning badge-error");
	if (isActiveStatus(rec.VND_STATUS)) {
		$status.addClass("badge-success").text("Active");
	} else if (String(rec.VND_STATUS).toUpperCase() === "HOLD") {
		$status.addClass("badge-warning").text("Hold");
	} else {
		$status.addClass("badge-error").text("Inactive");
	}

	const $group = $("#drawer-gen-group");
	$group
		.removeClass("badge-info badge-warning")
		.addClass(rec.GROUP_KEY === "SUBCON" ? "badge-warning" : "badge-info");

	$("#vendorGeneralDrawer").removeClass("hidden");
}

function closeGeneralDrawer() {
	$("#vendorGeneralDrawer").addClass("hidden");
}

async function initTable(data) {
	const opt = { ...tableOpt };
	opt.data = data;
	opt.order = [[0, "asc"]];
	opt.dom = `<"overflow-x-auto"t><"dt-footer-bar px-space-md py-3 bg-base-100 border-t border-base-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-mute"<"table-info"i><"table-page"p>>`;
	opt.language = {
		...tableOpt.language,
		info: 'Showing <strong class="text-primary">_START_ - _END_</strong> of <strong class="text-primary">_TOTAL_</strong> Approved Vendors',
		infoEmpty:
			'Showing <strong class="text-primary">0 - 0</strong> of <strong class="text-primary">0</strong> Approved Vendors',
	};

	opt.columns = [
		{
			data: "VND_CODE",
			title: "Vendor Code &amp; Group",
			className: "align-top py-3 text-nowrap",
			render: (data, type, row) => {
				if (type !== "display") return `${data || ""} ${row.GROUP_LABEL}`;
				return `
					<div class="flex flex-col gap-1">
						<button type="button" data-code="${escapeAttribute(data)}"
							class="btn-view-general link link-hover font-mono font-bold text-primary text-sm text-left cursor-pointer">
							${escapeHtml(data)}
						</button>
						<div>${getGroupBadge(row)}</div>
					</div>
				`;
			},
		},
		{
			data: "VND_NAME",
			title: "Vendor Name, Class &amp; Category",
			className: "align-top py-3 min-w-[240px]",
			render: (data, type, row) => {
				if (type !== "display")
					return `${data || ""} ${row.VND_CLASS || ""} ${row.VND_CATEGORY || ""}`;
				const classBadge = row.VND_CLASS
					? `<span class="badge badge-xs badge-secondary font-mono font-bold uppercase">${escapeHtml(row.VND_CLASS)}</span>`
					: "";
				const catHtml = row.VND_CATEGORY
					? `<span class="inline-flex items-center gap-1 text-[11px] font-medium text-secondary">
							<span class="material-symbols-outlined text-[14px] text-mute">category</span>
							<span>${escapeHtml(row.VND_CATEGORY)}</span>
						</span>`
					: "";
				return `
					<div class="font-bold text-primary leading-snug">${escapeHtml(data || "-")}</div>
					${classBadge || catHtml ? `<div class="mt-1 flex flex-wrap items-center gap-1.5">${classBadge}${catHtml}</div>` : ""}
				`;
			},
		},
		{
			data: "VND_COUNTRY",
			title: "Location &amp; Supply Origin",
			className: "align-top py-3 min-w-[210px]",
			render: (data, type, row) => {
				if (type !== "display")
					return `${data || ""} ${row.VND_ORIGIN || ""} ${row.VND_CITY || ""} ${row.VND_STATE || ""}`;
				const cityState = [row.VND_CITY, row.VND_STATE].filter(Boolean).join(", ");
				const addr = [row.VND_ADDRESS1, row.VND_ADDRESS2].filter(Boolean).join(" ");
				const originHtml = row.VND_ORIGIN
					? `<div class="inline-flex items-center gap-1 mt-1 text-[11px] font-mono text-info font-semibold">
							<span class="material-symbols-outlined text-[13px]">local_shipping</span>
							<span>Origin: ${escapeHtml(row.VND_ORIGIN)}</span>
						</div>`
					: "";
				return `
					<div class="flex items-center gap-1 font-bold text-primary">
						<span class="material-symbols-outlined text-[14px] text-secondary shrink-0">location_on</span>
						<span>${escapeHtml(data || "-")}</span>
					</div>
					${cityState ? `<div class="text-[11px] text-secondary font-medium">${escapeHtml(cityState)}</div>` : ""}
					${addr ? `<div class="text-[11px] text-mute truncate max-w-[240px]" title="${escapeAttribute(addr)}">${escapeHtml(addr)}</div>` : ""}
					${originHtml}
				`;
			},
		},
		{
			data: "VND_CONTACTNAME",
			title: "Contact Information",
			className: "align-top py-3 min-w-[160px]",
			render: (data, type, row) => {
				if (type !== "display") return `${data || ""} ${row.VND_PHONE || ""}`;
				const phone = row.VND_PHONE
					? `<div class="flex items-center gap-1 font-mono text-[11px] text-mute mt-0.5">
							<span class="material-symbols-outlined text-[13px]">call</span>
							<span>${escapeHtml(row.VND_PHONE)}</span>
						</div>`
					: "";
				const fax = row.VND_FAX
					? `<div class="flex items-center gap-1 font-mono text-[11px] text-mute">
							<span class="material-symbols-outlined text-[13px]">fax</span>
							<span>${escapeHtml(row.VND_FAX)}</span>
						</div>`
					: "";
				return `
					<div class="font-semibold text-primary">${escapeHtml(data || "-")}</div>
					${phone}
					${fax}
				`;
			},
		},
		{
			data: "VND_STATUS",
			title: "Status",
			className: "align-top py-3 text-center text-nowrap w-24",
			render: (data, type) => (type === "display" ? getStatusBadge(data) : data ?? ""),
		},
		{
			data: "VND_CODE",
			title: "Action",
			orderable: false,
			searchable: false,
			className: "align-top py-3 text-center w-28",
			render: (data, type) => {
				if (type !== "display") return "";
				return `
					<button type="button" data-code="${escapeAttribute(data)}"
						class="btn-view-general btn btn-xs btn-primary font-bold inline-flex items-center justify-center gap-1">
						<span class="material-symbols-outlined text-[14px]">visibility</span>
						<span>View Info</span>
					</button>
				`;
			},
		},
	];

	opt.initComplete = function (settings, json) {
		tableOpt.initComplete.call(this, settings, json);
		$(".dt-search").addClass("hidden");
		$(".dt-length").addClass("hidden");
	};

	opt.drawCallback = function (settings) {
		tableOpt.drawCallback.call(this, settings);
	};

	table = await createTable(opt);
}

// Event Delegation: Tabs
$(document).on("click", ".vendor-list-tab", function () {
	const $tab = $(this);
	activeTab = $tab.data("filter-tab") || "ALL";

	$(".vendor-list-tab").each(function () {
		const $btn = $(this);
		const isActive = $btn.is($tab);
		$btn.toggleClass("text-primary font-bold border-primary", isActive).toggleClass(
			"text-mute font-semibold border-transparent",
			!isActive,
		);
	});

	applyFilters();
});

// Event Delegation: Search & Dropdown Filters
$(document).on(
	"input change",
	"#listSearchInput, #listCategoryFilter, #listCountryFilter",
	() => {
		applyFilters();
	},
);

$(document).on("click", "#listFilterReset", () => {
	$("#listSearchInput").val("");
	$("#listCategoryFilter").val("");
	$("#listCountryFilter").val("");
	activeTab = "ALL";
	$('.vendor-list-tab[data-filter-tab="ALL"]').trigger("click");
});

// Event Delegation: General Info Slide-Over Drawer
$(document).on("click", ".btn-view-general", function () {
	openGeneralDrawer($(this).data("code"));
});

$(document).on("click", "#closeGeneralDrawerBtn, #closeGeneralDrawerFooterBtn, #generalDrawerBackdrop", () => {
	closeGeneralDrawer();
});

$(document).on("keydown", (e) => {
	if (e.key === "Escape" && !$("#vendorGeneralDrawer").hasClass("hidden")) {
		closeGeneralDrawer();
	}
});

$(document).ready(async () => {
	try {
		await showLoader();
		const res = await getVendors();
		const raw = Array.isArray(res) ? res : res?.data || [];

		// Strictly allow ONLY Indirect (6) and Subcontractor (8)
		scopedVendors = raw
			.filter((row) => isIndirectVendor(row) || isSubconVendor(row))
			.map(toGeneralRecord);

		updateKpi(scopedVendors);
		populateDropdowns(scopedVendors);
		await initTable(scopedVendors);
		applyFilters();
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error loading vendor list");
	} finally {
		await showLoader({ show: false });
	}
});
