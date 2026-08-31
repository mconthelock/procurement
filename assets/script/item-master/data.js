import { fetchUtils } from "@amec/webasset/api/fetch-utils";

export async function getItemMaster(data) {
	return await fetchUtils({
		url: `${process.env.APP_API}/workload/material-status-inquiry-view/server-side`,
		method: "POST",
		data: data,
	});
}
