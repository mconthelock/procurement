const { faker } = require("@faker-js/faker");

const createProduct = (id, categoryId) => {
	const imageCount = faker.number.int({ min: 1, max: 4 });
	const images = [];
	for (let i = 0; i < imageCount; i++) {
		images.push(faker.image.url({ category: "" }));
		images.push(
			faker.image.url({ category: "business", width: 640, height: 480 }),
		);
	}

	return {
		PRODID: id,
		PRODCODE: faker.string.alphanumeric({ length: 8, casing: "upper" }),
		PRODNAME: faker.commerce.productName(),
		PRODDESCRIPTION: faker.commerce.productDescription(),
		CATEGORY_ID: categoryId,
		IMAGES: images,
	};
};

const createProductAttributes = (productId, categoryId) => {
	const attributes = [];
	if (categoryId === 1) {
		// หมวด Electronics (สมมติว่าเป็น ID 1)
		attributes.push({
			PRODID: productId,
			ATTR_NAME: "ระยะเวลาการรับประกัน",
			ATTR_VALUE: faker.helpers.arrayElement(["6 เดือน", "1 ปี", "3 ปี"]),
		});
		attributes.push({
			PRODID: productId,
			ATTR_NAME: "ยี่ห้อ",
			ATTR_VALUE: faker.company.name(),
		});
		attributes.push({
			PRODID: productId,
			ATTR_NAME: "หมายเลข มอก.",
			ATTR_VALUE: faker.string.numeric(8),
		});
	} else if (categoryId === 2) {
		// หมวด Furniture
		attributes.push({
			PRODID: productId,
			ATTR_NAME: "วัสดุ",
			ATTR_VALUE: faker.commerce.productMaterial(),
		});
		attributes.push({
			PRODID: productId,
			ATTR_NAME: "ขนาด (กxยxส)",
			ATTR_VALUE: `${faker.number.int({ min: 50, max: 200 })} x ${faker.number.int({ min: 50, max: 200 })} x ${faker.number.int({ min: 50, max: 200 })} cm`,
		});
	} else {
		// หมวดอื่นๆ (สุ่มข้อมูลทั่วไป)
		const attrCount = faker.number.int({ min: 2, max: 4 });
		for (let i = 0; i < attrCount; i++) {
			attributes.push({
				PRODID: productId,
				ATTR_NAME: faker.lorem.word(),
				ATTR_VALUE: faker.lorem.words(2),
			});
		}
	}

	return attributes;
};

module.exports = { createProduct, createProductAttributes };
