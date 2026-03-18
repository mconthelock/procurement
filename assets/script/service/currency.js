export async function getCurrencies(id = "") {
	const response = await fetch(`${process.env.MOCK_API}/currencies/${id}`);

	if (!response.ok) {
		throw new Error("Failed to fetch currencies");
	}

	const data = await response.json();
	return data;
}
