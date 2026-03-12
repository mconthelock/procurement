// ไฟล์: schemas/price_history.js
const { faker } = require("@faker-js/faker");

const createPriceHistory = (vndId, price, currency, date, isActive) => {
	return {
		VND_ID: vndId,
		PRICE: price,
		CURRENCY: currency,
		EFFECTIVE_DATE: date,
		IS_ACTIVE: isActive,
		QUOTATION: {
			QUOTATION_NO: `QT-${faker.string.alphanumeric(6).toUpperCase()}`,
			QUOTATION_DATE: date,
			QUOTATION_FILE: `quotation_${faker.string.numeric(5)}.pdf`,
			REMARK: faker.lorem.sentence(),
		},
	};
};

module.exports = createPriceHistory;
