export const STATUS_CONFIG = {
	AWAITING_CONFIRMATION: {
		label: "Awaiting Confirmation",
		badge: "badge-error",
	},
	IN_PRODUCTION: {
		label: "In Production",
		badge: "badge-warning",
	},
	READY_TO_SHIP: {
		label: "Ready to Ship",
		badge: "badge-success",
	},
	IN_TRANSIT: {
		label: "In Transit (ASN)",
		badge: "badge-info",
	},
	DELIVERED: {
		label: "Delivered",
		badge: "badge-ghost",
	},
};

export const PRIORITY_CONFIG = {
	URGENT: {
		label: "Urgent < 24h",
		badge: "badge-error",
	},
	EXPEDITED: {
		label: "Expedited",
		badge: "badge-warning",
	},
	NORMAL: {
		label: "Standard",
		badge: "badge-ghost",
	},
};

export const SAMPLE_ORDERS = [
	{
		PO_NO: "PO-2026-0892",
		PO_REV: "02",
		ISSUE_DATE: "2026-11-17",
		TARGET_DELIVERY: "2026-11-24",
		VND_CODE: "V-884029-TH",
		VND_NAME: "Siam Precision Engineering Co., Ltd.",
		PLANT_CODE: "AMEC-P1",
		PLANT_NAME: "Amata City Chonburi Plant 01",
		DOCK_BAY: "Dock C4 (Receiving Gate 2)",
		PART_NO: "ELV-FRAME-SS304",
		PART_DESC: "Hoistway Door Jamb Frame SUS304 Hairline 2100mm",
		ORDER_QTY: 480,
		UNIT: "PCS",
		UNIT_PRICE: 4200.0,
		TOTAL_AMOUNT: 3040512.0,
		CURRENCY: "THB",
		PAYMENT_TERMS: "Net 30 Days",
		INCOTERMS: "DDP Amata City",
		PRIORITY: "URGENT",
		PO_STATUS: "AWAITING_CONFIRMATION",
		BUYER_NAME: "S. Narongrit (Dept 4)",
		ASN_NO: "",
		ECN_NO: "ECN-2026-114B",
		REMARKS:
			"Urgent production lot for Project Tower-B. Electronic acknowledgment required within 24 hours.",
		ITEMS: [
			{
				LINE_NO: 1,
				PART_NO: "ELV-FRAME-SS304",
				ECN_NO: "ECN-2026-114B",
				PART_DESC: "Hoistway Door Jamb Frame SUS304 Hairline 2100mm",
				ORDER_QTY: 480,
				UNIT: "PCS",
				UNIT_PRICE: 4200.0,
				LINE_TOTAL: 2016000.0,
			},
			{
				LINE_NO: 2,
				PART_NO: "ELV-TRANSOM-304",
				ECN_NO: "ECN-2026-114B",
				PART_DESC: "Upper Transom Header Panel SUS304 1100mm",
				ORDER_QTY: 480,
				UNIT: "PCS",
				UNIT_PRICE: 1650.0,
				LINE_TOTAL: 792000.0,
			},
			{
				LINE_NO: 3,
				PART_NO: "ELV-CLIP-M8-KIT",
				ECN_NO: "ECN-2026-102A",
				PART_DESC: "Jamb Mounting Bracket & Fastener Kit M8",
				ORDER_QTY: 240,
				UNIT: "SET",
				UNIT_PRICE: 968.8,
				LINE_TOTAL: 232512.0,
			},
		],
	},
	{
		PO_NO: "PO-2026-0889",
		PO_REV: "01",
		ISSUE_DATE: "2026-11-15",
		TARGET_DELIVERY: "2026-11-26",
		VND_CODE: "V-550124-TH",
		VND_NAME: "Thai Sumitomo Electric Wiring Systems Co., Ltd.",
		PLANT_CODE: "AMEC-P2",
		PLANT_NAME: "Amata City Chonburi Plant 02",
		DOCK_BAY: "Dock E1 (Electrical Hub)",
		PART_NO: "HRN-SAFE-420A",
		PART_DESC: "Hoistway Safety Circuit Wire Harness Assembly 420V",
		ORDER_QTY: 1200,
		UNIT: "SET",
		UNIT_PRICE: 1150.0,
		TOTAL_AMOUNT: 1740000.0,
		CURRENCY: "THB",
		PAYMENT_TERMS: "Net 45 Days",
		INCOTERMS: "DDP Amata City",
		PRIORITY: "URGENT",
		PO_STATUS: "AWAITING_CONFIRMATION",
		BUYER_NAME: "K. Apinya (Dept 3)",
		ASN_NO: "",
		ECN_NO: "ECN-2026-098A",
		REMARKS:
			"Include RoHS compliance certificate and lot traceability barcode label on each carton.",
		ITEMS: [
			{
				LINE_NO: 1,
				PART_NO: "HRN-SAFE-420A",
				ECN_NO: "ECN-2026-098A",
				PART_DESC: "Hoistway Safety Circuit Wire Harness Assembly 420V",
				ORDER_QTY: 1000,
				UNIT: "SET",
				UNIT_PRICE: 1260.0,
				LINE_TOTAL: 1260000.0,
			},
			{
				LINE_NO: 2,
				PART_NO: "HRN-INTERCOM-12",
				ECN_NO: "ECN-2026-098A",
				PART_DESC: "Car-to-Machine Room Shielded Intercom Cable 12-Core",
				ORDER_QTY: 400,
				UNIT: "SET",
				UNIT_PRICE: 1200.0,
				LINE_TOTAL: 480000.0,
			},
		],
	},
	{
		PO_NO: "PO-2026-0875",
		PO_REV: "01",
		ISSUE_DATE: "2026-11-10",
		TARGET_DELIVERY: "2026-12-03",
		VND_CODE: "V-671044-TH",
		VND_NAME: "Eastern Precision Casting Co., Ltd.",
		PLANT_CODE: "AMEC-P1",
		PLANT_NAME: "Amata City Chonburi Plant 01",
		DOCK_BAY: "Dock H2 (Heavy Foundry Bay)",
		PART_NO: "TRN-SHEAVE-520",
		PART_DESC: "Traction Machine Sheave Cast Iron FCD500 Ø520mm",
		ORDER_QTY: 160,
		UNIT: "PCS",
		UNIT_PRICE: 18250.0,
		TOTAL_AMOUNT: 2920000.0,
		CURRENCY: "THB",
		PAYMENT_TERMS: "Net 30 Days",
		INCOTERMS: "DDP Amata City",
		PRIORITY: "NORMAL",
		PO_STATUS: "IN_PRODUCTION",
		BUYER_NAME: "S. Narongrit (Dept 4)",
		ASN_NO: "",
		ECN_NO: "ECN-2026-072C",
		REMARKS:
			"Ultrasonic NDT inspection report required prior to shipment release.",
		ITEMS: [
			{
				LINE_NO: 1,
				PART_NO: "TRN-SHEAVE-520",
				ECN_NO: "ECN-2026-072C",
				PART_DESC: "Traction Machine Sheave Cast Iron FCD500 Ø520mm",
				ORDER_QTY: 160,
				UNIT: "PCS",
				UNIT_PRICE: 18250.0,
				LINE_TOTAL: 2920000.0,
			},
		],
	},
	{
		PO_NO: "PO-2026-0864",
		PO_REV: "03",
		ISSUE_DATE: "2026-11-08",
		TARGET_DELIVERY: "2026-11-29",
		VND_CODE: "V-80018-TH",
		VND_NAME: "Chokchai Engineering Co., Ltd.",
		PLANT_CODE: "AMEC-P2",
		PLANT_NAME: "Amata City Chonburi Plant 02",
		DOCK_BAY: "Dock B3 (Press & Stamping)",
		PART_NO: "BRK-GUIDE-T89",
		PART_DESC: "Rail Guide Bracket Stamped Steel 6mm Galvanized",
		ORDER_QTY: 3600,
		UNIT: "PCS",
		UNIT_PRICE: 285.0,
		TOTAL_AMOUNT: 1026000.0,
		CURRENCY: "THB",
		PAYMENT_TERMS: "Net 30 Days",
		INCOTERMS: "DDP Amata City",
		PRIORITY: "EXPEDITED",
		PO_STATUS: "IN_PRODUCTION",
		BUYER_NAME: "P. Sukcharoen (Dept 2)",
		ASN_NO: "",
		ECN_NO: "ECN-2026-061A",
		REMARKS:
			"Palletized in returnable steel racks (120 PCS/rack) per AMEC packaging standard.",
		ITEMS: [
			{
				LINE_NO: 1,
				PART_NO: "BRK-GUIDE-T89",
				ECN_NO: "ECN-2026-061A",
				PART_DESC: "Rail Guide Bracket Stamped Steel 6mm Galvanized",
				ORDER_QTY: 2000,
				UNIT: "PCS",
				UNIT_PRICE: 265.0,
				LINE_TOTAL: 530000.0,
			},
			{
				LINE_NO: 2,
				PART_NO: "BRK-CLIP-T89",
				ECN_NO: "ECN-2026-061A",
				PART_DESC: "Rail Retaining Clip Forged Steel T89-B",
				ORDER_QTY: 4000,
				UNIT: "PCS",
				UNIT_PRICE: 74.0,
				LINE_TOTAL: 296000.0,
			},
			{
				LINE_NO: 3,
				PART_NO: "PLT-SHIM-2MM",
				ECN_NO: "ECN-2026-058C",
				PART_DESC: "Alignment Shim Plate 2.0mm Zinc Plated",
				ORDER_QTY: 4000,
				UNIT: "PCS",
				UNIT_PRICE: 25.0,
				LINE_TOTAL: 100000.0,
			},
			{
				LINE_NO: 4,
				PART_NO: "PLT-FISH-T89",
				ECN_NO: "ECN-2026-061A",
				PART_DESC: "Guide Rail Fishplate Joint Bar T89",
				ORDER_QTY: 500,
				UNIT: "PCS",
				UNIT_PRICE: 200.0,
				LINE_TOTAL: 100000.0,
			},
		],
	},
	{
		PO_NO: "PO-2026-0851",
		PO_REV: "01",
		ISSUE_DATE: "2026-11-04",
		TARGET_DELIVERY: "2026-11-23",
		VND_CODE: "V-399102-TH",
		VND_NAME: "Nippon Sanso Gas & Metal Co. (Thailand)",
		PLANT_CODE: "AMEC-P1",
		PLANT_NAME: "Amata City Chonburi Plant 01",
		DOCK_BAY: "Dock A1 (Laser & Sheet Metal)",
		PART_NO: "CAB-PANEL-SPCC",
		PART_DESC: "Elevator Car Side Wall Panel Laser Cut SPCC 1.6t",
		ORDER_QTY: 640,
		UNIT: "PCS",
		UNIT_PRICE: 2150.0,
		TOTAL_AMOUNT: 1376000.0,
		CURRENCY: "THB",
		PAYMENT_TERMS: "Net 30 Days",
		INCOTERMS: "DDP Amata City",
		PRIORITY: "NORMAL",
		PO_STATUS: "READY_TO_SHIP",
		BUYER_NAME: "P. Sukcharoen (Dept 2)",
		ASN_NO: "ASN-2026-4410",
		ECN_NO: "ECN-2026-055A",
		REMARKS:
			"Final QC passed. Ready for morning milk-run pickup at 08:30 ICT.",
		ITEMS: [
			{
				LINE_NO: 1,
				PART_NO: "CAB-PANEL-SPCC",
				ECN_NO: "ECN-2026-055A",
				PART_DESC: "Elevator Car Side Wall Panel Laser Cut SPCC 1.6t",
				ORDER_QTY: 440,
				UNIT: "PCS",
				UNIT_PRICE: 2150.0,
				LINE_TOTAL: 946000.0,
			},
			{
				LINE_NO: 2,
				PART_NO: "CAB-CEIL-SPCC",
				ECN_NO: "ECN-2026-055A",
				PART_DESC: "Elevator Car Ceiling Support Frame SPCC 2.0t",
				ORDER_QTY: 200,
				UNIT: "PCS",
				UNIT_PRICE: 2150.0,
				LINE_TOTAL: 430000.0,
			},
		],
	},
	{
		PO_NO: "PO-2026-0840",
		PO_REV: "01",
		ISSUE_DATE: "2026-10-29",
		TARGET_DELIVERY: "2026-11-22",
		VND_CODE: "V-10003-JP",
		VND_NAME: "Mitsubishi Electric Trading Corporation (MT-S)",
		PLANT_CODE: "AMEC-WH",
		PLANT_NAME: "AMEC Central Logistics Warehouse",
		DOCK_BAY: "Dock G1 (Import Bonded Bay)",
		PART_NO: "PCB-INV-G200",
		PART_DESC: "Inverter Control Board Series-G 200kW Module",
		ORDER_QTY: 85,
		UNIT: "UNIT",
		UNIT_PRICE: 24800.0,
		TOTAL_AMOUNT: 2108000.0,
		CURRENCY: "THB",
		PAYMENT_TERMS: "Net 60 Days",
		INCOTERMS: "CIF Laem Chabang",
		PRIORITY: "EXPEDITED",
		PO_STATUS: "IN_TRANSIT",
		BUYER_NAME: "K. Apinya (Global Elec.)",
		ASN_NO: "ASN-2026-4398",
		ECN_NO: "ECN-2026-049D",
		REMARKS:
			"ESD-safe vacuum packaging verified. Dispatched via Laem Chabang express customs lane.",
		ITEMS: [
			{
				LINE_NO: 1,
				PART_NO: "PCB-INV-G200",
				ECN_NO: "ECN-2026-049D",
				PART_DESC: "Inverter Control Board Series-G 200kW Module",
				ORDER_QTY: 85,
				UNIT: "UNIT",
				UNIT_PRICE: 24800.0,
				LINE_TOTAL: 2108000.0,
			},
		],
	},
	{
		PO_NO: "PO-2026-0812",
		PO_REV: "01",
		ISSUE_DATE: "2026-10-18",
		TARGET_DELIVERY: "2026-11-12",
		VND_CODE: "V-718290-TH",
		VND_NAME: "Rayong Stamping & Tooling Co., Ltd.",
		PLANT_CODE: "AMEC-P2",
		PLANT_NAME: "Amata City Chonburi Plant 02",
		DOCK_BAY: "Dock B1 (Door Systems)",
		PART_NO: "SILL-AL6063-1100",
		PART_DESC: "Landing Door Sill Extruded Aluminum 1100mm",
		ORDER_QTY: 900,
		UNIT: "PCS",
		UNIT_PRICE: 920.0,
		TOTAL_AMOUNT: 828000.0,
		CURRENCY: "THB",
		PAYMENT_TERMS: "Net 30 Days",
		INCOTERMS: "DDP Amata City",
		PRIORITY: "NORMAL",
		PO_STATUS: "DELIVERED",
		BUYER_NAME: "P. Sukcharoen (Dept 2)",
		ASN_NO: "ASN-2026-4215",
		ECN_NO: "ECN-2026-031A",
		REMARKS:
			"Goods Receipt GR-2026-9904 completed with zero defect variance.",
		ITEMS: [
			{
				LINE_NO: 1,
				PART_NO: "SILL-AL6063-1100",
				ECN_NO: "ECN-2026-031A",
				PART_DESC: "Landing Door Sill Extruded Aluminum 1100mm",
				ORDER_QTY: 900,
				UNIT: "PCS",
				UNIT_PRICE: 920.0,
				LINE_TOTAL: 828000.0,
			},
		],
	},
];

export function getOrderItems(order) {
	if (Array.isArray(order?.ITEMS) && order.ITEMS.length > 0) {
		return order.ITEMS;
	}
	return [
		{
			LINE_NO: 1,
			PART_NO: order?.PART_NO || "-",
			ECN_NO: order?.ECN_NO || "-",
			PART_DESC: order?.PART_DESC || "-",
			ORDER_QTY: Number(order?.ORDER_QTY || 0),
			UNIT: order?.UNIT || "PCS",
			UNIT_PRICE: Number(order?.UNIT_PRICE || 0),
			LINE_TOTAL: Number(order?.TOTAL_AMOUNT || 0),
		},
	];
}

export function summarizeOrderItems(order) {
	const items = getOrderItems(order);
	const primary = items[0];
	const extraCount = Math.max(0, items.length - 1);
	const totalQty = items.reduce(
		(acc, item) => acc + Number(item.ORDER_QTY || 0),
		0,
	);
	const units = [
		...new Set(items.map((item) => String(item.UNIT || "PCS").toUpperCase())),
	];
	const hasMixedUnits = units.length > 1;
	const sharedUnit = units[0] || "PCS";

	return {
		items,
		primary,
		lineCount: items.length,
		extraCount,
		totalQty,
		hasMixedUnits,
		sharedUnit,
	};
}

export function normalizeStatus(status) {
	const key = String(status || "AWAITING_CONFIRMATION")
		.toUpperCase()
		.trim();
	return STATUS_CONFIG[key] ? key : "AWAITING_CONFIRMATION";
}

export function normalizePriority(priority) {
	const key = String(priority || "NORMAL")
		.toUpperCase()
		.trim();
	return PRIORITY_CONFIG[key] ? key : "NORMAL";
}

export function formatCurrency(amount, currency = "THB") {
	const num = Number(amount || 0);
	const symbol = currency === "USD" ? "$" : currency === "JPY" ? "¥" : "฿";
	return `${symbol}${num.toLocaleString("en-US", {
		minimumFractionDigits: 2,
		maximumFractionDigits: 2,
	})}`;
}

export function formatCompactCurrency(amount) {
	const num = Number(amount || 0);
	if (num >= 1_000_000) {
		return `฿${(num / 1_000_000).toFixed(2)}M THB`;
	}
	return `฿${num.toLocaleString("en-US", {
		minimumFractionDigits: 0,
		maximumFractionDigits: 0,
	})} THB`;
}
