import "@amec/webasset/css/dataTable.min.css";

import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { currentUser } from "@amec/webasset/api/amec";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { createTable } from "@amec/webasset/dataTable";
import { initApp, tableOpt } from "../utils.js";
import { getProducts } from "../service/products.js";

const API_URL = `${process.env.MOCK_API}/products`;

$(document).ready(async () => {
	try {
		await showLoader();

		await initApp({ submenu: ".nav-products" });
		const id = $("#prod_id_hidden").val();

		if (id) {
			await loadData(id);
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
async function loadData(id) {
	const res = await fetch(`${API_URL}/${id}`);
	const data = await res.json();

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
	const html = `
        <div class="p-2 border rounded-lg bg-gray-50 flex flex-col gap-2" id="${id}">
            <div class="flex gap-1">
                <input type="text" class="input input-bordered input-xs flex-1 img-url" value="${url}" placeholder="Image URL">
                <button type="button" class="btn btn-xs btn-error btn-square text-white" onclick="$('#${id}').remove()">×</button>
            </div>
            <div class="h-24 w-full bg-white rounded overflow-hidden flex justify-center border border-dashed">
                <img src="${url || "https://placehold.co/200x150?text=No+Preview"}" class="h-full object-contain p-1" onerror="this.src='https://placehold.co/200x150?text=Invalid+URL'">
            </div>
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
	const html = `
        <tr class="price-row border-b align-top bg-white hover:bg-gray-50" id="${rowId}">
            <td class="p-3">
                <div class="space-y-2">
                    <input type="number" class="input input-bordered input-sm w-full vnd-id font-bold" value="${data.VND_ID || ""}" placeholder="Vendor ID">
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
                <div class="bg-gray-100 p-3 rounded-lg grid grid-cols-2 gap-3 border">
                    <div class="col-span-1">
                        <label class="text-[10px] uppercase font-bold opacity-50">Quote No.</label>
                        <input type="text" class="input input-bordered input-xs w-full q-no" value="${q.QUOTATION_NO || ""}">
                    </div>
                    <div class="col-span-1">
                        <label class="text-[10px] uppercase font-bold opacity-50">Quote Date</label>
                        <input type="date" class="input input-bordered input-xs w-full q-date" value="${q.QUOTATION_DATE?.split("T")[0] || ""}">
                    </div>
                    <div class="col-span-2">
                        <label class="text-[10px] uppercase font-bold opacity-50">File (Filename)</label>
                        <input type="text" class="input input-bordered input-xs w-full q-file" value="${q.QUOTATION_FILE || ""}" placeholder="e.g. quote_01.pdf">
                    </div>
                    <div class="col-span-2">
                        <label class="text-[10px] uppercase font-bold opacity-50">Remark</label>
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
						VND_ID: parseInt($(el).find(".vnd-id").val()),
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
			const url = id ? `${API_URL}/${id}` : API_URL;

			const res = await fetch(url, {
				method: method,
				headers: { "Content-Type": "application/json" },
				body: JSON.stringify(payload),
			});

			if (res.ok) {
				window.location.href = "../Products";
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
