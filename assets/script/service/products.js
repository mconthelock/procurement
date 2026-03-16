// นำเข้าข้อมูล (ถ้ามีการใช้โมดูล) หรือประกาศไว้ในไฟล์เดียวกัน
export async function getProducts(id = "") {
	// ตรวจสอบว่า process.env.MOCK_API คือ http://localhost:3002
	const response = await fetch(`${process.env.MOCK_API}/products/${id}`);
	const data = await response.json();
	return data;
}

export async function getCategories(id = "") {
	const response = await fetch(`${process.env.MOCK_API}/categories/${id}`);
	const data = await response.json();
	return data;
}
