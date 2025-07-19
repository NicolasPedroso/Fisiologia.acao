/**
 * Composable para requisições HTTP com autenticação automática
 * Configura token Bearer e baseURL automaticamente
 *
 * @param {string} request - Endpoint da API
 * @param {Object} opts - Opções do fetch (método, headers, etc)
 * @returns {Object} - Dados da resposta ou erro
 */
import { useAuthStore } from "~/store/auth"

export const useDataLoader = async (request, opts) => {
	const router = useRouter()
	const config = useRuntimeConfig()
	const { logUserOut } = useAuthStore()
	const { value: token } = useCookie("token", { sameSite: true })
	const nuxtApp = useNuxtApp()

	// Configurar headers com token se disponível
	let headersOpts = {}
	if (opts?.headers) headersOpts = opts.headers
	if (token) headersOpts.Authorization = `Bearer ${token}`

	try {
		const data = await $fetch(request, {
			baseURL: config.public.baseURL,
			headers: headersOpts,
			...opts,
		})
		return data
	} catch (error) {
		// Logout automático em caso de não autorizado
		if (error.response?.status === 401) {
			await logUserOut(nuxtApp)
			return router.push("/")
		}

		throw error
	}
}
