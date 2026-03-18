const { faker } = require("@faker-js/faker");
const employeeNames = [
	"AMPIKA  POKAEW",
	"WIYADA  ONSEETHONG",
	"CHATCHAREE  WETCHAKAMA",
	"NOPPAMAT  CHAICHUMPOL",
	"CHITCHANOK  TEPCHOMPOO",
];
const createVendorApv = (id) => {
	const currentYear = new Date().getFullYear().toString().slice(-2);
	const randomDigits = Math.floor(Math.random() * 100)
		.toString()
		.padStart(6, "0");
	const generatedFormNo = `PUR-VND${currentYear}-${randomDigits}`;
	const randomDate = faker.date.past();
	const monthNames = [
		"JAN",
		"FEB",
		"MAR",
		"APR",
		"MAY",
		"JUN",
		"JUL",
		"AUG",
		"SEP",
		"OCT",
		"NOV",
		"DEC",
	];
	const formattedDate = `${String(randomDate.getDate()).padStart(2, "0")}-${monthNames[randomDate.getMonth()]}-${randomDate.getFullYear()}`;
	return {
		FRM_NO: generatedFormNo,
		FRM_REQNAME: faker.helpers.arrayElement(employeeNames),
		FRM_REQDATE: formattedDate,
		FRM_REQTIME: faker.date.past().toTimeString().split(" ")[0],
		FRM_VNDNAME: faker.company.name(),
		FRM_STATUS: faker.helpers.arrayElement([1, 2, 3]),
	};
};

module.exports = createVendorApv;
