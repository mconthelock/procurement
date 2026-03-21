import { showLoader } from "@amec/webasset/preloader";
import { showMessage, showConfirm } from "@amec/webasset/utils";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { initApp } from "../utils.js";
import { getVendors } from "../service/index.js";
import { getAddressMST } from "../service/addressth.js";
import { getPayments } from "../service/payment.js";
import { getCurrencies } from "../service/currency.js";
import { getCountry } from "../service/country.js";
import { log } from "three";
import { el } from "@faker-js/faker";

const statusBadges = {
	0: { class: "badge-warning", text: "Creating" },
	1: { class: "badge-success", text: "Active" },
	2: { class: "badge-error", text: "Inactive" },
};
let addressData = [];
let payments = await getPayments();
let vendorContainer = $("#edit-vendor-code-container");
let countrymst = [];
function getUniqueValues(dataArray, key) {
	return [...new Set(dataArray.map((item) => item[key]))];
}
$(document).ready(async () => {
	try {
		addressData = await getAddressMST();
		const $paymentSelects = $(".payment-select");
		payments.forEach((payment) => {
			const optionHTML = `<option value="${payment.term}">${payment.term}</option>`;
			$paymentSelects.append(optionHTML);
		});

		const currencies = await getCurrencies();
		const currencySelects = $(".currency-select");
		currencies.forEach((currency) => {
			const optionHTML = `<option value="${currency.curcode}">${currency.currency}</option>`;
			currencySelects.append(optionHTML);
		});

		countrymst = await getCountry();
		const countrySelect = $('select[name="EN_ADDR_COUNTRY"]');
		countrySelect.empty();

		countrymst.forEach((country) => {
			const optionHTML = `<option value="${country.code}">${country.name_en}</option>`;
			countrySelect.append(optionHTML);
		});

		// ล็อก Dropdown อำเภอและตำบลไว้ก่อนตั้งแต่เริ่มต้น
		$(".city-select").prop("disabled", true);
		$(".subdistrict-select").prop("disabled", true);
		// ทำให้ช่อง Zipcode พิมพ์เองไม่ได้ (ป้องกันพิมพ์ผิด)
		$('input[name="TH_ADDR_ZIPCODE"]')
			.prop("readonly", true)
			.addClass("bg-gray-100");

		// --- สเตปที่ 1: ใส่ข้อมูลจังหวัดลงใน Dropdown ที่มีคลาส .state-select ---
		const provinces = getUniqueValues(addressData, "province_en");
		$(".state-select").each(function () {
			const $thisProv = $(this);
			provinces.forEach((prov) => {
				$thisProv.append(new Option(prov, prov));
			});
		});
		const pathname = window.location.pathname;
		// แยกสตริงด้วยเครื่องหมาย / และดึงตัวสุดท้ายออกมา
		const vendorId = pathname.split("/").pop();

		const allVendors = await getVendors();

		// 3. ใช้คำสั่ง .find() เพื่อค้นหา object ที่มี id ตรงกับ vendorId
		// (ใช้เครื่องหมาย == เผื่อกรณีที่ MockAPI ส่ง id มาเป็นตัวเลข แต่ vendorId จาก URL เป็นตัวอักษร)
		const vendorData = allVendors.find(
			(vendor) => vendor.VND_ID == vendorId,
		);

		// 4. เช็คว่าหาเจอไหม
		if (vendorData) {
			const setText = (elementId, text) => {
				// ใช้ .text() แทน .innerText
				$("#" + elementId).text(text ? text : "-");
			};
			const setVal = (elementId, value) => {
				// ใช้ .val() และถ้าไม่มีข้อมูล ให้เป็นค่าว่าง ('') แทน
				$("#" + elementId).val(value ? value : "");
			};

			const setSelect = (elementName, value, text = null) => {
				// ถ้าไม่มีข้อมูลส่งมา ให้หยุดทำงานหรือปล่อยผ่านไปเลย
				if (!value) return;

				// อ้างอิง <select> จาก attribute name
				const selectEl = $(`select[name="${elementName}"]`);

				// ถ้าไม่ส่ง text มา ให้เอา value ไปแสดงเป็นข้อความแทน (เหมือนในโค้ดต้นฉบับของคุณ)
				const displayText = text !== null ? text : value;

				if (selectEl.length > 0) {
					// เช็คว่ามีตัวเลือกนี้อยู่แล้วหรือยัง
					if (
						selectEl.find(`option[value="${value}"]`).length === 0
					) {
						// ถ้าไม่มี ให้สร้าง option ใหม่ต่อท้าย
						selectEl.append(
							`<option value="${value}">${displayText}</option>`,
						);
					}
					// สั่งให้เลือกค่านี้
					selectEl.val(value);
				}
			};
			updateVendorStatus(vendorData.VND_STATUS);
			setText("view-VND_CODE", vendorData.VND_ID);
			setText("view-VND_NAME", vendorData.VND_NAME);
			setText("view-VND_TNAME", vendorData.VND_TNAME);
			setText("view-VND_SALE", vendorData.VND_SALE);
			setText("view-ADDR_PHONE", vendorData.ADDR_PHONE);
			setText("view-ADDR_WEB", vendorData.ADDR_WEB);
			setVal("input-VND_NAME", vendorData.VND_NAME);
			setVal("input-VND_TNAME", vendorData.VND_TNAME);
			setVal("input-VND_SALE", vendorData.VND_SALE);
			setVal("input-ADDR_PHONE", vendorData.ADDR_PHONE);
			setVal("input-ADDR_WEB", vendorData.ADDR_WEB);
			const addresses = vendorData.VENDOR_ADDRESS || [];
			const thAddress = addresses.find((addr) => addr.ADDR_TYPE === "T");
			const enAddress = addresses.find((addr) => addr.ADDR_TYPE === "E");
			if (thAddress) {
				setText("view-ADDR_TH_LINE1", thAddress.ADDR_LINE1);
				setVal("input-ADDR_TH_LINE1", thAddress.ADDR_LINE1);
				setText("view-ADDR_TH_LINE2", thAddress.ADDR_LINE2);
				setVal("input-ADDR_TH_LINE2", thAddress.ADDR_LINE2);
				setText("view-ADDR_TH_LINE3", thAddress.ADDR_LINE3);
				setVal("input-ADDR_TH_LINE3", thAddress.ADDR_LINE3);
				setText("view-ADDR_TH_SUBDISTRICT", thAddress.ADDR_SUBDISTRICT);
				setVal("input-ADDR_TH_SUBDISTRICT", thAddress.ADDR_SUBDISTRICT);
				setText("view-ADDR_TH_CITY", thAddress.ADDR_CITY);
				setVal("input-ADDR_TH_CITY", thAddress.ADDR_CITY);
				setText("view-ADDR_TH_STATE", thAddress.ADDR_STATE);
				setVal("input-ADDR_TH_STATE", thAddress.ADDR_STATE);
				setText("view-ADDR_TH_ZIPCODE", thAddress.ADDR_ZIPCODE);
				setVal("input-ADDR_TH_ZIPCODE", thAddress.ADDR_ZIPCODE);
				setText("view-ADDR_TH_COUNTRY", thAddress.ADDR_COUNTRY);
				setVal("input-ADDR_TH_COUNTRY", thAddress.ADDR_COUNTRY);
				setSelect("ADDR_TH_STATE", thAddress.ADDR_STATE);
				setSelect("ADDR_TH_CITY", thAddress.ADDR_CITY);
				setSelect("ADDR_TH_SUBDISTRICT", thAddress.ADDR_SUBDISTRICT);
				setSelect("ADDR_TH_COUNTRY", thAddress.ADDR_COUNTRY);
			}
			if (enAddress) {
				setText("view-ADDR_EN_LINE1", enAddress.ADDR_LINE1);
				setVal("input-ADDR_EN_LINE1", enAddress.ADDR_LINE1);
				setText("view-ADDR_EN_LINE2", enAddress.ADDR_LINE2);
				setVal("input-ADDR_EN_LINE2", enAddress.ADDR_LINE2);
				setText("view-ADDR_EN_LINE3", enAddress.ADDR_LINE3);
				setVal("input-ADDR_EN_LINE3", enAddress.ADDR_LINE3);
				setText("view-ADDR_EN_SUBDISTRICT", enAddress.ADDR_SUBDISTRICT);
				setVal("input-ADDR_EN_SUBDISTRICT", enAddress.ADDR_SUBDISTRICT);
				setText("view-ADDR_EN_CITY", enAddress.ADDR_CITY);
				setVal("input-ADDR_EN_CITY", enAddress.ADDR_CITY);
				setText("view-ADDR_EN_STATE", enAddress.ADDR_STATE);
				setVal("input-ADDR_EN_STATE", enAddress.ADDR_STATE);
				setText("view-ADDR_EN_ZIPCODE", enAddress.ADDR_ZIPCODE);
				setVal("input-ADDR_EN_ZIPCODE", enAddress.ADDR_ZIPCODE);
				setText("view-ADDR_EN_COUNTRY", enAddress.ADDR_COUNTRY);
				setVal("input-ADDR_EN_COUNTRY", enAddress.ADDR_COUNTRY);
				setSelect("ADDR_EN_COUNTRY", enAddress.ADDR_COUNTRY);
			}

			const existingContainer = $("#existing-files-container");
			existingContainer.empty();
			const files = vendorData.VENDOR_ATTFILE || [];
			//v_attContainer.empty();
			//e_attContainer.empty();

			if (files && files.length > 0) {
				files.forEach((file) => {
					const fileHtml = `
					<div class="flex items-center gap-2 text-sm mb-2" id="att-row-${file.FILE_ID}">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
						<a href="/uploads/${file.UFILE_NAME}" target="_blank" class="text-blue-600 hover:underline cursor-pointer">
							${file.FILE_NAME}
						</a>

						<button type="button" class="edit-mode hidden  btn btn-error btn-xs btn-square btn-remove-existing" data-fileid="${file.FILE_ID}">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
						</button>
					</div>`;
					existingContainer.append(fileHtml);
				});
			} else {
				existingContainer.append(
					'<span class="text-gray-400 italic text-sm">No attachments available.</span>',
				);
			}
			const vendorContainer = $("#view-vendor-code-container");
			const vendors = vendorData.VENDOR_CODES || [];
			vendorContainer.empty();

			if (vendors.length > 0) {
				vendors.forEach((vendor) => {
					let paymentOptionsHTML = "";
					if (typeof payments !== "undefined") {
						paymentOptionsHTML = payments
							.map((payment) => {
								// ถ้าค่า payment.term ตรงกับ vendor.CODE_PAY ให้ใส่คำว่า 'selected'
								const isSelected =
									payment.term === vendor.CODE_PAY
										? "selected"
										: "";
								return `<option value="${payment.term}" ${isSelected}>${payment.term}</option>`;
							})
							.join("");
					}
					const htmlContent = `
    <div class="vendor-code-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end mb-4">
        
        <div class="form-control w-full md:col-span-3">
            <label class="label"><span class="label-text font-medium text-gray-500">Code</span></label>
            <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                <p class="font-medium text-base px-1">${vendor.CODE_NUM || "-"}</p>
            </div>
        </div>

        <div class="form-control w-full md:col-span-3">
            <label class="label"><span class="label-text font-medium text-gray-500">Currency</span></label>
            <div class="min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                <p class="font-medium text-base px-1">${vendor.CODE_CURRENCY || "-"}</p>
            </div>
        </div>

        <div class="form-control w-full md:col-span-3">
            <label class="label"><span class="label-text font-medium text-gray-500">Payment Term</span></label>
            
            <div class="view-mode min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                <p class="font-medium text-base px-1">${vendor.CODE_PAY || "-"}</p>
            </div>
            
            <select name="CODE_PAY[]" class="edit-mode hidden select select-bordered w-full h-[3rem] bg-white payment-select" required>
                <option value="" disabled ${!vendor.CODE_PAY ? "selected" : ""}>Select Payment Term...</option>
                ${paymentOptionsHTML}
            </select>
        </div>

        <div class="form-control w-full md:col-span-3">
            <label class="label"><span class="label-text font-medium text-gray-500">Status</span></label>
            
            <div class="view-mode min-h-[3rem] px-4 py-2 bg-gray-50 border border-gray-100 rounded-lg flex items-center">
                <p class="font-medium text-base px-1">
                    ${
						vendor.CODE_STATUS == 1
							? '<span class="text-emerald-600 font-semibold">Active</span>'
							: vendor.CODE_STATUS == 0
								? '<span class="text-rose-500 font-semibold">Inactive</span>'
								: "-"
					}
                </p>
            </div>

            <select name="CODE_STATUS[]" class="edit-mode hidden select select-bordered w-full h-[3rem] bg-white font-semibold ${vendor.CODE_STATUS == 1 ? "text-emerald-600" : "text-rose-500"}">
                <option value="1" class="text-emerald-600" ${vendor.CODE_STATUS == 1 ? "selected" : ""}>Active</option>
                <option value="0" class="text-rose-500" ${vendor.CODE_STATUS == 0 ? "selected" : ""}>Inactive</option>
            </select>
        </div>
        
    </div>
`;
					vendorContainer.append(htmlContent);
				});
			} else {
				vendorContainer.append(
					'<span class="text-gray-400 italic text-sm">No vendor codes available.</span>',
				);
			}
			let boxBgClass = "bg-gray-50 border-gray-100";
			let textClass = "text-gray-800";

			// 3. เช็คสถานะเพื่อเปลี่ยนสี
			if (vendorData.VND_STATUS == 1) {
				// Active -> กล่องเขียวอ่อน ตัวหนังสือเขียวเข้ม
				boxBgClass = "bg-green-50 border-green-200";
				textClass = "text-green-700";
			} else if (vendorData.VND_STATUS == 2) {
				// Inactive -> กล่องแดงอ่อน ตัวหนังสือแดงเข้ม
				boxBgClass = "bg-red-50 border-red-200";
				textClass = "text-red-700";
			} else if (vendorData.VND_STATUS == 0) {
				// Creating -> กล่องเหลืองอ่อน ตัวหนังสือเหลืองเข้ม
				boxBgClass = "bg-yellow-50 border-yellow-200";
				textClass = "text-yellow-700";
			}

			// 4. สั่งเปลี่ยนสีที่กล่อง Vendor Code ด้วย jQuery
			$("#box-VND_CODE")
				.removeClass("bg-gray-50 border-gray-100") // ล้างสีเทาออก
				.addClass(boxBgClass); // ใส่สีตามสถานะ

			$("#view-VND_CODE")
				.removeClass("text-gray-800") // ล้างสีเทาของข้อความออก
				.addClass(textClass); // ใส่สีตามสถานะ
			const formatDate = (dateString) => {
				if (!dateString) return "-";
				const date = new Date(dateString);
				// เช็คว่าเป็นวันที่ที่ถูกต้องไหม
				if (isNaN(date.getTime())) return dateString;

				// รูปแบบ: DD/MM/YYYY HH:mm
				return (
					date.toLocaleDateString("en-GB") +
					" " +
					date.toLocaleTimeString("en-GB", {
						hour: "2-digit",
						minute: "2-digit",
					})
				);
			};

			// ใส่ข้อมูลลงในกล่อง System Information
			$("#view-VND_REGDATE").text(formatDate(vendorData.VND_REGDATE));
			$("#view-VND_LASTUPDATE").text(
				formatDate(vendorData.VND_LASTUPDATE),
			);
			$("#view-VND_REGNAME").text(vendorData.VND_REGNAME || "-");
		} else {
			console.warn(`ไม่มีข้อมูล Vendor ID: ${vendorId} อยู่ในระบบ`);
			alert("ไม่พบข้อมูลที่ต้องการแก้ไข");
		}
		await showLoader();
		await initApp({ submenu: ".navmenu-newinq" });
		const mode = $("#vnd-id").val() != "" ? 2 : 1;
		await setButton(mode);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error initializing app");
	} finally {
		await showLoader({ show: false });
	}
});

async function setButton(mode = 2) {
	const createdBtn = await createBtn({
		id: "create-vnd",
		title: "Register Vendor",
	});
	const updateBtn = await createBtn({
		id: "update-vnd",
		title: "Update Vendor",
	});
	const backBtn = await createBtn({
		id: "goback",
		title: "Go Back",
		className: "btn-secondary",
		icon: "fi fi-ss-arrow-circle-left text-xl",
	});
	$(".btn-container").append(
		`${mode == 1 ? createdBtn : updateBtn}${backBtn}`,
	);
}
$(document).on("click", "#create-vnd", async function (e) {
	e.preventDefault();
	try {
		await activatedBtnRow($(this), true);
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error updating vendor");
	} finally {
		//await activatedBtnRow($(this), false);
	}
});

// $(document).on("click", "#update-vnd", async function (e) {
// 	e.preventDefault();
// 	try {
// 		await activatedBtnRow($(this), true);
// 	} catch (error) {
// 		console.error(error);
// 		await showMessage(error.message || "Error updating vendor");
// 	} finally {
// 		//await activatedBtnRow($(this), false);
// 	}
// });

function updateVendorStatus(statusCode) {
	// ดึง HTML ออกมาตามตัวเลข ถ้าส่งเลขแปลกๆ มาให้ใส่ค่า Default เป็น Unknown
	const vndstatus = $("#view-VND_STATUS");
	vndstatus.removeClass(
		"badge-warning badge-success badge-error badge-ghost",
	);
	if (statusBadges[statusCode]) {
		// ถ้ามี: เติมคลาสสีใหม่เข้าไป และอัปเดตข้อความ
		vndstatus
			.addClass(statusBadges[statusCode].class)
			.text(statusBadges[statusCode].text);
	} else {
		// ถ้าไม่มี (เป็นค่าแปลกๆ): ให้เป็นสีเทา Unknown
		vndstatus.addClass("badge-ghost").text("Unknown");
	}
}

// สมมติว่านี่คือฟังก์ชันตอนสลับเป็นโหมดแก้ไข
function toggleEditMode(isEdit) {
	if (isEdit) {
		$(".view-mode").addClass("hidden");
		$(".edit-mode").removeClass("hidden");
	} else {
		$(".edit-mode").addClass("hidden");
		$(".view-mode").removeClass("hidden");
	}
}

$(document).on("click", "#update-vnd", async function (e) {
	e.preventDefault();
	toggleEditMode(true);
	const btnsave = await createBtn({
		id: "save-vnd",
		title: "Save",
	});
	const cansave = await createBtn({
		className: "bg-gray-200 hover:bg-gray-300 text-gray-700 border-none",
		id: "cancel-edit",
		title: "Cancel",
		icon: "fi fi-ss-cross text-sm", // <--- เปลี่ยนจาก text-xl เป็น text-sm ตรงนี้ครับ
	});
	$(".btn-container").empty();
	$(".btn-container").append(`${btnsave}${cansave}`);
});

$(document).on("click", "#cancel-edit", async function (e) {
	e.preventDefault();
	const isConfirmed = await showConfirm({
		title: "Confirm Cancellation?",
		message:
			"Are you sure you want to cancel? Any unsaved changes will be lost.",
		acceptText: "Yes, cancel",
		cancelText: "No, continue editing",
	});
	if (isConfirmed) {
		toggleEditMode(false); // เรียกใช้ฟังก์ชัน สั่งปิดโหมด Edit
		const updateBtn = await createBtn({
			id: "update-vnd",
			title: "Update Vendor",
		});
		const backBtn = await createBtn({
			id: "goback",
			title: "Go Back",
			className: "btn-secondary",
			icon: "fi fi-ss-arrow-circle-left text-xl",
		});
		$(".btn-container").empty();
		$(".btn-container").append(`${updateBtn}${backBtn}`);
	}
});

// ==========================================================
// ฟีเจอร์ใหม่: ตรวจสอบการเปลี่ยนประเทศ (Country)
// ==========================================================
$(document).on("change", 'select[name="EN_ADDR_COUNTRY"]', function () {
	const countryCode = $(this).val();
	const wrapper = $(this).closest(".tab-content");
	const matchedCountry = countrymst.find((c) => c.code === countryCode);

	// หา div ที่ครอบช่อง State, City, Subdistrict อยู่
	const stateParent = wrapper
		.find('[name="EN_ADDR_STATE"]')
		.closest(".form-control");
	const cityParent = wrapper
		.find('[name="EN_ADDR_CITY"]')
		.closest(".form-control");
	const subdistrictParent = wrapper
		.find('[name="EN_ADDR_SUBDISTRICT"]')
		.closest(".form-control");
	const zipcodeEN = wrapper.find('input[name="EN_ADDR_ZIPCODE"]');
	const countryTH = wrapper
		.find('input[name="TH_ADDR_COUNTRY"]')
		.val(matchedCountry.name_th);

	if (countryCode !== "66") {
		stateParent.html(
			'<label class="label"><span class="label-text font-medium">State / Province</span></label><input type="text" name="EN_ADDR_STATE" class="input input-bordered w-full"  />',
		);
		cityParent.html(
			'<label class="label"><span class="label-text font-medium">City / District</span></label><input type="text" name="EN_ADDR_CITY" class="input input-bordered w-full"  />',
		);
		subdistrictParent.html(
			'<label class="label"><span class="label-text font-medium">Subdistrict</span></label><input type="text" name="EN_ADDR_SUBDISTRICT" class="input input-bordered w-full"  />',
		);

		// ปลดล็อก Zipcode ให้พิมพ์เองได้
		zipcodeEN.prop("readonly", false).val("");
	} else {
		// ✅ ถ้ากลับมาเลือกประเทศไทย -> เปลี่ยน Input กลับเป็น Select เหมือนเดิม
		stateParent.html(
			'<label class="label"><span class="label-text font-medium">State / Province</span></label><select name="EN_ADDR_STATE" class="select select-bordered w-full bg-white state-select"><option value="" disabled selected>Select State / Province</option></select>',
		);
		cityParent.html(
			'<label class="label"><span class="label-text font-medium">City / District</span></label><select name="EN_ADDR_CITY" class="select select-bordered w-full bg-white city-select" disabled><option value="" disabled selected>Select City / District</option></select>',
		);
		subdistrictParent.html(
			'<label class="label"><span class="label-text font-medium">Subdistrict</span></label><select name="EN_ADDR_SUBDISTRICT" class="select select-bordered w-full bg-white subdistrict-select" disabled><option value="" disabled selected>Select Subdistrict</option></select>',
		);

		// ล็อก Zipcode ไว้รอ Auto-fill
		zipcodeEN.prop("readonly", true).val("");

		// เติมข้อมูลจังหวัดกลับเข้าไปใหม่
		const provinces = getUniqueValues(addressData, "province_en");
		const stateSelect = wrapper.find('select[name="EN_ADDR_STATE"]');
		provinces.forEach((prov) => {
			stateSelect.append(new Option(prov, prov));
		});
	}
});

// --- สเตปที่ 1: เลือก State/Province ---
$(document).on("change", 'select[name="EN_ADDR_STATE"]', function () {
	const selectedProvinceEN = $(this).val();
	const wrapper = $(this).closest(".tab-content");

	const selCityEN = wrapper.find('select[name="EN_ADDR_CITY"]');
	const selSubdistrictEN = wrapper.find('select[name="EN_ADDR_SUBDISTRICT"]');

	selCityEN
		.html(
			'<option value="" disabled selected>Select City / District</option>',
		)
		.prop("disabled", false);
	selSubdistrictEN
		.html('<option value="" disabled selected>Select Subdistrict</option>')
		.prop("disabled", true);
	wrapper.find('input[name="EN_ADDR_ZIPCODE"]').val("");

	const filteredCities = addressData.filter(
		(item) => item.province_en === selectedProvinceEN,
	);

	// 👉 AUTO-FILL: จังหวัดภาษาไทย
	if (filteredCities.length > 0) {
		wrapper
			.find('input[name="TH_ADDR_STATE"]')
			.val(filteredCities[0].province_th);
	}
	wrapper.find('input[name="TH_ADDR_CITY"]').val("");
	wrapper.find('input[name="TH_ADDR_SUBDISTRICT"]').val("");
	wrapper.find('input[name="TH_ADDR_ZIPCODE"]').val("");

	const citiesEN = getUniqueValues(filteredCities, "district_en");
	citiesEN.forEach((city) => {
		selCityEN.append(new Option(city, city));
	});
});

// --- สเตปที่ 2: เลือก City/District ---
$(document).on("change", 'select[name="EN_ADDR_CITY"]', function () {
	const wrapper = $(this).closest(".tab-content");
	const selectedProvinceEN = wrapper
		.find('select[name="EN_ADDR_STATE"]')
		.val();
	const selectedCityEN = $(this).val();

	const selSubdistrictEN = wrapper.find('select[name="EN_ADDR_SUBDISTRICT"]');
	selSubdistrictEN
		.html('<option value="" disabled selected>Select Subdistrict</option>')
		.prop("disabled", false);
	wrapper.find('input[name="EN_ADDR_ZIPCODE"]').val("");

	const filteredSubdistricts = addressData.filter(
		(item) =>
			item.province_en === selectedProvinceEN &&
			item.district_en === selectedCityEN,
	);

	// 👉 AUTO-FILL: อำเภอภาษาไทย
	if (filteredSubdistricts.length > 0) {
		wrapper
			.find('input[name="TH_ADDR_CITY"]')
			.val(filteredSubdistricts[0].district_th);
	}
	wrapper.find('input[name="TH_ADDR_SUBDISTRICT"]').val("");
	wrapper.find('input[name="TH_ADDR_ZIPCODE"]').val("");

	const subdistrictsEN = getUniqueValues(
		filteredSubdistricts,
		"sub_district_en",
	);
	subdistrictsEN.forEach((sub) => {
		selSubdistrictEN.append(new Option(sub, sub));
	});
});

// --- สเตปที่ 3: เลือก Subdistrict ---
$(document).on("change", 'select[name="EN_ADDR_SUBDISTRICT"]', function () {
	const wrapper = $(this).closest(".tab-content");
	const selectedProvinceEN = wrapper
		.find('select[name="EN_ADDR_STATE"]')
		.val();
	const selectedCityEN = wrapper.find('select[name="EN_ADDR_CITY"]').val();
	const selectedSubdistrictEN = $(this).val();

	const matchedAddress = addressData.find(
		(item) =>
			item.province_en === selectedProvinceEN &&
			item.district_en === selectedCityEN &&
			item.sub_district_en === selectedSubdistrictEN,
	);

	// 👉 AUTO-FILL: ตำบลภาษาไทย + Zipcode
	if (matchedAddress) {
		wrapper
			.find('input[name="EN_ADDR_ZIPCODE"]')
			.val(matchedAddress.zipcode);
		wrapper
			.find('input[name="TH_ADDR_SUBDISTRICT"]')
			.val(matchedAddress.sub_district_th);
		wrapper
			.find('input[name="TH_ADDR_ZIPCODE"]')
			.val(matchedAddress.zipcode);
	}
});

$(document).on("click", "#btnAddFile", function (e) {
	e.preventDefault();
	const $fileContainer = $("#edit-attachment-container");
	const rowHtml = `
        <div class="form-control w-full flex-row items-center gap-3 file-row mt-3">
            <input type="file" name="vendor_file[]" class="file-input file-input-bordered file-input-primary w-full max-w-md" />
            <button type="button" class="btn btn-error btn-sm btn-square btn-remove-file">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    `;
	$fileContainer.append(rowHtml);
	$fileContainer.scrollTop($fileContainer[0].scrollHeight);
});

$(document).on("click", ".btn-remove-file", function (e) {
	e.preventDefault();
	$(this).closest(".file-row").remove();
});

$("#btnAddVendorCode").on("click", function () {
	const newRow = vendorContainer.find(".vendor-code-row").first().clone();
	newRow.find('input[type="text"]').val("");
	newRow.find('select[name="CODE_CURRENCY[]"]').prop("selectedIndex", 0);
	newRow.find("select.payment-select").prop("selectedIndex", 0);
	vendorContainer.append(newRow);
});

vendorContainer.on("click", ".btn-remove-code", function () {
	if (vendorContainer.find(".vendor-code-row").length > 1) {
		$(this).closest(".vendor-code-row").remove();
	} else {
		alert(
			"Cannot remove the last vendor code. Please clear the inputs instead.",
		);
	}
});
