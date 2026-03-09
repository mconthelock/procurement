export async function getVendors(id = "") {
	const response = await fetch(`${process.env.MOCK_API}/vendors/${id}`);
	const data = await response.json();
	return data;
}
