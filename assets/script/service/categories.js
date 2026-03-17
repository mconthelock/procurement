const MOCK_API = process.env.MOCK_API;

export async function getCategories(id = "") {
	// ถ้ามี ID ให้เช็กว่าเป็น ID ของระบบ หรือเป็น CATEGORY_ID
	const url = id ? `${MOCK_API}/categories/${id}` : `${MOCK_API}/categories`;

	const response = await fetch(url);

	if (!response.ok) {
		if (id && response.status === 404) {
			const searchRes = await fetch(
				`${MOCK_API}/categories?CATEGORY_ID=${id}`,
			);
			const searchData = await searchRes.json();
			if (searchData.length > 0) return searchData[0]; // คืนค่าตัวแรกที่เจอ
		}
		throw new Error("Network response was not ok");
	}

	return await response.json();
}

export async function getCategoryAttributes(categoryId) {
	if (!categoryId) return [];
	try {
		// ดึงข้อมูล Category มาก่อน
		const category = await getCategories(categoryId);

		console.log("Found Category for Attributes:", category);

		// คืนค่า REQUIRED_ATTRIBUTES
		return category.REQUIRED_ATTRIBUTES || [];
	} catch (error) {
		console.error("Error fetching attributes:", error);
		return [];
	}
}
export const saveCategories = async (payload, id = null) => {
	const method = id ? "PUT" : "POST";
	const url = id ? `${MOCK_API}/categories/${id}` : `${MOCK_API}/categories`;

	const response = await fetch(url, {
		method: method,
		headers: { "Content-Type": "application/json" },
		body: JSON.stringify(payload),
	});
	return await response.json();
};
