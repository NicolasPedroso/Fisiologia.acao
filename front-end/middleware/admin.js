/* eslint-disable */
export default defineNuxtRouteMiddleware((to, from) => {
	const isAdmin = true
	if (isAdmin !== true) {
		return navigateTo("/", { redirectCode: 401 })
	}
})
