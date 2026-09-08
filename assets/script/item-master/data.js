import { fetchUtils } from "@amec/webasset/api/fetch-utils";

export async function getItemMaster(data) {
	return await fetchUtils({
		url: `${process.env.APP_API}/workload/material-status-inquiry-view/server-side`,
		method: "POST",
		data: data,
	});
}

/**
 * @author Sutthipong Tangmongkhoncharoen (24008)
 * @since 2026-08-31
 * @description Get Planner
 * @returns
 */
export async function getPlanner() {
	return await fetchUtils({
		url: `${process.env.APP_API}/datacenter/k850mp`,
		method: "GET",
	});
}

/**
 * @author Sutthipong Tangmongkhoncharoen (24008)
 * @since 2026-08-31
 * @description Get country
 * @returns
 */
export async function getCountry() {
	return await fetchUtils({
		url: `${process.env.APP_API}/workload/country-origin/country`,
		method: "GET",
	});
}

/**
 * @author Sutthipong Tangmongkhoncharoen (24008)
 * @since 2026-09-01
 * @description Save country origin
 * @param {CreateCountryOriginDto} data
 * @returns
 */
export async function saveOrigin(data) {
	return await fetchUtils({
		url: `${process.env.APP_API}/workload/country-origin`,
		method: "POST",
		data: data,
	});
}

/**
 * @author Sutthipong Tangmongkhoncharoen (24008)
 * @since 2026-09-02
 * @description Get country origin bulk list
 * @returns
 */
export async function getOriginBulkList() {
	return await fetchUtils({
		url: `${process.env.APP_API}/workload/country-origin/bulk-list`,
		method: "GET",
	});
}

/**
 * @author Sutthipong Tangmongkhoncharoen (24008)
 * @since 2026-09-08
 * @description upload country origin
 * @param {CreateCountryOriginDto[]} data
 * @returns
 */
export async function uploadOrigin(data) {
	return await fetchUtils({
		url: `${process.env.APP_API}/workload/country-origin/upload-excel`,
		method: "POST",
		data: data,
	});
}
