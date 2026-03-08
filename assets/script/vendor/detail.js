import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { initApp } from "../utils.js";
$(document).ready(async () => {
	try {
		await showLoader();
		await initApp({ submenu: ".navmenu-newinq" });
		const mode = $("#vnd-id").val() != "" ? 2 : 1;
		await setButton(mode);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error initializing app");
	} finally {
		await showLoader({ show: false });
	}
});

async function setButton(mode = 2) {
	const createdBtn = await createBtn({
		id: "create-vnd",
		title: "Register Vendor",
	});
	const updateBtn = await createBtn({
		id: "update-vnd",
		title: "Update Vendor",
	});
	const backBtn = await createBtn({
		id: "goback",
		title: "Go Back",
		className: "btn-secondary",
		icon: "fi fi-ss-arrow-circle-left text-xl",
	});
	$(".btn-container").append(
		`${mode == 1 ? createdBtn : updateBtn}${backBtn}`,
	);
}
$(document).on("click", "#create-vnd", async function (e) {
	e.preventDefault();
	try {
		await activatedBtnRow($(this), true);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error updating vendor");
	} finally {
		//await activatedBtnRow($(this), false);
	}
});

$(document).on("click", "#update-vnd", async function (e) {
	e.preventDefault();
	try {
		await activatedBtnRow($(this), true);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error updating vendor");
	} finally {
		//await activatedBtnRow($(this), false);
	}
});
