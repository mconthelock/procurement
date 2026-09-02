import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { initApp } from "../utils.js";
// import $ from "jquery";
// import Chart from "chart.js/auto";
// window.$ = window.jQuery = $;
// import {
// 	getProducts,
// 	getCategories,
// 	getVendors,
// 	getCategoryAttributes,
// } from "../service/index.js";

let vendorList = [];
let originalProductData = null;

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
			originalProductData = productData;
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

		const permission = $("#USER_PERMISSION").val();
		applyPermission(permission);
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
	// $("#PROD_UNIT").val(data.PROD_UNIT);
	$("#PROD_STATUS").val(data.PROD_STATUS);
	$("#HAZARD").val(data.HAZARD || 0);
	$("#CATEGORY_ID").val(data.CATEGORY_ID);

	data.IMAGES?.forEach((url) => addImageRow(url));
	data.ATTRIBUTES?.forEach((a) => addAttributeRow(a.ATTR_NAME, a.ATTR_VALUE));

	// โหลดตารางราคา
	data.PRICE_HISTORY?.forEach((p) => addPriceRow(p));

	// วาดกราฟราคา
	if (data.PRICE_HISTORY) {
		renderPriceChart(data.PRICE_HISTORY);
	}
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

	// ค้นหาชื่อ Vendor จาก ID
	let vendorLabel = "Unknown Vendor";
	vendorList.forEach((v) => {
		v.VENDOR_CODES.forEach((code) => {
			if (code.CODE_NUM == data.VND_ID) {
				vendorLabel = `(${code.VND_ID}) ${v.VND_NAME}`;
			}
		});
	});

	// เตรียมปุ่ม Download File
	const downloadBtn = q.QUOTATION_FILE
		? `<a href="/uploads/quotations/${q.QUOTATION_FILE}" target="_blank" class="btn btn-xs btn-outline btn-info gap-1">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="box-arrow-in-down" />
             </svg> Download
           </a>`
		: `<span class="text-gray-400 italic">No file attached</span>`;

	const statusBadge = data.IS_ACTIVE
		? '<span class="badge badge-success badge-sm">Active</span>'
		: '<span class="badge badge-ghost badge-sm opacity-50">History</span>';

	const html = `
        <tr class="price-row border-b align-top bg-white hover:bg-gray-50" id="${rowId}">
            <td class="p-3">
                <div class="font-bold text-sm text-gray-700">${vendorLabel}</div>
                <div class="mt-1">${statusBadge}</div>
            </td>
            <td class="p-3">
                <div class="text-blue-600 font-bold text-lg">
                    ฿${(data.PRICE || 0).toLocaleString(undefined, { minimumFractionDigits: 2 })}
                </div>
            </td>
            <td class="p-3 text-sm">
                ${data.EFFECTIVE_DATE?.split("T")[0] || "-"}
            </td>
            <td class="p-3">
                <div class="bg-gray-50 p-3 rounded-lg border border-dashed flex justify-between items-center">
                    <div class="space-y-1">
                        <div class="text-[10px] uppercase font-bold opacity-50">Quote Details</div>
                        <div class="text-xs font-semibold">No: ${q.QUOTATION_NO || "-"}</div>
                        <div class="text-[10px] opacity-70">Date: ${q.QUOTATION_DATE?.split("T")[0] || "-"}</div>
                    </div>
                    <div class="text-right">
                        ${downloadBtn}
                    </div>
                </div>
            </td>
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
				// PRICE_HISTORY: $(".price-row")
				// 	.map((i, el) => ({
				// 		CODE_NUM: $(el).find(".vnd-id").val(),
				// 		PRICE: parseFloat($(el).find(".price-val").val()) || 0,
				// 		EFFECTIVE_DATE: new Date(
				// 			$(el).find(".effective-date").val() || new Date(),
				// 		).toISOString(),
				// 		IS_ACTIVE: $(el).find(".is-active").val() === "true",
				// 		QUOTATION: {
				// 			QUOTATION_NO: $(el).find(".q-no").val(),
				// 			QUOTATION_DATE: new Date(
				// 				$(el).find(".q-date").val() || new Date(),
				// 			).toISOString(),
				// 			QUOTATION_FILE: $(el).find(".q-file").val(),
				// 		},
				// 	}))
				// 	.get()
				// 	.filter((v) => v.CODE_NUM),
				PRICE_HISTORY:
					id && originalProductData
						? originalProductData.PRICE_HISTORY
						: [],
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

function applyPermission(permission) {
	if (permission === "VIEWER") {
		// ... (โค้ดเดิมของคุณ) ...

		// เพิ่มเติม: ปรับส่วนรูปภาพให้คลิกดูรูปใหญ่ได้แทนการเปลี่ยนรูป
		$("#images_container .file-input").hide();
		$("#images_container .preview-box img").each(function () {
			const url = $(this).attr("src");
			if (url && !url.includes("placehold.co")) {
				$(this).addClass(
					"cursor-pointer hover:opacity-80 transition-all",
				);
				$(this).wrap(`<a href="${url}" target="_blank"></a>`);
			}
		});
	}
}

// เพิ่มตัวแปร global สำหรับเก็บ instance ของ chart (กันการวาดทับ)
let priceChartInstance = null;

function renderPriceChart(priceHistory) {
	const ctx = document.getElementById("priceChart").getContext("2d");

	if (!priceHistory || priceHistory.length === 0) {
		// ถ้าไม่มีข้อมูล ให้แสดงข้อความแทน
		ctx.font = "14px Inter";
		ctx.fillStyle = "#999";
		ctx.textAlign = "center";
		ctx.fillText(
			"No price history available to display graph",
			ctx.canvas.width / 2,
			ctx.canvas.height / 2,
		);
		return;
	}

	// 1. เตรียมข้อมูล: เรียงลำดับตามวันที่ (เก่าไปใหม่)
	const sortedData = [...priceHistory].sort(
		(a, b) => new Date(a.EFFECTIVE_DATE) - new Date(b.EFFECTIVE_DATE),
	);

	// 2. จัดรูปแบบข้อมูลสำหรับ Labels (วันที่) และ Data (ราคา)
	const labels = sortedData.map((item) => item.EFFECTIVE_DATE.split("T")[0]);
	const prices = sortedData.map((item) => item.PRICE);

	// ดึงชื่อ Vendor มาทำ Tooltip (ถ้าต้องการแยกสีตาม Vendor ต้องเขียน Logic เพิ่ม)
	const vendors = sortedData.map((item) => {
		const v = vendorList.find((v) =>
			v.VENDOR_CODES.some((c) => c.CODE_NUM == item.VND_ID),
		);
		return v ? v.VND_NAME : "Unknown";
	});

	// 3. ทำลาย Chart เก่าทิ้งก่อนสร้างใหม่ (ถ้ามี)
	if (priceChartInstance) {
		priceChartInstance.destroy();
	}

	// 4. สร้าง Chart ใหม่
	priceChartInstance = new Chart(ctx, {
		type: "line",
		data: {
			labels: labels,
			datasets: [
				{
					label: "Unit Price (฿)",
					data: prices,
					borderColor: "#2563eb", // สีน้ำเงิน Primary
					backgroundColor: "rgba(37, 99, 235, 0.1)",
					borderWidth: 3,
					pointBackgroundColor: "#fff",
					pointBorderColor: "#2563eb",
					pointRadius: 5,
					pointHoverRadius: 8,
					fill: true,
					tension: 0.3, // ความโค้งของเส้น
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				tooltip: {
					callbacks: {
						afterLabel: function (context) {
							return `Vendor: ${vendors[context.dataIndex]}`;
						},
					},
				},
			},
			scales: {
				y: {
					beginAtZero: false,
					ticks: {
						callback: (value) => "฿" + value.toLocaleString(),
					},
				},
			},
		},
	});
}
