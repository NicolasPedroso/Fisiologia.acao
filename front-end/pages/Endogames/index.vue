<template>
	<h1>Pagina inicial após logar</h1>
</template>

<script setup>
definePageMeta({
	middleware: ["guest"],
})
</script>
