/**
 * Função geral que pega erros do .catch (err) e retorna uma string com todos os erros do back-end laravel
 *      * Os erros do back-end são retornados em error.response._data
 *
 * @param {Object} error - Objeto de erro retornado do .catch (err)
 * @return {String} - String com todos os erros do back-end laravel concatenados por &
 */
export default (error) => {
	// Verifica se o erro é um objeto com a propriedade response
	// Caso não, apenas retorna o erro sem tratamento
	if (!error.response) return error

	// Extrair todas as strings de erro do back-end
	const allErrors = []
	let objetoErros = {}

	// Verifica se existe a propriedade errors em error.response._data.errors
	objetoErros = error.response._data.errors
		? error.response._data.errors
		: error.response._data

	// Caso de erro unico, como nao autorizado
	if (objetoErros.message) return objetoErros.message

	// Caso de rota errada
	if (objetoErros.erro) return "Rota não encontrada"

	for (const i in objetoErros) {
		// Itera sobre os elementos do array
		objetoErros[i].forEach((item) => {
			// Adiciona a string ao array de strings
			allErrors.push(item)
		})
	}

	// Retorna as strings concatenadas por &
	return allErrors.join(" & ")
}
