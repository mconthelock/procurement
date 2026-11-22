import { fetchUtils } from "@amec/webasset/api/fetch-utils";

export async function getItemMasterServerSide(data = {}) {
	return fetchUtils({
		url: `${process.env.APP_API}/workload/material-status-inquiry-view/server-side`,
		method: "POST",
		data,
	});
}

export async function getIimByProd(iprod) {
	return fetchUtils({
		url: `${process.env.APP_API}/datacenter/iim/prod`,
		method: "POST",
		data: { IPROD: iprod },
	});
}

export async function getItemPlanners() {
	return fetchUtils({
		url: `${process.env.APP_API}/datacenter/k850mp`,
		method: "GET",
	});
}

export async function getOriginCountries() {
	return fetchUtils({
		url: `${process.env.APP_API}/workload/country-origin/country`,
		method: "GET",
	});
}

export async function saveItemOrigin(data = {}) {
	return fetchUtils({
		url: `${process.env.APP_API}/workload/country-origin`,
		method: "POST",
		data,
	});
}

export async function getOriginBulkList() {
	return fetchUtils({
		url: `${process.env.APP_API}/workload/country-origin/bulk-list`,
		method: "GET",
	});
}

export async function uploadItemOrigin(data = []) {
	return fetchUtils({
		url: `${process.env.APP_API}/workload/country-origin/upload-excel`,
		method: "POST",
		data,
	});
}
