import "@flaticon/flaticon-uicons/css/all/all.css";
import dayjs from "dayjs";
import { initApp } from "./utils";

export const appReady = (window.appReady = initApp());
await appReady;
// $(async function () {
// 	try {
// 	} catch (error) {
// 		console.log(error);
// 		showMessage(error.message);
// 	}
// });

$(document).on("click", ".msg-close", function (e) {
	e.preventDefault();
	const alertBox = $(this).closest(".alert");
	alertBox.removeClass("opacity-100");
	alertBox.addClass("opacity-0");
	setTimeout(() => {
		alertBox.remove();
	}, 700);
});

$(document).on("click", ".mainmenu summary", function () {
	const m = $(".mainmenu").length;
	$(".mainmenu").map((i, el) => {
		$(el).find("details").removeAttr("open");
	});
});

$(document).on("click", "a.menu-name", async function (e) {
	e.preventDefault();
	const link = $(this).attr("href");
	if (link.includes("mar/inquiry/report")) {
		localStorage.removeItem("spinquiryquery");
	}
	startNavProgress();
	window.location.href = link;
});

$("#confirm_close").on("click", function () {
	$("#confirm_reason").val("");
});

$(document).on("focus", ".input-number", function (e) {
	this.select();
});

$(document).on("keyup", ".input-number", function (e) {
	let value = $(this).val();
	value = value.replace(/[^\d.-]/g, "");
	value = value.replace(/(?!^)-/g, "");
	const parts = value.split(".");
	if (parts.length > 2) value = parts[0] + "." + parts.slice(1).join("");
	$(this).val(value);
});

$(document).on("change", ".fdate", function (e) {
	if ($(this).hasClass("sdate-report")) {
		const row = $(this).closest(".fieldset");
		const edate = row.find(".edate-report").val();
		if (edate == "") {
			const newdate = dayjs($(this).val())
				.add(30, "days")
				.format("YYYY-MM-DD");
			row.find(".edate-report").val(newdate);
		}
	}
});

$(document).on("click", "#goback", async function (e) {
	e.preventDefault();
	window.history.back();
});

// Smooth Navigation UX: Top progress bar + sidebar collapse state sync
const startNavProgress = () => {
	const bar = document.getElementById("nav-progress-bar");
	if (!bar) return;
	bar.classList.remove("is-done");
	bar.classList.add("is-loading");
};

const resetNavProgress = () => {
	const bar = document.getElementById("nav-progress-bar");
	if (!bar) return;
	bar.classList.remove("is-loading", "is-done");
};

window.addEventListener("pageshow", resetNavProgress);

$(document).on("click", "a[href]", function (e) {
	if (
		e.isDefaultPrevented() ||
		e.metaKey ||
		e.ctrlKey ||
		e.shiftKey ||
		e.altKey ||
		e.which === 2
	) {
		return;
	}
	const href = $(this).attr("href");
	const target = $(this).attr("target");
	if (
		!href ||
		href.startsWith("#") ||
		href.startsWith("javascript:") ||
		href.startsWith("mailto:") ||
		href.startsWith("tel:") ||
		(target && target !== "_self") ||
		$(this).is("[download]")
	) {
		return;
	}
	try {
		const dest = new URL(href, window.location.href);
		if (dest.origin === window.location.origin && dest.href !== window.location.href) {
			startNavProgress();
		}
	} catch {
		// Ignore malformed URLs
	}
});

$(document).on("click", "#sidebarToggle", function () {
	setTimeout(() => {
		const isCollapsed = localStorage.getItem("pin") === "false";
		document.documentElement.classList.toggle("sidebar-collapsed", isCollapsed);
	}, 0);
});
