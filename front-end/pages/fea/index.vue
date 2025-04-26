<template>
	<h1>Pagina inicial após logar</h1>
	<v-btn class="text-color" @click="logout()"> Sair </v-btn>
	<div>
		<nuxt-link class="auth-link mb-4" to="fea/dashboard">
			<span> Acessar dashboard </span>
		</nuxt-link>
	</div>
</template>

<script setup>
import { useAuthStore } from "~/store/auth"

definePageMeta({
	middleware: ["guest"],
})

const { logUserOut } = useAuthStore()

async function logout() {
	await logUserOut()
	window.location.reload()
	router.push("/")
}
</script>
