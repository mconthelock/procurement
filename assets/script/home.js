import { showbgLoader } from "@amec/webasset/preloader";
$(async function () {
	try {
		await window.appReady;
		await showbgLoader({ show: false });
	} catch (error) {
		console.log(error);
	}
});
