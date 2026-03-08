import { it } from "@faker-js/faker";

export async function extractDataForExport(data) {
	let result = [];
	data = data.sort((a, b) => a.VND_ID - b.VND_ID);
	data.map((item) => {
		item.VENDOR_CODES.map((code) => {
			result.push({
				VND_ID: item.VND_ID,
				VND_NAME: item.VND_NAME,
				VND_ADDRESS1: item.VND_ADDRESS1,
				VND_ADDRESS2: item.VND_ADDRESS2,
				VND_CITY: item.VND_CITY,
				VND_STATE: item.VND_STATE,
				VND_ZIP: item.VND_ZIP,
				VND_COUNTRY: item.VND_COUNTRY,
				VND_CREATED_AT: item.VND_CREATED_AT,
				VND_UPDATED_AT: item.VND_UPDATED_AT,
				VND_STATUS: item.VND_STATUS,
				CODE_NUM: code.CODE_NUM,
			});
		});
	});
	return result;
}
