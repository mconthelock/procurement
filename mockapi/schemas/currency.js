const { faker } = require("@faker-js/faker");
const currencyList = [
	{ curcode: "US$", currency: "American Dollar (USD)" },
	{ curcode: "Bt.", currency: "Thai Baht (BHT)" },
	{ curcode: "Frc", currency: "French Franc (FRF)" },
	{ curcode: "S$", currency: "Singapore Dollar" },
	{ curcode: "GBP", currency: "Great British Pound (GBP)" },
	{ curcode: "Yen", currency: "Japanese Yen" },
	{ curcode: "EUR", currency: "EURO" },
	{ curcode: "RMB", currency: "Renminbi (RMB)" },
	{ curcode: "CNY", currency: "Chinese Yuan" },
];

// ไม่ต้องวนลูปสร้าง ID แล้ว ส่ง Array กลับไปตรงๆ ได้เลย
const createCurrencyMaster = () => {
	return currencyList;
};

module.exports = createCurrencyMaster;
