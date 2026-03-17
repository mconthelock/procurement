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

		const rawData = await getCategories();

		// --- 💡 ส่วนสำคัญ: จัดกลุ่มลำดับชั้นก่อนแสดงผล ---
		const sortedData = transformToTreeArray(rawData);

		const options = await tableCategoryOption(sortedData);
		table = await createTable(options, "#table");
	} catch (error) {
		console.error(error);
	} finally {
		await showLoader({ show: false });
	}
});
function transformToTreeArray(data, parentId = null) {
	let result = [];
	const children = data.filter((item) => item.CATEGORY_PARENT == parentId);

	children.forEach((child) => {
		result.push(child);
		const subChildren = transformToTreeArray(data, child.CATEGORY_ID);
		result = result.concat(subChildren);
	});
	return result;
}
async function tableCategoryOption(data) {
	console.log(data);
	const opt = { ...tableOpt };
	opt.data = data;
	opt.ordering = false; // ปิดการกด Sort ที่หัวตารางเพื่อไม่ให้ลำดับชั้นพัง

	opt.columns = [
		{
			data: "CATEGORY_NAME",
			title: "Category Structure",
			render: (data, type, row) => {
				// คำนวณการย่อหน้า (1 Level = 25px)
				const indent = (row.CATEGORY_LEVEL - 1) * 25;
				const isRoot = row.CATEGORY_LEVEL === 1;

				return `
                    <div style="padding-left: ${indent}px" class="flex items-center gap-2">
                        ${!isRoot ? '<i class="fi fi-rr-arrow-turn-down-right opacity-30 text-[10px]"></i>' : ""}
                        <div class="flex flex-col">
                            <span class="${isRoot ? "font-extrabold text-primary text-sm" : "text-neutral text-xs"}">
                                ${data}
                            </span>
                            ${isRoot ? '<span class="text-[9px] uppercase opacity-40 font-bold tracking-tighter">Root Category</span>' : ""}
                        </div>
                    </div>`;
			},
		},
		{
			data: "DESCRIPTION",
			title: "Description",
			render: (data) =>
				`<div class="text-[11px] opacity-70 truncate max-w-xs">${data || "-"}</div>`,
		},
		{
			data: "CATEGORY_OWNER",
			title: "Owner",
			className: "text-center",
			render: (data) =>
				`<span class="badge badge-ghost font-mono text-[10px]">${data}</span>`,
		},
		{
			data: "CATEGORY_STATUS",
			title: "Status",
			className: "text-center",
			render: (data) => {
				return data == 1
					? `<div class="badge badge-success badge-xs">Active</div>`
					: `<div class="badge badge-ghost badge-xs opacity-50">Inactive</div>`;
			},
		},
		{
			data: "id",
			title: "Actions",
			className: "text-center",
			render: (data) => `
                <a href="/procurement/categories/detail/${data}" class="btn btn-sm btn-ghost btn-circle text-primary">
                    <i class="fi fi-rr-settings-sliders"></i>
                </a>`,
		},
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
