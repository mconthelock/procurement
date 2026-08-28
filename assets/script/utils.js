import { initAuthen } from "@amec/webasset/authen";
export const initApp = async () => {
	try {
		await initAuthen({
			icon: `${process.env.APP_ENV}/assets/images/preloader.gif`,
			iconLogo: `${process.env.APP_ENV}/assets/images/preloader.gif`,
			programName: "Procurement",
			sidebarClass: `size-xl text-gray-50 bg-primary md:h-[calc(100vh-2.5rem)]! md:rounded-3xl! md:py-5 md:shadow-lg`,
		});
	} catch (error) {
		console.error(error);
	}
	await new Promise((r) => setTimeout(r, 1000));
	return;
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
