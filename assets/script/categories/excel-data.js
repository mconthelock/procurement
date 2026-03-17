/**
 * แปลงข้อมูล Categories สำหรับ Export ลง Excel
 */
export async function extractDataForExport(data) {
	// เรียงตามรหัสหมวดหมู่
	data.sort((a, b) => (a.CATEGORY_ID || 0) - (b.CATEGORY_ID || 0));

	return data.map((item) => ({
		CATEGORY_ID: item.CATEGORY_ID,
		CATEGORY_NAME: item.CATEGORY_NAME,
		DESCRIPTION: item.DESCRIPTION || "-",
		CATEGORY_OWNER: item.CATEGORY_OWNER || "-",
	}));
}
