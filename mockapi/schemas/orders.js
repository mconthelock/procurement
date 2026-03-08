const { faker } = require("@faker-js/faker");

const createOrder = (orderId, userId, allProducts) => {
	// สุ่มจำนวนสินค้าใน Order นี้ (เช่น 1 ถึง 5 ชิ้น)
	const itemCount = faker.number.int({ min: 1, max: 5 });

	const items = Array.from({ length: itemCount }, () => {
		// สุ่มเลือกสินค้า 1 ชิ้นจาก List ทั้งหมดที่มี
		const product = faker.helpers.arrayElement(allProducts);
		const quantity = faker.number.int({ min: 1, max: 3 });

		return {
			productId: product.id,
			productName: product.productName, // ใส่ชื่อไว้ด้วยเพื่อให้ Frontend แสดงผลได้ง่ายขึ้น
			price: product.price,
			quantity: quantity,
			subTotal:
				Number(product.price.replace(/[^0-9.-]+/g, "")) * quantity, // คำนวณราคารวมของชิ้นนี้
		};
	});

	// คำนวณราคารวมทั้ง Order
	const totalAmount = items.reduce((sum, item) => sum + item.subTotal, 0);

	return {
		id: orderId,
		userId: userId,
		orderNumber: faker.string.alphanumeric(8).toUpperCase(),
		items: items, // <--- นี่คือ Nesting Data
		totalAmount: `฿${totalAmount.toLocaleString()}`,
		status: faker.helpers.arrayElement(["pending", "paid", "shipped"]),
		orderedAt: faker.date.recent().toISOString(),
	};
};

module.exports = createOrder;
