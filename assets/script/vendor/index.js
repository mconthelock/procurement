import "@amec/webasset/css/dataTable.min.css";
import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { activatedBtnRow } from "@amec/webasset/components/buttons";
import {
	reloadTable,
	applyAllFilters,
	setActiveTab,
	resetAllFilters,
	exportApprovedList,
	exportVendorExcel,
} from "./index-table.js";

$(document).on("click", ".vendor-status-tab", function () {
	setActiveTab($(this));
});

$(document).on(
	"input change",
	"#vendorSearchInput, #vendorGroupFilter, #vendorCountryFilter, #vendorCurrencyFilter",
	() => {
		applyAllFilters();
	},
);

$(document).on("click", "#vendorFilterReset", () => {
	resetAllFilters();
});

$(document).on("click", "#btn-export-approved", async function () {
	try {
		await activatedBtnRow($(this), true);
		await exportApprovedList();
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error exporting Approved List");
	} finally {
		await activatedBtnRow($(this), false);
	}
});

$(document).on("click", "#export-vendor", async function () {
	try {
		await activatedBtnRow($(this), true);
		await exportVendorExcel();
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
