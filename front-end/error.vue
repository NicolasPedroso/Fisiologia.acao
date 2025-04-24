<template>
	<v-container
		fluid
		class="background-error h-screen d-flex justify-center align-center"
	>
		<v-empty-state
			:headline="`${error.statusCode}`"
			:title="errorMessage()"
			text="Se esse erro persistir, por favor, entre em contato com o suporte."
			class="error-text"
		>
			<v-btn
				prepend-icon="mdi-home"
				color="#fff"
				variant="tonal"
				class="mr-4"
				@click="handleError('/')"
			>
				Voltar
			</v-btn>
			<v-btn
				prepend-icon="mdi-trash"
				color="#fff"
				variant="tonal"
				@click="handleError('/')"
			>
				Contato
			</v-btn>
		</v-empty-state>
	</v-container>
</template>
<script setup>
// Handlers de erro do nuxt
const props = defineProps({
	error: { type: Object, value: () => NuxtError },
})

const handleError = (route) => clearError({ redirect: route })

function errorMessage() {
	if (!props.error) return "Um erro aconteceu!"

	const status = props.error.statusCode

	switch (status) {
		case 404:
			return "Esta página não existe!"

		case 401:
			return "Sem autorização necessária!"

		default:
			return props.error.message || "Um erro aconteceu!" // Fallback
	}
}

// Cabeçalhos da pagina
useSeoMeta({
	title: "Erro!",
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
.background-error {
	background: #1356d3;
	background: linear-gradient(
		45deg,
		rgba(19, 86, 211, 1) 0%,
		rgba(17, 50, 112, 1) 100%
	);
}

.error-text,
.error-text :deep(.v-empty-state__headline) {
	color: #fff;
}

.error-text :deep(.v-empty-state__headline) {
	font-size: 12rem;
	font-weight: 800;
	letter-spacing: -5px;
}

:deep(v-btn__content) {
	font-family: "Roboto", sans-serif;
}
</style>
