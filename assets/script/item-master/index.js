import { showErrorMessage, showMessage } from "@amec/webasset/utils";
import { initApp } from "../utils";
import { tableItemMaster } from "./table";
import { getBuyer, getCountry } from "./data";
import select2 from "select2";
import { clearSelect2, setSelect2 } from "@amec/webasset/select2";
import { modalItemMaster } from "./modal";

select2();
$(async function () {
	try {
		await initApp();
		tableItemMaster.init();
		const buyers = await getBuyer();
		const country = await getCountry();
		modalItemMaster.init();
		await setSelect2({
			id: "#buyer",
			data: buyers.data.map((buyer) => ({
				id: buyer.K85M02,
				text: `${buyer.K85M04} ${buyer.K85M05} (${buyer.K85M02})`,
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
		const buyer = $("#buyer").val();
		const country = $("#country").val();
		const purcode = $("#purcode").val();
		const partname = $("#partname").val();
		const status = $("#status").val();
		const drawing = $("#drawing").val();

		if (!buyer && !country && !purcode && !partname && !status && !drawing) {
			showMessage("Please select at least one filter to search.", "warning");
			return;
		}
		const table = await tableItemMaster.get();

		table.column("ITEM:name").search(purcode || "", false, false);
		table.column("PARTNAME:name").search(partname || "", false, false);
		table.column("COUNTRY:name").search(country || "", false, false);
		table.column("BUYER:name").search(buyer || "", false, false);
		table.column("STATUS:name").search(status || "", false, false);
		table.column("DRAW_FORMULA:name").search(drawing || "", false, false);
		table.draw();
	} catch (error) {
		console.error("Search Error:", error);
		showErrorMessage(error.message);
	}
});

$(document).on("click", "#reset-filter", async function () {
	try {
		clearSelect2("#buyer");
		clearSelect2("#country");
		clearSelect2("#status");
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
