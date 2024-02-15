/* eslint-disable */
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
 * @param {*} request - Endpoint da API (rotas: /api/...)
 * @param {*} opts - Opções do fetch (método, headers, etc...)
 * @returns {Object} - Retorna um objeto com as propriedades: data, error, loading proprias do $fetch
 */
export const useDataLoader = async (request, opts) => {
	const config = useRuntimeConfig()
	const { value: token } = useCookie("token")

	return await $fetch(request, {
		baseURL: config.public.baseURL,
		headers: {
			Authorization: `Bearer ${token}`,
			...opts?.headers,
		},
		...opts,
	})
}
