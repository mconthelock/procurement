import { fetchUtils } from "@amec/webasset/api/fetch-utils";

export async function getVendors(q = {}) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/search/`,
		method: "POST",
		data: q,
	});
}

export async function getVendorDetail(vndCode) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/detail/`,
		method: "POST",
		data: { VENDCODE: vndCode },
	});
}

export async function getVendorHistory(vndCode) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/history/`,
		method: "POST",
		data: { VENDCODE: vndCode },
	});
}

export async function getVendorEvaluation(vndCode) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/evaluation/`,
		method: "POST",
		data: { VENDCODE: vndCode },
	});
}

export async function getVendorGroups(data = {}) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/groups/search/`,
		method: "POST",
		data,
	});
}

export async function getVendorGroupByCode(vndCode) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/groups/by-code/`,
		method: "POST",
		data: { VENDCODE: vndCode },
	});
}

export async function linkVendorCodes(data) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/groups/link/`,
		method: "POST",
		data,
	});
}

export async function setPrimaryVendorCode(data) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/groups/set-primary/`,
		method: "POST",
		data,
	});
}

export async function unlinkVendorCode(data) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/groups/unlink/`,
		method: "POST",
		data,
	});
}
