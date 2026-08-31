import { showErrorMessage } from "@amec/webasset/utils";
import { initApp } from "../utils";
import { tableItemMaster } from "./table";

$(async function () {
	try {
		await initApp();
		tableItemMaster.init();
	} catch (error) {
		console.error("Initialization Error:", error);
		showErrorMessage(error.message);
	}
});
