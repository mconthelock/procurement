import { showLoader } from "@amec/webasset/preloader";
import { showErrorMessage, showMessage } from "@amec/webasset/utils";
import { currentUser } from "@amec/webasset/api/amec";
import { escapeHtml, escapeAttribute } from "../utils.js";
import {
	getIimByProd,
	getItemMasterServerSide,
	saveItemOrigin,
} from "../service/index.js";
import {
	SAMPLE_IIM_ITEMS,
	ORIGIN_TYPE_MAP,
	getItemTypeMeta,
	isItemActive,
	formatNumber,
	formatCost,
	formatBpcsDate,
	textOrDash,
	normalizeFlagBadge,
	normalizeIimRecord,
} from "./shared.js";

let currentItem = null;
let isPreviewMode = false;

function setFlagBadge(selector, rawValue) {
	const { text, cls } = normalizeFlagBadge(rawValue);
	$(selector)
		.removeClass("badge-ghost badge-success badge-info badge-warning badge-error")
		.addClass(cls)
		.text(text);
}

function renderCostBuckets(item, hideZero = false) {
	const $tbody = $("#cost-buckets-tbody");
	const $tfoot = $("#cost-buckets-tfoot");
	const totals = [0, 0, 0, 0, 0, 0, 0, 0];
	const rowsHtml = [];

	for (let i = 1; i <= 9; i++) {
		const vals = [
			Number(item[`ICST${i}`] ?? 0),
			Number(item[`ICSP${i}`] ?? 0),
			Number(item[`ICFT${i}`] ?? 0),
			Number(item[`ICFP${i}`] ?? 0),
			Number(item[`ICAT${i}`] ?? 0),
			Number(item[`ICAP${i}`] ?? 0),
			Number(item[`ISCT${i}`] ?? 0),
			Number(item[`ISCP${i}`] ?? 0),
		];
		vals.forEach((v, idx) => {
			totals[idx] += v;
		});

		const allZero = vals.every((v) => v === 0);
		if (hideZero && allZero) continue;

		rowsHtml.push(`
			<tr class="hover:bg-base-200/60 transition-colors ${allZero ? "text-mute" : "text-primary"}">
				<td class="py-2 px-3 font-bold">Bucket ${i}</td>
				${vals
					.map(
						(v) =>
							`<td class="py-2 px-3 text-right ${v !== 0 ? "font-semibold text-primary" : "text-mute"}">${formatCost(v, 4)}</td>`,
					)
					.join("")}
			</tr>
		`);
	}

	if (!rowsHtml.length) {
		$tbody.html(
			`<tr><td colspan="9" class="py-4 text-center text-mute">All 9 cost buckets are zero.</td></tr>`,
		);
	} else {
		$tbody.html(rowsHtml.join(""));
	}

	$tfoot.html(`
		<tr>
			<td class="py-2.5 px-3 text-primary uppercase">Total (1–9)</td>
			${totals
				.map(
					(t) =>
						`<td class="py-2.5 px-3 text-right text-primary">${formatCost(t, 4)}</td>`,
				)
				.join("")}
		</tr>
	`);
}

function renderVendorTable(item) {
	const appEnv = $("#app-env").val() || process.env.APP_ENV || "";
	const $tbody = $("#proc-vendors-tbody");
	const vendors = [];

	if (item.IVEND && Number(item.IVEND) !== 0) {
		vendors.push({
			role: "Primary Vendor (IVEND)",
			badge: "badge-success",
			code: String(item.IVEND),
			name: item.VENDOR_NAME || "Registered Primary Supplier",
		});
	}
	if (item.IVEN2 && Number(item.IVEN2) !== 0) {
		vendors.push({
			role: "Secondary Vendor (IVEN2)",
			badge: "badge-ghost",
			code: String(item.IVEN2),
			name: "Approved Alternate Supplier",
		});
	}

	if (!vendors.length) {
		$tbody.html(
			`<tr><td colspan="4" class="py-4 text-center text-mute">No vendor code assigned in IIM (IVEND / IVEN2).</td></tr>`,
		);
		return;
	}

	$tbody.html(
		vendors
			.map(
				(v) => `
			<tr class="hover:bg-base-200/60 transition-colors">
				<td class="py-2.5 px-space-md">
					<span class="badge badge-xs ${v.badge} font-mono font-bold uppercase">${escapeHtml(v.role)}</span>
				</td>
				<td class="py-2.5 px-space-md font-mono font-bold text-primary">${escapeHtml(v.code)}</td>
				<td class="py-2.5 px-space-md text-primary font-semibold">${escapeHtml(v.name)}</td>
				<td class="py-2.5 px-space-md text-right">
					<a href="${escapeAttribute(`${appEnv}/Vendors/detail/${encodeURIComponent(v.code)}`)}" class="btn btn-xs btn-outline border-base-300 gap-1">
						<span class="material-symbols-outlined text-[13px]">open_in_new</span>
						<span>Vendor Profile</span>
					</a>
				</td>
			</tr>
		`,
			)
			.join(""),
	);
}

function renderOriginView(item) {
	const modeLabel =
		item.COUNTRY_MODE === 1 || String(item.COUNTRY_MODE) === "1"
			? "Group / Multiple Countries"
			: item.COUNTRY
				? "Single Country"
				: "-";
	const typeLabel =
		ORIGIN_TYPE_MAP[item.ORIGIN_TYPE] ||
		(item.ORIGIN_TYPE ? String(item.ORIGIN_TYPE) : "-");

	$("#origin-view-mode").text(modeLabel);
	$("#origin-view-country").text(textOrDash(item.COUNTRY));
	$("#origin-view-type").text(typeLabel);
	$("#origin-view-mfg-name").text(textOrDash(item.MFG_NAME));
	$("#origin-view-mfg-addr").text(textOrDash(item.MFG_ADDRESS));

	$("#kpi-detail-country").text(textOrDash(item.COUNTRY));
	setFlagBadge("#flag-country", item.COUNTRY ? item.COUNTRY : "MISSING");
	if (!item.COUNTRY) {
		$("#flag-country")
			.removeClass("badge-info badge-success badge-ghost")
			.addClass("badge-warning");
	}
}

function renderItemDetail(item) {
	currentItem = item;
	const active = isItemActive(item.IID);
	const typeMeta = getItemTypeMeta(item.IITYP);
	const appEnv = $("#app-env").val() || process.env.APP_ENV || "";

	// Section 1: Operational Sync Strip
	$("#sync-status-dot")
		.removeClass("bg-success bg-error")
		.addClass(active ? "bg-success" : "bg-error");
	$("#sync-source-label").text(
		isPreviewMode ? "PREVIEW SAMPLE DATA" : "LIVE SYNC",
	);
	$("#sync-iid-badge").text(active ? "IM (ACTIVE)" : `${textOrDash(item.IID)} (INACTIVE)`);
	$("#sync-facility").text(textOrDash(item.IFCI));
	$("#sync-last-date").text(formatBpcsDate(item.ILDTE));
	$("#sync-abc-pill").text(`ABC: ${textOrDash(item.IABC)}`);

	// Section 1: Hero Header
	$("#detail-iprod").text(textOrDash(item.IPROD));
	$("#detail-idesc").text(textOrDash(item.IDESC));
	$("#detail-idsce").text(textOrDash(item.IDSCE));
	$("#detail-idscr").text(textOrDash(item.IDSCR));
	$("#detail-item-type")
		.removeClass("badge-primary badge-info badge-secondary badge-warning badge-ghost")
		.addClass(typeMeta.badge)
		.text(`TYPE ${typeMeta.code}: ${typeMeta.label}`);
	$("#detail-item-class").text(`CLASS: ${textOrDash(item.ICLAS)}`);
	$("#detail-item-status")
		.removeClass("badge-success badge-error")
		.addClass(active ? "badge-success" : "badge-error")
		.text(active ? "ACTIVE (IM)" : `INACTIVE (${textOrDash(item.IID)})`);
	$("#detail-preview-badge").toggleClass("hidden", !isPreviewMode);

	// 4 Quick Spec Chips
	$("#chip-idraw").text(textOrDash(item.IDRAW));
	$("#chip-imcom").text(
		item.IMCOM || item.IGTEC
			? `${textOrDash(item.IMCOM)} / ${textOrDash(item.IGTEC)}`
			: "-",
	);
	$("#chip-iwght").text(
		item.IWGHT
			? `${formatNumber(item.IWGHT, 2)} kg / ${textOrDash(item.IUMS)}`
			: textOrDash(item.IUMS),
	);
	$("#chip-iwhs").text(
		`${textOrDash(item.IWHS)} / ${textOrDash(item.ILOC)}`,
	);

	// Section 2: 4-Tile KPI Ribbon
	$("#kpi-detail-onhand").text(formatNumber(item.ONHAND ?? item.IOPB ?? 0));
	$("#kpi-detail-iums").text(textOrDash(item.IUMS));
	$("#kpi-detail-ionod").text(formatNumber(item.IONOD ?? 0));
	$("#kpi-detail-imin").text(formatNumber(item.IMIN ?? 0));

	$("#kpi-detail-iscst").text(formatCost(item.ISCST, 4));
	$("#kpi-detail-iacst").text(formatCost(item.IACST, 4));
	$("#kpi-detail-ilist").text(formatCost(item.ILIST, 2));

	$("#kpi-detail-ilead").text(formatNumber(item.ILEAD ?? 0));
	$("#kpi-detail-iordp").text(`POL: ${textOrDash(item.IORDP)}`);
	$("#kpi-detail-ilots").text(formatNumber(item.ILOTS ?? 0));
	$("#kpi-detail-imrp").text(textOrDash(item.IMRP));

	$("#kpi-detail-ivend").text(
		item.IVEND && Number(item.IVEND) !== 0 ? String(item.IVEND) : "-",
	);
	$("#kpi-detail-ibuyc").text(`BUY: ${textOrDash(item.IBUYC)}`);
	$("#kpi-detail-iven2").text(
		item.IVEN2 && Number(item.IVEN2) !== 0 ? String(item.IVEN2) : "-",
	);

	// TAB 1: Specs & Physical
	$("#f-IPROD").text(textOrDash(item.IPROD));
	$("#f-IID").text(textOrDash(item.IID));
	$("#f-IDRAW").text(textOrDash(item.IDRAW));
	$("#f-IDRF").text(textOrDash(item.IDRF));
	$("#f-ICLAS").text(textOrDash(item.ICLAS));
	$("#f-IITYP").text(`${typeMeta.code} (${typeMeta.label})`);
	$("#f-IABC").text(`${textOrDash(item.IABC)} / ${textOrDash(item.IABBT)}`);
	$("#f-IMCOM").text(textOrDash(item.IMCOM));
	$("#f-IGTEC").text(textOrDash(item.IGTEC));
	$("#f-IPFDV").text(textOrDash(item.IPFDV));
	$("#f-IPITM").text(textOrDash(item.IPITM));
	$("#f-ISITM").text(textOrDash(item.ISITM));
	$("#f-IBUSY").text(`${textOrDash(item.IBUSY)} / ${textOrDash(item.ISTYL)}`);
	$("#f-IFCI").text(`${textOrDash(item.IFCI)} / ${textOrDash(item.INCCFG)}`);
	$("#f-IDESC").text(textOrDash(item.IDESC));
	$("#f-IDSCE").text(textOrDash(item.IDSCE));
	$("#f-IDSCR").text(textOrDash(item.IDSCR));

	$("#f-IUMS").text(textOrDash(item.IUMS));
	$("#f-IUMP").text(textOrDash(item.IUMP));
	$("#f-IUMCN").text(formatNumber(item.IUMCN, 4));
	$("#f-IUMR").text(textOrDash(item.IUMR));
	$("#f-IUMRC").text(formatNumber(item.IUMRC, 4));
	$("#f-IMUM-ALT").text(
		`${textOrDash(item.IMUSC)} / ${textOrDash(item.IMUMB)} / ${textOrDash(item.IMUMA)}`,
	);
	$("#f-IWGHT").text(
		item.IWGHT !== undefined ? `${formatNumber(item.IWGHT, 3)} kg` : "-",
	);
	$("#f-IMBWT").text(
		item.IMBWT !== undefined ? `${formatNumber(item.IMBWT, 3)} kg` : "-",
	);
	$("#f-DIMS").text(
		`${formatNumber(item.ICLNG ?? 0, 2)} × ${formatNumber(item.ICWID ?? 0, 2)}`,
	);
	$("#f-IPACK").text(
		`${formatNumber(item.IPACK ?? 0)} / ${formatNumber(item.ILABL ?? 0)}`,
	);
	$("#f-IMPOT").text(`${formatNumber(item.IMPOT ?? 0, 2)}%`);
	$("#f-IUMAT").text(formatNumber(item.IUMAT ?? 0, 4));

	$("#f-IWHS").text(textOrDash(item.IWHS));
	$("#f-ILOC").text(textOrDash(item.ILOC));
	$("#f-IGLNO").text(textOrDash(item.IGLNO));
	$("#f-TAXC1").text(`${textOrDash(item.TAXC1)} / ${textOrDash(item.IDISC)}`);
	$("#f-IMUST").text(textOrDash(item.IMUST));
	$("#f-ISACT").text(textOrDash(item.ISACT));
	$("#f-IMPSD").text(`${textOrDash(item.IMPSD)} / ${textOrDash(item.IMSUM)}`);
	$("#f-ILDTE").text(formatBpcsDate(item.ILDTE));

	// TAB 2: Inventory & Activity
	$("#inv-IOPB").text(formatNumber(item.IOPB ?? 0));
	$("#inv-IONOD").text(formatNumber(item.IONOD ?? 0));
	$("#inv-IPRDA").text(formatNumber(item.IPRDA ?? 0));
	$("#inv-ICUSA").text(formatNumber(item.ICUSA ?? 0));
	$("#inv-IMIN").text(formatNumber(item.IMIN ?? 0));
	$("#inv-IMXIN").text(formatNumber(item.IMXIN ?? 0));
	$("#inv-REORDER").text(
		`${formatNumber(item.IMINR ?? 0)} / ${formatNumber(item.IMAXR ?? 0)}`,
	);
	$("#inv-TARGET").text(
		`${formatNumber(item.ITGQY ?? 0)} / ${formatNumber(item.IUNCN ?? 0)}`,
	);

	$("#mov-IRCT").text(formatNumber(item.IRCT ?? 0));
	$("#mov-IYRCT").text(formatNumber(item.IYRCT ?? 0));
	$("#mov-IISS").text(formatNumber(item.IISS ?? 0));
	$("#mov-IYISS").text(formatNumber(item.IYISS ?? 0));
	$("#mov-IADJ").text(formatNumber(item.IADJ ?? 0));
	$("#mov-IYADJ").text(formatNumber(item.IYADJ ?? 0));
	$("#mov-IMTDU").text(formatNumber(item.IMTDU ?? 0));
	$("#mov-IYTDU").text(formatNumber(item.IYTDU ?? 0));
	$("#mov-IMTDP").text(formatNumber(item.IMTDP ?? 0));
	$("#mov-IYTDP").text(formatNumber(item.IYTDP ?? 0));
	$("#mov-IMSLS").text(formatNumber(item.IMSLS ?? 0));
	$("#mov-IYSLS").text(formatNumber(item.IYSLS ?? 0));
	$("#mov-IMCOS").text(formatCost(item.IMCOS ?? 0, 2));
	$("#mov-IYCOS").text(formatCost(item.IYCOS ?? 0, 2));

	$("#inv-IAVEU").text(formatNumber(item.IAVEU ?? 0));
	$("#inv-IYUSE").text(formatNumber(item.IYUSE ?? 0));
	$("#inv-SAFLG").text(textOrDash(item.SAFLG));
	$("#inv-ICYC").text(`${formatNumber(item.ICYC ?? 0)} / ${textOrDash(item.ICYCF)}`);
	$("#inv-SEQ").text(`${formatNumber(item.INSEQ ?? 0)} / ${formatNumber(item.ITSEQ ?? 0)}`);
	$("#inv-IPCTK").text(`${formatNumber(item.IPCTK ?? 0, 2)}%`);

	// TAB 3: Costing & Valuation
	$("#cost-ISCST").text(formatCost(item.ISCST, 4));
	$("#cost-IACST").text(formatCost(item.IACST, 4));
	$("#cost-IFCST").text(formatCost(item.IFCST, 4));
	$("#cost-ILIST").text(formatCost(item.ILIST, 4));
	$("#cost-IORDC").text(formatCost(item.IORDC, 4));
	$("#cost-VUL").text(
		`${formatCost(item.IVULI ?? 0, 2)} / ${formatCost(item.IVULP ?? 0, 2)}`,
	);
	renderCostBuckets(item, $("#toggle-nonzero-buckets").is(":checked"));

	// TAB 4: Planning & MRP
	$("#plan-IMRP").text(textOrDash(item.IMRP));
	$("#plan-IORDP").text(textOrDash(item.IORDP));
	$("#plan-IACT").text(textOrDash(item.IACT));
	$("#plan-ILOTS").text(formatNumber(item.ILOTS ?? 0));
	$("#plan-IBTCH").text(formatNumber(item.IBTCH ?? 0));
	$("#plan-IIOQ").text(formatNumber(item.IIOQ ?? 0));
	$("#plan-ILEVL").text(formatNumber(item.ILEVL ?? 0));
	$("#plan-ILCC").text(formatNumber(item.ILCC ?? 0));
	$("#plan-IJIT").text(textOrDash(item.IJIT));
	$("#plan-IMAXP").text(formatNumber(item.IMAXP ?? 0));

	$("#plan-ILEAD").text(`${formatNumber(item.ILEAD ?? 0)} Days`);
	$("#plan-ITFDY").text(`${formatNumber(item.ITFDY ?? 0)} Days`);
	$("#plan-IPODY").text(`${formatNumber(item.IPODY ?? 0)} Days`);
	$("#plan-IDMTF").text(`${formatNumber(item.IDMTF ?? 0)} Days`);
	$("#plan-IDLTR").text(formatNumber(item.IDLTR ?? 0));
	$("#plan-IMBHD").text(formatNumber(item.IMBHD ?? 0));
	$("#plan-IMBDY").text(formatNumber(item.IMBDY ?? 0));
	$("#plan-IMQDY").text(formatNumber(item.IMQDY ?? 0));
	$("#plan-IPERS").text(formatNumber(item.IPERS ?? 0));
	$("#plan-IARRT").text(formatNumber(item.IARRT ?? 0));
	$("#plan-IDMC").text(`${textOrDash(item.IDMC1)} / ${textOrDash(item.IDMC2)}`);

	// TAB 5: Procurement & Origin
	$("#proc-IBUYC").text(textOrDash(item.IBUYC));
	$("#proc-IPURC").text(textOrDash(item.IPURC));
	$("#proc-IFENO").text(
		item.IFENO && Number(item.IFENO) !== 0 ? String(item.IFENO) : "-",
	);
	renderVendorTable(item);
	renderOriginView(item);

	// Right Sidebar
	$("#side-drawing-code").text(textOrDash(item.IDRAW));
	$("#side-idrf").text(textOrDash(item.IDRF));
	$("#side-iityp").text(`${typeMeta.code} (${typeMeta.label})`);
	$("#side-idesc").text(textOrDash(item.IDESC));
	$("#side-iwght").text(item.IWGHT ? `${formatNumber(item.IWGHT, 2)} kg` : "-");
	$("#side-dims").text(
		`${formatNumber(item.ICLNG ?? 0)}×${formatNumber(item.ICWID ?? 0)}`,
	);
	$("#side-ipack").text(formatNumber(item.IPACK ?? 0));

	const plannerLabel = item.PLANNERNAME || `Buyer ${textOrDash(item.IBUYC)}`;
	const initials = plannerLabel
		.split(/\s+/)
		.filter(Boolean)
		.slice(0, 2)
		.map((s) => s.charAt(0).toUpperCase())
		.join("");
	$("#side-planner-avatar").text(initials || "PL");
	$("#side-planner-name").text(plannerLabel);
	$("#side-ibuyc").text(textOrDash(item.IBUYC));
	$("#side-ipurc").text(textOrDash(item.IPURC));

	if (item.IVEND && Number(item.IVEND) !== 0) {
		$("#side-ivend-link")
			.attr("href", `${appEnv}/Vendors/detail/${encodeURIComponent(item.IVEND)}`)
			.text(String(item.IVEND));
	} else {
		$("#side-ivend-link").attr("href", "#").text("-");
	}
	$("#side-iven2").text(
		item.IVEN2 && Number(item.IVEN2) !== 0 ? String(item.IVEN2) : "-",
	);
	$("#side-wsh-loc").text(`${textOrDash(item.IWHS)} / ${textOrDash(item.ILOC)}`);
	$("#side-iglno").text(textOrDash(item.IGLNO));

	$("#side-status-pill")
		.removeClass("badge-success badge-error")
		.addClass(active ? "badge-success" : "badge-error")
		.text(textOrDash(item.IID));
	setFlagBadge("#flag-imrp", item.IMRP);
	setFlagBadge("#flag-ijit", item.IJIT);
	setFlagBadge("#flag-ifii", item.IFII);
	setFlagBadge("#flag-isofl", item.ISOFL);
	setFlagBadge("#flag-ifrfg", item.IFRFG);
}

function switchTab(tabId) {
	$(".item-detail-tab")
		.removeClass("font-bold text-primary border-primary")
		.addClass("font-semibold text-mute border-transparent")
		.attr("aria-selected", "false");

	$(`.item-detail-tab[data-tab="${tabId}"]`)
		.removeClass("font-semibold text-mute border-transparent")
		.addClass("font-bold text-primary border-primary")
		.attr("aria-selected", "true");

	$(".item-tab-panel").addClass("hidden").removeClass("flex");
	$(`#${tabId}`).removeClass("hidden").addClass("flex");
}

function openOriginEditor() {
	if (!currentItem) return;
	switchTab("tab-procurement");
	const mode = String(currentItem.COUNTRY_MODE ?? 0);
	$(`input[name="origin-mode"][value="${mode}"]`).prop("checked", true);
	$("#origin-edit-type").val(currentItem.ORIGIN_TYPE || "");
	$("#origin-edit-country").val(currentItem.COUNTRY || "");
	$("#origin-edit-mfg-name").val(currentItem.MFG_NAME || "");
	$("#origin-edit-mfg-addr").val(currentItem.MFG_ADDRESS || "");
	$("#origin-view-panel").addClass("hidden");
	$("#origin-edit-form").removeClass("hidden").addClass("flex");
}

function closeOriginEditor() {
	$("#origin-edit-form").addClass("hidden").removeClass("flex");
	$("#origin-view-panel").removeClass("hidden");
}

async function loadItemDetail() {
	const itemCode = ($("#item-prod-id").val() || "").trim();
	showLoader();
	try {
		if (!itemCode) {
			throw new Error("Missing item code");
		}
		const [iimRes, viewRes] = await Promise.allSettled([
			getIimByProd(itemCode),
			getItemMasterServerSide({
				draw: 1,
				start: 0,
				length: 1,
				search: { value: "", regex: false },
				order: [{ column: 0, dir: "asc", name: "ITEM" }],
				columns: [
					{
						data: "ITEM",
						name: "ITEM",
						searchable: true,
						orderable: true,
						search: { value: itemCode, regex: false },
					},
				],
			}),
		]);

		let merged = null;
		if (
			iimRes.status === "fulfilled" &&
			iimRes.value?.status &&
			Array.isArray(iimRes.value.data) &&
			iimRes.value.data.length > 0
		) {
			merged = { ...iimRes.value.data[0] };
		}
		if (
			viewRes.status === "fulfilled" &&
			Array.isArray(viewRes.value?.data) &&
			viewRes.value.data.length > 0
		) {
			const v = viewRes.value.data[0];
			merged = merged
				? {
						...merged,
						VENDOR_NAME: v.VENDOR_NAME,
						PLANNER: v.PLANNER,
						PLANNERNAME: v.PLANNERNAME,
						COUNTRY: v.COUNTRY,
						COUNTRY_MODE: v.COUNTRY_MODE,
						ORIGIN_TYPE: v.ORIGIN_TYPE,
						MFG_NAME: v.MFG_NAME,
						MFG_ADDRESS: v.MFG_ADDRESS,
						ONHAND: v.ONHAND,
					}
				: v;
		}

		if (!merged) {
			throw new Error("Record not found in live IIM API");
		}

		isPreviewMode = false;
		renderItemDetail(normalizeIimRecord(merged));
	} catch (error) {
		console.warn("Falling back to sample IIM detail:", error);
		isPreviewMode = true;
		const match =
			SAMPLE_IIM_ITEMS.find(
				(i) => i.IPROD.toLowerCase() === itemCode.toLowerCase(),
			) || SAMPLE_IIM_ITEMS[0];
		renderItemDetail(normalizeIimRecord(match));
	} finally {
		showLoader({ show: false });
	}
}

function bindEvents() {
	$(document).on("click", ".item-detail-tab", function () {
		const tabId = $(this).data("tab");
		if (tabId) switchTab(tabId);
	});

	$(document).on("change", "#toggle-nonzero-buckets", function () {
		if (currentItem) {
			renderCostBuckets(currentItem, $(this).is(":checked"));
		}
	});

	$(document).on(
		"click",
		"#detail-btn-edit-origin, #side-btn-jump-origin, #btn-edit-origin-inline",
		function () {
			openOriginEditor();
		},
	);

	$(document).on("click", "#btn-cancel-origin-inline", function () {
		closeOriginEditor();
	});

	$(document).on("submit", "#origin-edit-form", async function (e) {
		e.preventDefault();
		if (!currentItem) return;

		const country = ($("#origin-edit-country").val() || "").trim().toUpperCase();
		const originType = Number($("#origin-edit-type").val() || 0);
		const countryMode = Number(
			$('input[name="origin-mode"]:checked').val() || 0,
		);
		const mfgName = ($("#origin-edit-mfg-name").val() || "").trim();
		const mfgAddress = ($("#origin-edit-mfg-addr").val() || "").trim();

		if (!country) {
			showMessage("Please specify Country of Origin.", "warning");
			return;
		}

		try {
			showLoader();
			const payload = {
				BULKCODE: currentItem.IPROD,
				COUNTRY: country,
				COUNTRY_MODE: countryMode,
				ORIGIN_TYPE: originType,
				MFG_NAME: mfgName,
				MFG_ADDRESS: mfgAddress,
			};

			if (!isPreviewMode) {
				const user = await currentUser();
				if (currentItem.COUNTRY) {
					payload.UPDATEBY = user?.empno;
					payload.UPDATEDATE = new Date();
				} else {
					payload.CREATEBY = user?.empno;
				}
				const res = await saveItemOrigin(payload);
				if (!res?.status) {
					throw new Error(res?.message || "Failed to save Country of Origin");
				}
			}

			currentItem = {
				...currentItem,
				COUNTRY: country,
				COUNTRY_MODE: countryMode,
				ORIGIN_TYPE: originType,
				MFG_NAME: mfgName,
				MFG_ADDRESS: mfgAddress,
			};
			renderOriginView(currentItem);
			closeOriginEditor();
			showMessage(
				isPreviewMode
					? "Country of Origin updated in preview mode."
					: "Country of Origin saved successfully.",
				"success",
			);
		} catch (error) {
			console.error("Save Origin Error:", error);
			showErrorMessage(error.message);
		} finally {
			showLoader({ show: false });
		}
	});

	$(document).on("click", "#detail-btn-print, #footer-btn-print", function () {
		window.print();
	});

	$(document).on("click", "#detail-btn-copy-code", async function () {
		const code = currentItem?.IPROD || $("#detail-iprod").text().trim();
		if (!code || code === "-") return;
		try {
			await navigator.clipboard.writeText(code);
			showMessage(`Copied ${code} to clipboard.`, "success");
		} catch {
			showMessage(`Item Code: ${code}`, "info");
		}
	});
}

$(async function () {
	try {
		await window.appReady;
		bindEvents();
		await loadItemDetail();
	} catch (error) {
		console.error("ItemMaster Detail Initialization Error:", error);
		showErrorMessage(error.message || "Failed to load Item Master detail.");
	}
});
