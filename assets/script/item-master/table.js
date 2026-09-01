import { createTable, destroyTable } from "@amec/webasset/dataTable";
import { dataTableSkeleton } from "@amec/webasset/skeleton";
import { getItemMaster } from "./data";
import { showErrorMessage } from "@amec/webasset/utils";
import { displayEmpImage } from "@amec/webasset/indexDB";
import { showLoader } from "@amec/webasset/preloader";
import { modalItemMaster } from "./modal";

/**
 * Create table item master
 * @author Sutthipong Tangmongkhoncharoen (24008)
 * @since 2026-08-28
 */
export const tableItemMaster = {
	instance: null,
	skeleton: null,
	tableId: "table",
	handleInstance() {
		if (!this.instance) {
			throw new Error("Table instance not initialized. Call init() first.");
		}
	},
	get() {
		this.handleInstance();
		return this.instance;
	},
	set(instance) {
		this.instance = instance;
	},
	data(where = {}) {
		this.handleInstance();
		return this.instance.rows(where).data().toArray();
	},
	row(tr) {
		this.handleInstance();
		return this.instance.row(tr).data();
	},
	updateRow(tr, data) {
		this.handleInstance();
		this.instance.row(tr).data(data).draw(false);
	},
	preload(show = true) {
		this.skeleton = dataTableSkeleton({
			show: show,
			idLoading: this.tableId,
			button: false,
			height: "h-[60vh]",
			searchSize: {
				width: "w-16",
			},
		});
	},
	async destroy() {
		if (!this.instance) {
			return;
		}
		await destroyTable(this.tableId);
		this.instance = null;
	},
	async init() {
		this.preload();
		this.instance = await this.create();
		this.skeleton.remove();
		this.bindEvents();
	},
	async create() {
		try {
			return await createTable(
				{
					columns: columns,
					processing: true,
					serverSide: true,
					responsive: false,
					ordering: false,
					lengthMenu: [15, 25, 50, 100],
					ajax: async function (data, callback, settings) {
						try {
							showLoader();
							const response = await getItemMaster(data);
							const buyers = response.data.map((d) => d.BUYER);
							const uniqueBuyers = [...new Set(buyers)];
							const buyerImages = [];
							for (const b of uniqueBuyers) {
								const img = await displayEmpImage(b);
								buyerImages.push({ buyer: b, image: img });
							}
							const newData = response.data.map((item) => ({
								...item,
								BUYER_IMAGE: buyerImages.find((b) => b.buyer === item.BUYER)?.image || "",
							}));
							response.data = newData;
							callback(response);
						} catch (error) {
							console.error("Error fetching item master data:", error);
							callback({
								data: [],
								recordsTotal: 0,
								recordsFiltered: 0,
							});
							showErrorMessage(error.message || "Failed to fetch item master data.");
						} finally {
							showLoader({ show: false });
						}
					},
				},
				{
					id: this.tableId,
					domScroll: {
						status: true,
						maxHeight: "50vh",
						type: "custom",
						custom: {
							search: {
								show: false,
							},
						},
					},
					headerSticky: {
						shadow: false,
					},
				},
			);
		} catch (error) {
			console.error("Error in create item master table:", error);
			throw error;
		}
	},
	bindEvents() {
		const self = this;
		$(document).on("click", ".actions", function () {
			const tr = $(this).closest("tr");
			const rowData = self.row(tr);
			console.log("Row data:", rowData);
			modalItemMaster.data = rowData;
		});
	},
};

const columns = [
	{
		data: "ITEM",
		name: "ITEM",
		title: "PURCODE",
		width: "100px",
	},
	{
		data: "PARTNAME",
		name: "PARTNAME",
		title: "PART NAME",
	},
	{
		data: "COUNTRY",
		name: "COUNTRY",
		title: "COUNTRY",
	},
	{
		data: "STATUS",
		name: "STATUS",
		title: "STATUS",
		width: "100px",
		className: "text-right",
		render: function (data, type, row) {
			if (data === "IM") {
				return `<span class="badge badge-success">Active</span>`;
			} else {
				return `<span class="badge badge-error">Inactive</span>`;
			}
		},
	},
	{
		data: "BUYER",
		name: "BUYER",
		title: "BUYER",
		width: "300px",
		render: function (data, type, row) {
			if (!row.BUYER) {
				return `<span class="text-gray-400">N/A</span>`;
			}
			return `<div class="flex gap-5 items-center">
                <div class="avatar border-0 tooltip-html tooltip-primary" data-html="${row.BUYERNAME} (${row.BUYER})">
                    <div class="w-10 ring-primary ring-offset-base-100 rounded-full ring-2 ring-offset-2">
                        <img src="${row.BUYER_IMAGE}" class="" />
                    </div>
                </div>
                <span>${row.BUYERNAME}</span>
            </div>
                `;
		},
	},
	{
		data: null,
		name: "ACTIONS",
		title: "ACTIONS",
		width: "100px",
		searchable: false,
		orderable: false,
		className: "text-center",
		render: function (data, type, row) {
			return `<label for="modal-item-master" class="btn btn-sm btn-ghost btn-circle text-lg text-primary hover:text-xl actions">
                <i class="fi fi-rr-settings-sliders"></i>
            </label>`;
		},
	},
];
