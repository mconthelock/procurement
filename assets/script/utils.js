import {
	initAuthen,
	sessionTimeOut,
	clearAuth,
} from "@amec/webasset/authen";
import { getConfig } from "@amec/webasset/config";
import { decryptText } from "@amec/webasset/crypto";
import {
	getMenu,
	getGroup,
	displayEmpInfo,
} from "@amec/webasset/indexDB";
import {
	getCookie,
	setCookie,
	getTimeLeft,
} from "@amec/webasset/jsCookie";
import { initNavbar } from "@amec/webasset/navbar";
import { showbgLoader } from "@amec/webasset/preloader";
import {
	initSidebar,
	setSidebarMenu,
	expandMenu,
} from "@amec/webasset/sidebar";
import { root } from "@amec/webasset/utils";

const getAppOptions = () => {
	const pgmName = `<div class="space-y-space-xs max-w-3xl">
        <div class="flex items-center gap-1">
            <span class="px-1.5 py-0.5 bg-black text-[8px] uppercase font-bold">PUR-008P</span>
        </div>
        <h1 class="text-black font-head uppercase text-lg">Procurement</h1>
    </div>`;
	return {
		icon: `${process.env.APP_ENV}/assets/images/logo.svg`,
		iconLogo: `${process.env.APP_ENV}/assets/images/logo.svg`,
		programName: pgmName,
		sidebarClass: `bg-white! text-black! border border-base-300! size-xl text-gray-50 md:shadow-lg`,
	};
};

const initFromCache = async (opt) => {
	const { APP_NAME, APP_ID, TIMEOUT } = getConfig();
	const cookie = getCookie(APP_NAME);
	if (!cookie) {
		window.location.href = `${root}/form/authen/index/${APP_ID}`;
		return false;
	}

	setCookie(APP_NAME, cookie, TIMEOUT || 30);
	const indexedDBID = decryptText(cookie, APP_NAME);
	const [appid, empno] = indexedDBID.split("-");

	const [cachedMenu, cachedGroup] = await Promise.all([
		getMenu(indexedDBID),
		getGroup(indexedDBID),
	]);
	if (!cachedMenu?.data || !cachedGroup?.data) {
		return null;
	}

	const info = await displayEmpInfo(empno);
	if (!info) {
		return null;
	}

	const menu = cachedMenu.data;
	const group = cachedGroup.data;

	localStorage.setItem("amecUserLogin", empno);
	if ($("#user-login").length === 0) {
		$("body").prepend('<div id="user-login"></div>');
	}
	$("#user-login")
		.attr("empno", empno)
		.attr("empname", info.SNAME)
		.attr("appid", appid)
		.attr("groupcode", group.GROUP_CODE)
		.attr("program", indexedDBID);

	initNavbar(opt);
	initSidebar(opt);
	await setSidebarMenu(menu, info, opt.lang || "en");
	showbgLoader({ show: false });

	const pin = localStorage.getItem("pin");
	if (pin === undefined || pin === null) {
		expandMenu();
	}

	$(document)
		.off("click", "#delete-cookie")
		.on("click", "#delete-cookie", async function (e) {
			e.preventDefault();
			await clearAuth(indexedDBID);
		});

	$(document)
		.off("click", ".logout")
		.on("click", ".logout", async function (e) {
			e.preventDefault();
			await clearAuth(indexedDBID);
			localStorage.removeItem("amecUserLogin");
		});

	setInterval(async () => {
		const ck = await getCookie(APP_NAME);
		if (!ck) window.location.reload();
		const timeLeft = await getTimeLeft(APP_NAME);
		if (timeLeft > 0 && timeLeft <= 0.5 * 60 * 1000) {
			sessionTimeOut();
		}
	}, 1000 * 5);

	return true;
};

export const initApp = async () => {
	if (window.__APP_INIT_PROMISE__) {
		return window.__APP_INIT_PROMISE__;
	}

	window.__APP_INIT_PROMISE__ = (async () => {
		try {
			const opt = getAppOptions();
			const cached = await initFromCache(opt);
			if (cached === null) {
				await initAuthen(opt);
			}
		} catch (error) {
			console.error(error);
		}
	})();

	return window.__APP_INIT_PROMISE__;
};

export const tableOpt = {
	dom: `<"flex items-center mb-3"<"table-search flex flex-1 gap-5"f><"flex items-center table-option"l>><"bg-white border border-slate-300 rounded-2xl overflow-hidden"t><"flex mt-5 mb-3"<"table-info flex flex-col flex-1 gap-5"i><"table-page flex-none"p>>`,
	order: [[0, "asc"]],
	pageLength: 25,
	responsive: false,
	language: {
		info: "Showing _START_ to _END_ from _TOTAL_ records",
		infoEmpty: "",
		paginate: {
			previous: '<i class="fi fi-br-arrow-alt-circle-left"></i>',
			next: '<i class="fi fi-br-arrow-alt-circle-right"></i>',
			first: '<i class="fi fi-rs-angle-double-small-left"></i>',
			last: '<i class="fi fi-rs-angle-double-small-right"></i>',
		},
		search: "",
		searchPlaceholder: "Filter records...",
		loadingRecords: `<span class="loading loading-spinner loading-xl"></span>`,
		emptyTable: `<span class="text-[14px] text-gray-600 font-medium">Have no record found</span>`,
		zeroRecords: "ไม่พบข้อมูลที่ต้องการ",
		lengthMenu: "_MENU_",
		infoFiltered: "(กรองข้อมูลจากทั้งหมด _MAX_ รายการ)",
	},
	drawCallback: function (settings) {
		const api = this.api();
		const pagination = $(this).closest(".dt-container").find(".dt-paging");
		if (api.page.info().pages <= 1) {
			pagination.addClass("hidden");
		} else {
			pagination.removeClass("hidden");
		}
	},
	initComplete: function (settings, json) {
		$(this).closest(".tableArea").find(".table-loader").addClass("hidden");
		const container = $(this.api().table().container());
		return { container };
	},
};

export function tableFillSelect(selector, data, valueKey, labelKey) {
	const element = $(selector);
	element.find("option:not(:first)").remove();
	data.forEach((item) => {
		element.append(
			`<option value="${item[valueKey]}">${item[labelKey]}</option>`,
		);
	});
}

export function escapeHtml(value) {
	return String(value ?? "")
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&#039;");
}

export function escapeAttribute(value) {
	return escapeHtml(value);
}
