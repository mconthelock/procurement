const MOCK_API = process.env.MOCK_API;

export async function getCategories(id = "") {
	const response = await fetch(`${MOCK_API}/categories/${id}`);
	if (!response.ok) throw new Error("Network response was not ok");
	const data = await response.json();
	return data;
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
