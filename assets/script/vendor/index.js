import "@amec/webasset/css/dataTable.min.css";
import dayjs from "dayjs";
import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { activatedBtnRow } from "@amec/webasset/components/buttons";
import { createTable } from "@amec/webasset/dataTable";
import { tableOpt, escapeHtml } from "../utils.js";
import { getVendors, getTemplate, exportExcel } from "../service/index.js";
import { extractDataForExport } from "./excel-data.js";

let table = null;
let allVendorsData = [];
let activeTab = "ALL";

const DIGIT_META = {
	1: { short: "1: MELCO Oversea", badge: "badge-info" },
	2: { short: "2: Oversea", badge: "badge-info" },
	3: { short: "3: Domestic BOI", badge: "badge-ghost" },
	4: { short: "4: Domestic IPO", badge: "badge-secondary" },
	5: { short: "5: Domestic", badge: "badge-primary" },
	6: { short: "6: Non-Prod", badge: "badge-ghost" },
	7: { short: "7: Domestic FTA", badge: "badge-secondary" },
	8: { short: "8: Subcon", badge: "badge-warning" },
};

function isActiveStatus(status) {
	if (status === 1 || status === "1") return true;
	const s = String(status || "").toUpperCase();
	return s === "ACTIVE" || s === "A" || s === "";
}

function isDomesticVendor(row) {
	const code = String(row.VND_CODE || "").trim();
	return ["3", "4", "5", "7"].includes(code.charAt(0));
}

function isOverseaVendor(row) {
	const code = String(row.VND_CODE || "").trim();
	return (
		code.startsWith("1") || code.startsWith("2") || code.startsWith("69")
	);
}

function isIndirectVendor(row) {
	const code = String(row.VND_CODE || "").trim();
	const type1 = String(row.VND_TYPE1 || "")
		.toUpperCase()
		.trim();
	return code.startsWith("6") || type1 === "INDIRECT";
}

function isSubconVendor(row) {
	const code = String(row.VND_CODE || "").trim();
	const type1 = String(row.VND_TYPE1 || "")
		.toUpperCase()
		.trim();
	return code.startsWith("8") || type1 === "SUBCON";
}

function getStatusBadge(status) {
	const s = String(status ?? "")
		.toUpperCase()
		.trim();
	if (s === "1" || s === "ACTIVE" || s === "") {
		return '<span class="badge badge-xs badge-success font-mono font-bold uppercase">Active</span>';
	}
	if (s === "0" || s === "CREATING" || s === "PENDING") {
		return '<span class="badge badge-xs badge-warning font-mono font-bold uppercase">Creating</span>';
	}
	if (s === "HOLD") {
		return '<span class="badge badge-xs badge-warning font-mono font-bold uppercase">Hold</span>';
	}
	return '<span class="badge badge-xs badge-error font-mono font-bold uppercase">Inactive</span>';
}

function getDigitBadge(code) {
	const raw = String(code || "").trim();
	const first = raw.charAt(0);
	const meta = DIGIT_META[first] || {
		short: `Group ${first || "-"}`,
		badge: "badge-ghost",
	};
	let label = meta.short;
	if (first === "6" && raw.startsWith("69")) {
		label = "69: Non-Prod Oversea";
	}
	return `<span class="badge badge-xs ${meta.badge} font-mono font-bold">${escapeHtml(label)}</span>`;
}

function updateTabCounts(data) {
	const total = data.length;
	const active = data.filter((r) => isActiveStatus(r.VND_STATUS)).length;
	const inactive = total - active;
	const domestic = data.filter((r) => isDomesticVendor(r)).length;
	const oversea = data.filter((r) => isOverseaVendor(r)).length;
	const indirect = data.filter((r) => isIndirectVendor(r)).length;
	const subcon = data.filter((r) => isSubconVendor(r)).length;

	$('#vendorStatusTabs [data-count="ALL"]').text(total.toLocaleString());
	$('#vendorStatusTabs [data-count="ACTIVE"]').text(active.toLocaleString());
	$('#vendorStatusTabs [data-count="INACTIVE"]').text(
		inactive.toLocaleString(),
	);
	$('#vendorStatusTabs [data-count="DOMESTIC"]').text(
		domestic.toLocaleString(),
	);
	$('#vendorStatusTabs [data-count="OVERSEA"]').text(
		oversea.toLocaleString(),
	);
	$('#vendorStatusTabs [data-count="INDIRECT"]').text(
		indirect.toLocaleString(),
	);
	$('#vendorStatusTabs [data-count="SUBCON"]').text(subcon.toLocaleString());
}

function updateKpiAndTabs(data) {
	const total = data.length;
	const active = data.filter((r) => isActiveStatus(r.VND_STATUS)).length;
	const inactive = total - active;
	const oversea = data.filter((r) => isOverseaVendor(r)).length;
	const domestic = data.filter((r) => isDomesticVendor(r)).length;
	const subcon = data.filter((r) => isSubconVendor(r)).length;
	const nonProd = data.filter((r) => isIndirectVendor(r)).length;
	const countries = new Set(
		data
			.map((r) => (r.VND_COUNTRY || "").trim().toUpperCase())
			.filter(Boolean),
	).size;
	const currencies = new Set(
		data
			.map((r) => (r.VND_CURRENCY || "").trim().toUpperCase())
			.filter(Boolean),
	).size;
	const withTax = data.filter(
		(r) => String(r.VND_TAXNO || "").trim() !== "",
	).length;
	const withAgreement = data.filter(
		(r) =>
			String(r.VND_CANO || "").trim() !== "" ||
			String(r.VND_BANO || "").trim() !== "",
	).length;

	const activePct = total ? Math.round((active / total) * 100) : 0;
	const taxPct = total ? Math.round((withTax / total) * 100) : 0;

	$("#kpi-total-vendors").text(total.toLocaleString());
	$("#kpi-active-badge").text(`${activePct}% ACTIVE`);
	$("#kpi-active-count").text(active.toLocaleString());
	$("#kpi-inactive-count").text(inactive.toLocaleString());
	$("#kpi-domestic-count").text(domestic.toLocaleString());
	$("#kpi-oversea-count").text(oversea.toLocaleString());
	$("#kpi-country-count").text(countries.toLocaleString());
	$("#kpi-subcon-count").text(subcon.toLocaleString());
	$("#kpi-nonprod-count").text(`${nonProd.toLocaleString()} Indirect`);
	$("#kpi-currency-count").text(currencies.toLocaleString());
	$("#kpi-tax-pct").text(`${taxPct}%`);
	$("#kpi-agreement-count").text(withAgreement.toLocaleString());

	updateTabCounts(data);
}

function populateFilterDropdowns(data) {
	const countries = [
		...new Set(
			data.map((r) => (r.VND_COUNTRY || "").trim()).filter(Boolean),
		),
	].sort();
	const currencies = [
		...new Set(
			data.map((r) => (r.VND_CURRENCY || "").trim()).filter(Boolean),
		),
	].sort();

	const $country = $("#vendorCountryFilter");
	$country.find("option:not(:first)").remove();
	countries.forEach((c) => {
		$country.append(
			`<option value="${escapeHtml(c)}">${escapeHtml(c)}</option>`,
		);
	});

	const $curr = $("#vendorCurrencyFilter");
	$curr.find("option:not(:first)").remove();
	currencies.forEach((cur) => {
		$curr.append(
			`<option value="${escapeHtml(cur)}">${escapeHtml(cur)}</option>`,
		);
	});
}

function applyAllFilters() {
	if (!table) return;

	const query = ($("#vendorSearchInput").val() || "")
		.toString()
		.toLowerCase()
		.trim();
	const groupDigit = ($("#vendorGroupFilter").val() || "").toString().trim();
	const country = ($("#vendorCountryFilter").val() || "")
		.toString()
		.trim()
		.toUpperCase();
	const currency = ($("#vendorCurrencyFilter").val() || "")
		.toString()
		.trim()
		.toUpperCase();

	const baseFiltered = allVendorsData.filter((row) => {
		const code = String(row.VND_CODE || "").trim();

		if (groupDigit && !code.startsWith(groupDigit)) return false;
		if (
			country &&
			String(row.VND_COUNTRY || "")
				.trim()
				.toUpperCase() !== country
		)
			return false;
		if (
			currency &&
			String(row.VND_CURRENCY || "")
				.trim()
				.toUpperCase() !== currency
		)
			return false;

		if (query) {
			const hay = [
				row.VND_CODE,
				row.VND_NAME,
				row.VND_CATEGORY,
				row.VND_CLASS,
				row.VND_ORIGIN,
				row.VND_TAXNO,
				row.VND_CANO,
				row.VND_BANO,
				row.VND_CONTACTNAME,
				row.VND_PHONE,
				row.VND_CITY,
				row.VND_STATE,
				row.VND_COUNTRY,
				row.VND_CURRENCY,
				row.VND_TERM,
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
		const active = isActiveStatus(row.VND_STATUS);
		if (activeTab === "ACTIVE") return active;
		if (activeTab === "INACTIVE") return !active;
		if (activeTab === "DOMESTIC") return isDomesticVendor(row);
		if (activeTab === "OVERSEA") return isOverseaVendor(row);
		if (activeTab === "INDIRECT") return isIndirectVendor(row);
		if (activeTab === "SUBCON") return isSubconVendor(row);
		return true;
	});

	table.clear();
	table.rows.add(filtered);
	table.draw();

	$("#activeViewSummary").text(
		`Showing ${filtered.length.toLocaleString()} of ${allVendorsData.length.toLocaleString()} Vendor records`,
	);
}

async function createVendorsTable(data) {
	const opt = { ...tableOpt };
	opt.data = data;
	opt.order = [[0, "asc"]];
	opt.dom = `<"overflow-x-auto"t><"dt-footer-bar px-space-md py-3 bg-base-100 border-t border-base-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-mute"<"table-info"i><"table-page"p>>`;
	opt.language = {
		...tableOpt.language,
		info: 'Showing <strong class="text-primary">_START_ - _END_</strong> of <strong class="text-primary">_TOTAL_</strong> Registered Vendors',
		infoEmpty:
			'Showing <strong class="text-primary">0 - 0</strong> of <strong class="text-primary">0</strong> Registered Vendors',
	};

	opt.columns = [
		{
			data: "VND_CODE",
			title: "Vendor Code &amp; Class",
			className: "align-top py-3 text-nowrap sticky-column",
			render: (data, type, row) => {
				if (type !== "display") return data || "";
				const code = escapeHtml(data || "-");
				const typeTag = row.VND_TYPE1
					? `<span class="badge badge-xs badge-outline border-base-300 text-secondary font-mono">${escapeHtml(row.VND_TYPE1)}</span>`
					: "";
				return `
					<div class="flex flex-col gap-1">
						<a href="${process.env.APP_ENV}/vendors/detail/${encodeURIComponent(data || "")}"
							class="link link-hover font-mono font-bold text-primary text-sm text-left">
							${code}
						</a>
						<div class="flex flex-wrap items-center gap-1">
							${getDigitBadge(data)}
							${typeTag}
						</div>
					</div>
				`;
			},
		},
		{
			data: "VND_NAME",
			title: "Corporate Entity, Class &amp; Category",
			className: "align-top py-3 min-w-[260px]",
			render: (data, type, row) => {
				if (type !== "display")
					return `${data || ""} ${row.VND_CLASS || ""} ${row.VND_CATEGORY || ""} ${row.VND_TAXNO || ""}`;
				const classBadge = row.VND_CLASS
					? `<span class="badge badge-xs badge-secondary font-mono font-bold uppercase">${escapeHtml(row.VND_CLASS)}</span>`
					: "";
				const categoryHtml = row.VND_CATEGORY
					? `<span class="inline-flex items-center gap-1 text-[11px] font-medium text-secondary">
							<span class="material-symbols-outlined text-[14px] text-mute">category</span>
							<span>${escapeHtml(row.VND_CATEGORY)}</span>
						</span>`
					: "";
				const metaParts = [];
				if (row.VND_TAXNO)
					metaParts.push(
						`Tax: <strong class="text-primary">${escapeHtml(row.VND_TAXNO)}</strong>`,
					);
				if (row.VND_CANO)
					metaParts.push(
						`CA: <strong class="text-primary">${escapeHtml(row.VND_CANO)}</strong>`,
					);
				if (row.VND_BANO)
					metaParts.push(
						`BA: <strong class="text-primary">${escapeHtml(row.VND_BANO)}</strong>`,
					);
				const metaHtml = metaParts.length
					? `<div class="mt-1 text-[11px] font-mono text-mute flex flex-wrap gap-x-2 gap-y-0.5">${metaParts.join(" • ")}</div>`
					: "";
				return `
					<div class="font-bold text-primary leading-snug">${escapeHtml(data || "-")}</div>
					${classBadge || categoryHtml ? `<div class="mt-1 flex flex-wrap items-center gap-1.5">${classBadge}${categoryHtml}</div>` : ""}
					${metaHtml}
				`;
			},
		},
		{
			data: "VND_CURRENCY",
			title: "Settlement &amp; Currency",
			className: "align-top py-3 text-nowrap",
			render: (data, type, row) => {
				if (type !== "display")
					return `${data || ""} ${row.VND_TERM || ""}`;
				const curr = escapeHtml(data || "-");
				const term = escapeHtml(row.VND_TERM || "-");
				const vtype = row.VND_TYPE2
					? `<div class="text-[11px] font-mono text-mute">Type: ${escapeHtml(row.VND_TYPE2)}</div>`
					: "";
				return `
					<div class="flex flex-col gap-1">
						<div class="flex items-center gap-1.5">
							<span class="badge badge-xs badge-outline border-primary text-primary font-mono font-bold">${curr}</span>
							<span class="text-[11px] font-mono text-secondary">Term: <strong class="text-primary">${term}</strong></span>
						</div>
						${vtype}
					</div>
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
				const cityState = [row.VND_CITY, row.VND_STATE]
					.filter(Boolean)
					.join(", ");
				const addr = [row.VND_ADDRESS1, row.VND_ADDRESS2]
					.filter(Boolean)
					.join(" ");
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
					${addr ? `<div class="text-[11px] text-mute truncate max-w-60" title="${escapeHtml(addr)}">${escapeHtml(addr)}</div>` : ""}
					${originHtml}
				`;
			},
		},
		{
			data: "VND_CONTACTNAME",
			title: "Liaison Contact",
			className: "align-top py-3 min-w-[160px]",
			render: (data, type, row) => {
				if (type !== "display")
					return `${data || ""} ${row.VND_PHONE || ""}`;
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
			title: "Status &amp; Audit",
			className: "align-top py-3 text-center text-nowrap",
			render: (data, type, row) => {
				if (type !== "display") return data ?? "";
				const regDate = row.VND_REGISTED
					? dayjs(row.VND_REGISTED).format("DD MMM YYYY")
					: "-";
				const updDate = row.UPDATE_AT
					? dayjs(row.UPDATE_AT).format("DD MMM YYYY")
					: "";
				return `
					<div class="flex flex-col items-center gap-1">
						${getStatusBadge(data)}
						<span class="text-[10px] font-mono text-mute">Reg: ${escapeHtml(regDate)}</span>
						${updDate ? `<span class="text-[10px] font-mono text-secondary">Upd: ${escapeHtml(updDate)}</span>` : ""}
					</div>
				`;
			},
		},
		{
			data: "VND_CODE",
			title: "Actions",
			orderable: false,
			searchable: false,
			className: "align-top py-3 w-32",
			render: (data, type) => {
				if (type !== "display") return data || "";
				const code = encodeURIComponent(data || "");
				return `
					<div class="flex flex-col gap-1 items-stretch">
						<a href="${process.env.APP_ENV}/vendors/detail/${code}"
							class="btn btn-xs btn-primary font-bold flex items-center justify-center gap-1 text-nowrap">
							<span class="material-symbols-outlined text-[14px]">visibility</span>
							<span>View Profile</span>
						</a>
						<a href="${process.env.APP_ENV}/vendors/create?mode=U&code=${code}"
							class="btn btn-xs btn-outline border-base-300 font-semibold flex items-center justify-center gap-1 text-nowrap">
							<span class="material-symbols-outlined text-[13px]">edit_document</span>
							<span>Cover Update</span>
						</a>
					</div>
				`;
			},
		},
	];

	opt.initComplete = async function (settings, json) {
		tableOpt.initComplete.call(this, settings, json);
		$(".dt-search").addClass("hidden");
		$(".dt-length").addClass("hidden");
	};

	opt.drawCallback = function (settings) {
		tableOpt.drawCallback.call(this, settings);
	};

	table = await createTable(opt);
}

async function reloadTable() {
	const res = await getVendors();
	allVendorsData = Array.isArray(res) ? res : res?.data || [];

	updateKpiAndTabs(allVendorsData);
	populateFilterDropdowns(allVendorsData);

	if (!table) {
		await createVendorsTable(allVendorsData);
	}
	applyAllFilters();
}

// Event Delegation: Status & Group Tabs
$(document).on("click", ".vendor-status-tab", function () {
	const $tab = $(this);
	activeTab = $tab.data("filter-tab") || "ALL";

	$(".vendor-status-tab").each(function () {
		const $btn = $(this);
		const isActive = $btn.is($tab);
		$btn.toggleClass(
			"text-primary font-bold border-primary",
			isActive,
		).toggleClass("text-mute font-semibold border-transparent", !isActive);
	});

	applyAllFilters();
});

// Event Delegation: Search & Dropdown Filters
$(document).on(
	"input change",
	"#vendorSearchInput, #vendorGroupFilter, #vendorCountryFilter, #vendorCurrencyFilter",
	() => {
		applyAllFilters();
	},
);

$(document).on("click", "#vendorFilterReset", () => {
	$("#vendorSearchInput").val("");
	$("#vendorGroupFilter").val("");
	$("#vendorCountryFilter").val("");
	$("#vendorCurrencyFilter").val("");
	activeTab = "ALL";
	$('.vendor-status-tab[data-filter-tab="ALL"]').trigger("click");
});

// Export Approved List CSV
$(document).on("click", "#btn-export-csv", () => {
	const data = table ? table.data().toArray() : allVendorsData;
	if (!data.length) return;
	const headers = [
		"VENDOR CODE",
		"VENDOR NAME",
		"TYPE1",
		"TYPE2",
		"CATEGORY",
		"TAX ID",
		"CA NO.",
		"BA NO.",
		"CURRENCY",
		"TERM",
		"CONTACT",
		"PHONE",
		"FAX",
		"ADDRESS1",
		"ADDRESS2",
		"CITY",
		"STATE",
		"COUNTRY",
		"STATUS",
		"REGISTERED",
	];
	const esc = (v) => `"${String(v ?? "").replace(/"/g, '""')}"`;
	const lines = [
		headers.map(esc).join(","),
		...data.map((r) =>
			[
				r.VND_CODE,
				r.VND_NAME,
				r.VND_TYPE1,
				r.VND_TYPE2,
				r.VND_CATEGORY,
				r.VND_TAXNO,
				r.VND_CANO,
				r.VND_BANO,
				r.VND_CURRENCY,
				r.VND_TERM,
				r.VND_CONTACTNAME,
				r.VND_PHONE,
				r.VND_FAX,
				r.VND_ADDRESS1,
				r.VND_ADDRESS2,
				r.VND_CITY,
				r.VND_STATE,
				r.VND_COUNTRY,
				r.VND_STATUS,
				r.VND_REGISTED
					? dayjs(r.VND_REGISTED).format("YYYY-MM-DD")
					: "",
			]
				.map(esc)
				.join(","),
		),
	];
	const blob = new Blob(["\uFEFF" + lines.join("\n")], {
		type: "text/csv;charset=utf-8;",
	});
	const url = URL.createObjectURL(blob);
	const a = document.createElement("a");
	a.href = url;
	a.download = `Approved_Vendor_List_${dayjs().format("YYYYMMDD")}.csv`;
	document.body.appendChild(a);
	a.click();
	document.body.removeChild(a);
	URL.revokeObjectURL(url);
});

// Export Vendors Excel
$(document).on("click", "#export-vendor", async function () {
	try {
		await activatedBtnRow($(this), true);
		const data = table ? table.data().toArray() : allVendorsData;
		const result = await extractDataForExport(data);
		const template = await getTemplate("export_vendors.xlsx");
		await exportExcel(result, template, {
			filename: "Vendors List.xlsx",
		});
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error exporting data");
	} finally {
		await activatedBtnRow($(this), false);
	}
});

$(document).ready(async () => {
	try {
		await showLoader();
		await reloadTable();
	} catch (error) {
		console.error(error);
		await showMessage(
			error.message || "Error initializing vendor directory",
		);
	} finally {
		await showLoader({ show: false });
	}
});
