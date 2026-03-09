export async function extractDataForExport(data) {
	let result = [];
	data = data.sort((a, b) => a.VND_ID - b.VND_ID);
	data.map((item) => {
		item.VENDOR_CODES.map((code) => {
			const addr = `${item.VND_ADDRESS1} ${item.VND_ADDRESS2} ${item.VND_CITY} ${item.VND_STATE} ${item.VND_ZIP} ${item.VND_COUNTRY}`;
			const statusMap = {
				0: "Creating",
				1: "Active",
				2: "Inactive",
			};
			result.push({
				...item,
				...code,
				ADDRESS: addr,
				STATUS: statusMap[code.CODE_STATUS],
			});
		});
	});
	return result;
}
