import { getCountries } from "@amec/webasset/api/countries";
import { createModal, setModal } from "@amec/webasset/components/modal";
import { showLoader } from "@amec/webasset/preloader";
import { setSelect2 } from "@amec/webasset/select2";
import { requiredForm, showErrorMessage, showMessage } from "@amec/webasset/utils";
import { saveOrigin } from "./data";
import { tableItemMaster } from "./table";
import { currentUser } from "@amec/webasset/api/amec";

export const modalItemMaster = {
	id: "modal-item-master",
	_data: null,
	get data() {
		return this._data;
	},
	set data(value) {
		this._data = value;
		setModal({
			id: this.id,
			body: setBody(value),
		});
	},
	show(isShow) {
		$("#" + this.id).prop("checked", isShow ? "checked" : false);
	},
	init: async function () {
		const modal = createModal({
			id: this.id,
			headerDivider: false,
			footerDivider: false,
			className: "min-w-[80vw] self-start mt-[1%]",
		});
		$("body").append(modal);
		this.bindEvent();
	},
	reset: function () {
		setModal({
			id: this.id,
			body: ``,
		});
	},
	bindEvent: function () {
		const self = this;
		$(document)
			.off("click.set-origin", "#set-origin")
			.on("click.set-origin", "#set-origin", async function () {
				try {
					$("#country-info").html(countryInfo(self.data, true));
					const country = await getCountries({
						excluded: ["NORTH KOREA"],
						transform: [{ from: "SOUTH KOREA", to: "KOREA" }],
					});
					const countryData = (country ?? []).map((item) => {
						return {
							id: item.name_en.toUpperCase(),
							text: item.name_en.toUpperCase(),
							flag: item.flag.png,
						};
					});
					await setSelect2({
						id: "origin-country",
						data: countryData,
						flag: true,
						defaultValue: self.data.COUNTRY,
					});
					await setSelect2({
						id: "origin-type",
						data: originTypeOptions,
						search: false,
						defaultValue: self.data.ORIGIN_TYPE,
					});
				} catch (error) {
					console.error("Error setting origin:", error);
					showErrorMessage(error.message);
				}
			});
		$(document)
			.off("click.save-origin", "#save-origin")
			.on("click.save-origin", "#save-origin", async function () {
				try {
					showLoader();
					if (!requiredForm("#country-info")) {
						return;
					}
					const country = $("#origin-country").val();
					const originType = $("#origin-type").val();
					const mfgName = $("#mfg-name").val();
					const mfgAddress = $("#mfg-address").val();
					const predata = {
						BULKCODE: self.data.ITEM,
						ORIGIN_TYPE: originType,
						COUNTRY: country,
						MFG_NAME: mfgName,
						MFG_ADDRESS: mfgAddress,
					};
					const user = await currentUser();
					if (self.data.COUNTRY) {
						predata.UPDATEBY = user.empno;
						predata.UPDATEDATE = new Date();
					} else {
						predata.CREATEBY = user.empno;
					}
					const res = await saveOrigin(predata);
					if (!res.status) {
						throw new Error(res.message);
					}
					const data = {
						...self.data,
						COUNTRY: country,
						ORIGIN_TYPE: originType,
						MFG_NAME: mfgName,
						MFG_ADDRESS: mfgAddress,
					};
					showMessage("Country origin saved successfully.", "success");
					tableItemMaster.updateRow(data.ITEM, data);
					self.data = data;
				} catch (error) {
					console.error("Error saving origin:", error);
					showErrorMessage(error.message);
				} finally {
					showLoader({ show: false });
				}
			});
		$(document)
			.off("click.cancel-origin", "#cancel-origin")
			.on("click.cancel-origin", "#cancel-origin", function () {
				try {
					$("#country-info").html(countryInfo(self.data, false));
				} catch (error) {
					console.error("Error canceling origin edit:", error);
					showErrorMessage(error.message);
				}
			});
	},
};

function setBody(data) {
	return `
            <div class="flex gap-5">
                <div class="flex flex-col gap-5 w-full">
                <div class="border rounded w-full p-5">
                    <h2 class="text-2xl font-bold text-center mb-5">Item Information</h2>
                    <div class="flex flex-col gap-5">
                        <div class="flex gap-5">
                            <span class="font-bold">ITEM</span>
                            <span>${data.ITEM}</span>
                            <span>${data.PARTNAME}</span>
                        </div>
                        <div class="grid grid-cols-2 xl:grid-cols-6 gap-2">
                            <span class="font-bold">GROUP</span>
                            <span>${data.GROUPCODE}</span>
                            <span class="font-bold text-nowrap">U/M SALES</span>
                            <span>${data.UMSALE}</span>
                            <span class="font-bold text-nowrap">U/M PURCH</span>
                            <span>${data.UMPURCH}</span>
                        </div>
                        <div class="grid grid-cols-2 xl:grid-cols-6 gap-2">
                            <span class="font-bold">CLASS</span>
                            <span>${data.CLASS}</span>
                            <span class="font-bold text-nowrap">U/M STOCK</span>
                            <span>${data.UMSTOCK}</span>
                            <span class="font-bold text-nowrap">YIELD PCT</span>
                            <span>${data.YIELD}</span>
                        </div>
                        <div class="grid grid-cols-2 xl:grid-cols-[auto_1fr_auto_auto] gap-2">
                            <span class="font-bold">TYPE</span>
                            <span>${data.TYPE}</span>
                            <span class="font-bold text-nowrap">DRAW/FORMULA # </span>
                            <span>${data.DRAW_FORMULA}</span>
                        </div>
                        <div class="grid grid-cols-[auto_1fr] gap-2">
                            <span class="font-bold text-nowrap">Ref #/Desc </span>
                            <span>${data.REFDESC}</span>
                            <span class="font-bold text-nowrap">Extra Desc </span>
                            <span>${data.EXTRADESC}</span>
                        </div>
                    </div>
                    <table class="table table-sm" id="sales-info">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="underline">MTD</th>
                                <th class="underline">YTD</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${salesInfo(data)
								.map(
									(item) => `
                                <tr>
                                    <td class="font-bold">${item.text}</td>
                                    <td>${item.mtd}</td>
                                    <td>${item.ytd}</td>
                                </tr>
                            `,
								)
								.join("")}
                        </tbody>
                    </table>
                </div>
                    <div class="border rounded p-5 min-w-48 w-full h-full">
                        <div class="flex flex-col gap-3">
                            ${venderInfo(data)
								.map(
									(item) => `
                                    <div class="flex justify-between gap-5">
                                        <span class="font-bold">${item.text}</span>
                                        <span>${item.value}</span>
                                    </div>
                                    `,
								)
								.join("")}
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-5 w-fit">
                    <div class="border rounded w-full">
                        <div class="w-full p-5">
                            <h2 class="text-2xl font-bold text-center mb-5 flex gap-3 items-center">
                                <span class="text-nowrap">Country of origin</span>
                                <button class="btn btn-sm btn-neutral" id="set-origin"><i class="fi fi-rr-edit text-lg"></i></button>
                            </h2>
                            <div class="flex flex-col gap-3" id="country-info">
                                ${countryInfo(data)}
                            </div>
                        </div>
                    </div>
                    <div class="border rounded p-5 min-w-48 w-full h-fit">
                        <div class="flex flex-col gap-3">
                            ${itemStatus(data)
								.map(
									(item) => `
                            <div class="flex justify-between gap-5">
                                <span class="font-bold">${item.text}</span>
                                <span>${item.value}</span>
                            </div>
                            `,
								)
								.join("")}
                        </div>   
                    </div>
                    <div class="border rounded p-5 min-w-48 w-full h-full">
                        <div class="flex flex-col gap-3">
                            ${planningParams(data)
								.map(
									(item) => `
                                    <div class="flex justify-between gap-5">
                                        <span class="font-bold text-nowrap">${item.text}</span>
                                        <span>${item.value}</span>
                                    </div>
                                    `,
								)
								.join("")}
                        </div>
                    </div>
                </div>
                
            </div>
        `;
}

const originTypeOptions = [
	{ id: 1, text: "Trading" },
	{ id: 2, text: "Process" },
	{ id: 3, text: "Manufacturing" },
];

function countryInfo(data, editable = false) {
	let country = `<span>${data.COUNTRY || "-"}</span>`;
	let originType = `<span>${originTypeOptions.find((option) => option.id == data.ORIGIN_TYPE)?.text || "-"}</span>`;
	let mfgName = `<span>${data.MFG_NAME || "-"}</span>`;
	let mfgAddress = `<span>${data.MFG_ADDRESS || "-"}</span>`;
	let btn = "";
	if (editable) {
		country = `<select id="origin-country" class="select w-full req" name="country" placeholder="Select Country" data-message="Please select a country"></select>`;
		originType = `<select id="origin-type" class="select w-full req" name="origin-type" placeholder="Select Origin Type" data-message="Please select an origin type"></select>`;
		mfgName = `<textarea id="mfg-name" name="mfg-name" class="textarea w-full" placeholder="Enter Manufacturer Name">${data.MFG_NAME || ""}</textarea>`;
		mfgAddress = `<textarea id="mfg-address" name="mfg-address" class="textarea w-full" placeholder="Enter Manufacturer Address">${data.MFG_ADDRESS || ""}</textarea>`;
		btn = `
        <button class="btn btn-primary w-full" id="save-origin">Save</button>
        <button class="btn btn-neutral w-full" id="cancel-origin">Cancel</button>
        `;
	}
	return `<label class="fieldset w-full" for="origin-country">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Country</legend>
                ${country}
            </label>
            <label class="fieldset w-full" for="origin-type">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Type</legend>
                ${originType}
            </label>
            <label class="fieldset w-full" for="mfg-name">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Manufacturer Name</legend>
                ${mfgName}
            </label>
            <label class="fieldset w-full" for="mfg-address">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Manufacturer Address</legend>
                ${mfgAddress}
            </label>
            ${btn}`;
}

const itemStatus = (data) => [
	{
		text: "ON HAND",
		value: data.ONHAND || "-",
	},
	{
		text: "MFG. ALLOC",
		value: data.MFG_ALLOC || "-",
	},
	{
		text: "AVAILABLE",
		value: data.AVAILABLE || "-",
	},
];

const venderInfo = (data) => [
	{
		text: "VENDERS",
		value: data.VENDOR || "-",
	},
	{
		text: "VENDERS ITEM #",
		value: data.VENDOR_NAME || "-",
	},
];

const planningParams = (data) => [
	{
		text: "LOT SIZE STD.",
		value: data.LOT_SIZE || "",
	},
	{
		text: "STD BATCH SIZE",
		value: data.BATCH_SIZE || "",
	},
	{
		text: "DAILY LEAD TIME RATE",
		value: data.DAILY_TIME_RATE || "",
	},
	{
		text: "FIXED LEAD TIME DAYS",
		value: data.FIXED_TIME_DAYS || "",
	},
	{
		text: "ORDER POLICY CODE",
		value: data.ORDER_POLICY_CODE || "",
	},
	{
		text: "HORIZON DAYS",
		value: data.HORIZON_DAYS || "",
	},
	{
		text: "PERIOD ORDER DAYS",
		value: data.PERIOD_ORDER_DAYS || "",
	},
	{
		text: "BUYER CODE",
		value: data.BUYER_CODE || "",
	},
	{
		text: "PLANNER CODE",
		value: data.PLANNER || "",
	},
	{
		text: "MINIMUM BALANCE",
		value: data.MINIMUM_BALANCE || "",
	},
];

const salesInfo = (data) => [
	{
		text: "OPENING BALANCE",
		mtd: data.OPEN_BALANCE || "",
		ytd: "",
	},
	{
		text: "ISSUE",
		mtd: data.ISSUES_MTD || "",
		ytd: data.ISSUES_YTD || "",
	},
	{
		text: "RECEIPTS",
		mtd: data.RECEIPTS_MTD || "",
		ytd: data.RECEIPTS_YTD || "",
	},
	{
		text: "ADJUSTMENTS",
		mtd: data.ADJUSTMENTS_MTD || "",
		ytd: data.ADJUSTMENTS_YTD || "",
	},
	{
		text: "SALES UNITS",
		mtd: data.SALEUNIT_MTD || "",
		ytd: data.SALEUNIT_YTD || "",
	},
	{
		text: "SALED AMT",
		mtd: data.SALEAMOUNT_MTD || "",
		ytd: data.SALEAMOUNT_YTD || "",
	},
	{
		text: "ADDRESS(F6:ALL)",
		mtd: data.ADDRESS || "",
		ytd: "",
	},
	{
		text: "LIST PRICE",
		mtd: data.LISTPRICE || "",
		ytd: "",
	},
	{
		text: "STD. COST",
		mtd: data.STANDARD_COST || "",
		ytd: "",
	},
	{
		text: "ACTUAL COST",
		mtd: data.ACTUAL_COST || "",
		ytd: "",
	},
	{
		text: "DISCOUNT CODE",
		mtd: data.DISCOUNT_CODE || "",
		ytd: "",
	},
	{
		text: "PURCH U/M CNV",
		mtd: data.PURCHUM_CNV || "",
		ytd: "",
	},
	{
		text: "SALES U/M CNV",
		mtd: data.SALEUM_CNV || "",
		ytd: "",
	},
];
