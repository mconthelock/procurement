import "@amec/webasset/css/dataTable.min.css";

import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { currentUser } from "@amec/webasset/api/amec";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { createTable } from "@amec/webasset/dataTable";
import { initApp, tableOpt } from "../utils.js";
import {
	getProducts,
	getCategories,
	getVendors,
	saveProduct,
} from "../service/index.js";
let vendorList = []; // เก็บข้อมูล Vendor สำหรับใช้งานใน Dropdown
$(document).ready(async () => {
	try {
		await showLoader();

		// 1. ดึงข้อมูล Categories และสร้าง Dropdown ก่อน
		const [categories, vendors] = await Promise.all([
			getCategories(),
			getVendors(),
		]);
		vendorList = vendors;
		renderCategoryOptions(categories);

		await initApp({ submenu: ".nav-products" });
		const id = $("#prod_id_hidden").val();

		if (id) {
			// 2. ถ้ามี ID ให้โหลดข้อมูลสินค้าผ่าน Service
			const productData = await getProducts(id);
			loadData(productData);
		} else {
			// โหมดสร้างใหม่: เพิ่มแถวเริ่มต้น
			addImageRow();
			addAttributeRow();
			addPriceRow();
		}

		initSubmit();
	} catch (error) {
		console.error(error);
		await showMessage("Error loading page");
	} finally {
		await showLoader({ show: false });
	}
});

// --- LOAD DATA ---
async function loadData(data) {
	// Mapping General Info
	$("#PROD_CODE").val(data.PROD_CODE);
	$("#PROD_NAME").val(data.PROD_NAME);
	$("#PROD_DESCRIPTION").val(data.PROD_DESCRIPTION);
	$("#PROD_UNIT").val(data.PROD_UNIT);
	$("#PROD_STATUS").val(data.PROD_STATUS);
	$("#HAZARD").val(data.HAZARD || 0);
	$("#CATEGORY_ID").val(data.CATEGORY_ID || 1);

	// Mapping Arrays
	data.IMAGES?.forEach((url) => addImageRow(url));
	data.ATTRIBUTES?.forEach((a) => addAttributeRow(a.ATTR_NAME, a.ATTR_VALUE));
	data.PRICE_HISTORY?.forEach((p) => addPriceRow(p));
}

// --- UI ROW BUILDERS ---

window.addImageRow = (url = "") => {
	const id = `img_${Date.now()}_${Math.floor(Math.random() * 100)}`;
	const fileName = url ? url.split("/").pop() : ""; // ตัดเอาเฉพาะชื่อไฟล์มาโชว์

	const html = `
        <div class="p-3 border rounded-lg bg-gray-50 flex flex-col gap-2" id="${id}">
            <div class="flex gap-2 items-center">
                <input type="hidden" class="img-url" value="${url}">
                
                <input type="file" class="file-input file-input-bordered file-input-xs flex-1" 
                    onchange="handleFileUpload(this, '${id}')">
                
                <button type="button" class="btn btn-xs btn-error btn-square text-white" onclick="$('#${id}').remove()">×</button>
            </div>
            <div class="h-24 w-full bg-white rounded overflow-hidden flex justify-center border border-dashed preview-box">
                <img src="${url || "https://placehold.co/200x150?text=No+Preview"}" class="h-full object-contain p-1">
            </div>
            <p class="text-[10px] truncate text-gray-400 file-name-display">${fileName}</p>
        </div>`;
	$("#images_container").append(html);
};

window.addAttributeRow = (name = "", value = "") => {
	const html = `
        <div class="flex gap-2 attr-row bg-white p-2 rounded shadow-sm border">
            <input type="text" placeholder="Spec Name (e.g. Color)" class="input input-bordered input-sm flex-1 attr-name" value="${name}">
            <input type="text" placeholder="Value" class="input input-bordered input-sm flex-1 attr-value" value="${value}">
            <button type="button" class="btn btn-sm btn-ghost text-error" onclick="$(this).parent().remove()">✕</button>
        </div>`;
	$("#attributes_container").append(html);
};

window.addPriceRow = (data = {}) => {
	const rowId = `row_${Date.now()}_${Math.floor(Math.random() * 100)}`;
	const q = data.QUOTATION || {};

	// 1. กระจาย Vendor Codes ออกมาเป็นรายการย่อยๆ
	let allOptions = [];
	vendorList.forEach((v) => {
		v.VENDOR_CODES.forEach((code) => {
			allOptions.push({
				val: code.CODE_NUM, // ใช้รหัสคู่ค้าเป็น Value
				text: `(${code.CODE_NUM})|${v.VND_NAME}`, // แสดง "ชื่อบริษัท (รหัส)"
				fullData: v,
			});
		});
	});

	// 2. สร้าง HTML Options จากรายการที่กระจายแล้ว
	const vendorOptions = allOptions
		.map(
			(opt) =>
				`<option value="${opt.val}" ${data.VND_ID == opt.val ? "selected" : ""}>
            ${opt.text}
        </button>`,
		)
		.join("");

	const html = `
        <tr class="price-row border-b align-top bg-white hover:bg-gray-50" id="${rowId}">
            <td class="p-3">
                <div class="space-y-2">
                    <select class="select select-bordered select-sm w-full vnd-id font-bold">
                        <option value="">Select Vendor Code</option>
                        ${vendorOptions}
                    </select>
                    <select class="select select-bordered select-sm w-full is-active">
                        <option value="true" ${data.IS_ACTIVE ? "selected" : ""}>Active Price</option>
                        <option value="false" ${!data.IS_ACTIVE ? "selected" : ""}>History Only</option>
                    </select>
                </div>
            </td>
            <td class="p-3">
                <input type="number" step="0.01" class="input input-bordered input-sm w-full price-val text-blue-600 font-bold" value="${data.PRICE || ""}" placeholder="0.00">
            </td>
            <td class="p-3">
                <input type="date" class="input input-bordered input-sm w-full effective-date" value="${data.EFFECTIVE_DATE?.split("T")[0] || ""}">
            </td>
            <td class="p-3">
                <div class="bg-gray-100 p-3 rounded-lg grid grid-cols-2 gap-3 border text-xs">
                    <div class="col-span-1">
                        <label class="font-bold opacity-50">Quote No.</label>
                        <input type="text" class="input input-bordered input-xs w-full q-no" value="${q.QUOTATION_NO || ""}">
                    </div>
                    <div class="col-span-1">
                        <label class="font-bold opacity-50">Quote Date</label>
                        <input type="date" class="input input-bordered input-xs w-full q-date" value="${q.QUOTATION_DATE?.split("T")[0] || ""}">
                    </div>
                    <div class="col-span-2">
						<label class="text-[10px] uppercase font-bold opacity-50">Quotation File (PDF/Image)</label>
						<div class="flex flex-col gap-1">
							<input type="hidden" class="q-file" value="${q.QUOTATION_FILE || ""}">
							
							<input type="file" class="file-input file-input-bordered file-input-xs w-full" 
								onchange="handleQuoteFileUpload(this)">
							
							<span class="text-[10px] text-blue-600 font-medium current-file-name">
								${q.QUOTATION_FILE ? "Current: " + q.QUOTATION_FILE : "No file selected"}
							</span>
						</div>
					</div>
                    <div class="col-span-2">
                        <label class="font-bold opacity-50">Remark</label>
                        <textarea class="textarea textarea-bordered textarea-xs w-full q-remark" rows="1">${q.REMARK || ""}</textarea>
                    </div>
                </div>
            </td>
            <td class="p-3 text-center">
                <button type="button" class="btn btn-circle btn-ghost btn-xs text-error" onclick="$('#${rowId}').remove()">✕</button>
            </td>
        </tr>`;
	$("#price_history_container").append(html);
};

// --- SUBMIT LOGIC ---
function initSubmit() {
	$("#productForm").on("submit", async function (e) {
		e.preventDefault();

		// --- 1. VALIDATION LOGIC ---
		const errors = [];

		// ล้างสีขอบ Error เดิมออกก่อน
		$(".input, .select, .textarea").removeClass("border-error");

		// ตรวจสอบช่องข้อมูลพื้นฐาน
		if (!$("#PROD_CODE").val().trim()) {
			errors.push("Product Code is required");
			$("#PROD_CODE").addClass("border-error");
		}
		if (!$("#PROD_NAME").val().trim()) {
			errors.push("Product Name is required");
			$("#PROD_NAME").addClass("border-error");
		}
		if (!$("#CATEGORY_ID").val()) {
			errors.push("Please select a Category");
			$("#CATEGORY_ID").addClass("border-error");
		}

		// ตรวจสอบว่าต้องมีราคาอย่างน้อย 1 รายการและเลือก Vendor แล้ว
		const priceRows = $(".price-row");
		if (priceRows.length === 0) {
			errors.push("At least one Price History row is required");
		} else {
			priceRows.each(function (i, el) {
				if (!$(el).find(".vnd-id").val()) {
					errors.push(`Row ${i + 1}: Please select a Vendor`);
					$(el).find(".vnd-id").addClass("border-error");
				}
				if (
					!$(el).find(".price-val").val() ||
					$(el).find(".price-val").val() <= 0
				) {
					errors.push(`Row ${i + 1}: Price must be greater than 0`);
					$(el).find(".price-val").addClass("border-error");
				}
			});
		}

		// ถ้ามี Error ให้แจ้งเตือนและหยุดการทำงาน
		if (errors.length > 0) {
			// ใช้ showMessage แจ้ง Error ตัวแรก หรือรวมทั้งหมด
			await showMessage(errors.join("<br>"));
			return false;
		}

		try {
			await showLoader();
			const API_URL = `${process.env.MOCK_API}/products`; //http://localhost:3002/products
			const id = $("#prod_id_hidden").val();
			// alert(API_URL);

			const payload = {
				PROD_CODE: $("#PROD_CODE").val(),
				PROD_NAME: $("#PROD_NAME").val(),
				PROD_DESCRIPTION: $("#PROD_DESCRIPTION").val(),
				PROD_UNIT: $("#PROD_UNIT").val(),
				PROD_STATUS: parseInt($("#PROD_STATUS").val()),
				HAZARD: parseInt($("#HAZARD").val()),
				CATEGORY_ID: parseInt($("#CATEGORY_ID").val()),
				CREATED_AT: id ? undefined : new Date().toISOString(),
				UPDATED_AT: new Date().toISOString(),
				IMAGES: $(".img-url")
					.map((i, el) => $(el).val())
					.get()
					.filter((v) => v.trim() !== ""),
				ATTRIBUTES: $(".attr-row")
					.map((i, el) => ({
						ATTR_NAME: $(el).find(".attr-name").val(),
						ATTR_VALUE: $(el).find(".attr-value").val(),
					}))
					.get()
					.filter((v) => v.ATTR_NAME.trim() !== ""),
				PRICE_HISTORY: $(".price-row")
					.map((i, el) => ({
						VND_ID: $(el).find(".vnd-id").val(),
						PRICE: parseFloat($(el).find(".price-val").val()) || 0,
						EFFECTIVE_DATE: $(el).find(".effective-date").val()
							? new Date(
									$(el).find(".effective-date").val(),
								).toISOString()
							: new Date().toISOString(),
						IS_ACTIVE: $(el).find(".is-active").val() === "true",
						QUOTATION: {
							QUOTATION_NO: $(el).find(".q-no").val(),
							QUOTATION_DATE: $(el).find(".q-date").val()
								? new Date(
										$(el).find(".q-date").val(),
									).toISOString()
								: new Date().toISOString(),
							QUOTATION_FILE: $(el).find(".q-file").val(),
							REMARK: $(el).find(".q-remark").val(),
						},
					}))
					.get()
					.filter((v) => v.VND_ID),
			};

			const method = id ? "PUT" : "POST";
			const url = id ? `${API_URL}/${id}` : API_URL; //http://localhost:3002/products/0043
			// alert(url);
			const res = await fetch(url, {
				method: method,
				headers: { "Content-Type": "application/json" },
				body: JSON.stringify(payload),
			});

			if (res.ok) {
				await showMessage(
					id ? "Product updated!" : "Product added successfully!",
				);
				window.location.href = `${process.env.APP_ENV}/Products`;
			} else {
				throw new Error("Failed to save data");
			}
		} catch (error) {
			await showMessage(error.message);
		} finally {
			await showLoader({ show: false });
		}
	});
}

// สำหรับรูปภาพ (แสดง Preview ได้ด้วย)
window.handleFileUpload = function (input, containerId) {
	const file = input.files[0];
	if (file) {
		const fileName = file.name;
		const $container = $(`#${containerId}`);

		// 1. อัปเดตชื่อไฟล์เข้า Hidden input เพื่อรอส่ง JSON
		$container.find(".img-url").val(fileName);
		$container.find(".file-name-display").text(fileName);

		// 2. ทำ Preview (ถ้าเป็นรูปภาพ)
		const reader = new FileReader();
		reader.onload = function (e) {
			$container.find("img").attr("src", e.target.result);
		};
		reader.readAsDataURL(file);

		// หมายเหตุ: ในระบบจริง คุณต้องมีฟังก์ชันส่งไฟล์ขึ้น Server (Upload API)
		// แล้วเอา URL จริงมาใส่ใน .val() แทน
	}
};

// สำหรับไฟล์ใบเสนอราคา
window.handleQuoteFileUpload = function (input) {
	const file = input.files[0];
	if (file) {
		const fileName = file.name;
		const $parent = $(input).parent();

		// อัปเดตชื่อไฟล์เข้า Hidden input
		$parent.find(".q-file").val(fileName);
		$parent.find(".current-file-name").text("Selected: " + fileName);
	}
};

window.deleteProduct = async function (id) {
	// 1. ถามเพื่อความแน่ใจ
	if (confirm("Are you sure you want to delete this product?")) {
		try {
			await showLoader(); // แสดง Preloader ของ amec

			// 2. ส่งคำสั่งลบไปยัง API
			const response = await fetch(`${API_URL}/${id}`, {
				method: "DELETE",
			});

			if (response.ok) {
				await showMessage("Product deleted successfully");
				// 3. Refresh ข้อมูลในตารางใหม่
				initTable();
			} else {
				throw new Error("Failed to delete product");
			}
		} catch (error) {
			await showMessage(error.message);
		} finally {
			await showLoader({ show: false });
		}
	}
};

// ฟังก์ชันสร้าง Options ใน Select
function renderCategoryOptions(categories) {
	const $select = $("#CATEGORY_ID");
	$select.empty(); // ล้างค่าเดิม
	$select.append('<option value="">Select Category</option>');

	categories.forEach((cat) => {
		$select.append(
			`<option value="${cat.CATEGORY_ID}">${cat.CATEGORY_NAME}</option>`,
		);
	});
}
