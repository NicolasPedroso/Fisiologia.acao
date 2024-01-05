export default defineNuxtRouteMiddleware(() => {
	const auth = true // check if user is authenticated
	if (auth === false) {
		return navigateTo("/login", { redirectCode: 401 })
	}
})
