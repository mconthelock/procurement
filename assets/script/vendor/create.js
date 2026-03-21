import "@amec/webasset/css/dataTable.min.css";

import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { currentUser } from "@amec/webasset/api/amec";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { createTable } from "@amec/webasset/dataTable";
import { initApp, tableOpt } from "../utils.js";
import { getPayments } from "../service/payment.js";
import { getCurrencies } from "../service/currency.js";
import { getAddressMST } from "../service/addressth.js";
import { getCountry } from "../service/country.js";

import { extractDataForExport } from "./excel-data.js";
import { get } from "jquery";
import { wrap } from "gsap";

var table;
let addressData = [];
let countrymst = [];
function getUniqueValues(dataArray, key) {
	return [...new Set(dataArray.map((item) => item[key]))];
}
$(document).ready(async () => {
	try {
		await showLoader();
		await initApp({ submenu: ".nav-vendors" });
		const payments = await getPayments();
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
		countrySelect.val("66");
		countrySelect.trigger("change");

		addressData = await getAddressMST();

		// ล็อก Dropdown อำเภอและตำบลไว้ก่อนตั้งแต่เริ่มต้น
		$(".city-select").prop("disabled", true);
		$(".subdistrict-select").prop("disabled", true);
		// ทำให้ช่อง Zipcode พิมพ์เองไม่ได้ (ป้องกันพิมพ์ผิด)
		$('input[name="EN_ADDR_ZIPCODE"]')
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
	} catch (error) {
		console.error(error);
		await showMessage(error.message || "Error initializing app");
	} finally {
		await showLoader({ show: false });
	}
});
const vendorContainer = $("#vendor-code-container");
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

// ==========================================================
// ฟีเจอร์ใหม่: ตรวจสอบการเปลี่ยนประเทศ (Country)
// ==========================================================
$(document).on("change", 'select[name="EN_ADDR_COUNTRY"]', function () {
	const countryCode = $(this).val();
	const wrapper = $(this).closest(".tab-content");
	const matchedCountry = countrymst.find((c) => c.code === countryCode);

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
			'<label class="label"><span class="label-text font-medium">State / Province</span></label><input type="text" name="EN_ADDR_STATE" class="input input-bordered w-full" placeholder="Enter State/Province" />',
		);
		cityParent.html(
			'<label class="label"><span class="label-text font-medium">City / District</span></label><input type="text" name="EN_ADDR_CITY" class="input input-bordered w-full" placeholder="Enter City/District" />',
		);
		subdistrictParent.html(
			'<label class="label"><span class="label-text font-medium">Subdistrict</span></label><input type="text" name="EN_ADDR_SUBDISTRICT" class="input input-bordered w-full" placeholder="Enter Subdistrict" />',
		);
		zipcodeEN.prop("readonly", false).val("");
	} else {
		stateParent.html(
			'<label class="label"><span class="label-text font-medium">State / Province</span></label><select name="EN_ADDR_STATE" class="select select-bordered w-full bg-white state-select"><option value="" disabled selected>Select State / Province</option></select>',
		);
		cityParent.html(
			'<label class="label"><span class="label-text font-medium">City / District</span></label><select name="EN_ADDR_CITY" class="select select-bordered w-full bg-white city-select" disabled><option value="" disabled selected>Select City / District</option></select>',
		);
		subdistrictParent.html(
			'<label class="label"><span class="label-text font-medium">Subdistrict</span></label><select name="EN_ADDR_SUBDISTRICT" class="select select-bordered w-full bg-white subdistrict-select" disabled><option value="" disabled selected>Select Subdistrict</option></select>',
		);

		zipcodeEN.prop("readonly", true).val("");

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

document.addEventListener("DOMContentLoaded", function () {
	// ==============================================
	// สคริปต์การแนบไฟล์
	// ==============================================
	const fileContainer = document.getElementById("attachment-container");
	const btnAddFile = document.getElementById("btnAddFile");

	if (btnAddFile && fileContainer) {
		btnAddFile.addEventListener("click", function () {
			const row = document.createElement("div");
			row.className =
				"form-control w-full flex-row items-center gap-3 file-row mt-3";

			row.innerHTML = `
                        <input type="file" name="vendor_file[]" class="file-input file-input-bordered file-input-primary w-full max-w-md" />
                        <button type="button" class="btn btn-error btn-sm btn-square btn-remove-file">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    `;

			row.querySelector(".btn-remove-file").addEventListener(
				"click",
				function () {
					row.remove();
				},
			);

			fileContainer.appendChild(row);
			fileContainer.scrollTop = fileContainer.scrollHeight;
		});
	}
});
