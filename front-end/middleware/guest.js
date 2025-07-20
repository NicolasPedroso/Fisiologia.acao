/**
 * Middleware para usuários autenticados
 * Redireciona usuários não autenticados para a página de login
 */
export default defineNuxtRouteMiddleware(() => {
	const cookieAuth = useCookie("authenticated", { sameSite: true })
	const cookieToken = useCookie("token", { sameSite: true })

	if (
		!cookieAuth.value ||
		cookieAuth.value === false ||
		!cookieToken.value ||
		cookieToken.value === false
	) {
		return navigateTo("/")
	}
})
