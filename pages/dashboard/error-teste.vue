<template>teste</template>
<script setup>
// Tudo aqui dentro é executado após a montagem da página
onBeforeMount(() => {
	console.log("teste")
	throw createError({
		statusCode: 420,
		statusMessage: "Isso foi uma simulação de erro",
		fatal: true,
	})
})

// Cabeçalho da pagina
definePageMeta({
	layout: "dashboard",
	middleware: ["guest"],
})
</script>
