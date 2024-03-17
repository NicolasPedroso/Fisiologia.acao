/* eslint-disable */

/**
 * * Precisa ser feito ao longo do projeto:
 * TODO: Colocar testes com JEST para verificar se o middleware foi chamado e se funcionou
 * 		? Logou - funcionou - true authtincated & token existe (!== null)
 * 		? Logout - auth false, token === null
 * 		? Fazer requisicao sem token
 * 		? Trocar de pagina e perder o token
 */

/**
 * * Middleware de autenticação (acontece antes da pagina carregar)
 * ? Verifica se o usuario esta autenticado
 *
 * Se o usuario nao estiver autenticado, redireciona para a pagina de login
 * Utiliza o hook useCookie para pegar o token e authenticated
 *
 * @param {Object} to - Pagina que o usuario esta tentando acessar
 * @param {Object} from - Pagina que o usuario esta vindo
 */
export default defineNuxtRouteMiddleware((to, from) => {
	const cookieAuth = useCookie("authenticated", {
		sameSite: true,
	})
	const cookieToken = useCookie("token", {
		sameSite: true,
	})

	if (cookieAuth.value === true && cookieToken.value !== null) {
		return navigateTo("/dashboard", { redirectCode: 200 })
	}
})
