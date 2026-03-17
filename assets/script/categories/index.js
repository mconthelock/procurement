import "@amec/webasset/css/dataTable.min.css";

import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { currentUser } from "@amec/webasset/api/amec";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { createTable } from "@amec/webasset/dataTable";
import { initApp, tableOpt } from "../utils.js";
import { getCategories, getTemplate, exportExcel } from "../service/index.js";
import { extractDataForExport } from "./excel-data.js"; // สร้างฟังก์ชันช่วย export แยกไฟล์

const API_URL = `${process.env.MOCK_API}/categories`;
var table;

$(document).ready(async () => {
	try {
		await showLoader();
		await initApp({ submenu: ".nav-categories" });

		// ดึงข้อมูล Categories
		const data = await getCategories();
		const options = await tableCategoryOption(data);
		// console.log(data);
		// console.log(options);

		// สร้าง Table ตามมาตรฐาน amec
		table = await createTable(options, "#table");
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error initializing app");
	} finally {
		await showLoader({ show: false });
	}
});

async function tableCategoryOption(data) {
	console.log(data);
	const opt = { ...tableOpt };
	opt.data = data;
	opt.columns = [
		// {
		// 	title: "Category Information",
		// 	data: "CATEGORY_NAME",
		// 	render: (data, type, row) => `
		//         <div class="flex items-center gap-3">
		//             <div class="avatar placeholder">
		//                 <div class="bg-neutral text-neutral-content rounded-full w-10">
		//                     <span class="text-xs">${data.charAt(0)}</span>
		//                 </div>
		//             </div>
		//             <div>
		//                 <div class="font-bold text-sm">${data}</div>
		//                 <div class="text-[10px] opacity-50">ID: ${row.CATEGORY_ID}</div>
		//             </div>
		//         </div>`,
		// },
		{
			data: "CATEGORY_NAME",
			title: "Category Name",
			render: (data) =>
				`<div class="max-w-xs truncate" title="${data}">${data || "-"}</div>`,
		},
		{
			data: "DESCRIPTION",
			title: "Description",
			render: (data) =>
				`<div class="max-w-xs truncate" title="${data}">${data || "-"}</div>`,
		},
		{
			data: "CATEGORY_OWNER",
			title: "Owner Dept.",
			// className: "text-center",
			render: (data) =>
				`<span class="badge badge-ghost badge-sm font-mono">${data}</span>`,
		},
		{
			data: "CATEGORY_STATUS",
			title: "Status",
			className: "text-center",
			render: (data) => {
				// แสดง Badge ตามสถานะ 1=Active, 0=Inactive
				return data == 1
					? `<div class="badge badge-success badge-outline gap-2 py-3 px-4">
                     <div class="h-2 w-2 rounded-full bg-success"></div> Active
                   </div>`
					: `<div class="badge badge-ghost opacity-50 gap-2 py-3 px-4">
                     <div class="h-2 w-2 rounded-full bg-gray-400"></div> Inactive
                   </div>`;
			},
		},
		{
			data: "id",
			title: "Actions",
			className: "text-center",
			orderable: false,
			render: (data) => {
				return `<a href="/procurement/categories/detail/${data}" class="btn btn-sm btn-ghost btn-circle text-lg text-primary hover:text-xl"><i class="fi fi-rr-settings-sliders"></i></a>`;
			},
		},
		// {
		// 	data: "id",
		// 	title: "Actions",
		// 	className: "text-center",
		// 	orderable: false,
		// 	render: (data) => {
		// 		return `
		//             <div class="flex justify-center gap-1">
		//                 <a href="/procurement/categories/detail/${data}" class="btn btn-sm btn-ghost btn-circle text-lg text-primary hover:bg-primary/10">
		//                     <i class="fi fi-rr-edit"></i>
		//                 </a>
		//                 <button type="button" onclick="deleteCategory('${data}')" class="btn btn-sm btn-ghost btn-circle text-lg text-error hover:bg-error/10">
		//                     <i class="fi fi-rr-trash"></i>
		//                 </button>
		//             </div>`;
		// 	},
		// },
	];

	// จัดการปุ่ม Export Excel ในส่วน initComplete
	const baseInitComplete = tableOpt.initComplete;
	opt.initComplete = async function (settings, json) {
		if (typeof baseInitComplete === "function") {
			baseInitComplete.call(this, settings, json);
		}

		const exportBtn = await createBtn({
			id: "export-categories",
			title: "Export Excel",
			icon: "fi fi-rr-file-excel text-xl",
			className: "btn-neutral",
			tooltip: "Export Category List",
		});

		$(this.api().table().container())
			.find(".table-info")
			.append(`<div class="btn-container">${exportBtn}</div>`);
	};

	return opt;
}

// --- Event Handlers ---

$(document).on("click", "#export-categories", async function () {
	try {
		await activatedBtnRow($(this), true);
		const data = table.data().toArray();
		const result = await extractDataForExport(data); // เรียกฟังก์ชันแปลงข้อมูล

		const template = await getTemplate("export_categories.xlsx");
		await exportExcel(result, template, {
			filename: "Categories_List.xlsx",
		});
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error exporting data");
	} finally {
		await activatedBtnRow($(this), false);
	}
});

window.deleteCategory = async function (id) {
	if (confirm("Are you sure you want to Deactivate this category?")) {
		try {
			await showLoader();

			// 1. ดึงข้อมูลเดิมมาก่อน (ถ้า API ต้องการข้อมูลครบชุดสำหรับ PUT)
			const currentRes = await fetch(`${API_URL}/${id}`);
			const currentData = await currentRes.json();

			// 2. เตรียมข้อมูลใหม่โดยเปลี่ยนสถานะเป็น 0 (Soft Delete)
			const payload = {
				...currentData,
				CATEGORY_STATUS: 0,
				UPDATED_AT: new Date().toISOString(),
			};

			// 3. ส่งคำสั่งอัปเดต
			const response = await fetch(`${API_URL}/${id}`, {
				method: "PUT",
				headers: { "Content-Type": "application/json" },
				body: JSON.stringify(payload),
			});

			if (response.ok) {
				await showMessage("Category has been deactivated.");
				window.location.reload();
			} else {
				throw new Error("Failed to deactivate category");
			}
		} catch (error) {
			await showMessage(error.message);
		} finally {
			await showLoader({ show: false });
		}
	}
};
