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
const createVendorCode = (vndId, codeNum) => {
	return {
		CODE_NUM: codeNum,
		CODE_CURRENCY: faker.finance.currencyCode(),
		CODE_SHIP: faker.helpers.arrayElement(["Air", "Sea", "Land"]),
		CODE_PAY: faker.helpers.arrayElement(paymentTermsList),
		CODE_TYPE: faker.helpers.arrayElement([
			"Standard",
			"Express",
			"Overnight",
		]),
		CODE_STATUS: faker.helpers.arrayElement([0, 1, 2]),
		CODE_REGDATE: faker.date.past().toISOString(),
		VENDORS: vndId,
	};
};

module.exports = createVendorCode;
