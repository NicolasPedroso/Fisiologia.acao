/**
 * * Função para formatar a URL da imagem para o formato correto
 *		- Troca o public/ por storage/ na URL da imagem
 *  	- Utiliza o runtimeConfig para pegar a baseURL
 *      - Exemplo: return "http://localhost:8000/storage/images/image.jpg"
 *
 * @param {String} url - URL da imagem a ser formatado
 * @returns {String} - URL da imagem formatada (BaseURL + URL da imagem formatado)
 */
export default (url) => {
	const config = useRuntimeConfig()
	const configURL = config.public.baseURL

	// Troca o public/ por storage/ na URL da imagem
	return `${configURL}/${url.replace("public/", "storage/")}`
}
