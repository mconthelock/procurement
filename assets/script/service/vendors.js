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
