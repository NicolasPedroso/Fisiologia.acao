/* eslint-disable */
export default defineNuxtRouteMiddleware((to, from) => {
	const cookieAdmin = useCookie("admin", {
		sameSite: true,
	})

	if (cookieAdmin.value !== true) {
		return navigateTo("/fea", { redirectCode: 200 })
	}
})
