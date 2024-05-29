<template>
	<v-container
		fluid
		class="background-error h-screen d-flex justify-center align-center"
	>
		<v-card class="pa-2 pa-sm-8" color="#fffffff3" rounded="xl">
			<v-empty-state
				:headline="`Whoops, erro ${error.statusCode}`"
				:title="errorMessage()"
				text="Se esse erro persistir, por favor, entre em contato com o suporte."
				icon="mdi-magnify"
			>
				<v-btn
					prepend-icon="mdi-home"
					variant="text"
					@click="handleError('/')"
				>
					Voltar a home
				</v-btn>
			</v-empty-state>
		</v-card>
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
	background: url("/images/auth/background.jpeg") no-repeat center center
		fixed;
}
</style>
