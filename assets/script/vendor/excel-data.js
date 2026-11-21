export async function extractDataForExport(data) {
	const result = [];
	const sorted = [...data].sort((a, b) =>
		String(a.VND_CODE || a.VND_ID || "").localeCompare(
			String(b.VND_CODE || b.VND_ID || ""),
		),
	);

	const statusMap = {
		0: "Creating",
		1: "Active",
		2: "Inactive",
		ACTIVE: "Active",
		INACTIVE: "Inactive",
		HOLD: "Hold",
	};

	sorted.forEach((item) => {
		const addr = [
			item.VND_ADDRESS1,
			item.VND_ADDRESS2,
			item.VND_CITY,
			item.VND_STATE,
			item.VND_ZIP || item.VND_ZIPCODE,
			item.VND_COUNTRY,
		]
			.filter(Boolean)
			.join(" ");

		if (Array.isArray(item.VENDOR_CODES) && item.VENDOR_CODES.length) {
			item.VENDOR_CODES.forEach((code) => {
				result.push({
					...item,
					...code,
					ADDRESS: addr,
					STATUS: statusMap[code.CODE_STATUS] || code.CODE_STATUS || "-",
				});
			});
		} else {
			result.push({
				...item,
				CODE_NUM: item.VND_CODE,
				CODE_CURRENCY: item.VND_CURRENCY,
				CODE_PAY: item.VND_TERM,
				ADDRESS: addr,
				STATUS: statusMap[item.VND_STATUS] || item.VND_STATUS || "-",
			});
		}
	});

	return result;
}

export async function extractApvDataForExport(data) {
	const result = [];
	const sorted = [...data].sort((a, b) => (a.FRM_ID || 0) - (b.FRM_ID || 0));
	const statusMap = {
		1: "Running",
		2: "Approve",
		3: "Reject",
	};
	sorted.forEach((item) => {
		result.push({
			...item,
			STATUS: statusMap[item.FRM_STATUS] || item.FRM_STATUS || "-",
		});
	});
	return result;
}
