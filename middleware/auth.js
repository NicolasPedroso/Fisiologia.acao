export default defineNuxtRouteMiddleware(() => {
	const auth = false // check if user is authenticated
	if (auth === true) {
		return navigateTo("/dashboard")
	}
})
