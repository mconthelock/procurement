import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { createBtn, activatedBtnRow } from "@amec/webasset/components/buttons";
import { initApp } from "../utils.js";
import { getVendors } from "../service/index.js";
import { log } from "three";
import { el } from "@faker-js/faker";
$(document).ready(async () => {
	try {
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
			setText("view-VND_CODE", vendorData.VND_ID);
			setText("view-VND_NAME", vendorData.VND_NAME);
			setText("view-VND_TNAME", vendorData.VND_TNAME);
			setText("view-VND_SALE", vendorData.VND_SALE);
			setText("view-ADDR_PHONE", vendorData.ADDR_PHONE);
			setText("view-ADDR_WEB", vendorData.ADDR_WEB);
			setText("view-ADDR_WEB", vendorData.ADDR_WEB);
			const addresses = vendorData.VENDOR_ADDRESS || [];
			const thAddress = addresses.find((addr) => addr.ADDR_TYPE === "T");
			const enAddress = addresses.find((addr) => addr.ADDR_TYPE === "E");
			if (thAddress) {
				setText("view-ADDR_TH_LINE1", thAddress.ADDR_LINE1);
				setText("view-ADDR_TH_LINE2", thAddress.ADDR_LINE2);
				setText("view-ADDR_TH_LINE3", thAddress.ADDR_LINE3);
				setText("view-ADDR_TH_CITY", thAddress.ADDR_CITY);
				setText("view-ADDR_TH_STATE", thAddress.ADDR_STATE);
				setText("view-ADDR_TH_ZIPCODE", thAddress.ADDR_ZIPCODE);
				setText("view-ADDR_TH_COUNTRY", thAddress.ADDR_COUNTRY);
			}
			if (enAddress) {
				setText("view-ADDR_EN_LINE1", enAddress.ADDR_LINE1);
				setText("view-ADDR_EN_LINE2", enAddress.ADDR_LINE2);
				setText("view-ADDR_EN_LINE3", enAddress.ADDR_LINE3);
				setText("view-ADDR_EN_CITY", enAddress.ADDR_CITY);
				setText("view-ADDR_EN_STATE", enAddress.ADDR_STATE);
				setText("view-ADDR_EN_ZIPCODE", enAddress.ADDR_ZIPCODE);
				setText("view-ADDR_EN_COUNTRY", enAddress.ADDR_COUNTRY);
			}

			const attContainer = $("#attachment-container");
			const files = vendorData.VENDOR_ATTFILE || [];
			attContainer.empty();

			if (files.length > 0) {
				files.forEach((file) => {
					const fileHtml = `
					<div class="flex items-center gap-2 text-sm">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
						</svg>
						
						<a href="/uploads/${file.UFILE_NAME}" target="_blank" class="text-blue-600 hover:underline cursor-pointer">
							${file.FILE_NAME}
						</a>
					</div>
				`;
					attContainer.append(fileHtml);
				});
			} else {
				attContainer.append(
					'<span class="text-gray-400 italic text-sm">No attachments available.</span>',
				);
			}
			const vendorContainer = $("#view-vendor-code-container");
			const vendors = vendorData.VENDOR_CODES || [];
			vendorContainer.empty();

			if (vendors.length > 0) {
				vendors.forEach((vendor) => {
					const htmlContent = `
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-gray-50 p-4 rounded-lg border border-gray-100 mb-4">
                <div class="form-control w-full md:col-span-3">
                    <label class="label"><span class="label-text font-medium text-gray-500">Code</span></label>
                    <div class="px-4 py-3 bg-white border border-gray-200 rounded-lg text-gray-800 font-semibold h-[3rem] flex items-center">${vendor.CODE_NUM || "-"}</div>
                </div>
                <div class="form-control w-full md:col-span-3">
                    <label class="label"><span class="label-text font-medium text-gray-500">Currency</span></label>
                    <div class="px-4 py-3 bg-white border border-gray-200 rounded-lg text-gray-800 h-[3rem] flex items-center">${vendor.CODE_CURRENCY || "-"}</div>
                </div>
                <div class="form-control w-full md:col-span-3">
                    <label class="label"><span class="label-text font-medium text-gray-500">Shipping Term</span></label>
                    <div class="px-4 py-3 bg-white border border-gray-200 rounded-lg text-gray-800 h-[3rem] flex items-center">${vendor.CODE_SHIP || "-"}</div>
                </div>
                <div class="form-control w-full md:col-span-3">
                    <label class="label"><span class="label-text font-medium text-gray-500">Payment Term</span></label>
                    <div class="px-4 py-3 bg-white border border-gray-200 rounded-lg text-gray-800 h-[3rem] flex items-center">${vendor.CODE_PAY || "-"}</div>
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

$(document).on("click", "#update-vnd", async function (e) {
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
