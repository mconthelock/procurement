import { fetchUtils } from "@amec/webasset/api/fetch-utils";

export async function getAddressMST(id = "") {
	return fetchUtils({
		url: `${process.env.APP_API}/addressmst/${id}`,
		method: "GET",
	});
}
