import "@amec/webasset/css/dataTable.min.css";

import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { currentUser } from "@amec/webasset/api/amec";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { createTable } from "@amec/webasset/dataTable";
import { initApp, tableOpt } from "../utils.js";
import { getCategories, getTemplate, exportExcel } from "../service/index.js";
import { extractDataForExport } from "./excel-data.js";

const API_URL = `${process.env.MOCK_API}/categories`;
var table;

$(document).ready(async () => {
	try {
		await showLoader();
		await initApp({ submenu: ".nav-categories" });

		const rawData = await getCategories();

		const sortedData = transformToTreeArray(rawData);

		// กรณีข้อมูลมีปัญหา (เช่น Parent ID ผิด) ให้เอาข้อมูลที่เหลือที่ไม่ได้ถูกจัดกลุ่มมาต่อท้าย
		const sortedIds = new Set(sortedData.map((i) => i.CATEGORY_ID));
		const orphans = rawData.filter((i) => !sortedIds.has(i.CATEGORY_ID));
		const finalData = sortedData.concat(orphans);

		const options = await tableCategoryOption(finalData);
		table = await createTable(options, "#table");

		const permission = $("#USER_PERMISSION").val();
		applyPermission(permission);
	} catch (error) {
		console.error("Initialization Error:", error);
		await showMessage("Error: " + error.message, "error");
	} finally {
		await showLoader({ show: false });
	}
});
function transformToTreeArray(data, parentId = null, processedIds = new Set()) {
	let result = [];

	// กรองหาลูกของ Parent ปัจจุบัน
	// ตรวจสอบทั้ง null และค่าว่าง เพื่อความชัวร์
	const children = data.filter((item) => {
		const p = item.CATEGORY_PARENT;
		return parentId === null
			? p === null || p === "" || p === 0
			: p == parentId;
	});

	children.forEach((child) => {
		if (processedIds.has(child.CATEGORY_ID)) return;

		processedIds.add(child.CATEGORY_ID);
		result.push(child);

		// ค้นหาชั้นถัดไป
		const subChildren = transformToTreeArray(
			data,
			child.CATEGORY_ID,
			processedIds,
		);
		result = result.concat(subChildren);
	});

	return result;
}
async function tableCategoryOption(data) {
	const opt = { ...tableOpt };
	opt.data = data;
	opt.ordering = false; // สำคัญ: ปิดการเรียงลำดับของ DataTable เพื่อคงสภาพ Tree ไว้

	opt.columns = [
		{
			data: "CATEGORY_NAME",
			title: "Category Structure",
			render: (data, type, row) => {
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
                <a href="/procurement/categories/detail/${data}/${$("#USER_PERMISSION").val()}" class="btn btn-sm btn-ghost btn-circle text-primary hover:bg-primary/10">
                    <i class="fi fi-rr-settings-sliders"></i>
                </a>`,
		},
	];

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

function applyPermission(permission) {
	if (permission === "VIEWER") {
		// 1. สั่ง Disable Input, Select, Textarea ทั้งหมดในฟอร์ม

		$("#ADDBTN").hide();
	}
}
