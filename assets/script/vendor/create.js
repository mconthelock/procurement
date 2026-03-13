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

import { extractDataForExport } from "./excel-data.js";
import { get } from "jquery";

var table;
let addressData = [];
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
		addressData = await getAddressMST();

		// ล็อก Dropdown อำเภอและตำบลไว้ก่อนตั้งแต่เริ่มต้น
		$(".city-select").prop("disabled", true);
		$(".subdistrict-select").prop("disabled", true);
		// ทำให้ช่อง Zipcode พิมพ์เองไม่ได้ (ป้องกันพิมพ์ผิด)
		$('input[name="TH_ADDR_ZIPCODE"]')
			.prop("readonly", true)
			.addClass("bg-gray-100");

		// --- สเตปที่ 1: ใส่ข้อมูลจังหวัดลงใน Dropdown ที่มีคลาส .state-select ---
		const provinces = getUniqueValues(addressData, "province");
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
// --- สเตปที่ 2: เมื่อเลือกจังหวัด (ดึงจังหวัดภาษาอังกฤษ) ---
$(document).on("change", ".state-select", function () {
	const selectedProvince = $(this).val();

	// หา Wrapper ตัวใหญ่ที่ครอบทั้งฟอร์มไทยและอังกฤษ
	const $wrapper = $(this).closest("#tab-content-address");

	// ช่องฝั่งไทย
	const $selCity = $wrapper.find(".city-select");
	const $selSubdistrict = $wrapper.find(".subdistrict-select");
	const $txtZipcodeTH = $wrapper.find('input[name="TH_ADDR_ZIPCODE"]');

	// ช่องฝั่งอังกฤษ
	const $txtStateEN = $wrapper.find('input[name="EN_ADDR_STATE"]');
	const $txtCityEN = $wrapper.find('input[name="EN_ADDR_CITY"]');
	const $txtSubdistrictEN = $wrapper.find(
		'input[name="EN_ADDR_SUBDISTRICT"]',
	);
	const $txtZipcodeEN = $wrapper.find('input[name="EN_ADDR_ZIPCODE"]');

	// รีเซ็ตค่าฟิลด์ที่เกี่ยวข้องและปลดล็อกช่องอำเภอ (ไทย)
	$selCity
		.html('<option value="" disabled selected>เลือกอำเภอ/เขต</option>')
		.prop("disabled", false);
	$selSubdistrict
		.html('<option value="" disabled selected>เลือกตำบล/แขวง</option>')
		.prop("disabled", true);
	$txtZipcodeTH.val("");

	// เคลียร์ค่าฝั่งอังกฤษ (เผื่อผู้ใช้เปลี่ยนจังหวัด)
	$txtCityEN.val("");
	$txtSubdistrictEN.val("");
	$txtZipcodeEN.val("");

	// ดึงอำเภอทั้งหมดที่ตรงกับจังหวัด
	const filteredCities = addressData.filter(
		(item) => item.province === selectedProvince,
	);

	// Auto-fill: จังหวัดภาษาอังกฤษ (ดึงจาก Object แรกที่เจอในจังหวัดนี้ได้เลย)
	if (filteredCities.length > 0) {
		$txtStateEN.val(filteredCities[0].province_en);
	}

	// เอาอำเภอมาใส่ Dropdown ไทย (ไม่ให้ซ้ำกัน)
	const cities = getUniqueValues(filteredCities, "district");
	cities.forEach((city) => {
		$selCity.append(new Option(city, city));
	});
});

// --- สเตปที่ 3: เมื่อเลือกอำเภอ/เขต (ดึงอำเภอภาษาอังกฤษ) ---
$(document).on("change", ".city-select", function () {
	const $wrapper = $(this).closest("#tab-content-address");
	const selectedProvince = $wrapper.find(".state-select").val();
	const selectedCity = $(this).val();

	const $selSubdistrict = $wrapper.find(".subdistrict-select");
	const $txtZipcodeTH = $wrapper.find('input[name="TH_ADDR_ZIPCODE"]');
	const $txtCityEN = $wrapper.find('input[name="EN_ADDR_CITY"]');
	const $txtSubdistrictEN = $wrapper.find(
		'input[name="EN_ADDR_SUBDISTRICT"]',
	);
	const $txtZipcodeEN = $wrapper.find('input[name="EN_ADDR_ZIPCODE"]');

	// รีเซ็ตค่าและปลดล็อกช่องตำบล
	$selSubdistrict
		.html('<option value="" disabled selected>เลือกตำบล/แขวง</option>')
		.prop("disabled", false);
	$txtZipcodeTH.val("");
	$txtSubdistrictEN.val("");
	$txtZipcodeEN.val("");

	// กรองหาตำบลที่ตรงกับจังหวัดและอำเภอ
	const filteredSubdistricts = addressData.filter(
		(item) =>
			item.province === selectedProvince &&
			item.district === selectedCity,
	);

	// Auto-fill: อำเภอภาษาอังกฤษ
	if (filteredSubdistricts.length > 0) {
		$txtCityEN.val(filteredSubdistricts[0].district_en);
	}

	// เอาตำบลมาใส่ Dropdown ไทย
	const subdistricts = getUniqueValues(filteredSubdistricts, "sub_district");
	subdistricts.forEach((sub) => {
		$selSubdistrict.append(new Option(sub, sub));
	});
});

// --- สเตปที่ 4: เมื่อเลือกตำบล/แขวง (ดึงตำบล + รหัสไปรษณีย์) ---
$(document).on("change", ".subdistrict-select", function () {
	const $wrapper = $(this).closest("#tab-content-address");
	const selectedProvince = $wrapper.find(".state-select").val();
	const selectedCity = $wrapper.find(".city-select").val();
	const selectedSubdistrict = $(this).val();

	// หา Object ที่ข้อมูลตรงกันเป๊ะๆ ทั้ง 3 ระดับ
	const matchedAddress = addressData.find(
		(item) =>
			item.province === selectedProvince &&
			item.district === selectedCity &&
			item.sub_district === selectedSubdistrict,
	);

	// นำข้อมูลที่เหลือไปใส่ใน Input อัตโนมัติ (ทั้งไทยและอังกฤษ)
	if (matchedAddress) {
		$wrapper
			.find('input[name="TH_ADDR_ZIPCODE"]')
			.val(matchedAddress.zipcode);
		$wrapper
			.find('input[name="EN_ADDR_SUBDISTRICT"]')
			.val(matchedAddress.sub_district_en);
		$wrapper
			.find('input[name="EN_ADDR_ZIPCODE"]')
			.val(matchedAddress.zipcode);
	}
});
