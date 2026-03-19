export const getBaseURL = () => {
	const currentURL = window.location.href; // ดึง URL ปัจจุบันของเบราว์เซอร์
	const hostname = window.location.hostname;

	// 1. เช็คว่ารันบนเครื่องตัวเอง (Local Development) หรือไม่
	if (hostname === "localhost") {
		return process.env.MOCK_API; // ใช้ JSON Server
	}

	// 2. เช็คว่า URL มีคำว่า "test" หรือไม่ (เช่น test-procurement.mitsubishi...)
	if (currentURL.includes("test")) {
		return process.env.APP_API; // ใช้ API ฝั่ง Test
	}

	// 3. ถ้าไม่ใช่ทั้งคู่ ให้ใช้ API หลัก (Production)
	return process.env.APP_API;
};

const API_BASE = getBaseURL();
