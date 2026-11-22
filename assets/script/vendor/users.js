import "select2/dist/css/select2.min.css";
import "@amec/webasset/css/select2.min.css";
import "@amec/webasset/css/dataTable.min.css";
import select2 from "select2";
import dayjs from "dayjs";
import { showLoader } from "@amec/webasset/preloader";
import { showMessage, showConfirm } from "@amec/webasset/utils";
import { createTable } from "@amec/webasset/dataTable";
import { tableOpt, escapeHtml, escapeAttribute } from "../utils.js";

select2();
import {
	getVendors,
	getVendorUsers,
	createVendorUser,
	updateVendorUser,
	resetVendorUserPassword,
} from "../service/index.js";

const ROLE_CONFIG = {
	ADMIN: {
		label: "Vendor Admin",
		badge: "badge-primary",
		modules: [
			"Purchase Orders",
			"ASN Dispatch",
			"Claim Slip (CAR)",
			"Drawings",
			"User Management",
		],
	},
	SALES: {
		label: "Sales / PO Handler",
		badge: "badge-info",
		modules: ["Purchase Orders", "Changing Notice", "Drawings"],
	},
	LOGISTICS: {
		label: "Logistics / ASN",
		badge: "badge-secondary",
		modules: ["Purchase Orders (View)", "ASN Dispatch", "Delivery Slips"],
	},
	QA: {
		label: "Quality / Claim",
		badge: "badge-warning",
		modules: ["Claim Slip (CAR)", "Drawings", "Changing Notice"],
	},
};

const STATUS_CONFIG = {
	ACTIVE: { label: "Active", badge: "badge-success" },
	PENDING: { label: "Pending", badge: "badge-warning" },
	INACTIVE: { label: "Inactive", badge: "badge-error" },
};

let table = null;
let usersData = [];
let vendorsList = [];
let activeStatusFilter = "";
let selectedUser = null;

function normalizeStatus(status) {
	if (status === 1 || status === "1" || String(status).toUpperCase() === "ACTIVE") {
		return "ACTIVE";
	}
	if (status === 0 || status === "0" || String(status).toUpperCase() === "PENDING") {
		return "PENDING";
	}
	return "INACTIVE";
}

function updateSummaryStats(rows) {
	const total = rows.length;
	const active = rows.filter((u) => normalizeStatus(u.USER_STATUS) === "ACTIVE").length;
	const pending = rows.filter((u) => normalizeStatus(u.USER_STATUS) === "PENDING").length;
	const inactive = rows.filter((u) => normalizeStatus(u.USER_STATUS) === "INACTIVE").length;
	const uniqueVendors = new Set(rows.map((u) => u.VND_CODE).filter(Boolean)).size;
	const activeRate = total > 0 ? Math.round((active / total) * 100) : 0;

	$("#kpi-total-users").text(total);
	$("#kpi-vendor-count").text(`${uniqueVendors} Vendors`);
	$("#kpi-active-users").text(active);
	$("#kpi-active-rate").text(`${activeRate}%`);
	$("#kpi-pending-users").text(pending);
	$("#kpi-inactive-users").text(inactive);

	$("#tab-count-all").text(total);
	$("#tab-count-active").text(active);
	$("#tab-count-pending").text(pending);
	$("#tab-count-inactive").text(inactive);
}

function populateVendorSelects() {
	const $filter = $("#user-vendor-filter");
	const $modal = $("#modal-user-vendor");

	$filter.find("option:not(:first)").remove();
	$modal.find("option:not(:first)").remove();

	const map = new Map();
	vendorsList.forEach((v) => {
		const code = v.VND_CODE || v.VND_ID;
		if (code && !map.has(code)) {
			map.set(code, v.VND_NAME || code);
		}
	});
	usersData.forEach((u) => {
		if (u.VND_CODE && !map.has(u.VND_CODE)) {
			map.set(u.VND_CODE, u.VND_NAME || u.VND_CODE);
		}
	});

	map.forEach((name, code) => {
		const label = `${code} — ${name}`;
		$filter.append(
			`<option value="${escapeAttribute(code)}">${escapeHtml(label)}</option>`,
		);
		$modal.append(
			`<option value="${escapeAttribute(code)}">${escapeHtml(label)}</option>`,
		);
	});

	if ($filter.hasClass("select2-hidden-accessible")) {
		$filter.select2("destroy");
	}
	$filter.select2({
		placeholder: "All Registered Vendors",
		allowClear: true,
		width: "100%",
	});

	if ($modal.hasClass("select2-hidden-accessible")) {
		$modal.select2("destroy");
	}
	$modal.select2({
		placeholder: "Search & Select Registered Vendor...",
		allowClear: true,
		width: "100%",
		dropdownParent: $("#vendorUserModal"),
	});

	const defaultPositions = [
		"Sales / Coordinator",
		"Production / Planning",
		"Logistics / Delivery",
		"Quality Assurance (QA)",
		"Accounting / Finance",
		"Management / Director",
	];
	const positionSet = new Set(defaultPositions);
	usersData.forEach((u) => {
		const pos = String(u.USER_POSITION || u.USER_ROLE || u.USER_DEPT || "").trim();
		if (pos) positionSet.add(pos);
	});

	const $roleFilter = $("#user-role-filter");
	if ($roleFilter.hasClass("select2-hidden-accessible")) $roleFilter.select2("destroy");
	$roleFilter.find("option:not(:first)").remove();
	[...positionSet].sort().forEach((pos) => {
		$roleFilter.append(
			`<option value="${escapeAttribute(pos)}">${escapeHtml(pos)}</option>`,
		);
	});
	$roleFilter.select2({
		placeholder: "All Positions / Duties",
		allowClear: true,
		width: "100%",
	});

	const $modalRole = $("#modal-user-role");
	if ($modalRole.hasClass("select2-hidden-accessible")) $modalRole.select2("destroy");
	$modalRole.find("option:not(:first)").remove();
	[...positionSet].sort().forEach((pos) => {
		$modalRole.append(
			`<option value="${escapeAttribute(pos)}">${escapeHtml(pos)}</option>`,
		);
	});
	$modalRole.select2({
		placeholder: "Select or type position...",
		tags: true,
		allowClear: true,
		width: "100%",
		dropdownParent: $("#vendorUserModal"),
	});
}

function updateSelectedCounter() {
	const $boxes = $("#table tbody .user-row-select");
	const $checked = $("#table tbody .user-row-select:checked");
	$("#selected-counter").text(`${$checked.length} items`);

	const headerCb = $("#user-header-checkbox")[0];
	if (headerCb) {
		headerCb.checked = $boxes.length > 0 && $checked.length === $boxes.length;
		headerCb.indeterminate =
			$checked.length > 0 && $checked.length < $boxes.length;
	}
}

function applyAllFilters() {
	if (!table) return;
	const searchVal = ($("#user-search").val() || "").trim();
	const vendorVal = $("#user-vendor-filter").val() || "";
	const roleVal = $("#user-role-filter").val() || "";

	table.search(searchVal);
	table.column(2).search(vendorVal);
	table.column(3).search(roleVal);
	table.column(5).search(activeStatusFilter);
	table.draw();
}

async function initUsersTable(rows) {
	const opt = { ...tableOpt };
	opt.data = rows;
	opt.order = [[1, "asc"]];
	opt.dom = `<"overflow-x-auto"t><"dt-footer-bar px-space-md py-3 bg-base-100 border-t border-base-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-mute"<"table-info"i><"table-page"p>>`;
	opt.language = {
		...tableOpt.language,
		info: 'Showing <strong class="text-primary">_START_ - _END_</strong> of <strong class="text-primary">_TOTAL_</strong> Vendor Users',
		infoEmpty:
			'Showing <strong class="text-primary">0 - 0</strong> of <strong class="text-primary">0</strong> Vendor Users',
	};

	const baseDrawCallback = tableOpt.drawCallback;
	opt.drawCallback = function (settings) {
		if (typeof baseDrawCallback === "function") {
			baseDrawCallback.call(this, settings);
		}
		const api = this.api();
		const info = api.page.info();
		$("#active-view-summary").text(
			`Showing ${info.recordsDisplay} of ${info.recordsTotal} User accounts`,
		);
		updateSelectedCounter();
	};

	opt.columns = [
		{
			data: null,
			orderable: false,
			searchable: false,
			className: "w-10 text-center",
			title: `<input id="user-header-checkbox" type="checkbox" class="checkbox checkbox-xs checkbox-accent border-white" />`,
			render: (data, type, row) =>
				`<input type="checkbox" class="user-row-select checkbox checkbox-xs checkbox-primary" data-id="${escapeAttribute(row.USER_ID)}" />`,
		},
		{
			data: "USER_NAME",
			title: "User Account &amp; Contact",
			render: (data, type, row) => {
				if (type !== "display") {
					return `${row.USER_NAME || ""} ${row.USER_LOGIN || ""} ${row.USER_EMAIL || ""}`;
				}
				return `
					<button type="button" class="js-open-user-drawer link link-hover font-bold text-primary text-sm block text-left"
						data-id="${escapeAttribute(row.USER_ID)}">
						${escapeHtml(row.USER_NAME || "-")}
					</button>
					<div class="font-mono text-[11px] text-secondary">${escapeHtml(row.USER_LOGIN || "-")}</div>
					<div class="font-mono text-[11px] text-mute">${escapeHtml(row.USER_EMAIL || "-")}</div>
				`;
			},
		},
		{
			data: "VND_CODE",
			title: "Assigned Vendor Entity",
			render: (data, type, row) => {
				if (type !== "display") {
					return `${row.VND_CODE || ""} ${row.VND_NAME || ""}`;
				}
				return `
					<div class="font-mono font-bold text-primary">${escapeHtml(row.VND_CODE || "-")}</div>
					<div class="text-mute">${escapeHtml(row.VND_NAME || "-")}</div>
				`;
			},
		},
		{
			data: "USER_ROLE",
			title: "Position / Responsibility",
			render: (data, type, row) => {
				const pos = String(
					row.USER_POSITION || data || row.USER_DEPT || "",
				).trim();
				if (type !== "display") return pos;
				if (!pos) return '<span class="text-mute italic">-</span>';
				return `<span class="badge badge-xs badge-outline border-base-300 text-primary font-medium">${escapeHtml(pos)}</span>`;
			},
		},
		{
			data: "LAST_LOGIN",
			title: "Last Sign-In",
			className: "text-nowrap",
			render: (data, type) => {
				if (type !== "display") return data || "";
				if (!data) {
					return `<span class="font-mono text-mute italic">Never signed in</span>`;
				}
				const parsed = dayjs(data);
				return parsed.isValid()
					? `<div class="font-mono font-semibold text-primary">${parsed.format("YYYY-MM-DD")}</div>
					   <div class="font-mono text-[11px] text-mute">${parsed.format("HH:mm")} ICT</div>`
					: `<span class="font-mono text-primary">${escapeHtml(data)}</span>`;
			},
		},
		{
			data: "USER_STATUS",
			title: "Status",
			className: "text-center",
			render: (data, type) => {
				const statusKey = normalizeStatus(data);
				if (type !== "display") return statusKey;
				const cfg = STATUS_CONFIG[statusKey] || STATUS_CONFIG.INACTIVE;
				return `<span class="badge badge-xs ${cfg.badge} font-bold uppercase">${cfg.label}</span>`;
			},
		},
		{
			data: null,
			title: "Actions",
			orderable: false,
			searchable: false,
			className: "text-center w-36",
			render: (data, type, row) => `
				<div class="flex flex-col gap-1 items-stretch">
					<button type="button" class="js-open-user-drawer btn btn-xs btn-primary font-bold flex items-center justify-center gap-1"
						data-id="${escapeAttribute(row.USER_ID)}">
						<span class="material-symbols-outlined text-[14px]">visibility</span>
						<span>Inspect</span>
					</button>
					<button type="button" class="js-edit-user btn btn-xs btn-outline border-base-300 font-semibold flex items-center justify-center gap-1"
						data-id="${escapeAttribute(row.USER_ID)}">
						<span class="material-symbols-outlined text-[13px]">edit</span>
						<span>Edit</span>
					</button>
				</div>
			`,
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

function openUserDrawer(user) {
	selectedUser = user;
	const statusKey = normalizeStatus(user.USER_STATUS);
	const statusCfg = STATUS_CONFIG[statusKey] || STATUS_CONFIG.INACTIVE;
	const positionLabel =
		String(user.USER_POSITION || user.USER_ROLE || user.USER_DEPT || "").trim() ||
		"-";

	$("#drawer-user-login").text(user.USER_LOGIN || "-");
	$("#drawer-user-status")
		.removeClass("badge-success badge-warning badge-error badge-ghost")
		.addClass(statusCfg.badge)
		.text(statusCfg.label);
	$("#drawer-user-subtitle").text(
		`${user.VND_NAME || "Registered Vendor"} • Mitsubishi Elevator Asia Co., Ltd. (AMEC)`,
	);
	$("#drawer-user-name").text(user.USER_NAME || "-");
	$("#drawer-user-role").text(positionLabel);
	$("#drawer-user-vndcode").text(user.VND_CODE || "-");
	$("#drawer-user-lastlogin").text(
		user.LAST_LOGIN ? dayjs(user.LAST_LOGIN).format("YYYY-MM-DD HH:mm") : "Never",
	);
	$("#drawer-user-vndname").text(user.VND_NAME || "-");
	$("#drawer-user-email").text(user.USER_EMAIL || "-");
	$("#drawer-user-phone").text(user.USER_PHONE || "-");
	$("#drawer-user-dept").text(user.USER_DEPT || positionLabel);

	const $alert = $("#drawer-user-alert");
	if (statusKey === "INACTIVE") {
		$("#drawer-alert-title").text("ACCOUNT SUSPENDED / LOCKED");
		$("#drawer-alert-text").text(
			"This vendor portal account is currently restricted from signing in. Verify authorization before reactivating.",
		);
		$alert.removeClass("hidden").addClass("flex");
	} else if (statusKey === "PENDING") {
		$("#drawer-alert-title").text("ACTIVATION PENDING");
		$("#drawer-alert-text").text(
			"This account has not completed initial sign-in. You may resend a password activation email below.",
		);
		$alert.removeClass("hidden").addClass("flex");
	} else {
		$alert.addClass("hidden").removeClass("flex");
	}

	$("#vendorUserDrawer").removeClass("hidden");
}

function closeUserDrawer() {
	$("#vendorUserDrawer").addClass("hidden");
}

function openUserModal(user = null) {
	if (user) {
		$("#modal-user-title").text("Edit Vendor User Account");
		$("#modal-user-id").val(user.USER_ID || "");
		$("#modal-user-vendor").val(user.VND_CODE || "").trigger("change.select2");
		$("#modal-user-name").val(user.USER_NAME || "");
		$("#modal-user-login").val(user.USER_LOGIN || "");
		$("#modal-user-email").val(user.USER_EMAIL || "");
		$("#modal-user-phone").val(user.USER_PHONE || "");
		const posVal = String(
			user.USER_POSITION || user.USER_ROLE || user.USER_DEPT || "",
		).trim();
		const $modalRole = $("#modal-user-role");
		if (
			posVal &&
			$modalRole.find(`option[value="${escapeAttribute(posVal)}"]`).length === 0
		) {
			$modalRole.append(
				`<option value="${escapeAttribute(posVal)}">${escapeHtml(posVal)}</option>`,
			);
		}
		$modalRole.val(posVal).trigger("change.select2");
		$("#modal-user-status").val(normalizeStatus(user.USER_STATUS));
	} else {
		$("#modal-user-title").text("Provision New Vendor User");
		$("#vendorUserForm")[0].reset();
		$("#modal-user-id").val("");
		$("#modal-user-vendor").val("").trigger("change.select2");
		$("#modal-user-role").val("").trigger("change.select2");
		$("#modal-user-status").val("PENDING");
	}

	$("#vendorUserModal").removeClass("hidden").addClass("flex");
}

function closeUserModal() {
	$("#vendorUserModal").addClass("hidden").removeClass("flex");
}

async function reloadUsers() {
	const [usersRes, vendorsRes] = await Promise.allSettled([
		getVendorUsers(),
		getVendors(),
	]);

	if (vendorsRes.status === "fulfilled") {
		vendorsList = Array.isArray(vendorsRes.value)
			? vendorsRes.value
			: vendorsRes.value?.data || [];
	}

	if (usersRes.status === "fulfilled") {
		usersData = Array.isArray(usersRes.value)
			? usersRes.value
			: usersRes.value?.data || [];
	} else {
		usersData = [];
	}

	updateSummaryStats(usersData);
	populateVendorSelects();
	await initUsersTable(usersData);
}

// Event Delegation (No inline JS in Blade)
$(document).on("click", ".user-status-tab", function () {
	const $tab = $(this);
	activeStatusFilter = $tab.data("status") || "";

	$(".user-status-tab").each(function () {
		const $btn = $(this);
		const isActive = $btn.is($tab);
		$btn.toggleClass("text-primary font-bold border-primary", isActive)
			.toggleClass("text-mute font-semibold border-transparent", !isActive);
	});

	applyAllFilters();
});

$(document).on("input", "#user-search", applyAllFilters);
$(document).on("change", "#user-vendor-filter, #user-role-filter", applyAllFilters);

$(document).on("click", "#user-filter-reset", function () {
	$("#user-search").val("");
	$("#user-vendor-filter").val("").trigger("change.select2");
	$("#user-role-filter").val("").trigger("change.select2");
	activeStatusFilter = "";
	$('.user-status-tab[data-status=""]').trigger("click");
});

$(document).on("change", "#user-header-checkbox", function () {
	const checked = $(this).is(":checked");
	$("#table tbody .user-row-select").prop("checked", checked);
	updateSelectedCounter();
});

$(document).on("change", ".user-row-select", updateSelectedCounter);

$(document).on("click", "#select-all-users-btn", function () {
	const $master = $("#user-header-checkbox");
	$master.prop("checked", !$master.is(":checked")).trigger("change");
});

$(document).on("click", ".js-open-user-drawer", function () {
	const id = $(this).data("id");
	const user = usersData.find((u) => String(u.USER_ID) === String(id));
	if (user) openUserDrawer(user);
});

$(document).on("click", ".js-close-user-drawer", closeUserDrawer);

$(document).on("click", "#open-create-user-modal", function () {
	openUserModal(null);
});

$(document).on("click", ".js-edit-user", function () {
	const id = $(this).data("id");
	const user = usersData.find((u) => String(u.USER_ID) === String(id));
	if (user) openUserModal(user);
});

$(document).on("click", "#drawer-btn-edit", function () {
	if (!selectedUser) return;
	closeUserDrawer();
	openUserModal(selectedUser);
});

$(document).on("click", ".js-close-user-modal", closeUserModal);

$(document).on("click", "#drawer-btn-reset-pw", async function () {
	if (!selectedUser) return;
	const ok = await showConfirm({
		title: "Send Password Reset?",
		message: `Send password reset instructions to ${selectedUser.USER_EMAIL || selectedUser.USER_LOGIN}?`,
		acceptText: "Send Reset Link",
		cancelText: "Cancel",
	});
	if (!ok) return;

	try {
		await showLoader();
		await resetVendorUserPassword(selectedUser.USER_ID);
		await showMessage("Password reset link dispatched successfully.");
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Failed to send password reset.");
	} finally {
		await showLoader({ show: false });
	}
});

$(document).on("submit", "#vendorUserForm", async function (e) {
	e.preventDefault();
	const id = $("#modal-user-id").val();
	const payload = {
		VND_CODE: $("#modal-user-vendor").val(),
		USER_NAME: $("#modal-user-name").val().trim(),
		USER_LOGIN: $("#modal-user-login").val().trim(),
		USER_EMAIL: $("#modal-user-email").val().trim(),
		USER_PHONE: $("#modal-user-phone").val().trim(),
		USER_ROLE: $("#modal-user-role").val(),
		USER_STATUS: $("#modal-user-status").val(),
	};

	try {
		await showLoader();
		if (id) {
			await updateVendorUser(id, payload);
		} else {
			await createVendorUser(payload);
		}
		closeUserModal();
		await reloadUsers();
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Failed to save vendor user account.");
	} finally {
		await showLoader({ show: false });
	}
});

$(document).on("click", "#export-vendor-users", async function () {
	if (!usersData.length) {
		await showMessage("No vendor user records available to export.");
		return;
	}
	const headers = [
		"User ID",
		"Full Name",
		"Login ID",
		"Email",
		"Phone",
		"Vendor Code",
		"Vendor Name",
		"Role",
		"Status",
		"Last Login",
	];
	const csvRows = [
		headers.join(","),
		...usersData.map((u) =>
			[
				u.USER_ID,
				u.USER_NAME,
				u.USER_LOGIN,
				u.USER_EMAIL,
				u.USER_PHONE,
				u.VND_CODE,
				u.VND_NAME,
				u.USER_ROLE,
				normalizeStatus(u.USER_STATUS),
				u.LAST_LOGIN,
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
	a.download = `vendor-users-${dayjs().format("YYYYMMDD")}.csv`;
	a.click();
	URL.revokeObjectURL(url);
});

$(document).ready(async () => {
	try {
		await showLoader();
		await window.appReady;
		await reloadUsers();
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error initializing Vendor Users page");
	} finally {
		await showLoader({ show: false });
	}
});
