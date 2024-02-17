<template>
	<v-container fluid class="background">
		<h2>oops!</h2>
		<h1>{{ error.statusCode }}</h1>
		<p v-if="error.statusCode === 404">Esta página não existe!</p>
		<p v-else-if="error.statusCode === 401">Sem autorização necessária!</p>
		<p v-else>Um erro aconteceu!</p>
		<v-btn class="mt-3" @click.stop="handleError"> Voltar </v-btn>
	</v-container>
</template>
<script setup>
// Handlers de erro do nuxt
defineProps({
	error: { type: Object, value: () => NuxtError },
})
const handleError = () => clearError({ redirect: "/" })

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
<style scoped>
.background {
	background-color: rgb(29, 29, 29);
	height: 100vh;
	width: 100vw;

	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;

	color: #fff;
}

.background h2 {
	font-size: 3vw;
	line-height: 3vw;
}

.background p {
	font-size: 1vw;
	line-height: 1vw;
	font-weight: 200;
	text-transform: uppercase;
}

.background h1 {
	font-size: 20vw;
	line-height: 18vw;
	color: #c76dff;
	font-weight: 900;
}
</style>
