const { faker } = require("@faker-js/faker");

const createVendorCode = (vndId, codeNum) => {
	return {
		CODE_NUM: codeNum,
		CODE_CURR: faker.finance.currencyCode(),
		CODE_STATUS: faker.helpers.arrayElement([0, 1, 2]),
		VND_ID: vndId,
	};
};

module.exports = createVendorCode;
