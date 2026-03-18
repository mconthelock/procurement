import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { initApp } from "../utils.js";
import $ from "jquery";
window.$ = window.jQuery = $;
import {
	getProducts,
	getCategories,
	getVendors,
	getCategoryAttributes,
} from "../service/index.js";

let vendorList = [];

$(document).ready(async () => {
	try {
		await showLoader();
		const [categories, vendors] = await Promise.all([
			getCategories(),
			getVendors(),
		]);
		vendorList = vendors;
		renderCategoryOptions(categories);

		await initApp({ submenu: ".nav-products" });
		const id = $("#prod_id_hidden").val();

		if (id) {
			const productData = await getProducts(id);
			// โหลดสเปกของ Category ปัจจุบันรอไว้ก่อน loadData
			if (productData.CATEGORY_ID) {
				window.currentCategorySpecs = await getCategoryAttributes(
					productData.CATEGORY_ID,
				);
			}
			loadData(productData);
		} else {
			addPriceRow();
			addAttributeRow("Material", "");
		}

		initSubmit();
	} catch (error) {
		console.error(error);
		await showMessage("Error loading page", "error");
	} finally {
		await showLoader({ show: false });
	}
});

function loadData(data) {
	$("#PROD_CODE").val(data.PROD_CODE);
	$("#PROD_NAME").val(data.PROD_NAME);
	$("#PROD_DESCRIPTION").val(data.PROD_DESCRIPTION);
	$("#PROD_UNIT").val(data.PROD_UNIT);
	$("#PROD_STATUS").val(data.PROD_STATUS);
	$("#HAZARD").val(data.HAZARD || 0);
	$("#CATEGORY_ID").val(data.CATEGORY_ID);

	data.IMAGES?.forEach((url) => addImageRow(url));
	data.ATTRIBUTES?.forEach((a) => addAttributeRow(a.ATTR_NAME, a.ATTR_VALUE));
	data.PRICE_HISTORY?.forEach((p) => addPriceRow(p));
}

// ใน $(document).ready
$(document).on("change", "#CATEGORY_ID", async function () {
	const catId = $(this).val();
	try {
		await showLoader();
		window.currentCategorySpecs = await getCategoryAttributes(catId);
		// แจ้งเตือน user เล็กน้อยว่าสเปกเปลี่ยนแล้ว
		console.log("Updated Specs for Category:", window.currentCategorySpecs);
	} finally {
		await showLoader({ show: false });
	}
});
// async function updateAttributeOptions(catId) {
// 	// 1. ดึงรายการ Attributes จาก Category ที่เลือก
// 	const attributes = await getCategoryAttributes(catId);

// 	// 2. เก็บไว้ในตัวแปร Global เพื่อให้ function addAttributeRow เรียกใช้
// 	window.currentCategorySpecs = attributes;

// 	// 3. (Optional) ถ้าเป็นของใหม่ อาจจะสั่ง addAttributeRow เปล่าๆ ให้เลยตามจำนวนที่ Category บังคับ
// 	// $("#attributes_container").empty();
// 	// attributes.forEach(attrName => addAttributeRow(attrName, ""));
// }
// --- UI Builders ---

window.addImageRow = (url = "") => {
	const id = `img_${Date.now()}_${Math.floor(Math.random() * 100)}`;
	const fileName = url ? url.split("/").pop() : "";
	const html = `
        <div class="p-3 border rounded-lg bg-gray-50 flex flex-col gap-2" id="${id}">
            <div class="flex gap-2 items-center">
                <input type="hidden" class="img-url" value="${url}">
                <input type="file" class="file-input file-input-bordered file-input-xs flex-1" onchange="handleFileUpload(this, '${id}')">
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
	const id = `attr_${Date.now()}`;
	const specs = window.currentCategorySpecs || []; // ดึงมาจากที่โหลดไว้

	const options = specs
		.map(
			(s) =>
				`<option value="${s}" ${name === s ? "selected" : ""}>${s}</option>`,
		)
		.join("");

	const html = `
        <div class="flex gap-2 attr-row items-center bg-white p-2 rounded-lg border shadow-sm" id="${id}">
            <div class="flex-none w-48">
                <select class="select select-bordered select-xs w-full font-bold attr-name">
                    <option value="">-- Other Spec --</option>
                    ${options}
                    ${name && !specs.includes(name) ? `<option value="${name}" selected>${name}</option>` : ""}
                </select>
            </div>
            <div class="flex-1">
                <input type="text" class="input input-bordered input-xs w-full attr-value" value="${value}" placeholder="Value">
            </div>
            <button type="button" class="btn btn-ghost btn-xs text-error" onclick="$('#${id}').remove()">✕</button>
        </div>`;
	$("#attributes_container").append(html);
};

window.addPriceRow = (data = {}) => {
	const rowId = `row_${Date.now()}_${Math.floor(Math.random() * 100)}`;
	const q = data.QUOTATION || {};
	let allOptions = [];
	vendorList.forEach((v) => {
		v.VENDOR_CODES.forEach((code) => {
			allOptions.push({
				val: code.CODE_NUM,
				text: `(${code.CODE_NUM})|${v.VND_NAME}`,
			});
		});
	});
	const vendorOptions = allOptions
		.map(
			(opt) =>
				`<option value="${opt.val}" ${data.VND_ID == opt.val ? "selected" : ""}>${opt.text}</option>`,
		)
		.join("");

	const html = `
        <tr class="price-row border-b align-top bg-white hover:bg-gray-50" id="${rowId}">
            <td class="p-3">
                <div class="space-y-2">
                    <select class="select select-bordered select-sm w-full vnd-id font-bold">${vendorOptions}</select>
                    <select class="select select-bordered select-sm w-full is-active">
                        <option value="true" ${data.IS_ACTIVE ? "selected" : ""}>Active Price</option>
                        <option value="false" ${!data.IS_ACTIVE ? "selected" : ""}>History Only</option>
                    </select>
                </div>
            </td>
            <td class="p-3">
                <input type="number" step="0.01" class="input input-bordered input-sm w-full price-val text-blue-600 font-bold" value="${data.PRICE || ""}">
            </td>
            <td class="p-3">
                <input type="date" class="input input-bordered input-sm w-full effective-date" value="${data.EFFECTIVE_DATE?.split("T")[0] || ""}">
            </td>
            <td class="p-3">
                <div class="bg-gray-100 p-3 rounded-lg grid grid-cols-2 gap-3 border text-xs">
                    <div><label class="font-bold opacity-50">Quote No.</label><input type="text" class="input input-bordered input-xs w-full q-no" value="${q.QUOTATION_NO || ""}"></div>
                    <div><label class="font-bold opacity-50">Quote Date</label><input type="date" class="input input-bordered input-xs w-full q-date" value="${q.QUOTATION_DATE?.split("T")[0] || ""}"></div>
                    <div class="col-span-2">
                        <label class="font-bold opacity-50">File (PDF/Image)</label>
                        <input type="hidden" class="q-file" value="${q.QUOTATION_FILE || ""}">
                        <input type="file" class="file-input file-input-bordered file-input-xs w-full" onchange="handleQuoteFileUpload(this)">
                        <span class="text-[10px] text-blue-600 current-file-name">${q.QUOTATION_FILE || ""}</span>
                    </div>
                </div>
            </td>
            <td class="p-3 text-center"><button type="button" class="btn btn-ghost btn-xs text-error" onclick="$('#${rowId}').remove()">✕</button></td>
        </tr>`;
	$("#price_history_container").append(html);
};

// --- Submit & File Logic ---

function initSubmit() {
	$("#productForm").on("submit", async function (e) {
		e.preventDefault();
		const errors = [];
		$(".input, .select").removeClass("border-error");

		if (!$("#PROD_CODE").val().trim()) {
			errors.push("Code is required");
			$("#PROD_CODE").addClass("border-error");
		}
		if (!$("#PROD_NAME").val().trim()) {
			errors.push("Name is required");
			$("#PROD_NAME").addClass("border-error");
		}

		if (errors.length > 0) {
			await showMessage(errors.join("<br>"), "error");
			return;
		}

		try {
			await showLoader();
			const id = $("#prod_id_hidden").val();
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
					.filter((v) => v.trim()),
				ATTRIBUTES: $(".attr-row")
					.map((i, el) => ({
						ATTR_NAME: $(el).find(".attr-name").val(),
						ATTR_VALUE: $(el).find(".attr-value").val(),
					}))
					.get()
					.filter((v) => v.ATTR_NAME.trim()),
				PRICE_HISTORY: $(".price-row")
					.map((i, el) => ({
						VND_ID: $(el).find(".vnd-id").val(),
						PRICE: parseFloat($(el).find(".price-val").val()) || 0,
						EFFECTIVE_DATE: new Date(
							$(el).find(".effective-date").val() || new Date(),
						).toISOString(),
						IS_ACTIVE: $(el).find(".is-active").val() === "true",
						QUOTATION: {
							QUOTATION_NO: $(el).find(".q-no").val(),
							QUOTATION_DATE: new Date(
								$(el).find(".q-date").val() || new Date(),
							).toISOString(),
							QUOTATION_FILE: $(el).find(".q-file").val(),
						},
					}))
					.get()
					.filter((v) => v.VND_ID),
			};

			const res = await fetch(
				id
					? `${process.env.MOCK_API}/products/${id}`
					: `${process.env.MOCK_API}/products`,
				{
					method: id ? "PUT" : "POST",
					headers: { "Content-Type": "application/json" },
					body: JSON.stringify(payload),
				},
			);

			if (res.ok) {
				await showMessage(id ? "Updated!" : "Created!", "success");
				window.location.href = `${process.env.APP_ENV}/Products`;
			}
		} catch (e) {
			await showMessage(e.message);
		} finally {
			await showLoader({ show: false });
		}
	});
}

window.handleFileUpload = function (i, id) {
	const file = i.files[0];
	if (file) {
		$(`#${id} .img-url`).val(file.name);
		$(`#${id} .file-name-display`).text(file.name);
		const r = new FileReader();
		r.onload = (e) => $(`#${id} img`).attr("src", e.target.result);
		r.readAsDataURL(file);
	}
};

window.handleQuoteFileUpload = function (i) {
	const file = i.files[0];
	if (file) {
		$(i).siblings(".q-file").val(file.name);
		$(i).siblings(".current-file-name").text(file.name);
	}
};

function renderCategoryOptions(cats) {
	const s = $("#CATEGORY_ID");
	s.empty().append('<option value="">Select Category</option>');

	// เรียงลำดับ Level 1 ไว้บนสุด
	cats.sort((a, b) => a.CATEGORY_LEVEL - b.CATEGORY_LEVEL);

	cats.forEach((c) => {
		const indent = "— ".repeat((c.CATEGORY_LEVEL || 1) - 1);
		s.append(
			`<option value="${c.CATEGORY_ID}">${indent}${c.CATEGORY_NAME}</option>`,
		);
	});
}
