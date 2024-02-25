<template>
	<v-container fluid class="background text-center">
		<h4 class="mb-2">{{ error.statusCode }}</h4>
		<h2 v-if="error.statusCode === 404">Esta página não existe!</h2>
		<h2 v-else-if="error.statusCode === 401">
			Sem autorização necessária!
		</h2>
		<h2 v-else-if="error.message">{{ error.message }}</h2>
		<h2 v-else>Um erro aconteceu!</h2>
		<v-btn
			class="mt-4"
			variant="tonal"
			color="#00dc80"
			@click.stop="handleError"
		>
			Voltar para a Home
		</v-btn>
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
	title: `Erro`,
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
	background-color: #151515;
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

.background h2 {
	font-size: min(45px, 20vw);
	line-height: min(47px, 20.5vw);
	font-weight: 600;
}

.background h4 {
	font-size: min(35px, 15vw);
	line-height: min(37px, 15.5vw);
	color: #00dc80;
	font-weight: 900;
}
</style>
