/* eslint-disable */
export default defineNuxtRouteMiddleware((to) => {
	if (!to.params.id || !Number.isInteger(+to.params.id)) {
		return abortNavigation({
			statusCode: 404,
			message: "ID inválido",
		})
	}
})
