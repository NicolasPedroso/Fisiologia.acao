<template>
	<h1>Pagina inicial após logar</h1>
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
