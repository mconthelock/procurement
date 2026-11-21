import { fetchUtils } from "@amec/webasset/api/fetch-utils";

export async function getVendorUsers(data = {}) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/users/search/`,
		method: "POST",
		data,
	});
}

export async function createVendorUser(data) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/users/`,
		method: "POST",
		data,
	});
}

export async function updateVendorUser(id, data) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/users/${id}`,
		method: "PUT",
		data,
	});
}

export async function resetVendorUserPassword(id) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/users/${id}/reset-password`,
		method: "POST",
	});
}
