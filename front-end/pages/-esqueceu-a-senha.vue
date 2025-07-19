<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container fluid class="ma-0 pa-0 text-center">
		<h1 class="text-center">Esqueceu a sua senha?</h1>
		<h3 class="description text-center mb-12">
			Coloque seu e-mail para receber um link de redefinição
		</h3>

		<v-form v-model="valid" @submit.prevent>
			<v-text-field
				v-model="email"
				label="Insira seu E-mail"
				prepend-inner-icon="mdi-email-outline"
				variant="outlined"
				:rules="rule"
				class="field-content mt-3"
				tile
				hint
			/>
			<v-btn
				type="submit"
				class="passwordRecovery-btn rounded-lg mt-8"
				variant="outlined"
				:disabled="!valid"
				@click="passwordRecovery"
			>
				Mandar e-mail
			</v-btn>
		</v-form>
		<div class="mt-1 text-center">
			<nuxt-link class="text-center link mb-4" to="/cadastro">
				<span>
					Sabe sua senha?
					<strong>Entre agora</strong>
				</span>
			</nuxt-link>
		</div>
	</v-container>
	<!-- Conteudo da pagina -->
</template>
<script setup>
// Campos do formulário
const email = ref("")

// Usar o snackbar
const { notify } = useNotification()

// Regras e validade do formulário
const valid = ref(false)
const rule = [
	(value) => {
		if (value) return true
		return "O campo é obrigatório"
	},
	(value) => {
		if (/^[a-z0-9.]+@[a-z0-9]+\.[a-z]+(\.[a-z]+)?$/i.test(value))
			return true
		return "O e-mail deve ser válido"
	},
]

// Funções
async function passwordRecovery() {
	// Verifica se o formulário está preenchido corretamente
	if (valid.value) {
		// Feedback que está carregando a requisição
		notify({
			id: "loading",
			text: "Carregando...",
			type: "info",
		})
		// Envia os dados para o backend
		try {
			// TODO: Implementar a recuperação de senha
		} catch (error) {
			notify.close("loading")
			notify({
				title: "Erro ao enviar e-mail",
				text: formatError(error),
				type: "error",
			})
		}
	} else {
		notify({
			title: "Campos faltando",
			text: "Preencha os campos corretamente para continuar",
			type: "error",
		})
	}
}

// Layout da página e middlewares
definePageMeta({
	layout: "passwordRecovery",
	middleware: ["auth"],
})
useSeoMeta({
	title: "passwordRecovery - Fisiologia em Ação",
	description: "Faça passwordRecovery na Fisiologia em Ação",
	keywords: "passwordRecovery, acesso, fisiologia, ação",
})
</script>
<style scoped>
h1 {
	align-self: flex-start;
	text-align: left;
	font-size: 28px;
}

:deep(.v-field__outline) {
	--v-field-border-width: 2px !important;
	--v-field-border-opacity: 1 !important;
}
:deep(.v-field__overlay) {
	background-color: #ffff !important;
}

.passwordRecovery-btn {
	width: 100%;
	height: 3.5rem;
	font-size: 1.5rem;
	font-weight: 600;
	background-color: var(--secondary-color);
	color: #ffffff;
	box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
	transition: box-shadow 0.3s ease;
}

.passwordRecovery-btn:hover {
	box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.register-link {
	font-size: 28px;
}

.link {
	color: var(--secondary-color);
	font-size: 1rem;
	text-decoration: underline;
	font-weight: 400;
	transition: all 0.25s;
	text-align: center;
}

.field-content :deep(.v-field__outline) {
	border-radius: 8px;
}

:deep(.v-text-field input) {
	font-size: 1.2rem;
}

.link strong {
	font-weight: 800;
	color: var(--secondary-color);
	text-decoration: underline;
}

.link:hover {
	color: var(--secondary-color);
	text-decoration: underline;
}

.description {
	font-weight: 400;
}
</style>
