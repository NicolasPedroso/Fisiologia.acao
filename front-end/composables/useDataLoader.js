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
export const useDataLoader = async (request, opts) => {
	const config = useRuntimeConfig()
	const { value: token } = useCookie("token", { sameSite: true })

	// Objeto com os cabeçalhos
	let headersOpts = {}
	if (opts?.headers) headersOpts = opts.headers
	if (token) headersOpts.Authorization = `Bearer ${token}`

	// Retorna o objeto com as propriedades: data, error, loading, ...
	return await $fetch(request, {
		baseURL: config.public.baseURL,
		headers: headersOpts,
		...opts,
	})
}
