export async function getVendors() {
	const response = await fetch(`${process.env.API_URL}/pursys/vendors`, {});
	const data = await response.json();
	return data;
}
