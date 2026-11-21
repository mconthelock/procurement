import { fetchUtils } from "@amec/webasset/api/fetch-utils";

export async function getVendors(q = {}) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/vendors/search/`,
		method: "POST",
		data: q,
	});
}
