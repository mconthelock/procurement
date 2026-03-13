const { faker } = require("@faker-js/faker");
const employeeNames = [
	"AMPIKA  POKAEW",
	"WIYADA  ONSEETHONG",
	"CHATCHAREE  WETCHAKAMA",
	"NOPPAMAT  CHAICHUMPOL",
	"CHITCHANOK  TEPCHOMPOO",
];
const createVendor = (id) => {
	return {
		VND_ID: id,
		VND_NAME: faker.company.name(),
		VND_TNAME: faker.company.name(),
		VND_SALE: faker.person.fullName(),
		VND_REGDATE: faker.date.past().toISOString(),
		VND_REGNAME: faker.helpers.arrayElement(employeeNames),
		VND_LASTUPDATE: faker.date.recent().toISOString(),
		VND_STATUS: faker.helpers.arrayElement([0, 1, 2]),

		ADDR_PHONE: faker.phone.number(),
		ADDR_WEB: faker.internet.url(),
		VENDOR_CODES: [],
		// 	{
		// 		CODE_NUM: faker.string.numeric(6),
		// 		CODE_CURRENCY: faker.finance.currencyCode(),
		// 		CODE_SHIP: faker.helpers.arrayElement(["AIR", "SEA", "LAND"]),
		// 		CODE_PAY: faker.helpers.arrayElement([
		// 			"CASH",
		// 			"CREDIT",
		// 			"TRANSFER",
		// 		]),
		// 		CODE_TYPE: faker.helpers.arrayElement(["PRIMARY", "SECONDARY"]),
		// 	},
		// ],
		VENDOR_ADDRESS: [
			{
				ADDR_TYPE: faker.helpers.arrayElement(["T", "E"]),
				ADDR_LINE1: faker.location.streetAddress(),
				ADDR_LINE2: faker.location.secondaryAddress(),
				ADDR_CITY: faker.location.city(),
				ADDR_COUNTRY: faker.location.country(),
				ADDR_ZIPCODE: faker.location.zipCode(),
			},
		],
		VENDOR_ATTFILE: [
			{
				FILE_NAME: faker.system.fileName(),
				UFILE_NAME: faker.system.fileName(),
			},
		],
	};
};

module.exports = createVendor;
