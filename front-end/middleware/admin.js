/**
 * Middleware para verificação de permissões administrativas
 * Redireciona usuários não-admin para a página principal
 */
export default defineNuxtRouteMiddleware(() => {
	const cookieAdmin = useCookie("admin", { sameSite: true })

	if (cookieAdmin.value !== true) {
		return abortNavigation({
			statusCode: 403,
			message: "Você não tem permissão para acessar esta página",
		})
	}
})
