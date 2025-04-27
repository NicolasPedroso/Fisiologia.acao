/**
 * * Função que SETA alguns padrões para o fetch utilizado
 * ?    TOKEN - Bearer token recebido do back-end, armazenado no cookie
 * ?    baseURL - URL base da aplicação, recebida do back-end, armazenada no nuxtConfig
 *
 * * Exemplo de uso:
 *      let { data: respostaRes, error, loading } = useDataLoader("/api/endpoint", {
 *          method: "GET",
 *      })
 * }
 *
 * ! Atenção: comente a linha da AUTHORIZATION caso não esteja utilizando autenticação por token
 * ! 	Como em back-end simulado, ao exemplo do json-server que tem problemas com o header Authorization
 *
 * @param {*} request - Endpoint da API (rotas: /api/...)
 * @param {*} opts - Opções do fetch (método, headers, etc...)
 * @returns {Object} - Retorna um objeto com as propriedades: data, error, loading proprias do $fetch
 */
import { useAuthStore } from "~/store/auth"
export const useDataLoader = async (request, opts) => {
	const router = useRouter()
	const config = useRuntimeConfig()
	const { logUserOut } = useAuthStore()
	const { value: token } = useCookie("token", { sameSite: true })

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
		if (error.response?.status === 401) {
			await logUserOut()
			return router.push("/fea")
		}

		throw error
	}
}
