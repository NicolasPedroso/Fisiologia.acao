/* eslint-disable */
import { defineStore } from "pinia"

export const useAuthStore = defineStore("auth", {
	state: () => ({
		authenticated: false,
	}),
	actions: {
		/**
		 * Função de autenticação.
		 * Aceita o nuxtApp para funcionar corretamente no SSR.
		 */
		async authenticateUser(payload) {
			// ✅ Obtém o contexto do Nuxt. Essencial para SSR.
			const nuxtApp = useNuxtApp()
			const config = useRuntimeConfig(nuxtApp)

			try {
				const response = await $fetch(`/api/login`, {
					baseURL: config.public.baseURL,
					method: "POST",
					body: payload, // Recebe { email, password, remember_me }
				})

				// Se o login for bem-sucedido, definimos os cookies
				const expiresDate = payload.remember_me
					? new Date(response.expires_at)
					: undefined

				const token = useCookie("token", {
					sameSite: true,
					expires: expiresDate,
					nuxtApp,
				})

				const imageProfile = useCookie("imageProfile", {
					sameSite: true,
					expires: expiresDate,
					nuxtApp,
				})

				const authenticated = useCookie("authenticated", {
					sameSite: true,
					expires: expiresDate,
					nuxtApp,
				})

				const admin = useCookie("admin", {
					sameSite: true,
					expires: expiresDate,
					nuxtApp,
				})

				token.value = response.access_token
				authenticated.value = true
				admin.value = !!response.admin // Forma mais simples de converter para booleano
				imageProfile.value = response.image || null
				this.authenticated = true

				return true // Retorna sucesso
			} catch (err) {
				// Em caso de erro, simplesmente limpamos os dados
				console.error("Falha na autenticação:", err)
				this.clearAuthData(nuxtApp)
				return false // Retorna falha
			}
		},

		/**
		 * Função de logout.
		 * Aceita o nuxtApp para funcionar corretamente no SSR.
		 */
		async logUserOut(nuxtApp = useNuxtApp()) {
			const config = useRuntimeConfig(nuxtApp)

			try {
				// Tenta fazer logout na API, mas continua mesmo se falhar
				await $fetch(`/api/logout`, {
					baseURL: config.public.baseURL,
					method: "POST",
				})
			} catch (err) {
				console.error(
					"Erro no endpoint de logout, limpando dados localmente:",
					err,
				)
			} finally {
				this.clearAuthData(nuxtApp)
			}
		},

		/**
		 * Ação auxiliar para limpar todos os dados de autenticação.
		 * Reutiliza a lógica e mantém o código limpo.
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
