import DefaultTheme from "vitepress/theme";
import HeroBackground from "./components/HeroBackground.vue";
import LogoModel from "./components/LogoModel.vue";
import WaterBackground from "./components/WaterBackground.vue";
import "./custom.css";

export default {
	extends: DefaultTheme,
	enhanceApp({ app }) {
		app.component("HeroBackground", HeroBackground);
		app.component("LogoModel", LogoModel);
		app.component("WaterBackground", WaterBackground);
	},
};
