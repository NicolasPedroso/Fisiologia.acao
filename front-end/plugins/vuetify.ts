import "@mdi/font/css/materialdesignicons.css"

import "vuetify/styles"
import { createVuetify } from "vuetify"
import { en, pt } from "vuetify/locale"

export default defineNuxtPlugin((app) => {
	const vuetify = createVuetify({
		ssr: true,
		locale: {
			locale: "pt",
			fallback: "en",
			messages: { pt, en },
		},
	})
	app.vueApp.use(vuetify)
})
