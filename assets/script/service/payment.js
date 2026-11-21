import { fetchUtils } from "@amec/webasset/api/fetch-utils";

export async function getPayments(id = "") {
	return fetchUtils({
		url: `${process.env.APP_API}/payments/${id}`,
		method: "GET",
	});
}
