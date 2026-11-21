import { fetchUtils } from "@amec/webasset/api/fetch-utils";

export async function getPurchaseOrders(data = {}) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/orders/search/`,
		method: "POST",
		data,
	});
}

export async function getPurchaseOrderDetail(poNo) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/orders/${encodeURIComponent(poNo)}`,
		method: "GET",
	});
}

export async function acknowledgePurchaseOrder(poNo, data = {}) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/orders/${encodeURIComponent(poNo)}/acknowledge`,
		method: "POST",
		data,
	});
}

export async function bulkAcknowledgePurchaseOrders(data = {}) {
	return fetchUtils({
		url: `${process.env.APP_API}/pursys/orders/bulk-acknowledge`,
		method: "POST",
		data,
	});
}
