// Plugins imports
import vuetify, { transformAssetUrls } from "vite-plugin-vuetify"
import eslintPlugin from "vite-plugin-eslint"

// https://nuxt.com/docs/api/configuration/nuxt-config
// Exports from Nuxt
export default defineNuxtConfig({
	// Habilita o modo de DEV TOOLS no projeto - depuracao e etc
	devtools: { enabled: true },

	// Define o CSS global do projeto
	css: ["@/assets/index.css"],

	// Define o cabeçalho do Nuxt [meta tags]
	app: {
		head: {
			charset: "utf-8",
			viewport: "width=device-width, initial-scale=1",
			link: [
				{
					rel: "icon",
					type: "image/ico",
					href: "/favicon.ico",
				},
			],
		},
	},

	runtimeConfig: {
		public: {
			baseURL: "http://localhost:8000",
		},
	},

	// Define o modus operandi dos componentes
	components: [
		{
			path: "~/components",
			pathPrefix: true,
		},
	],

	// Define o modo de renderizacao do Nuxt
	// Definição e configurações do Nuxt3
	build: {
		transpile: ["vuetify"],
	},
	modules: [
		["@nuxtjs/eslint-module", { lintOnStart: false }],
		(_options, nuxt) => {
			nuxt.hooks.hook("vite:extendConfig", (config) => {
				// @ts-expect-error
				config.plugins.push(vuetify({ autoImport: true }))
			})
		},
	],
	vite: {
		vue: {
			template: {
				transformAssetUrls,
			},
		},
		plugins: [eslintPlugin()],
	},
})
