const { faker } = require("@faker-js/faker");

// ฟังก์ชันสำหรับสร้าง User 1 คน
const createUser = (id) => ({
	id: id,
	fullName: faker.person.fullName(),
	email: faker.internet.email(),
	avatar: faker.image.avatar(),
	jobTitle: faker.person.jobTitle(),
	createdAt: faker.date.past().toISOString(),
});

module.exports = createUser;
