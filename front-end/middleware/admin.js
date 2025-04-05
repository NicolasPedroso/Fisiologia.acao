/* eslint-disable */
export default defineNuxtRouteMiddleware((to, from) => {
	const cookieAdmin = useCookie("admin", {
		sameSite: true,
	})

	if (cookieAdmin.value !== true) {
		return navigateTo("/Endogames", { redirectCode: 200 })
	}
})
