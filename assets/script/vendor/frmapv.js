import "@amec/webasset/css/dataTable.min.css";

import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { currentUser } from "@amec/webasset/api/amec";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { createTable } from "@amec/webasset/dataTable";
import { initApp, tableOpt } from "../utils.js";
import { getVendors, getTemplate, exportExcel } from "../service/index.js";
import { getVendorsApv } from "../service/approval.js";

var table;
const frmstatus = {
	1: { class: "text-gray-600", text: "Running" },
	2: { class: "text-green-600", text: "Approve" },
	3: { class: "text-red-600", text: "Reject" },
};
$(document).ready(async () => {
	try {
		await showLoader();
		await initApp({ submenu: ".nav-vendors" });
		const pathname = window.location.pathname;
		const frmId = pathname.split("/").pop();
		const allfrm = await getVendorsApv();
		const frmData = allfrm.find((frm) => frm.FRM_ID == frmId);
		if (frmData) {
			const setText = (elementId, text) => {
				// ใช้ .text() แทน .innerText
				$("#" + elementId).text(text ? text : "-");
			};
			setText("FRM_NO", frmData.FRM_NO);
			setText("FRM_REQNAME", frmData.FRM_REQNAME);
			setText("FRM_VNDNAME", frmData.FRM_VNDNAME);
			setText("modal-VND_NAME", frmData.FRM_VNDNAME);
			setText("FLOW_REQNAME", frmData.FRM_REQNAME);

			const status = $("#FRM_STATUS");
			status.removeClass("text-gray-500 text-green text-red");
			status
				.addClass(frmstatus[frmData.FRM_STATUS].class)
				.text(frmstatus[frmData.FRM_STATUS].text);

			$("#dimstapv").removeClass("hidden inline-flex");
			$("#dimstrej").removeClass("hidden inline-flex");
			$("#dimapvdate").removeClass("hidden");
			$("#dimapvtime").removeClass("hidden");
			if (frmData.FRM_STATUS == 1) {
				$("#dimstapv").addClass("hidden");
				$("#dimstrej").addClass("hidden");
				$("#dimapvdate").addClass("hidden");
				$("#dimapvtime").addClass("hidden");
			} else if (frmData.FRM_STATUS == 2) {
				$("#dimstrej").addClass("hidden");
				$("#dimstapv").addClass("inline-flex");
			} else if (frmData.FRM_STATUS == 3) {
				$("#dimstapv").addClass("hidden");
				$("#dimstrej").addClass("inline-flex");
			}
		}
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error initializing app");
	} finally {
		await showLoader({ show: false });
	}
});
