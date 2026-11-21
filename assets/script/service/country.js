import { fetchUtils } from "@amec/webasset/api/fetch-utils";

export async function getCountry(id = "") {
	return fetchUtils({
		url: `${process.env.APP_API}/countrymst/${id}`,
		method: "GET",
	});
}
