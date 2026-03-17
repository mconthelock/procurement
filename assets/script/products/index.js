import "@amec/webasset/css/dataTable.min.css";

import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { currentUser } from "@amec/webasset/api/amec";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { createTable } from "@amec/webasset/dataTable";
import { initApp, tableOpt } from "../utils.js";
import { getProducts, getTemplate, exportExcel } from "../service/index.js";
import { extractDataForExport } from "./excel-data.js";

const API_URL = `${process.env.MOCK_API}/products`;
var table;
$(document).ready(async () => {
	try {
		await showLoader();
		await initApp({ submenu: ".nav-products" });

		// ดึงข้อมูล Products
		const data = await getProducts();
		const options = await tableProductOption(data);

		// สร้าง Table ตามมาตรฐาน amec
		table = await createTable(options);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error initializing app");
	} finally {
		await showLoader({ show: false });
	}
});

async function tableProductOption(data) {
	const opt = { ...tableOpt };
	opt.data = data;
	opt.columns = [
		{
			title: "Product",
			data: "PROD_NAME",
			render: (data, type, row) => `
                <div class="flex items-center gap-3">
                    <div class="avatar">
                        <div class="mask mask-squircle w-10 h-10 bg-gray-100">
                            <img src="${row.IMAGES?.[0] || "https://placehold.co/100?text=No+Img"}" />
                        </div>
                    </div>
                    <div>
                        <div class="font-bold text-sm">${data}</div>
                        <div class="text-[10px] opacity-50">${row.PROD_CODE}</div>
                    </div>
                </div>`,
		},
		{
			data: "PROD_UNIT",
			title: "Unit",
			className: "text-center",
		},
		{
			data: "PRICE_HISTORY",
			title: "Active Price",
			className: "text-right",
			render: (history) => {
				const active = history?.find((p) => p.IS_ACTIVE);
				return active
					? `<span class="font-bold text-blue-600">${Number(active.PRICE).toLocaleString()}</span>`
					: '<span class="text-gray-400">N/A</span>';
			},
		},
		{
			data: "CATEGORY_ID",
			title: "CATEGORY_ID",
			className: "text-center",
		},
		{
			data: "PROD_STATUS",
			title: "Status",
			className: "text-center",
			render: (data) => {
				const statusMap = {
					0: `<div class="badge badge-warning badge-xs">Draft</div>`,
					1: `<div class="badge badge-success badge-xs">Active</div>`,
					2: `<div class="badge badge-error badge-xs">Inactive</div>`,
				};
				return statusMap[data] || "Unknown";
			},
		},
		{
			data: "id",
			title: "Actions",
			className: "text-center",
			orderable: false,
			render: (data) => {
				return `<a href="/procurement/products/detail/${data}" class="btn btn-sm btn-ghost btn-circle text-lg text-primary hover:text-xl"><i class="fi fi-rr-settings-sliders"></i></a>`;
			},
		},
	];

	// จัดการปุ่ม Export Excel ในส่วน initComplete
	const baseInitComplete = tableOpt.initComplete;
	opt.initComplete = async function (settings, json) {
		if (typeof baseInitComplete === "function") {
			baseInitComplete.call(this, settings, json);
		}

		const exportBtn = await createBtn({
			id: "export-products",
			title: "Export Excel",
			icon: "fi fi-rr-file-excel text-xl",
			className: "btn-neutral",
			tooltip: "Export Product List",
		});

		$(this.api().table().container())
			.find(".table-info")
			.append(`<div class="btn-container">${exportBtn}</div>`);
	};

	return opt;
}

$(document).on("click", "#export-products", async function () {
	try {
		await activatedBtnRow($(this), true);
		const data = table.data().toArray();
		const result = await extractDataForExport(data);
		console.log(result);
		const template = await getTemplate("export_products.xlsx");
		await exportExcel(result, template, {
			filename: "Products_List.xlsx",
		});
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error exporting data");
	} finally {
		await activatedBtnRow($(this), false);
	}
});

window.deleteProduct = async function (id) {
	if (confirm("Are you sure you want to delete this product?")) {
		try {
			await showLoader();
			await fetch(`${API_URL}/${id}`, { method: "DELETE" });
			initTable();
		} catch (error) {
			await showMessage("Delete failed");
		} finally {
			await showLoader({ show: false });
		}
	}
};
