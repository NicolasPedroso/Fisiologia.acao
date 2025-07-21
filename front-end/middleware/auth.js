/**
 * Middleware de autenticação
 * Verifica se o usuário está autenticado e redireciona conforme necessário
 */
export default defineNuxtRouteMiddleware(() => {
	const cookieAuth = useCookie("authenticated", { sameSite: true })
	const cookieToken = useCookie("token", { sameSite: true })

	// Se não autenticado, permanecer na página atual
	if (!cookieAuth.value || !cookieToken.value) {
		return
	}

	// Se já autenticado, redirecionar para área logada
	return navigateTo("/fisiologia", { redirectCode: 200 })
})
