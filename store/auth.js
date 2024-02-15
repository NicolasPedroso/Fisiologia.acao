/* eslint-disable */
import { defineStore } from "pinia"
export const useAuthStore = defineStore("auth", {
	state: () => ({
		authenticated: false,
	}),
	actions: {
		async authenticateUser({ email, password }) {
			// useFetch from nuxt 3
			const authenticated = useCookie("authenticated")
			const token = useCookie("token")

			try {
				const response = await $fetch(`/api/login`, {
					baseURL: useRuntimeConfig().public.baseURL,
					method: "post",
					headers: { "Content-Type": "application/json" },
					body: {
						email,
						password,
					},
				})

				// Se não der erro, vai ser feito as seguintes ações
				token.value = response.access_token
				authenticated.value = true
				this.authenticated = true
			} catch (err) {
				console.error(err)
				this.authenticated = false // set authenticated  state value to false
				token.value = null // clear the token cookie
				authenticated.value = false
			}
		},
		logUserOut() {
			const token = useCookie("token") // useCookie new hook in nuxt 3
			const authenticated = useCookie("authenticated") // useCookie new hook in nuxt 3
			this.authenticated = false // set authenticated  state value to false
			authenticated.value = false
			token.value = null // clear the token cookie
		},
	},
})
