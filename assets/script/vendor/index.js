import "@amec/webasset/css/dataTable.min.css";

import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { currentUser } from "@amec/webasset/api/amec";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { createTable } from "@amec/webasset/dataTable";
import { initApp, tableOpt } from "../utils.js";
import { getVendors, getTemplate, exportExcel } from "../service/index.js";
import { extractDataForExport } from "./excel-data.js";

var table;
$(document).ready(async () => {
	try {
		await showLoader();
		await initApp({ submenu: ".nav-vendors" });
		const data = await getVendors();
		const options = await tableVendorOption(data);
		table = await createTable(options);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error initializing app");
	} finally {
		await showLoader({ show: false });
	}
});

async function tableVendorOption(data) {
	const opt = { ...tableOpt };
	opt.data = data;
	opt.columns = [
		{ data: "VND_NAME", title: "Name" },
		{
			data: "VND_CITY",
			title: "Address",
			render: (data, type, row) => `${data}, ${row.VND_COUNTRY}`,
		},
		{
			data: "VND_STATUS",
			title: "Status",
			render: (data) => {
				const statusMap = {
					0: `<div class="badge badge-warning">Creating</div>`,
					1: `<div class="badge badge-success">Active</div>`,
					2: `<div class="badge badge-error">Inactive</div>`,
				};
				return statusMap[data] || "Unknown";
			},
		},
		{
			data: "VENDOR_CODES",
			title: "Code",
			render: (data) => {
				if (data.length === 0) return "-";
				return data.map((code) => code.CODE_NUM).join(", ");
			},
		},
		{
			data: "VND_ID",
			title: "Actions",
			className: "text-center",
			orderable: false,
			render: (data, type, row) => {
				return `<a href="/procurement/vendors/detail/${data}" class="btn btn-sm btn-ghost btn-circle text-lg text-primary hover:text-xl"><i class="fi fi-rr-settings-sliders"></i></a>`;
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
		// const template = await getTemplate("vendor_template.xlsx");
		// await exportExcel(result, template, {
		// 	filename: "Vendors List.xlsx",
		// 	rowstart: 3,
		// });
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error exporting data");
	} finally {
		await activatedBtnRow($(this), false);
	}
});
