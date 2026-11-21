const quickStartItem = {
	text: "Back to Home",
	link: "/quick-start",
	roles: ["*"],
};

const pr = [
	{
		text: "P/R Management",
		collapsed: false,
		roles: ["ADMIN", "REQUESTER", "APPROVER", "BUYER"],
		items: [
			{
				text: "Create P/R",
				link: "/pr/create",
				roles: ["ADMIN", "REQUESTER", "APPROVER", "BUYER"],
			},
			{
				text: "Wait for Approval",
				link: "/pr/approval",
				roles: ["ADMIN", "APPROVER", "BUYER"],
			},
			{
				text: "Coming soon",
				link: "/pr/comming",
				roles: ["ADMIN", "REQUESTER", "APPROVER", "BUYER"],
			},
			{
				text: "Mine",
				link: "/pr/mine",
				roles: ["ADMIN", "REQUESTER", "APPROVER", "BUYER"],
			},
		],
	},
];

const po = [
	{
		text: "P/O Management",
		collapsed: false,
		roles: ["ADMIN", "BUYER", "APPROVER"],
		items: [
			{
				text: "Issue P/O",
				link: "/po/issue",
				roles: ["ADMIN", "BUYER"],
			},
			{
				text: "Wait for Approval",
				link: "/po/approve",
				roles: ["ADMIN", "APPROVER", "BUYER"],
			},
			{
				text: "Mine",
				link: "/po/mine",
				roles: ["ADMIN", "BUYER", "APPROVER"],
			},
			{
				text: "Awaiting Delivery",
				link: "/po/wait",
				roles: ["ADMIN", "BUYER", "APPROVER"],
			},
			{
				text: "Canceled P/O",
				link: "/po/canceled",
				roles: ["ADMIN", "BUYER", "APPROVER"],
			},
		],
	},
];

const product = [
	{
		text: "Products and Inventory",
		collapsed: false,
		roles: ["ADMIN", "BUYER", "WAREHOUSE"],
		items: [
			{
				text: "Product List",
				link: "/product/product",
				roles: ["ADMIN", "BUYER", "WAREHOUSE"],
			},
			{
				text: "Category",
				link: "/product/category",
				roles: ["ADMIN", "BUYER"],
			},
		],
	},
];

const receive = [
	{
		text: "Receiving",
		collapsed: false,
		roles: ["ADMIN", "WAREHOUSE", "BUYER", "ACCOUNTING"],
		items: [
			{
				text: "WH Receive",
				link: "/receive/receive",
				roles: ["ADMIN", "WAREHOUSE", "BUYER"],
			},
			{
				text: "Receiving Plan",
				link: "/receive/plan",
				roles: ["ADMIN", "WAREHOUSE", "BUYER"],
			},
			{
				text: "Invoice/Tax",
				link: "/receive/invoice",
				roles: ["ADMIN", "ACCOUNTING", "BUYER"],
			},
		],
	},
];

const report = [
	{
		text: "Report",
		collapsed: false,
		roles: ["ADMIN", "BUYER", "APPROVER", "ACCOUNTING", "WAREHOUSE"],
		items: [
			{
				text: "Orders Report",
				link: "/report/order",
				roles: ["ADMIN", "BUYER", "APPROVER"],
			},
			{
				text: "Receiving Report",
				link: "/report/receive",
				roles: ["ADMIN", "WAREHOUSE", "BUYER", "ACCOUNTING"],
			},
			{
				text: "Matching Report",
				link: "/report/matching",
				roles: ["ADMIN", "ACCOUNTING", "BUYER"],
			},
			{
				text: "Inventory Report",
				link: "/report/inventory",
				roles: ["ADMIN", "WAREHOUSE", "BUYER"],
			},
			{
				text: "Running Orders",
				link: "/report/running",
				roles: ["ADMIN", "BUYER", "APPROVER"],
			},
		],
	},
];

const vendor = [
	{
		text: "Vendor Management",
		collapsed: false,
		roles: ["ADMIN", "BUYER", "APPROVER"],
		items: [
			{
				text: "Vendor List",
				link: "/vendor/vendor",
				roles: ["ADMIN", "BUYER"],
			},
			{
				text: "Approving Vendor",
				link: "/vendor/approve",
				roles: ["ADMIN", "APPROVER", "BUYER"],
			},
			{
				text: "SCM users",
				link: "/vendor/users",
				roles: ["ADMIN", "BUYER"],
			},
			{
				text: "Technical Spec (Admin)",
				link: "/vendor/tech-spec",
				roles: ["ADMIN"],
			},
		],
	},
];

export const prItem = [...pr, quickStartItem];
export const poItem = [...po, quickStartItem];
export const productItem = [...product, quickStartItem];
export const receiveItem = [...receive, quickStartItem];
export const reportItem = [...report, quickStartItem];
export const vendorItem = [...vendor, quickStartItem];
