/**
 * Composable para requisições HTTP com autenticação automática
 * Configura token Bearer e baseURL automaticamente
 *
 * @param {string} request - Endpoint da API
 * @param {Object} opts - Opções do fetch (método, headers, etc)
 * @returns {Object} - Dados da resposta ou erro
 */
export const useDataLoader = async (request, opts = {}) => {
	const config = useRuntimeConfig()
	const route = useRouter()
	const token = useCookie("token", { sameSite: true })

	const customHeaders = { ...opts.headers }
	if (token.value) {
		customHeaders.Authorization = `Bearer ${token.value}`
	}

	try {
		// Executa a chamada real usando $fetch
		const data = await $fetch(request, {
			...opts,
			baseURL: config.public.baseURL,
			headers: customHeaders,
		})
		return data
	} catch (error) {
		if (error.response?.status === 401) {
			token.value = null
			route.push("/")
		}

		throw error
	}
}
