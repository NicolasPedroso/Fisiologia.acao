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
				prepend-icon="mdi-account-box"
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
</script>
<style scoped>
@keyframes bg {
	0% {
		background-position: 0% 0%;
	}
	50% {
		background-position: 50% 50%;
	}
	100% {
		background-position: 0% 0%;
	}
}

.background-error {
	background: var(--primary-color);
	background: linear-gradient(
		0deg,
		var(--primary-color) 0%,
		var(--secondary-color) 100%
	);
	background-size: 400% 400%;
	animation: bg 10s infinite;
}

.error-text,
.error-text :deep(.v-empty-state__headline) {
	color: #fff;
}

.error-text :deep(.v-empty-state__headline) {
	color: #fff;
	mix-blend-mode: overlay;
	font-size: 18rem;
	font-weight: 800;
	line-height: 13rem;
	letter-spacing: -5px;
}

:deep(v-btn__content) {
	font-family: "Roboto", sans-serif;
}
</style>
