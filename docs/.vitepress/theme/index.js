import DefaultTheme from "vitepress/theme";
import Layout from "./Layout.vue";
import HeroBackground from "./components/HeroBackground.vue";
import LogoModel from "./components/LogoModel.vue";
import WaterBackground from "./components/WaterBackground.vue";
import ProcurementScene from "./components/ProcurementScene.vue";
import RoleOnly from "./components/RoleOnly.vue";
import RoleBadge from "./components/RoleBadge.vue";
import "./custom.css";

export default {
	extends: DefaultTheme,
	Layout,
	enhanceApp({ app }) {
		app.component("HeroBackground", HeroBackground);
		app.component("LogoModel", LogoModel);
		app.component("WaterBackground", WaterBackground);
		app.component("ProcurementScene", ProcurementScene);
		app.component("RoleOnly", RoleOnly);
		app.component("RoleBadge", RoleBadge);
	},
};
