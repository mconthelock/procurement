import { defineConfig } from "vitepress";
import { fileURLToPath, URL } from "node:url";
import dotenv from "dotenv";
import * as sidebar from "./sidebar.js";
dotenv.config();

export default defineConfig({
	vite: {
		clearScreen: false,
		resolve: {
			alias: [
				{
					find: /^.*\/VPSidebarGroup\.vue$/,
					replacement: fileURLToPath(
						new URL(
							"./theme/components/VPSidebarGroup.vue",
							import.meta.url,
						),
					),
				},
			],
		},
	},
	title: "AMEC Procurement System",
	head: [
		[
			"link",
			{
				rel: "icon",
				href: `${process.env.VITE_APP_HOST || ``}/assets/images/icon_512.png`,
			},
		],
	],
	outDir: "dist",
	base: "/procurement/docs/",
	markdown: { image: { lazyLoading: true } },
	themeConfig: {
		auth: {
			appName: process.env.APP_NAME || "procurement",
			appId: process.env.APP_ID || "",
			appHost: process.env.APP_HOST || "",
			appEnv: process.env.APP_ENV || process.env.VITE_APP_HOST || "/procurement",
			appApi: process.env.APP_API || "",
		},
		logo: `${process.env.VITE_APP_HOST || ""}/assets/images/icon_512.png`,
		search: {
			provider: "local",
		},
		nav: [
			{ text: "Home", link: "/" },
			{ text: "Guide", link: "/quick-start" },
		],
		sidebar: {
			"/": [
				{ text: "Quick Start", link: "/quick-start", roles: ["*"] },
				{
					text: "P/R Management",
					link: "/pr/create",
					roles: ["ADMIN", "REQUESTER", "APPROVER", "BUYER"],
				},
				{
					text: "P/O Management",
					link: "/po/issue",
					roles: ["ADMIN", "BUYER", "APPROVER"],
				},
				{
					text: "Receiving",
					link: "/receive/receive",
					roles: ["ADMIN", "WAREHOUSE", "BUYER", "ACCOUNTING"],
				},
				{
					text: "Products and Inventory",
					link: "/product/product",
					roles: ["ADMIN", "BUYER", "WAREHOUSE"],
				},
				{
					text: "Vendor Management",
					link: "/vendor/vendor",
					roles: ["ADMIN", "BUYER", "APPROVER"],
				},
				{
					text: "Report",
					link: "/report/order",
					roles: ["ADMIN", "BUYER", "APPROVER", "ACCOUNTING", "WAREHOUSE"],
				},
			],
			"/pr/": sidebar.prItem,
			"/po/": sidebar.poItem,
			"/receive/": sidebar.receiveItem,
			"/product/": sidebar.productItem,
			"/vendor/": sidebar.vendorItem,
			"/report/": sidebar.reportItem,
		},
	},
	// ควบคุม หน้า index.md จาก env
	transformPageData(pageData) {
		if (pageData.relativePath === "index.md") {
			pageData.frontmatter ||= {};
			pageData.frontmatter.hero = {
				...(pageData.frontmatter.hero || {}),
				name: process.env.VITE_APP_NAME || "AMEC Procurement System",
				text: process.env.VITE_APP_TEXT || "Manual",
				tagline:
					process.env.VITE_APP_TAGLINE ||
					"Powered by VitePress + custom theme",
				actions: [
					{
						theme: "brand",
						text: "Getting Started",
						link: process.env.VITE_APP_HOST || "/",
					},
					{
						theme: "alt",
						text: "User Guide",
						link: "/quick-start",
					},
				],
			};
		}
	},
});
