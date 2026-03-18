export async function getPayments(id = "") {
	const response = await fetch(`${process.env.MOCK_API}/payments/${id}`);

	if (!response.ok) {
		throw new Error("Failed to fetch payments");
	}

	const data = await response.json();
	return data;
}
