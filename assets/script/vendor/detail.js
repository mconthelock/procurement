import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import {
	getVendors,
	getVendorHistory,
	getVendorEvaluation,
} from "../service/index.js";
import { escapeHtml, escapeAttribute } from "../utils.js";

const STATUS_BADGES = {
	0: { class: "badge-warning", text: "Creating" },
	1: { class: "badge-success", text: "Active" },
	2: { class: "badge-error", text: "Inactive" },
	ACTIVE: { class: "badge-success", text: "Active" },
	HOLD: { class: "badge-warning", text: "Hold" },
	INACTIVE: { class: "badge-error", text: "Inactive" },
	DELETED: { class: "badge-error", text: "Deleted" },
	DO_NOT_USE: { class: "badge-error", text: "Do Not Use" },
};

const FIRST_DIGIT_MAP = {
	1: "1: Overseas (MELCO Group)",
	2: "2: Overseas (Non-MELCO)",
	3: "3: Domestic BOI (Paused until FY2031)",
	4: "4: Domestic IPO (IBC Approval)",
	5: "5: Domestic Vendor",
	6: "6: Non-Production (AMEC PO)",
	7: "7: Domestic FTA Privilege",
	8: "8: Sub-Contractor",
};

const MODE_META = {
	A: { label: "ADD", class: "badge-success" },
	U: { label: "UPDATE", class: "badge-info" },
	E: { label: "UPDATE", class: "badge-info" },
	D: { label: "DELETE", class: "badge-error" },
};

const FORM_STATUS_META = {
	0: { label: "Draft", class: "badge-ghost" },
	1: { label: "In-Progress", class: "badge-warning" },
	2: { label: "Approved", class: "badge-success" },
	3: { label: "Rejected", class: "badge-error" },
};

const DIFF_FIELD_LABELS = [
	["VENDNAME", "Vendor Name (EN)"],
	["VENDGROUPTYPE", "Vendor Group Type"],
	["VENDCAT", "Vendor Category"],
	["TAXID", "TAX. ID / Swift Code"],
	["CANO", "CA No."],
	["BANO", "BA No."],
	["CURCODE", "Currency Code"],
	["TERMCODE", "Terms Code"],
	["TRADE_CODE", "Trade Term / Ship-to"],
	["VTYPE", "Vendor Type (FIN)"],
	["VPAYTO", "Pay to Vendor"],
	["V1TIME", "One-Time Vendor"],
	["HOLD_VENDOR", "Hold Vendor"],
	["V1099", "1099 Vendor"],
	["CONTACT", "Contact Name"],
	["EMAIL", "Email"],
	["TELNO", "Telephone No."],
	["FAX", "Fax No."],
	["WEBSITE", "Website"],
	["ADDR1", "Address Line 1 (EN)"],
	["ADDR2", "Address Line 2 (EN)"],
	["CITY", "City"],
	["STATE", "State"],
	["POSTCODE", "Postcode"],
	["COUNTRY", "Country"],
	["BANKNAME", "Bank Name"],
	["BRANCH", "Branch Name"],
	["ACCNUMBER", "Bank Account No."],
];

let currentVendor = null;
let allRevisions = [];
let activeDiffRev = null;

const setText = (elementId, value) => {
	$(`#${elementId}`).text(
		value !== undefined && value !== null && String(value).trim() !== ""
			? value
			: "-",
	);
};

const formatDate = (dateString) => {
	if (!dateString) return "-";
	const date = new Date(dateString);
	if (Number.isNaN(date.getTime())) return String(dateString);
	return (
		date.toLocaleDateString("en-GB") +
		" " +
		date.toLocaleTimeString("en-GB", {
			hour: "2-digit",
			minute: "2-digit",
		})
	);
};

const formatNumber = (val) => {
	if (val === undefined || val === null || val === "") return "-";
	const num = Number(val);
	if (Number.isNaN(num)) return String(val);
	return num.toLocaleString("en-US", {
		minimumFractionDigits: 2,
		maximumFractionDigits: 2,
	});
};

const decodeVendorCode = (code) => {
	const raw = String(code || "").trim();
	if (!raw) return "PRO-QP-A-020 Classification";
	const first = raw.charAt(0);
	let desc = FIRST_DIGIT_MAP[first] || `Group ${first}`;
	if (first === "6" && raw.length >= 2) {
		desc += raw.startsWith("69") ? " • Oversea (69XXX)" : " • Local (6XXXX)";
	}
	return desc;
};

function updateVendorStatus(statusCode, holdFlag) {
	const $badge = $("#view-VND_STATUS");
	$badge.removeClass("badge-warning badge-success badge-error badge-ghost");
	const key =
		typeof statusCode === "string"
			? statusCode.toUpperCase().replace(/\s+/g, "_")
			: statusCode;
	const meta = STATUS_BADGES[key];
	if (meta) {
		$badge.addClass(meta.class).text(meta.text);
	} else {
		$badge.addClass("badge-ghost").text(statusCode ? String(statusCode) : "Unknown");
	}

	const isHold =
		String(holdFlag || "").toUpperCase() === "Y" ||
		key === "HOLD" ||
		key === "DO_NOT_USE" ||
		key === "DELETED" ||
		key === 2;
	$("#hold-vendor-banner")
		.toggleClass("hidden", !isHold)
		.toggleClass("flex", isHold);
}

function updateCharCounter(elId, text, limit = 30) {
	const len = String(text || "").length;
	const $el = $(`#${elId}`);
	$el.text(`${len} / ${limit} chars`);
	$el.toggleClass("text-error font-bold", len > limit);
	$el.toggleClass("text-mute", len <= limit);
}

function renderAddresses(vendorData) {
	const addresses =
		vendorData.VENDOR_ADDRESS || vendorData.PURNVF_ADDRESS || [];
	const enAddress = addresses.find(
		(a) => (a.ADDR_TYPE || a.ADDRTYPE) === "E",
	);
	const thAddress = addresses.find(
		(a) => (a.ADDR_TYPE || a.ADDRTYPE) === "T",
	);

	const enLine1 =
		enAddress?.ADDR_LINE1 || enAddress?.ADDR1 || vendorData.VND_ADDRESS1 || "";
	const enLine2 =
		enAddress?.ADDR_LINE2 || enAddress?.ADDR2 || vendorData.VND_ADDRESS2 || "";

	setText("view-ADDR_EN_LINE1", enLine1);
	setText("view-ADDR_EN_LINE2", enLine2);
	updateCharCounter("char-en-line1", enLine1, 30);
	updateCharCounter("char-en-line2", enLine2, 30);

	setText("view-ADDR_EN_CITY", enAddress?.ADDR_CITY || enAddress?.CITY || vendorData.VND_CITY);
	setText("view-ADDR_EN_STATE", enAddress?.ADDR_STATE || enAddress?.STATE || vendorData.VND_STATE);
	setText("view-ADDR_EN_ZIPCODE", enAddress?.ADDR_ZIPCODE || enAddress?.POSTCODE || vendorData.VND_ZIPCODE);
	setText("view-ADDR_EN_COUNTRY", enAddress?.ADDR_COUNTRY || enAddress?.COUNTRY || vendorData.VND_COUNTRY);

	if (thAddress) {
		setText("view-ADDR_TH_LINE1", thAddress.ADDR_LINE1 || thAddress.ADDR1);
		setText("view-ADDR_TH_LINE2", thAddress.ADDR_LINE2 || thAddress.ADDR2 || thAddress.ADDR_SUBDISTRICT);
		setText("view-ADDR_TH_CITY", thAddress.ADDR_CITY || thAddress.CITY);
		setText("view-ADDR_TH_STATE", thAddress.ADDR_STATE || thAddress.STATE);
		setText("view-ADDR_TH_ZIPCODE", thAddress.ADDR_ZIPCODE || thAddress.POSTCODE);
		setText("view-ADDR_TH_COUNTRY", thAddress.ADDR_COUNTRY || thAddress.COUNTRY);
	}
}

function renderVendorCodes(codes = [], vendorData = {}) {
	const $tbody = $("#view-vendor-code-container");
	$tbody.empty();

	const rows = codes.length
		? codes
		: vendorData.VND_CODE
			? [
					{
						CODE_NUM: vendorData.VND_CODE,
						CODE_CURRENCY: vendorData.VND_CURRENCY || vendorData.CURCODE || "-",
						CODE_PAY: vendorData.VND_TERM || vendorData.TERMCODE || "-",
						CODE_STATUS: vendorData.VND_STATUS === 2 ? 0 : 1,
					},
				]
			: [];

	$("#badge-count-codes").text(rows.length);

	if (!rows.length) {
		$tbody.append(`
			<tr>
				<td colspan="4" class="py-6 text-center text-mute italic">No vendor codes available.</td>
			</tr>
		`);
		return;
	}

	rows.forEach((item) => {
		const isActive = item.CODE_STATUS == 1 || item.CODE_STATUS === "ACTIVE";
		const statusHtml = isActive
			? '<span class="badge badge-xs badge-success font-bold uppercase">Active</span>'
			: '<span class="badge badge-xs badge-error font-bold uppercase">Inactive</span>';

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

function renderScmUsers(users = []) {
	const $tbody = $("#view-scm-users-container");
	$tbody.empty();
	$("#badge-count-scm").text(users.length);

	const $syncScm = $("#sync-badge-scm");
	$syncScm.removeClass("badge-ghost badge-success badge-warning");
	if (users.length > 0) {
		$syncScm.addClass("badge-success").text(`E-SCM: ${users.length} USERS`);
	} else {
		$syncScm.addClass("badge-ghost").text("E-SCM: N/A");
	}

	if (!users.length) {
		$tbody.append(`
			<tr>
				<td colspan="6" class="py-6 text-center text-mute italic">
					No E-SCM contact accounts registered for this vendor.
				</td>
			</tr>
		`);
		return;
	}

	users.forEach((u, idx) => {
		const isEnabled = u.STATUS === undefined || u.STATUS == 1 || u.STATUS === "ACTIVE";
		const statusHtml = isEnabled
			? '<span class="badge badge-xs badge-success font-mono font-bold uppercase">Enabled</span>'
			: '<span class="badge badge-xs badge-ghost font-mono font-bold uppercase">Disabled</span>';

		$tbody.append(`
			<tr class="hover:bg-base-200/60 transition-colors">
				<td class="text-center font-mono text-mute py-3">${idx + 1}</td>
				<td class="font-semibold text-primary py-3">${escapeHtml(u.NAME || u.USR_NAME || "-")}</td>
				<td class="font-mono text-info py-3">${escapeHtml(u.EMAIL || u.USR_EMAIL || "-")}</td>
				<td class="font-mono font-bold text-primary py-3">${escapeHtml(u.USERNAME || u.USR_LOGIN || "-")}</td>
				<td class="font-mono text-secondary py-3">${escapeHtml(u.FORM_NO || "-")}</td>
				<td class="text-center py-3">${statusHtml}</td>
			</tr>
		`);
	});
}

function renderDocuments(files = []) {
	const groups = {
		11: $("#docs-group-11"),
		12: $("#docs-group-12"),
		13: $("#docs-group-13"),
		other: $("#docs-group-other"),
	};

	Object.values(groups).forEach(($g) => $g.empty());
	$("#badge-count-docs").text(files.length);

	const bucketCounts = { 11: 0, 12: 0, 13: 0, other: 0 };

	files.forEach((file) => {
		const fType = Number(file.FILE_TYPE);
		const key = fType === 11 || fType === 12 || fType === 13 ? fType : "other";
		bucketCounts[key] += 1;

		const fileName = escapeHtml(
			file.FILE_ONAME || file.FILE_NAME || file.UFILE_NAME || "Document",
		);
		const rawPath = file.FILE_PATH
			? `${file.FILE_PATH}/${file.FILE_FNAME || ""}`
			: `/uploads/${file.UFILE_NAME || file.FILE_FNAME || ""}`;
		const fileUrl = escapeAttribute(rawPath.replace(/\/+/g, "/"));
		const sourceTag = file.SOURCE_FORM
			? `<span class="badge badge-xs badge-outline font-mono text-[10px]">${escapeHtml(file.SOURCE_FORM)}</span>`
			: "";
		const metaDate = file.FILE_DATECREATE ? formatDate(file.FILE_DATECREATE) : "";

		groups[key].append(`
			<div class="flex items-center justify-between gap-2 px-3 py-2 bg-base-200 border border-base-300">
				<div class="flex items-center gap-2 min-w-0">
					<span class="material-symbols-outlined text-[16px] text-secondary shrink-0">description</span>
					<div class="min-w-0">
						<a href="${fileUrl}" target="_blank" rel="noopener noreferrer"
							class="link link-hover text-xs font-mono text-info block truncate">
							${fileName}
						</a>
						<div class="flex items-center gap-2 text-[10px] text-mute font-mono mt-0.5">
							${sourceTag}
							${metaDate ? `<span>${escapeHtml(metaDate)}</span>` : ""}
						</div>
					</div>
				</div>
				<a href="${fileUrl}" target="_blank" rel="noopener noreferrer"
					class="btn btn-xs btn-outline border-base-300 bg-white shrink-0 gap-1">
					<span class="material-symbols-outlined text-[13px]">open_in_new</span>
					<span>View</span>
				</a>
			</div>
		`);
	});

	Object.entries(bucketCounts).forEach(([key, count]) => {
		if (count === 0) {
			groups[key].append(
				'<span class="text-mute italic">No files in this category.</span>',
			);
		}
	});
}

function renderEvaluation(eva) {
	if (!eva) return;

	const grade = eva.MJUDGEMENT || eva.JUDGEMENT || "-";
	setText("kpi-eval-grade", grade !== "-" ? `Grade ${grade}` : "-");
	setText("badge-eval-grade", grade);
	setText("eva-mjudgement", grade !== "-" ? `Grade ${grade}` : "-");
	setText("eva-judgement-auto", `Auto Calc: ${eva.JUDGEMENT || "-"}`);

	const $gradeBadge = $("#badge-eval-grade");
	$gradeBadge.removeClass("badge-ghost badge-success badge-warning badge-error");
	if (grade === "A" || grade === "B") $gradeBadge.addClass("badge-success");
	else if (grade === "C") $gradeBadge.addClass("badge-warning");
	else if (grade === "D" || grade === "E") $gradeBadge.addClass("badge-error");
	else $gradeBadge.addClass("badge-ghost");

	if (eva.EVANO) {
		$("#eva-form-badge").text(`EVA: ${eva.EVANO}`);
		$("#kpi-eval-ref").text(eva.EVANO);
		$("#view-REF_EVANO").text(`EVA: ${eva.EVANO}`);
		$("#link-ref-eva").removeClass("hidden").addClass("inline-flex");
	}

	if (eva.NVFNO) {
		setText("eva-nvfno", eva.NVFNO);
		$("#badge-ref-nvf").text(`NVF: ${eva.NVFNO}`).removeClass("hidden");
	}

	setText("kpi-eval-level", `Purchase Level: ${eva.PUR_LEVEL || "-"}`);
	setText("kpi-eval-fy", `Fiscal Year: ${eva.FY_AMOUNT || "-"}`);
	setText("eva-pur-level", eva.PUR_LEVEL ? `Level ${eva.PUR_LEVEL}` : "-");
	setText("eva-amount", `${formatNumber(eva.AMOUNT)} THB (FY ${eva.FY_AMOUNT || "-"})`);
	setText(
		"eva-operation",
		eva.OPERATION === "N"
			? "New Vendor Evaluation"
			: eva.OPERATION === "A"
				? "Annual Evaluation"
				: eva.OPERATION || "-",
	);

	setText("eva-qm", eva.QM_STATUS ? `${eva.QM_STATUS}${eva.QM_REASON ? ` (${eva.QM_REASON})` : ""}` : "-");
	setText("eva-env", eva.ENV_STATUS ? `${eva.ENV_STATUS}${eva.ENV_REASON ? ` (${eva.ENV_REASON})` : ""}` : "-");
	setText("eva-csr", eva.CSR_STATUS ? `${eva.CSR_STATUS}${eva.CSR_REASON ? ` (${eva.CSR_REASON})` : ""}` : "-");
	setText(
		"eva-labor",
		eva.LABOR_STATUS
			? `${eva.LABOR_STATUS}${eva.LABOR_ESTABLISH_DATE ? ` (Est. ${formatDate(eva.LABOR_ESTABLISH_DATE)})` : ""}`
			: "-",
	);

	if (eva.COMPLIANCE) {
		const $tags = $("#eva-compliance-tags").empty();
		String(eva.COMPLIANCE)
			.split(/[,;|]+/)
			.map((s) => s.trim())
			.filter(Boolean)
			.forEach((tag) => {
				$tags.append(
					`<span class="badge badge-xs badge-outline border-primary text-primary font-mono">${escapeHtml(tag)}</span>`,
				);
			});
	}

	setText(
		"eva-capital",
		eva.CAPITAL ? `${formatNumber(eva.CAPITAL)} ${eva.CAPITAL_CUR || "THB"}` : "-",
	);
	setText("eva-established", eva.ESTABLISHED);
	const empTotal = (Number(eva.EMPDIRECT) || 0) + (Number(eva.EMPINDIRECT) || 0);
	setText(
		"eva-employees",
		empTotal ? `${empTotal} (${eva.EMPDIRECT || 0}D / ${eva.EMPINDIRECT || 0}I)` : "-",
	);

	// Scores
	const scores = eva.SCORES || [];
	if (scores.length) {
		const $scoreBody = $("#eva-score-container").empty();
		let totalScore = 0;
		scores.forEach((sc) => {
			const val = Number(sc.SCORE) || 0;
			totalScore += val;
			const pct = Math.min(100, Math.round((val / 25) * 100));
			$scoreBody.append(`
				<tr class="hover:bg-base-200/60">
					<td class="font-semibold text-primary py-2.5">${escapeHtml(sc.TOPIC || "-")}</td>
					<td class="text-secondary py-2.5">${escapeHtml(sc.TOPIC_DESC || "-")}</td>
					<td class="text-center font-mono font-bold py-2.5">${escapeHtml(sc.SLEVEL || "-")}</td>
					<td class="text-right font-mono font-bold text-primary py-2.5">${val} / 25</td>
					<td class="py-2.5">
						<div class="w-full h-2 bg-base-200 border border-base-300">
							<div class="h-full bg-primary" style="width:${pct}%"></div>
						</div>
					</td>
				</tr>
			`);
		});
		$("#kpi-eval-score").text(`Score: ${totalScore} / ${scores.length * 25}`);
	}

	// 3-Year Financials
	const financials = eva.FINANCIALS || [];
	if (financials.length) {
		const byYear = {};
		financials.forEach((row) => {
			const yr = row.MYEAR;
			if (!byYear[yr]) byYear[yr] = { year: yr, T: null, P: null };
			byYear[yr][row.RECORD_TYPE] = row.AMOUNT;
		});
		const $finBody = $("#eva-financials-container").empty();
		Object.values(byYear)
			.sort((a, b) => b.year - a.year)
			.forEach((yr) => {
				$finBody.append(`
					<tr>
						<td class="font-mono font-bold text-primary">${escapeHtml(yr.year)}</td>
						<td class="text-right font-mono">${formatNumber(yr.T)}</td>
						<td class="text-right font-mono">${formatNumber(yr.P)}</td>
					</tr>
				`);
			});
	}

	// Relations
	const relations = eva.RELATIONS || [];
	const relMap = {
		N: $("#eva-rel-shareholders"),
		C: $("#eva-rel-customers"),
		S: $("#eva-rel-suppliers"),
		P: $("#eva-rel-products"),
	};
	if (relations.length) {
		Object.values(relMap).forEach(($el) => $el.empty());
		relations.forEach((r) => {
			const $target = relMap[r.ENTITY_TYPE];
			if ($target) {
				$target.append(`
					<div class="flex items-center justify-between gap-2">
						<span class="truncate">${escapeHtml(r.ENTITY_NAME || "-")}</span>
						<span class="font-mono font-bold text-primary shrink-0">${escapeHtml(r.PERCENT ?? 0)}%</span>
					</div>
				`);
			}
		});
		Object.values(relMap).forEach(($el) => {
			if (!$el.children().length) $el.append('<span class="text-mute italic">-</span>');
		});
	}
}

function computeChangedFields(prevSnap = {}, currSnap = {}) {
	const changed = [];
	DIFF_FIELD_LABELS.forEach(([key, label]) => {
		const before = prevSnap[key] ?? "";
		const after = currSnap[key] ?? "";
		if (String(before).trim() !== String(after).trim()) {
			changed.push({ key, label, before: before || "-", after: after || "-" });
		}
	});
	return changed;
}

function buildFallbackRevision(vendorData) {
	const snap = {
		VENDNAME: vendorData.VND_NAME || "",
		VENDGROUPTYPE: vendorData.VENDGROUPTYPE || vendorData.VND_TYPE1 || "",
		VENDCAT: vendorData.VND_CATEGORY || "",
		TAXID: vendorData.VND_TAXNO || vendorData.TAXID || "",
		CANO: vendorData.VND_CANO || "",
		BANO: vendorData.VND_BANO || "",
		CURCODE: vendorData.VND_CURRENCY || vendorData.CURCODE || "",
		TERMCODE: vendorData.VND_TERM || vendorData.TERMCODE || "",
		VTYPE: vendorData.VND_TYPE2 || vendorData.VTYPE || "",
		CONTACT: vendorData.VND_CONTACTNAME || vendorData.VND_SALE || "",
		TELNO: vendorData.VND_PHONE || vendorData.ADDR_PHONE || "",
		FAX: vendorData.VND_FAX || "",
		ADDR1: vendorData.VND_ADDRESS1 || "",
		ADDR2: vendorData.VND_ADDRESS2 || "",
		CITY: vendorData.VND_CITY || "",
		STATE: vendorData.VND_STATE || "",
		COUNTRY: vendorData.VND_COUNTRY || "",
	};

	return [
		{
			revNo: 1,
			formNo: vendorData.INITIAL_FORM_NO || "MASTER-INIT",
			evaNo: vendorData.EVANO || "",
			mode: "A",
			status: 2,
			approvedDate: vendorData.VND_REGDATE || vendorData.VND_REGISTED || vendorData.CREATE_AT,
			approvals: [
				{
					role: "In-charge (Buyer)",
					user: vendorData.VND_REGNAME || vendorData.CREATE_BY || "-",
					action: "Issued",
					timestamp: vendorData.VND_REGDATE || vendorData.VND_REGISTED || "-",
				},
			],
			prevSnapshot: {},
			currSnapshot: snap,
		},
	];
}

function renderHistoryTable(revisions = []) {
	const $tbody = $("#view-history-container").empty();
	$("#historySummaryCount").text(
		`Showing ${revisions.length} revision transaction${revisions.length === 1 ? "" : "s"}`,
	);

	if (!revisions.length) {
		$tbody.append(`
			<tr>
				<td colspan="6" class="py-8 text-center text-mute italic">
					No revision transactions match the selected filters.
				</td>
			</tr>
		`);
		return;
	}

	revisions.forEach((rev, index) => {
		const modeKey = String(rev.mode || "U").toUpperCase();
		const modeMeta = MODE_META[modeKey] || MODE_META.U;
		const statusMeta = FORM_STATUS_META[rev.status] || FORM_STATUS_META[2];
		const diffs = computeChangedFields(rev.prevSnapshot, rev.currSnapshot);

		const diffPills =
			modeKey === "A"
				? '<span class="badge badge-xs badge-outline border-success text-success font-mono">Initial Master Creation</span>'
				: diffs.length
					? diffs
							.slice(0, 3)
							.map(
								(d) =>
									`<span class="badge badge-xs badge-outline border-base-300 text-secondary font-mono">${escapeHtml(d.label)}</span>`,
							)
							.join(" ") +
						(diffs.length > 3
							? ` <span class="badge badge-xs badge-ghost font-mono">+${diffs.length - 3} more</span>`
							: "")
					: '<span class="text-mute italic">Metadata / Attachment update</span>';

		const trailHtml = (rev.approvals || [])
			.map(
				(ap) =>
					`<div class="flex items-center gap-1.5 text-[11px] font-mono">
						<span class="font-bold text-primary">${escapeHtml(ap.role)}:</span>
						<span class="text-secondary">${escapeHtml(ap.user || "-")}</span>
						<span class="text-mute">(${escapeHtml(formatDate(ap.timestamp))})</span>
					</div>`,
			)
			.join("");

		$tbody.append(`
			<tr class="hover:bg-base-200/60 transition-colors">
				<td class="py-3 align-top">
					<div class="flex flex-col gap-1">
						<span class="font-mono font-bold text-primary">Rev #${escapeHtml(rev.revNo ?? revisions.length - index)}</span>
						<span class="badge badge-xs ${modeMeta.class} font-mono font-bold w-fit">${modeMeta.label}</span>
					</div>
				</td>
				<td class="py-3 align-top">
					<div class="font-mono font-bold text-primary">${escapeHtml(rev.formNo || "-")}</div>
					${rev.evaNo ? `<div class="text-[11px] font-mono text-info mt-0.5">Ref EVA: ${escapeHtml(rev.evaNo)}</div>` : ""}
					<div class="text-[11px] font-mono text-mute mt-0.5">${escapeHtml(formatDate(rev.approvedDate))}</div>
				</td>
				<td class="py-3 align-top">
					<div class="flex flex-wrap gap-1">${diffPills}</div>
				</td>
				<td class="py-3 align-top space-y-0.5">
					${trailHtml || '<span class="text-mute italic">-</span>'}
				</td>
				<td class="py-3 text-center align-top">
					<span class="badge badge-xs ${statusMeta.class} font-mono font-bold uppercase">${statusMeta.label}</span>
				</td>
				<td class="py-3 text-center align-top">
					<button type="button" data-rev-index="${rev._uid}"
						class="btn-view-diff btn btn-xs btn-primary gap-1">
						<span class="material-symbols-outlined text-[13px]">difference</span>
						<span>View Diff</span>
					</button>
				</td>
			</tr>
		`);
	});
}

function applyHistoryFilters() {
	const query = ($("#historySearchInput").val() || "").toString().toLowerCase().trim();
	const mode = ($("#historyModeFilter").val() || "").toString().toUpperCase();
	const status = ($("#historyStatusFilter").val() || "").toString();

	const filtered = allRevisions.filter((rev) => {
		const revMode = String(rev.mode || "").toUpperCase();
		const normalizedMode = revMode === "E" ? "U" : revMode;
		const matchMode = !mode || normalizedMode === mode;
		const matchStatus = !status || String(rev.status) === status;
		const haystack = JSON.stringify(rev).toLowerCase();
		const matchQuery = !query || haystack.includes(query);
		return matchMode && matchStatus && matchQuery;
	});

	renderHistoryTable(filtered);
}

function renderDiffDrawerContent(rev, changedOnly = true) {
	if (!rev) return;

	const modeKey = String(rev.mode || "U").toUpperCase();
	const modeMeta = MODE_META[modeKey] || MODE_META.U;
	const statusMeta = FORM_STATUS_META[rev.status] || FORM_STATUS_META[2];

	$("#diff-mode-badge")
		.attr("class", `badge badge-xs ${modeMeta.class} font-mono font-bold uppercase`)
		.text(modeMeta.label);
	$("#diff-status-badge")
		.attr("class", `badge badge-xs ${statusMeta.class} font-mono font-bold uppercase`)
		.text(statusMeta.label);
	$("#diff-rev-date").text(formatDate(rev.approvedDate));
	$("#diff-form-no").text(rev.formNo || "-");
	$("#diff-open-form-link").attr("href", rev.formUrl || "#");

	const prevSnap = rev.prevSnapshot || {};
	const currSnap = rev.currSnapshot || {};
	const $diffBody = $("#diff-table-body").empty();

	let renderedCount = 0;
	DIFF_FIELD_LABELS.forEach(([key, label]) => {
		const before = prevSnap[key] ?? "";
		const after = currSnap[key] ?? "";
		const isChanged = String(before).trim() !== String(after).trim();

		if (changedOnly && !isChanged) return;
		if (!changedOnly && !before && !after) return;

		renderedCount += 1;
		$diffBody.append(`
			<tr class="${isChanged ? "bg-warning/5" : ""}">
				<td class="font-bold text-primary py-2 align-top">${escapeHtml(label)}</td>
				<td class="font-mono py-2 align-top ${isChanged ? "bg-error/10 text-error line-through" : "text-mute"}">
					${escapeHtml(before || "-")}
				</td>
				<td class="font-mono py-2 align-top ${isChanged ? "bg-success/10 text-primary font-bold" : "text-secondary"}">
					${escapeHtml(after || "-")}
				</td>
			</tr>
		`);
	});

	if (!renderedCount) {
		$diffBody.append(`
			<tr>
				<td colspan="3" class="py-6 text-center text-mute italic">
					No field differences detected for this revision.
				</td>
			</tr>
		`);
	}

	const $apvBody = $("#diff-approval-body").empty();
	(rev.approvals || []).forEach((ap) => {
		$apvBody.append(`
			<tr>
				<td class="font-bold text-primary py-2">${escapeHtml(ap.role || "-")}</td>
				<td class="font-mono text-secondary py-2">${escapeHtml(ap.user || "-")}</td>
				<td class="py-2"><span class="badge badge-xs badge-success font-mono uppercase">${escapeHtml(ap.action || "Approved")}</span></td>
				<td class="text-right font-mono text-mute py-2">${escapeHtml(formatDate(ap.timestamp))}</td>
			</tr>
		`);
	});

	const groupType = (currSnap.VENDGROUPTYPE || currentVendor?.VENDGROUPTYPE || "Direct").toLowerCase();
	const ccGroup =
		groupType.includes("subcon")
			? "SC_Sect@MitsubishiElevatorAsia.co.th + Mgr."
			: groupType.includes("indirect")
				? "PADmember@MitsubishiElevatorAsia.co.th + Mgr."
				: modeKey === "A"
					? "Buyer In-charge + SPU Mgr."
					: "Buyer In-charge + SPU_BUYER@mitsubishielevatorasia.co.th + SPU Mgr.";

	$("#diff-email-details").html(`
		<div><strong class="text-primary">To (ACC):</strong> Accounting@MitsubishiElevatorAsia.co.th</div>
		<div><strong class="text-primary">CC (Group / Mode ${escapeHtml(modeKey)}):</strong> ${escapeHtml(ccGroup)}</div>
		<div><strong class="text-primary">Requester Notification:</strong> ${rev.evaNo ? `NVF / EVA Requester (${escapeHtml(rev.evaNo)})` : "Buyer In-charge"}</div>
	`);
}

function openDiffDrawer(rev) {
	activeDiffRev = rev;
	const changedOnly = $("#toggleChangedOnly").is(":checked");
	renderDiffDrawerContent(rev, changedOnly);
	$("#revisionDiffDrawer").removeClass("hidden");
}

function closeDiffDrawer() {
	$("#revisionDiffDrawer").addClass("hidden");
	activeDiffRev = null;
}

function exportCsv(filename, headers, rows) {
	const escapeCell = (val) => `"${String(val ?? "").replace(/"/g, '""')}"`;
	const lines = [
		headers.map(escapeCell).join(","),
		...rows.map((r) => r.map(escapeCell).join(",")),
	];
	const blob = new Blob(["\uFEFF" + lines.join("\n")], {
		type: "text/csv;charset=utf-8;",
	});
	const url = URL.createObjectURL(blob);
	const a = document.createElement("a");
	a.href = url;
	a.download = filename;
	document.body.appendChild(a);
	a.click();
	document.body.removeChild(a);
	URL.revokeObjectURL(url);
}

function renderVendorDetail(vendorData) {
	currentVendor = vendorData;
	const vndCode = vendorData.VND_CODE || vendorData.VND_ID || "-";
	const appEnv = $("#app-env").val() || "";

	// Update Cover Sheet action URLs with resolved Vendor Code
	$("#btn-request-update, #footer-btn-cover-update").attr(
		"href",
		`${appEnv}/Vendors/create?mode=U&code=${encodeURIComponent(vndCode)}`,
	);
	$("#btn-request-delete").attr(
		"href",
		`${appEnv}/Vendors/create?mode=D&code=${encodeURIComponent(vndCode)}`,
	);

	// Header & Badges
	updateVendorStatus(vendorData.VND_STATUS, vendorData.HOLD_VENDOR);
	setText("header-VND_CODE", vndCode);
	setText("header-VND_NAME", vendorData.VND_NAME);
	setText("header-VND_TNAME", vendorData.VND_TNAME);
	setText("header-TAXID", vendorData.VND_TAXNO || vendorData.TAXID);
	setText("header-CATEGORY", vendorData.VND_CATEGORY || vendorData.VENDCAT);

	const groupType = vendorData.VENDGROUPTYPE || vendorData.VND_TYPE1 || "-";
	setText("view-VENDGROUPTYPE_BADGE", groupType);
	setText("view-VENDGROUPTYPE", groupType);

	const v1099 = vendorData.V1099 || (String(vndCode).startsWith("1") || String(vndCode).startsWith("2") ? "Y (Oversea)" : "N (Domestic)");
	$("#view-V1099_BADGE").text(`1099: ${v1099}`);

	// KPI Ribbon
	setText("view-VND_CODE", vndCode);
	setText("kpi-vendor-currency", vendorData.VND_CURRENCY || vendorData.CURCODE || "-");
	setText("kpi-code-decode", decodeVendorCode(vndCode));
	setText("view-VND_REGNAME", vendorData.VND_REGNAME || vendorData.CREATE_BY);
	setText("view-VND_REGDATE", formatDate(vendorData.VND_REGDATE || vendorData.VND_REGISTED));
	setText("view-VND_LASTUPDATE", formatDate(vendorData.VND_LASTUPDATE || vendorData.UPDATE_AT));

	// Tab 1: Overview & Identity
	setText("view-VND_NAME", vendorData.VND_NAME);
	setText("view-VND_TNAME", vendorData.VND_TNAME);
	setText("view-VND_CATEGORY", vendorData.VND_CATEGORY || vendorData.VENDCAT);
	setText("view-VND_TAXNO", vendorData.VND_TAXNO || vendorData.TAXID);
	setText("view-VND_CANO", vendorData.VND_CANO || vendorData.CANO);
	setText("view-VND_BANO", vendorData.VND_BANO || vendorData.BANO);
	setText("view-LEGAL_STATUS", vendorData.LEGAL_STATUS);
	setText("view-CORPORATE_ID", vendorData.CORPORATE_ID);
	setText("view-CORPORATE_VENDOR", vendorData.CORPORATE_VENDOR);

	// Contact
	setText("view-VND_SALE", vendorData.VND_CONTACTNAME || vendorData.VND_SALE);
	setText("view-ADDR_PHONE", vendorData.VND_PHONE || vendorData.ADDR_PHONE);
	setText("view-VND_FAX", vendorData.VND_FAX || vendorData.FAX);

	const email = vendorData.EMAIL || vendorData.VND_EMAIL || "";
	const $email = $("#view-VND_EMAIL");
	if (email) {
		$email.attr("href", `mailto:${email}`).text(email);
	} else {
		$email.attr("href", "#").text("-");
	}

	const web = vendorData.ADDR_WEB || vendorData.WEBSITE || "";
	const $web = $("#view-ADDR_WEB");
	if (web) {
		const href = /^https?:\/\//i.test(web) ? web : `https://${web}`;
		$web.attr("href", href).text(web);
	} else {
		$web.attr("href", "#").text("-");
	}

	renderAddresses(vendorData);

	// Tab 2: Financial & AS400
	setText("view-CURCODE", vendorData.VND_CURRENCY || vendorData.CURCODE);
	setText("view-TERMCODE", vendorData.VND_TERM || vendorData.TERMCODE);
	setText("view-TRADE_CODE", vendorData.TRADE_CODE);
	setText("view-VTYPE", vendorData.VTYPE || vendorData.VND_TYPE2);
	setText("view-VPAYTO", vendorData.VPAYTO);
	setText("view-V1099", v1099);
	setText("view-HOLD_VENDOR", vendorData.HOLD_VENDOR || "N");
	setText("view-V1TIME", vendorData.V1TIME || "N");

	// Bank
	setText("view-BANKNAME", vendorData.BANKNAME);
	setText("view-BRANCH", vendorData.BRANCH);
	setText("view-ACCNUMBER", vendorData.ACCNUMBER);
	setText("view-BANKADDR", vendorData.BANKADDR);

	// Technical AP Params
	setText("view-COMPANY", vendorData.COMPANY || "1");
	setText("view-DAYS_TO_CLEAR", vendorData.DAYS_TO_CLEAR);
	setText("view-GL_ACCOUNT", vendorData.GL_ACCOUNT);
	setText("view-PRICE_INC_TAX", vendorData.PRICE_INC_TAX);
	setText("view-TAX_CODE", vendorData.TAX_CODE);
	setText("view-AP_TAX_ID", vendorData.AP_TAX_ID || vendorData.VND_TAXNO);
	setText("view-GEN_INV_NO", vendorData.GEN_INV_NO);
	setText("view-NEXT_INV_NO", vendorData.NEXT_INV_NO);
	setText("view-VNALPH", vendorData.VNALPH);
	setText("view-SSECURITY_CODE", vendorData.SSECURITY_CODE);
	setText("view-FISCAL_CODE", vendorData.FISCAL_CODE);
	setText("view-COMMI", vendorData.FIRM_COMMI || vendorData.MATERIAL_COMMI);

	renderVendorCodes(vendorData.VENDOR_CODES || [], vendorData);
	renderScmUsers(vendorData.PURVMM_SCMUSR || vendorData.VENDOR_SCMUSR || []);
	renderDocuments(vendorData.VENDOR_ATTFILE || vendorData.PUR_FILE || []);
}

function hydrateRevisions(revisions = [], vendorData = {}) {
	const list = revisions.length ? revisions : buildFallbackRevision(vendorData);
	allRevisions = list.map((rev, i) => ({ ...rev, _uid: i }));

	$("#badge-count-history").text(allRevisions.length);
	$("#kpi-revision-count").text(allRevisions.length);

	const latest = allRevisions[0];
	if (latest) {
		const modeKey = String(latest.mode || "A").toUpperCase();
		const modeMeta = MODE_META[modeKey] || MODE_META.U;
		$("#kpi-latest-mode")
			.attr("class", `badge badge-xs ${modeMeta.class} font-mono font-bold uppercase`)
			.text(`MODE: ${modeMeta.label}`);
	}

	// Check for In-Progress Cover Sheet Request (CST = 1)
	const pending = allRevisions.find((r) => String(r.status) === "1");
	if (pending) {
		$("#pending-form-no").text(pending.formNo || "-");
		$("#pending-form-mode").text(MODE_META[pending.mode]?.label || pending.mode || "UPDATE");
		$("#pending-form-step").text(pending.pendingStep || "PUR Manager");
		$("#pending-cover-banner").removeClass("hidden").addClass("flex");
		$("#btn-inspect-pending-form").data("rev-index", pending._uid);

		// Lock new cover requests while one is in-progress
		$("#btn-request-update, #btn-request-delete, #footer-btn-cover-update")
			.addClass("btn-disabled opacity-50 pointer-events-none")
			.attr("title", "A Cover Sheet request is already in progress for this vendor.");
	}

	applyHistoryFilters();
}

// Event Delegation: Tab Switching
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

// Event Delegation: History Filters
$(document).on("input change", "#historySearchInput, #historyModeFilter, #historyStatusFilter", () => {
	applyHistoryFilters();
});

$(document).on("click", "#historyFilterReset", () => {
	$("#historySearchInput").val("");
	$("#historyModeFilter").val("");
	$("#historyStatusFilter").val("");
	applyHistoryFilters();
});

// Event Delegation: Revision Diff Drawer
$(document).on("click", ".btn-view-diff, #btn-inspect-pending-form", function () {
	const uid = Number($(this).data("rev-index"));
	const rev = allRevisions.find((r) => r._uid === uid);
	if (rev) openDiffDrawer(rev);
});

$(document).on("change", "#toggleChangedOnly", function () {
	if (activeDiffRev) {
		renderDiffDrawerContent(activeDiffRev, $(this).is(":checked"));
	}
});

$(document).on("click", "#closeDiffDrawerBtn, #closeDiffDrawerFooterBtn, #diffDrawerBackdrop", () => {
	closeDiffDrawer();
});

$(document).on("keydown", (e) => {
	if (e.key === "Escape" && activeDiffRev) closeDiffDrawer();
});

// Event Delegation: Export Approved List Profile & Audit Log
$(document).on("click", "#btn-export-profile", () => {
	if (!currentVendor) return;
	const code = currentVendor.VND_CODE || currentVendor.VND_ID || "VENDOR";
	exportCsv(
		`Vendor_Approved_List_${code}.csv`,
		[
			"VENDOR CODE",
			"VENDOR NAME",
			"GROUP TYPE",
			"CATEGORY",
			"TAX ID / SWIFT",
			"CA NO.",
			"BA NO.",
			"CURRENCY",
			"TERMS CODE",
			"CONTACT",
			"TEL",
			"ADDRESS1",
			"ADDRESS2",
			"CITY",
			"STATE",
			"COUNTRY",
			"STATUS",
		],
		[
			[
				code,
				currentVendor.VND_NAME || "",
				currentVendor.VENDGROUPTYPE || currentVendor.VND_TYPE1 || "",
				currentVendor.VND_CATEGORY || "",
				currentVendor.VND_TAXNO || currentVendor.TAXID || "",
				currentVendor.VND_CANO || "",
				currentVendor.VND_BANO || "",
				currentVendor.VND_CURRENCY || currentVendor.CURCODE || "",
				currentVendor.VND_TERM || currentVendor.TERMCODE || "",
				currentVendor.VND_CONTACTNAME || currentVendor.VND_SALE || "",
				currentVendor.VND_PHONE || currentVendor.ADDR_PHONE || "",
				currentVendor.VND_ADDRESS1 || "",
				currentVendor.VND_ADDRESS2 || "",
				currentVendor.VND_CITY || "",
				currentVendor.VND_STATE || "",
				currentVendor.VND_COUNTRY || "",
				currentVendor.VND_STATUS ?? "",
			],
		],
	);
});

$(document).on("click", "#btn-export-history", () => {
	if (!allRevisions.length) return;
	const code = currentVendor?.VND_CODE || currentVendor?.VND_ID || "VENDOR";
	exportCsv(
		`Vendor_Audit_History_${code}.csv`,
		["REV", "MODE", "COVER FORM NO", "REF EVA", "STATUS", "APPROVED DATE", "CHANGED FIELDS"],
		allRevisions.map((r) => [
			r.revNo || "",
			r.mode || "",
			r.formNo || "",
			r.evaNo || "",
			FORM_STATUS_META[r.status]?.label || r.status || "",
			formatDate(r.approvedDate),
			computeChangedFields(r.prevSnapshot, r.currSnapshot)
				.map((d) => d.label)
				.join("; "),
		]),
	);
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

		const resolvedCode = vendorData.VND_CODE || vendorData.VND_ID;
		const [historyRes, evaRes] = await Promise.allSettled([
			getVendorHistory(resolvedCode),
			getVendorEvaluation(resolvedCode),
		]);

		const historyList =
			historyRes.status === "fulfilled"
				? Array.isArray(historyRes.value)
					? historyRes.value
					: historyRes.value?.data || []
				: vendorData.REVISIONS || [];
		hydrateRevisions(historyList, vendorData);

		const evaData =
			evaRes.status === "fulfilled"
				? evaRes.value?.data || evaRes.value
				: vendorData.EVALUATION || null;
		if (evaData) renderEvaluation(evaData);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error loading vendor details");
	} finally {
		await showLoader({ show: false });
	}
});
