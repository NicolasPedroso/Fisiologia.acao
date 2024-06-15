/* eslint-disable */
import { defineStore } from "pinia"
export const useAuthStore = defineStore("auth", {
	state: () => ({
		authenticated: false,
	}),
	actions: {
		// Função de autenticação
		async authenticateUser({ email, password }) {
			try {
				// Tentar fazer o LOGIN usando os campos de email & password
				const response = await $fetch(`/api/login`, {
					baseURL: useRuntimeConfig().public.baseURL,
					method: "post",
					headers: { "Content-Type": "application/json" },
					body: {
						email,
						password,
					},
				})

				// Pega a data de expiração dos tokens
				const expiresDate = new Date(response.expires_at)

				// Utilizar o useCookies do Nuxt3 para armazenar dados locais
				const authenticated = useCookie("authenticated", {
					sameSite: true,
					expires: expiresDate,
				})
				const token = useCookie("token", {
					sameSite: true,
					expires: expiresDate,
				})

				/**
				 * Se não der algum erro, vai ser feito as seguintes ações:
				 * 		- Definir o token de acesso
				 * 		- Definir o estado com autenticado
				 **/
				token.value = response.access_token
				authenticated.value = true
				this.authenticated = true
			} catch (err) {
				
				/**
				 * Caso de algum erro durante o LOGIN
				 * 		- Remove o token de acesso
				 * 		- Remove o estado de autenticado
				 * 		- Coloca o ERRO no console
				 **/
				console.error(err)
				this.authenticated = false // set authenticated  state value to false
				token.value = null // clear the token cookie
				authenticated.value = false
			}
		},

		// Função de deslogar
		async logUserOut() {
			// Utilizar o useCookies do Nuxt3 para armazenar dados locais
			const token = useCookie("token", {
				sameSite: true,
			})
			const authenticated = useCookie("authenticated", {
				sameSite: true,
			})

			// Desconecta o usuário (deletar o TOKEN de autenticacao)
			await $fetch(`/api/logout`, {
				baseURL: useRuntimeConfig().public.baseURL,
			}).catch((err) => {
				console.error(err)
			})

			// Remove token de acesso e estado de autorizado
			this.authenticated = false
			authenticated.value = false
			token.value = null
		},
	},
})
