export async function getCountry(id = "") {
	const response = await fetch(`${process.env.MOCK_API}/countrymst/${id}`);
	const data = await response.json();
	return data;
}
