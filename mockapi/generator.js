const fs = require("fs");
const path = require("path");
const { faker } = require("@faker-js/faker");

// Import Templates
const createVendor = require("./schemas/vendors");
const createVendorCode = require("./schemas/vendors_code");
const createPaymentMaster = require("./schemas/paymentterm");
const createCurrencyMaster = require("./schemas/currency");
const { createCategory, CATEGORY_DEFINITIONS } = require("./schemas/category");
const createProduct = require("./schemas/products");
const createPriceHistory = require("./schemas/price_history");
const createVendorApv = require("./schemas/vendorsaproval");

function generateDB() {
	const db = {
		vendors: [],
		payments: createPaymentMaster(),
		currencies: createCurrencyMaster(),
		categories: [],
		products: [],
		vendorApprovals: [],
		addressmst: [
			// ================= กรุงเทพมหานคร (Bangkok) =================
			{
				id: "1",
				province_en: "Bangkok",
				province_th: "กรุงเทพมหานคร",
				district_en: "Phra Nakhon",
				district_th: "เขตพระนคร",
				sub_district_en: "Phra Borom Maha Ratchawang",
				sub_district_th: "พระบรมมหาราชวัง",
				zipcode: "10200",
			},
			{
				id: "2",
				province_en: "Bangkok",
				province_th: "กรุงเทพมหานคร",
				district_en: "Phra Nakhon",
				district_th: "เขตพระนคร",
				sub_district_en: "Wang Burapha Phirom",
				sub_district_th: "วังบูรพาภิรมย์",
				zipcode: "10200",
			},
			{
				id: "3",
				province_en: "Bangkok",
				province_th: "กรุงเทพมหานคร",
				district_en: "Huai Khwang",
				district_th: "เขตห้วยขวาง",
				sub_district_en: "Huai Khwang",
				sub_district_th: "ห้วยขวาง",
				zipcode: "10310",
			},
			{
				id: "4",
				province_en: "Bangkok",
				province_th: "กรุงเทพมหานคร",
				district_en: "Huai Khwang",
				district_th: "เขตห้วยขวาง",
				sub_district_en: "Sam Sen Nok",
				sub_district_th: "สามเสนนอก",
				zipcode: "10310",
			},

			// ================= ชลบุรี (Chon Buri) =================
			{
				id: "5",
				province_en: "Chon Buri",
				province_th: "ชลบุรี",
				district_en: "Mueang Chon Buri",
				district_th: "เมืองชลบุรี",
				sub_district_en: "Don Hua Lo",
				sub_district_th: "ดอนหัวฬ่อ",
				zipcode: "20000",
			},
			{
				id: "6",
				province_en: "Chon Buri",
				province_th: "ชลบุรี",
				district_en: "Mueang Chon Buri",
				district_th: "เมืองชลบุรี",
				sub_district_en: "Saen Suk",
				sub_district_th: "แสนสุข",
				zipcode: "20130",
			},
			{
				id: "7",
				province_en: "Chon Buri",
				province_th: "ชลบุรี",
				district_en: "Si Racha",
				district_th: "ศรีราชา",
				sub_district_en: "Si Racha",
				sub_district_th: "ศรีราชา",
				zipcode: "20110",
			},
			{
				id: "8",
				province_en: "Chon Buri",
				province_th: "ชลบุรี",
				district_en: "Si Racha",
				district_th: "ศรีราชา",
				sub_district_en: "Thung Sukhla",
				sub_district_th: "ทุ่งสุขลา",
				zipcode: "20230",
			},

			// ================= เชียงใหม่ (Chiang Mai) =================
			{
				id: "9",
				province_en: "Chiang Mai",
				province_th: "เชียงใหม่",
				district_en: "Mueang Chiang Mai",
				district_th: "เมืองเชียงใหม่",
				sub_district_en: "Phra Sing",
				sub_district_th: "พระสิงห์",
				zipcode: "50200",
			},
			{
				id: "10",
				province_en: "Chiang Mai",
				province_th: "เชียงใหม่",
				district_en: "Mueang Chiang Mai",
				district_th: "เมืองเชียงใหม่",
				sub_district_en: "Su Thep",
				sub_district_th: "สุเทพ",
				zipcode: "50200",
			},
			{
				id: "11",
				province_en: "Chiang Mai",
				province_th: "เชียงใหม่",
				district_en: "Hang Dong",
				district_th: "หางดง",
				sub_district_en: "Hang Dong",
				sub_district_th: "หางดง",
				zipcode: "50230",
			},
			{
				id: "12",
				province_en: "Chiang Mai",
				province_th: "เชียงใหม่",
				district_en: "Hang Dong",
				district_th: "หางดง",
				sub_district_en: "Nong Kwai",
				sub_district_th: "หนองควาย",
				zipcode: "50230",
			},

			// ================= ภูเก็ต (Phuket) =================
			{
				id: "13",
				province_en: "Phuket",
				province_th: "ภูเก็ต",
				district_en: "Mueang Phuket",
				district_th: "เมืองภูเก็ต",
				sub_district_en: "Talat Yai",
				sub_district_th: "ตลาดใหญ่",
				zipcode: "83000",
			},
			{
				id: "14",
				province_en: "Phuket",
				province_th: "ภูเก็ต",
				district_en: "Mueang Phuket",
				district_th: "เมืองภูเก็ต",
				sub_district_en: "Ratsada",
				sub_district_th: "รัษฎา",
				zipcode: "83000",
			},
			{
				id: "15",
				province_en: "Phuket",
				province_th: "ภูเก็ต",
				district_en: "Kathu",
				district_th: "กะทู้",
				sub_district_en: "Pa Tong",
				sub_district_th: "ป่าตอง",
				zipcode: "83150",
			},
		],
	};

	//1. Create Vendor data
	const usedCodes = new Set();
	for (let i = 1; i <= 100; i++) {
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

	for (let i = 1; i <= 10; i++) {
		const vendorApv = createVendorApv(i);
		db.vendorApprovals.push(vendorApv);
	}

	// 2. Create Category data
	db.categories = createCategory(CATEGORY_DEFINITIONS);

	// 3. Create Product data
	for (let i = 1; i <= 20; i++) {
		const randomCategory = faker.helpers.arrayElement(db.categories);
		const categoryId = randomCategory.CATEGORY_ID;
		const product = createProduct(i, categoryId);

		const vendorsForProduct = faker.helpers.arrayElements(
			db.vendors,
			faker.number.int({ min: 1, max: 3 }),
		);
		for (const vendor of vendorsForProduct) {
			const historyCount = faker.number.int({ min: 1, max: 4 });
			let currentPrice = parseFloat(
				faker.commerce.price({ min: 100, max: 5000 }),
			);
			const dates = Array.from({ length: historyCount }, () =>
				faker.date.past({ years: 2 }),
			).sort((a, b) => a - b);
			for (let k = 0; k < historyCount; k++) {
				const isLatest = k === historyCount - 1;
				product.PRICE_HISTORY.push(
					createPriceHistory(
						vendor.VND_ID,
						currentPrice,
						vendor.CURRENCY,
						dates[k].toISOString(),
						isLatest,
					),
				);
				currentPrice = parseFloat(
					(
						currentPrice *
						faker.number.float({ min: 0.9, max: 1.1 })
					).toFixed(2),
				);
			}
		}
		db.products.push(product);
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
