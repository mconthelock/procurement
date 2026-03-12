const fs = require("fs");
const path = require("path");
const { faker } = require("@faker-js/faker");

// Import Templates
const createVendor = require("./schemas/vendors");
const createVendorCode = require("./schemas/vendors_code");
const { createCategory, CATEGORY_DEFINITIONS } = require("./schemas/category");
const {
	createProduct,
	createProductAttributes,
} = require("./schemas/products");

const generateDB = () => {
	const db = {
		vendors: [],
		categories: [],
		products: [],
		product_attributes: [],
	};

	//1. Create Vendor data
	const usedCodes = new Set();
	let codeIdCounter = 1;
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
		db.products.push(product);
		const attributes = createProductAttributes(i, categoryId);
		db.product_attributes.push(...attributes);
	}

	db.categories = createCategory(CATEGORY_DEFINITIONS);
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
