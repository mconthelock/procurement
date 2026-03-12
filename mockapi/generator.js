const fs = require("fs");
const path = require("path");
const { faker } = require("@faker-js/faker");

// Import Templates
const createVendor = require("./schemas/vendors");
const createVendorCode = require("./schemas/vendors_code");
const { createCategory, CATEGORY_DEFINITIONS } = require("./schemas/category");
const createProduct = require("./schemas/products");
const createPriceHistory = require("./schemas/price_history");

const generateDB = () => {
	const db = {
		vendors: [],
		categories: [],
		products: [],
	};

	//1. Create Vendor data
	const usedCodes = new Set();
	for (let i = 1; i <= 5; i++) {
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
};

// สั่งเขียนไฟล์
const targetPath = path.join(__dirname, "../db.json");
try {
	const data = generateDB();
	fs.writeFileSync(targetPath, JSON.stringify(data, null, 2));
	console.log("✨ Mock data with Faker.js generated successfully!");
} catch (error) {
	console.error("❌ Error:", error);
}
