import "select2/dist/css/select2.min.css";
import "@amec/webasset/css/dataTable.min.css";
import "@amec/webasset/css/select2.min.css";
import select2 from "select2";
import * as dayjs from "dayjs";
import { showLoader } from "@amec/webasset/preloader";
import { setSelect2 } from "@amec/webasset/select2";
import { showMessage } from "@amec/webasset/utils";
import { currentUser } from "@amec/webasset/api/amec";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { createTable } from "@amec/webasset/dataTable";
import { initApp, tableOpt, tableFillSelect } from "../utils.js";
import { getVendors, getTemplate, exportExcel } from "../service/index.js";

import { extractDataForExport } from "./excel-data.js";

var table;
select2();
$(document).ready(async () => {
	try {
		await showLoader();
		await reloadTable();
		await bindEvents();
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error initializing app");
	} finally {
		await showLoader({ show: false });
	}
});

function bindEvents() {
	$("#table-search").on("input", function () {
		table.search($(this).val()).draw();
	});

	$("#table-country-filter").on("change", function () {
		table.column(3).search($(this).val()).draw();
	});

	$("#table-status-filter").on("change", function () {
		table.column(5).search($(this).val()).draw();
	});

	$("#reset-filter").on("click", function () {
		$("#table-search").val("");
		$("#table-country-filter").val("").trigger("change.select2");
		$("#table-status-filter").val("").trigger("change.select2");

		table.search("");
		table.columns().search("");
		table.page("first").draw("full-reset");
	});
}

async function populateFilters(data) {
	const statusOptions = [
		{ value: 1, text: "Active" },
		{ value: 2, text: "Inactive" },
	];
	await tableFillSelect(
		"#table-status-filter",
		statusOptions,
		"value",
		"text",
	);
	await setSelect2({
		element: $("#table-status-filter"),
		placeholder: "Filter by Status",
	});

	//Country filter
	const countryList = [
		...new Set(data.map((item) => item.VND_COUNTRY)),
	].filter((item) => item);
	const countryOptions = countryList.map((country) => ({
		value: country,
		text: country,
	}));
	await tableFillSelect(
		"#table-country-filter",
		countryOptions,
		"value",
		"text",
	);
	await setSelect2({
		element: $("#table-country-filter"),
		placeholder: "Filter by Country",
	});
}

async function reloadTable() {
	const data = await getVendors();
	const filteredData = data.filter((item) => item.VND_STATUS > 0);
	await populateFilters(filteredData);
	if (!table) {
		await createVendorsTable(filteredData);
	} else {
		table.clear();
		table.rows.add(filteredData);
		table.draw();
	}
}

async function createVendorsTable(data) {
	const opt = { ...tableOpt };
	opt.data = data;
	opt.columns = [
		{ data: "VND_CODE", title: "Code" },
		{ data: "VND_NAME", title: "Name" },
		{
			data: "VND_ADDRESS1",
			title: "Address",
			render: (data, type, row) => {
				const addressParts = [
					row.VND_ADDRESS1,
					row.VND_ADDRESS2,
					row.VND_CITY,
					row.VND_STATE,
				].filter(Boolean);
				return addressParts.join(", ");
			},
		},
		{ data: "VND_COUNTRY", title: "Country", className: "text-nowrap" },
		{
			data: "VND_REGISTED",
			title: "Registered",
			render: (data, type, row) => {
				if (type == "display") {
					return data ? dayjs(data).format("DD MMM YYYY") : "";
				}
				return data;
			},
		},
		{
			data: "VND_STATUS",
			title: "Status",
			render: (data, type) => {
				if (type == "display") {
					const statusMap = {
						0: `<div class="badge badge-warning">Creating</div>`,
						1: `<div class="badge badge-success">Active</div>`,
						2: `<div class="badge badge-error">Inactive</div>`,
					};
					return statusMap[data] || "Unknown";
				}
				return data;
			},
		},
		{
			data: "VND_CODE",
			title: "Actions",
			className: "text-center",
			orderable: false,
			render: (data, type, row) => {
				return `<a href="/procurement/vendors/detail/${data}" class="btn btn-sm btn-ghost btn-circle text-lg text-primary hover:text-xl"><i class="fi fi-rr-settings-sliders"></i></a>`;
			},
		},
	];

	opt.initComplete = async function (settings, json) {
		const { container } = tableOpt.initComplete.call(this, settings, json);
		$(".dt-search").addClass("hidden");
		$(".dt-length").addClass("hidden");
	};

	table = await createTable(opt);
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
