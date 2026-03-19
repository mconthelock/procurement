/**
 * ฟังก์ชันสำหรับเตรียมข้อมูล Products เพื่อ Export ออกเป็น Excel
 * โดยจะกระจายข้อมูล 1 แถวต่อ 1 ประวัติราคา (Price History)
 */
export async function extractDataForExport(data) {
	let result = [];

	// 1. เรียงลำดับข้อมูลตามรหัสสินค้า (A-Z)
	data.sort((a, b) => (a.PROD_CODE || "").localeCompare(b.PROD_CODE || ""));

	data.forEach((item) => {
		// Mapping ตัวอักษรสำหรับค่าที่เป็น ID/ตัวเลข
		const statusMap = { 0: "Draft", 1: "Active", 2: "Inactive" };
		const hazardMap = { 0: "None", 1: "Low", 2: "Medium", 3: "High" };

		// รวม Attributes ทั้งหมดเป็นข้อความเดียว (เช่น "Color: Red | Size: L")
		const attrString =
			item.ATTRIBUTES?.map((a) => `${a.ATTR_NAME}: ${a.ATTR_VALUE}`).join(
				" | ",
			) || "-";

		// 2. ตรวจสอบว่าสินค้ามีประวัติราคา (Price History) หรือไม่
		if (item.PRICE_HISTORY && item.PRICE_HISTORY.length > 0) {
			item.PRICE_HISTORY.forEach((price) => {
				const quote = price.QUOTATION || {};

				result.push({
					// --- ข้อมูลพื้นฐานสินค้า ---
					PROD_CODE: item.PROD_CODE || "",
					PROD_NAME: item.PROD_NAME || "",
					PROD_DESCRIPTION: item.PROD_DESCRIPTION || "",
					PROD_UNIT: item.PROD_UNIT || "",
					PROD_STATUS_TEXT: statusMap[item.PROD_STATUS] || "Unknown",
					HAZARD_TEXT: hazardMap[item.HAZARD] || "None",
					CATEGORY_ID: item.CATEGORY_ID || "-",
					ATTRIBUTES_TEXT: attrString,

					// --- ข้อมูลราคาและ Vendor ---
					VND_ID: price.VND_ID ? String(price.VND_ID) : "-",
					PRICE: parseFloat(price.PRICE) || 0,
					PRICE_STATUS: price.IS_ACTIVE ? "Active" : "History",
					EFFECTIVE_DATE: price.EFFECTIVE_DATE || null,

					// --- ข้อมูลใบเสนอราคา (Quotation) ---
					QUOTE_NO: quote.QUOTATION_NO || "-",
					QUOTE_DATE: quote.QUOTATION_DATE || null,
					QUOTE_FILE: quote.QUOTATION_FILE || "-",
					QUOTE_REMARK: quote.REMARK || "-",
				});
			});
		} else {
			// 3. กรณีไม่มีประวัติราคาเลย ให้สร้างแถวสินค้าเปล่าๆ ไว้ 1 แถว
			result.push({
				PROD_CODE: item.PROD_CODE || "",
				PROD_NAME: item.PROD_NAME || "",
				PROD_DESCRIPTION: item.PROD_DESCRIPTION || "",
				PROD_UNIT: item.PROD_UNIT || "",
				PROD_STATUS_TEXT: statusMap[item.PROD_STATUS] || "Unknown",
				HAZARD_TEXT: hazardMap[item.HAZARD] || "None",
				CATEGORY_ID: item.CATEGORY_ID || "-",
				ATTRIBUTES_TEXT: attrString,
				VND_ID: "-",
				PRICE: 0,
				PRICE_STATUS: "No Price Record",
				EFFECTIVE_DATE: null,
				QUOTE_NO: "-",
				QUOTE_DATE: null,
				QUOTE_FILE: "-",
				QUOTE_REMARK: "-",
			});
		}
	});

	return result;
}
