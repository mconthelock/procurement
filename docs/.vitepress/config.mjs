import { defineConfig } from "vitepress";
import dotenv from "dotenv";
import * as sidebar from "./sidebar.js";
dotenv.config();

export default defineConfig({
	vite: { clearScreen: false },
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
				{ text: "Quick Start", link: "/quick-start" },
				{
					text: "P/R Management",
					link: "/pr/create",
				},
				{
					text: "P/O Management",
					link: "/po/issue",
				},
				{
					text: "Receiving",
					link: "/receive/receive",
				},
				{
					text: "Products and Inventory",
					link: "/product/product",
				},
				{
					text: "Vendor Management",
					link: "/vendor/vendor",
				},
				{
					text: "Report",
					link: "/report/order",
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
