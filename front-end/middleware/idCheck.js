/* eslint-disable */
export default defineNuxtRouteMiddleware((to, from) => {
	if (!to.params.id || !Number.isInteger(+to.params.id)) {
		return navigateTo("/fisiologia", { redirectCode: 301 })
	}
})
