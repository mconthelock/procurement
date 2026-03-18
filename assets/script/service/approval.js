export async function getVendorsApv(id = "") {
	const response = await fetch(
		`${process.env.MOCK_API}/vendorApprovals/${id}`,
	);
	const data = await response.json();
	return data;
}
