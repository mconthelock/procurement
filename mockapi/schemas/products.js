const { faker } = require("@faker-js/faker");

// ฟังก์ชันสำหรับสร้าง Product 1 ชิ้น
const createProduct = (id) => ({
	id: id,
	uuid: faker.string.uuid(),
	productName: faker.commerce.productName(),
	price: faker.commerce.price({ min: 100, max: 5000, dec: 0, symbol: "฿" }),
	description: faker.commerce.productDescription(),
	category: faker.commerce.department(),
	image: faker.image.faker.image.url({ category: "technics" }),
});

module.exports = createProduct;
