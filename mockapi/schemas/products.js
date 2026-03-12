const { faker } = require("@faker-js/faker");

const createProduct = (id, categoryId) => {
	const imageCount = faker.number.int({ min: 1, max: 4 });
	const images = [];
	let attributes = {};
	for (let i = 0; i < imageCount; i++) {
		images.push(
			faker.image.url({ category: "business", width: 640, height: 480 }),
		);
	}

	return {
		PROD_ID: id,
		PROD_CODE: faker.string.alphanumeric({ length: 8, casing: "upper" }),
		PROD_NAME: faker.commerce.productName(),
		PROD_DESCRIPTION: faker.commerce.productDescription(),
		PROD_UNIT: faker.helpers.arrayElement(["ชิ้น", "กล่อง", "แพ็ค", "ชุด"]),
		PROD_STATUS: faker.helpers.arrayElement([0, 1]),
		HAZARD: faker.helpers.arrayElement([1, 2, 3]),
		CATEGORY_ID: categoryId,
		CREATED_AT: faker.date.past({ years: 2 }),
		IMAGES: images,
		ATTRIBUTES: createProductAttributes(categoryId),
		PRICE_HISTORY: [],
	};
};

const createProductAttributes = (categoryId) => {
	const attributes = [];
	if (categoryId === 1) {
		// หมวด Electronics (สมมติว่าเป็น ID 1)
		attributes.push({
			ATTR_NAME: "ระยะเวลาการรับประกัน",
			ATTR_VALUE: faker.helpers.arrayElement(["6 เดือน", "1 ปี", "3 ปี"]),
		});
		attributes.push({
			ATTR_NAME: "ยี่ห้อ",
			ATTR_VALUE: faker.company.name(),
		});
		attributes.push({
			ATTR_NAME: "หมายเลข มอก.",
			ATTR_VALUE: faker.string.numeric(8),
		});
	} else if (categoryId === 2) {
		// หมวด Furniture
		attributes.push({
			ATTR_NAME: "วัสดุ",
			ATTR_VALUE: faker.commerce.productMaterial(),
		});
		attributes.push({
			ATTR_NAME: "ขนาด (กxยxส)",
			ATTR_VALUE: `${faker.number.int({ min: 50, max: 200 })} x ${faker.number.int({ min: 50, max: 200 })} x ${faker.number.int({ min: 50, max: 200 })} cm`,
		});
	} else {
		// หมวดอื่นๆ (สุ่มข้อมูลทั่วไป)
		const attrCount = faker.number.int({ min: 2, max: 4 });
		for (let i = 0; i < attrCount; i++) {
			attributes.push({
				ATTR_NAME: faker.lorem.word(),
				ATTR_VALUE: faker.lorem.words(2),
			});
		}
	}

	return attributes;
};

module.exports = createProduct;
