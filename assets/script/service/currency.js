import { fetchUtils } from "@amec/webasset/api/fetch-utils";

export async function getCurrencies(id = "") {
	return fetchUtils({
		url: `${process.env.APP_API}/currencies/${id}`,
		method: "GET",
	});
}
