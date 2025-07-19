import { defineStore } from "pinia"

/**
 * Store de autenticação
 * Gerencia login, logout e estado de autenticação
 */
export const useAuthStore = defineStore("auth", {
	state: () => ({
		authenticated: false,
	}),

	actions: {
		/**
		 * Autentica usuário no sistema
		 * @param {Object} payload - Dados de login (email, password, remember_me)
		 * @returns {Boolean} - Sucesso da autenticação
		 */
		async authenticateUser(payload) {
			const nuxtApp = useNuxtApp()
			const config = useRuntimeConfig(nuxtApp)

			try {
				const response = await $fetch(`/api/login`, {
					baseURL: config.public.baseURL,
					method: "POST",
					body: payload,
				})

				// Configurar cookies baseado no "lembrar-me"
				const expiresDate = payload.remember_me
					? new Date(response.expires_at)
					: undefined

				const cookieConfig = {
					sameSite: true,
					expires: expiresDate,
					nuxtApp,
				}

				// Definir cookies de autenticação
				const token = useCookie("token", cookieConfig)
				const imageProfile = useCookie("imageProfile", cookieConfig)
				const authenticated = useCookie("authenticated", cookieConfig)
				const admin = useCookie("admin", cookieConfig)

				token.value = response.access_token
				authenticated.value = true
				admin.value = !!response.admin
				imageProfile.value = response.image || null
				this.authenticated = true

				return true
			} catch (err) {
				console.error("Falha na autenticação:", err)
				this.clearAuthData(nuxtApp)
				return false
			}
		},

		/**
		 * Realiza logout do usuário
		 */
		async logUserOut(nuxtApp = useNuxtApp()) {
			const config = useRuntimeConfig(nuxtApp)

			try {
				await $fetch(`/api/logout`, {
					baseURL: config.public.baseURL,
					method: "POST",
				})
			} catch (err) {
				console.error("Erro no logout da API:", err)
			} finally {
				this.clearAuthData(nuxtApp)
			}
		},

		/**
		 * Limpa dados de autenticação
		 */
		clearAuthData(nuxtApp = useNuxtApp()) {
			const token = useCookie("token", { nuxtApp })
			const authenticated = useCookie("authenticated", { nuxtApp })
			const admin = useCookie("admin", { nuxtApp })
			const imageProfile = useCookie("imageProfile", { nuxtApp })

			token.value = null
			authenticated.value = null
			admin.value = null
			imageProfile.value = null
			this.authenticated = false
		},
	},
})
