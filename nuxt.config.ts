// Imports from Nuxt
import vuetify, { transformAssetUrls } from "vite-plugin-vuetify";

// https://nuxt.com/docs/api/configuration/nuxt-config
// Exports from Nuxt
export default defineNuxtConfig({
	// Habilita o modo de DEV TOOLS no projeto - depuracao e etc
	devtools: { enabled: true },

	// Define o cabeçalho do Nuxt
	app: {
		head: {
			link: [
				{
					rel: "icon",
					type: "image/ico",
					href: "favicon.ico",
				},
			],
		},
	},

	build: {
		transpile: ["vuetify"],
	},
	modules: [
		(_options, nuxt) => {
			nuxt.hooks.hook("vite:extendConfig", (config) => {
				// @ts-expect-error
				config.plugins.push(vuetify({ autoImport: true }));
			});
		},
	],
	vite: {
		vue: {
			template: {
				transformAssetUrls,
			},
		},
	},
});
