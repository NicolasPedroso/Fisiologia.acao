/**
 * Middleware para verificação de permissões administrativas
 * Redireciona usuários não-admin para a página principal
 */
export default defineNuxtRouteMiddleware(() => {
	const cookieAdmin = useCookie("admin", { sameSite: true })

	if (cookieAdmin.value !== true) {
		return navigateTo("/fisiologia", { redirectCode: 200 })
	}
})
