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
			// Define os metadados do projeto gerais
			charset: "utf-8",
			viewport: "width=device-width, initial-scale=1",
			htmlAttrs: {
				lang: "pt-br",
			},
			/**
			 * * Define o titulo do projeto
			 * Se não houver um titulo, ele pega o nome do projeto do package.json
			 * Se houver um titulo, ele pega o nome do projeto do package.json e concatena com o titulo
			 * 		Exemplo: "Titulo - Nome do Projeto do package.json"
			 */
			titleTemplate: `%s - ${process.env.npm_package_name}`,
			title: process.env.npm_package_name || "",
			// Define o icone padrão do projeto
			link: [
				{
					rel: "icon",
					type: "image/png",
					href: "/favicon.png",
				},
			],
		},
	},

	/**
	 *  Aqui se define variáveis globais do projeto
	 * 		const config = useRuntimeConfig()
	 * 		config.public.baseURL,
	 */
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
		(_options, nuxt) => {
			nuxt.hooks.hook("vite:extendConfig", (config) => {
				// @ts-expect-error
				config.plugins.push(vuetify({ autoImport: true }))
			})
		},
		"@nuxtjs/eslint-module",
		"nuxt3-notifications",
		"@pinia/nuxt",
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
