const quickStartItem = { text: "Back to Home", link: "/quick-start" };
const pr = [
	{
		text: "P/R Management",
		collapsed: true,
		items: [
			{ text: "Create P/R", link: "/pr/create" },
			{
				text: "Wait for Approval",
				link: "/pr/approval",
			},
			{
				text: "Conning soon",
				link: "/pr/comming",
			},
			{
				text: "Mine",
				link: "/pr/mine",
			},
		],
	},
];
const po = [
	{
		text: "P/O Management",
		collapsed: true,
		items: [
			{ text: "Issue P/O", link: "/po/issue" },
			{ text: "Wait for Approval", link: "/po/approve" },
			{ text: "Mine", link: "/po/mine" },
			{ text: "Awaiting Delivery", link: "/po/wait" },
			{ text: "Canceled P/O", link: "/po/canceled" },
		],
	},
];
const product = [
	{
		text: "P/O Management",
		collapsed: true,
		items: [
			{ text: "Product List", link: "/product/product" },
			{ text: "Category", link: "/product/category" },
		],
	},
];
const receive = [
	{
		text: "Receiving",
		collapsed: true,
		items: [
			{ text: "WH Receive", link: "/receive/receive" },
			{ text: "Receiving Plan", link: "/receive/plan" },
			{ text: "Invoice/Tax", link: "/receive/invoice" },
		],
	},
];
const report = [
	{
		text: "Report",
		collapsed: true,
		items: [
			{ text: "Orders Report", link: "/report/order" },
			{ text: "Receiving Report", link: "/report/receive" },
			{ text: "Matching Report", link: "/report/matching" },
			{ text: "Inventory Report", link: "/report/inventory" },
			{ text: "Running Orders", link: "/report/running" },
		],
	},
];
const vendor = [
	{
		text: "Vendor Management",
		collapsed: true,
		items: [
			{ text: "Vendor List", link: "/vendor/vendor" },
			{ text: "Approving Vendor", link: "/vendor/approve" },
			{ text: "SCM users", link: "/vendor/users" },
		],
	},
];

export const prItem = [...pr, quickStartItem];
export const poItem = [...po, quickStartItem];
export const productItem = [...product, quickStartItem];
export const receiveItem = [...receive, quickStartItem];
export const reportItem = [...report, quickStartItem];
export const vendorItem = [...vendor, quickStartItem];
