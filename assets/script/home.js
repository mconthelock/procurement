import { showbgLoader } from "@amec/webasset/preloader";
import { initApp } from "./utils.js";
$(async function () {
	try {
		await showbgLoader();
		await initApp({ submenu: ".navmenu-newinq" });
	} catch (error) {
		console.log(error);
	}
});
