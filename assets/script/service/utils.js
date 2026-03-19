export const getBaseURL = (envType = null) => {
	const hostname = window.location.hostname;
	const currentURL = window.location.href;

	// 1. ถ้าอยู่บน localhost ให้ใช้ MOCK_API เสมอ (เพื่อความสะดวกตอน Dev)
	if (hostname === "localhost") {
		return process.env.MOCK_API;
	}

	// 2. ถ้ามีการส่ง 'MOCK_API' มาโดยตรง ให้ใช้ MOCK_API
	if (envType === "MOCK_API") {
		return process.env.MOCK_API;
	}

	// 3. ถ้า URL มีคำว่า "test" ให้ใช้ MOCK_API
	if (currentURL.includes("test")) {
		return process.env.MOCK_API;
	}

	// 4. กรณีอื่นๆ ทั้งหมด (เช่น Production หรือไม่ส่ง parameter มา) ให้ใช้ APP_API
	return process.env.APP_API;
};
