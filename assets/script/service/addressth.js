export async function getAddressMST(id = "") {
	const response = await fetch(`${process.env.MOCK_API}/addressmst/${id}`);

	if (!response.ok) {
		throw new Error("Failed to fetch address data");
	}

	const data = await response.json();
	return data;
}
