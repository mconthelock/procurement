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

export async function extractApvDataForExport(data) {
	let result = [];
	data = data.sort((a, b) => a.FRM_ID - b.FRM_ID);
	data.map((item) => {
		const statusMap = {
			1: "Running",
			2: "Approve",
			3: "Reject",
		};
		result.push({
			...item,
			STATUS: statusMap[item.FRM_STATUS],
		});
	});
	return result;
}
