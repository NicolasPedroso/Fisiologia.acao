<template>
	<!-- Página de erro com fundo animado -->
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
				@click="handleError('/contato')"
			>
				Contato
			</v-btn>
		</v-empty-state>
	</v-container>
</template>
<script setup>
/**
 * Página de tratamento de erros do Nuxt.js
 * Exibe interface amigável para diferentes tipos de erro
 */

const props = defineProps({
	error: {
		type: Object,
		default: () => ({}),
	},
})

/**
 * Limpa o erro e redireciona para nova rota
 */
const handleError = (route) => clearError({ redirect: route })

/**
 * Determina a mensagem de erro baseada no status code
 */
function errorMessage() {
	if (!props.error || !props.error.statusCode) {
		return "Um erro inesperado aconteceu!"
	}

	const status = props.error.statusCode

	switch (status) {
		case 404:
			return "Esta página não existe!"
		case 401:
			return "Você não tem autorização para acessar esta página!"
		case 403:
			return "Acesso negado!"
		case 500:
			return "Erro interno do servidor!"
		default:
			return props.error.message || "Um erro inesperado aconteceu!"
	}
}

useSeoMeta({
	title: "Erro - Fisiologia em Ação",
	description: "Página de erro do sistema Fisiologia em Ação",
})
</script>
<style scoped>
/* Animação do gradiente de fundo */
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

/* Fundo animado da página de erro */
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

/* Texto branco para elementos de erro */
.error-text,
.error-text :deep(.v-empty-state__headline) {
	color: #fff;
}

/* Estilização do código de status */
.error-text :deep(.v-empty-state__headline) {
	color: #fff;
	mix-blend-mode: overlay;
	font-size: 18rem;
	font-weight: 800;
	line-height: 13rem;
	letter-spacing: -5px;
}
</style>
