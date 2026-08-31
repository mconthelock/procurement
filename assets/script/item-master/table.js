import { createTable, destroyTable } from "@amec/webasset/dataTable";
// import { createTable, destroyTable } from './datatable5';
import { dataTableSkeleton } from "@amec/webasset/skeleton";
import { getItemMaster } from "./data";
import { showErrorMessage } from "@amec/webasset/utils";

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
	},
	async create() {
		try {
			return await createTable(
				{
					columns: columns,
					processing: true,
					serverSide: true,
					responsive: false,
					searching: false,
					ordering: false,
					lengthMenu: [15, 25, 50, 100],
					ajax: async function (data, callback, settings) {
						try {
							const response = await getItemMaster(data);
							callback(response);
						} catch (error) {
							console.error("Error fetching item master data:", error);
							callback({
								data: [],
								recordsTotal: 0,
								recordsFiltered: 0,
							});
							showErrorMessage(error.message || "Failed to fetch item master data.");
						}
					},
				},
				{
					id: this.tableId,
					domScroll: {
						status: true,
						maxHeight: "50vh",
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
};

const columns = [
	{
		data: "ITEM",
		name: "ITEM",
		title: "PURCODE",
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
		data: "BUYER",
		name: "BUYER",
		title: "BUYER",
	},
];
