const { faker } = require("@faker-js/faker");
const paymentTermsList = [
	"30 Days after delivery",
	"60 Days after delivery",
	"15 Days after delivery",
	"7 Days after delivery",
	"90 Days after delivery",
	"100% Cash",
	"45 Days after delivery",
	"T/T 30 Days after B/L date",
	"T/T 60 Days after B/L date",
	"T/T 45 Days after B/L date",
	"T/T 90 Days after B/L date",
	"T/T 75 Days after B/L date",
];

// ฟังก์ชันนี้จะคืนค่า (Return) ออกมาเป็น Array ของข้อมูลทั้งหมดเลย
const createPaymentMaster = () => {
	return paymentTermsList.map((term, index) => ({
		id: index + 1, // รัน ID เป็น 1, 2, 3...
		term: term, // เก็บชื่อ Payment Term ตาม list
	}));
};

module.exports = createPaymentMaster;
