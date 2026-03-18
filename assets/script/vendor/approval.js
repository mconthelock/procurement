import "@amec/webasset/css/dataTable.min.css";

import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { currentUser } from "@amec/webasset/api/amec";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { createTable } from "@amec/webasset/dataTable";
import { initApp, tableOpt } from "../utils.js";
import { getVendors, getTemplate, exportExcel } from "../service/index.js";
import { getVendorsApv } from "../service/approval.js";
import { extractDataForExport } from "./excel-data.js";

var table;
$(document).ready(async () => {
	try {
		await showLoader();
		await initApp({ submenu: ".nav-vendors" });
		const data = await getVendorsApv();
		const options = await tableVendorApvOption(data);
		table = await createTable(options);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error initializing app");
	} finally {
		await showLoader({ show: false });
	}
});

async function tableVendorApvOption(data) {
	const opt = { ...tableOpt };
	opt.data = data;
	opt.columns = [
		{ data: "FRM_NO", title: "Form No." },
		{ data: "FRM_VNDNAME", title: "Vendor Name" },
		{
			data: "FRM_REQNAME",
			title: "Requester",
		},
		{
			data: "FRM_REQDATE",
			title: "Request Date",
		},
		{
			data: "FRM_REQTIME",
			title: "Request Time",
		},
		{
			data: "FRM_STATUS",
			title: "Status",
			render: (data) => {
				const statusMap = {
					1: `<div class="badge badge-warning">Running</div>`,
					2: `<div class="badge badge-success">Approve</div>`,
					3: `<div class="badge badge-error">Reject</div>`,
				};
				return statusMap[data] || "Unknown";
			},
		},
		{
			data: "FRM_NO",
			title: "Actions",
			className: "text-center",
			orderable: false,
			render: (data, type, row) => {
				return `<a href="/procurement/vendors/form/${data}" class="btn btn-sm btn-ghost btn-circle text-lg text-primary hover:text-xl"><i class="fi fi-rr-settings-sliders"></i></a>`;
			},
		},
	];
	const baseInitComplete = tableOpt.initComplete;
	opt.initComplete = async function (settings, json) {
		if (typeof baseInitComplete === "function") {
			baseInitComplete.call(this, settings, json);
		}
		const exportExcel = await createBtn({
			id: "export-vendor",
			title: "Export Excel",
			icon: "fi fi-rr-file-excel text-xl",
			className: "btn-neutral",
			tooltip: "Export to Excel",
		});
		$(this.api().table().container())
			.find(".table-info")
			.append(`<div class="btn-container">${exportExcel}</div>`);
	};

	return opt;
}

$(document).on("click", "#export-vendor", async function () {
	try {
		await activatedBtnRow($(this), true);
		const data = table.data().toArray();
		const result = await extractDataForExport(data);
		console.log(result);
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
