<template>
	<v-container fluid class="ma-0 pa-0"> /index </v-container>
</template>
<script setup>
// Cabeçalhos da pagina
useSeoMeta({
	title: "Página inicial",
	description: "Página inicial do projeto base 2024 da Ecomp.",
})
useHead({
	htmlAttrs: {
		lang: "pt-br",
	},
	link: [
		{
			rel: "icon",
			type: "image/ico",
			href: "/favicon.ico",
		},
	],
})
</script>
