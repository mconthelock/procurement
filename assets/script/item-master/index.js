import { showErrorMessage, showMessage } from "@amec/webasset/utils";
import { initApp } from "../utils";
import { tableItemMaster } from "./table";
import { getPlanner, getCountry, getOriginBulkList } from "./data";
import select2 from "select2";
import { clearSelect2, setSelect2 } from "@amec/webasset/select2";
import { modalItemMaster } from "./modal";
import { defaultExcel, exportExcel } from "@amec/webasset/excel";
import { showLoader } from "@amec/webasset/preloader";

select2();
$(async function () {
	try {
		await initApp();
		tableItemMaster.init();
		const planners = await getPlanner();
		const country = await getCountry();
		modalItemMaster.init();
		await setSelect2({
			id: "#planner",
			data: planners.data.map((planner) => ({
				id: planner.K85M02,
				text: `${planner.K85M04} ${planner.K85M05} (${planner.K85M02})`,
			})),
		});
		await setSelect2({
			id: "#country",
			data: country.data.map((country) => ({
				id: country.COUNTRY,
				text: country.COUNTRY,
			})),
		});
		await setSelect2({
			id: "#type",
			data: [
				{ id: "1", text: "Bulk" },
				{ id: "2,3", text: "JOP" },
				{ id: "5", text: "N/A" },
				{ id: "A", text: "Stock" },
				{ id: "B,C", text: "Sub con Part" },
			],
		});
		await setSelect2({
			id: "#status",
			data: [
				{ id: "IM", text: "Active" },
				{ id: "IZ", text: "Inactive" },
			],
		});
		$("#form-filter").find("input, select, button").prop("disabled", false);
	} catch (error) {
		console.error("Initialization Error:", error);
		showErrorMessage(error.message);
	}
});

$(document).on("submit", "#form-filter", async function (e) {
	e.preventDefault();
	try {
		const planner = $("#planner").val();
		const country = $("#country").val();
		const purcode = $("#purcode").val();
		const partname = $("#partname").val();
		const status = $("#status").val();
		const drawing = $("#drawing").val();
		const type = $("#type").val();

		if (!planner && !country && !purcode && !partname && !status && !drawing && !type) {
			showMessage("Please select at least one filter to search.", "warning");
			return;
		}
		const table = await tableItemMaster.get();

		table.column("ITEM:name").search(purcode || "", false, false);
		table.column("PARTNAME:name").search(partname || "", false, false);
		table.column("COUNTRY:name").search(country || "", false, false);
		table.column("PLANNER_CODE:name").search(planner || "", false, false);
		table.column("STATUS:name").search(status || "", false, false);
		table.column("TYPE:name").search(type.includes(",") ? type.split(",") : [type] || "", false, false);
		table.column("DRAW_FORMULA:name").search(drawing || "", false, false);
		table.draw();
	} catch (error) {
		console.error("Search Error:", error);
		showErrorMessage(error.message);
	}
});

$(document).on("click", "#reset-filter", async function () {
	try {
		clearSelect2("#planner");
		clearSelect2("#country");
		clearSelect2("#status");
		clearSelect2("#type");
		$("#purcode").val("");
		$("#partname").val("");
		$("#drawing").val("");
		const table = tableItemMaster.get();
		table.columns().search("").draw();
	} catch (error) {
		console.error("Reset Filter Error:", error);
		showErrorMessage(error.message);
	}
});

$(document).on("click", "#origin-bulk-list", async function () {
	try {
		showLoader();
		const res = await getOriginBulkList();
		if (!res.status) {
			throw new Error(res.message);
		}
		const workboox = await defaultExcel({
			data: res.data,
			column: [
				{ key: "PLANNER", header: "Planner" },
				{ key: "BULK_CODE", header: "BULK Code" },
				{ key: "DRAWING", header: "DWG" },
				{ key: "PARTNAME", header: "Part Name" },
				{ key: "VENDOR", header: "Vendor" },
				{ key: "VENDOR_NAME", header: "Vendor Name" },
				{ key: "TRADING", header: "Trading" },
				{ key: "PROCESS", header: "Process" },
				{ key: "MANUFACTURER", header: "Manufacturer" },
				{ key: "COUNTRY", header: "Country of Origin" },
				{ key: "MFG_NAME", header: "Manufacturer Name" },
				{ key: "MFG_ADDRESS", header: "Manufacturer Address" },
			],
		});
		exportExcel(workboox, "Country_of_Origin_BULK_List.xlsx");
	} catch (error) {
		console.error("Origin Bulk List Error:", error);
		showErrorMessage(error.message);
	} finally {
		showLoader({ show: false });
	}
});
