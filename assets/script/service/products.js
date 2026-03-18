// นำเข้าข้อมูล (ถ้ามีการใช้โมดูล) หรือประกาศไว้ในไฟล์เดียวกัน
const API_BASE =
	process.env.API_MODE === "REAL"
		? process.env.APP_API // http://localhost:3001
		: process.env.MOCK_API; // http://localhost:3002
export async function getProducts(id = "") {
	// ตรวจสอบว่า process.env.MOCK_API คือ http://localhost:3002
	const response = await fetch(`${API_BASE}/products/${id}`);
	if (!response.ok) throw new Error("Network response was not ok");
	const data = await response.json();
	return data;
}

export const saveProduct = async (payload, id = null) => {
	const method = id ? "PUT" : "POST";
	const url = id ? `${API_BASE}/products/${id}` : `${API_BASE}/products`;

	const response = await fetch(url, {
		method: method,
		headers: { "Content-Type": "application/json" },
		body: JSON.stringify(payload),
	});
	return await response.json();
};
