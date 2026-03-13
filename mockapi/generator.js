const fs = require("fs");
const path = require("path");
const { faker } = require("@faker-js/faker");

// Import Templates
const createVendor = require("./schemas/vendors");
const createVendorCode = require("./schemas/vendors_code");
const createPaymentMaster = require("./schemas/paymentterm");
const createCurrencyMaster = require("./schemas/currency");

function generateDB() {
	const db = {
		vendors: [],
		payments: createPaymentMaster(),
		currencies: createCurrencyMaster(),
		addressmst: [
			// กรุงเทพมหานคร
			{
				id: "1",
				province: "กรุงเทพมหานคร",
				province_en: "Bangkok",
				district: "เขตพระนคร",
				district_en: "Phra Nakhon",
				sub_district: "พระบรมมหาราชวัง",
				sub_district_en: "Phra Borom Maha Ratchawang",
				zipcode: "10200",
			},
			{
				id: "2",
				province: "กรุงเทพมหานคร",
				province_en: "Bangkok",
				district: "เขตพระนคร",
				district_en: "Phra Nakhon",
				sub_district: "วังบูรพาภิรมย์",
				sub_district_en: "Wang Burapha Phirom",
				zipcode: "10200",
			},
			{
				id: "3",
				province: "กรุงเทพมหานคร",
				province_en: "Bangkok",
				district: "เขตห้วยขวาง",
				district_en: "Huai Khwang",
				sub_district: "ห้วยขวาง",
				sub_district_en: "Huai Khwang",
				zipcode: "10310",
			},
			{
				id: "4",
				province: "กรุงเทพมหานคร",
				province_en: "Bangkok",
				district: "เขตห้วยขวาง",
				district_en: "Huai Khwang",
				sub_district: "สามเสนนอก",
				sub_district_en: "Sam Sen Nok",
				zipcode: "10310",
			},

			// ชลบุรี
			{
				id: "5",
				province: "ชลบุรี",
				province_en: "Chon Buri",
				district: "เมืองชลบุรี",
				district_en: "Mueang Chon Buri",
				sub_district: "ดอนหัวฬ่อ",
				sub_district_en: "Don Hua Lo",
				zipcode: "20000",
			},
			{
				id: "6",
				province: "ชลบุรี",
				province_en: "Chon Buri",
				district: "เมืองชลบุรี",
				district_en: "Mueang Chon Buri",
				sub_district: "แสนสุข",
				sub_district_en: "Saen Suk",
				zipcode: "20130",
			},
			{
				id: "7",
				province: "ชลบุรี",
				province_en: "Chon Buri",
				district: "ศรีราชา",
				district_en: "Si Racha",
				sub_district: "ศรีราชา",
				sub_district_en: "Si Racha",
				zipcode: "20110",
			},
			{
				id: "8",
				province: "ชลบุรี",
				province_en: "Chon Buri",
				district: "ศรีราชา",
				district_en: "Si Racha",
				sub_district: "ทุ่งสุขลา",
				sub_district_en: "Thung Sukhla",
				zipcode: "20230",
			},

			// เชียงใหม่
			{
				id: "9",
				province: "เชียงใหม่",
				province_en: "Chiang Mai",
				district: "เมืองเชียงใหม่",
				district_en: "Mueang Chiang Mai",
				sub_district: "พระสิงห์",
				sub_district_en: "Phra Sing",
				zipcode: "50200",
			},
			{
				id: "10",
				province: "เชียงใหม่",
				province_en: "Chiang Mai",
				district: "เมืองเชียงใหม่",
				district_en: "Mueang Chiang Mai",
				sub_district: "สุเทพ",
				sub_district_en: "Su Thep",
				zipcode: "50200",
			},
			{
				id: "11",
				province: "เชียงใหม่",
				province_en: "Chiang Mai",
				district: "หางดง",
				district_en: "Hang Dong",
				sub_district: "หางดง",
				sub_district_en: "Hang Dong",
				zipcode: "50230",
			},
			{
				id: "12",
				province: "เชียงใหม่",
				province_en: "Chiang Mai",
				district: "หางดง",
				district_en: "Hang Dong",
				sub_district: "หนองควาย",
				sub_district_en: "Nong Kwai",
				zipcode: "50230",
			},

			// ภูเก็ต
			{
				id: "13",
				province: "ภูเก็ต",
				province_en: "Phuket",
				district: "เมืองภูเก็ต",
				district_en: "Mueang Phuket",
				sub_district: "ตลาดใหญ่",
				sub_district_en: "Talat Yai",
				zipcode: "83000",
			},
			{
				id: "14",
				province: "ภูเก็ต",
				province_en: "Phuket",
				district: "เมืองภูเก็ต",
				district_en: "Mueang Phuket",
				sub_district: "รัษฎา",
				sub_district_en: "Ratsada",
				zipcode: "83000",
			},
			{
				id: "15",
				province: "ภูเก็ต",
				province_en: "Phuket",
				district: "กะทู้",
				district_en: "Kathu",
				sub_district: "ป่าตอง",
				sub_district_en: "Pa Tong",
				zipcode: "83150",
			},
		],
	};

	//Create Vendor data
	const usedCodes = new Set();
	let codeIdCounter = 1;
	for (let i = 1; i <= 1250; i++) {
		const vendor = createVendor(i);
		const codeCount = faker.number.int({ min: 1, max: 3 });

		for (let j = 0; j < codeCount; j++) {
			let uniqueCode;
			do {
				uniqueCode = faker.number
					.int({ min: 10000, max: 99999 })
					.toString();
			} while (usedCodes.has(uniqueCode));
			usedCodes.add(uniqueCode);

			const newCode = createVendorCode(vendor.VND_ID, uniqueCode);
			vendor.VENDOR_CODES.push(newCode);
		}
		db.vendors.push(vendor);
	}
	return db;
}

// สั่งเขียนไฟล์
const targetPath = path.join(__dirname, "../db.json");
try {
	const data = generateDB();
	fs.writeFileSync(targetPath, JSON.stringify(data, null, 2));
	console.log("✨ Mock data with Faker.js generated successfully!");
} catch (error) {
	console.error("❌ Error:", error);
}
