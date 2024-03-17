<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container fluid class="ma-0 pa-0 text-center">
		<auth-title :title="'Registro'" />
		<v-form v-model="valid" @submit.prevent>
			<v-text-field
				v-model="name"
				class="mt-3"
				label="Nome"
				prepend-icon="mdi-account"
				:rules="rules.name"
			/>
			<v-text-field
				v-model="email"
				class="mt-3"
				label="E-mail"
				prepend-icon="mdi-email"
				:rules="rules.email"
			/>
			<v-text-field
				v-model="newPassword"
				class="mt-3"
				label="Senha"
				prepend-icon="mdi-lock"
				:rules="rules.password"
				type="password"
			/>
			<v-text-field
				v-model="newPasswordC"
				class="mt-3"
				label="Confirmar senha"
				prepend-icon="mdi-lock"
				:rules="rules.passwordC"
				type="password"
			/>
			<v-btn
				type="submit"
				class="mb-6 mt-4"
				variant="outlined"
				color="#244407"
				@click="signIn"
			>
				Registrar
			</v-btn>
		</v-form>
		<v-row class="mt-2 d-flex flex-column justify-center">
			<nuxt-link class="auth-link mt-2 mb-4" to="/login">
				Voltar
			</nuxt-link>
		</v-row>
	</v-container>
	<!-- Conteudo da pagina -->
</template>
<script setup>
// Campos do formulário
const name = ref("")
const email = ref("")
const newPassword = ref("")
const newPasswordC = ref("")

// Utilizar o snackbar
const { notify } = useNotification()

// Regras e validade do formulário
const valid = ref(false)
const rules = {
	name: [
		(value) => {
			if (value) return true
			return "O campo é obrigatório"
		},
	],
	email: [
		(value) => {
			if (value) return true
			return "O campo é obrigatório"
		},
		(value) => {
			if (/^[a-z0-9.]+@[a-z0-9]+\.[a-z]+(\.[a-z]+)?$/i.test(value))
				return true
			return "O e-mail deve ser válido"
		},
	],
	password: [
		(value) => {
			if (value) return true
			return "O campo é obrigatório"
		},
	],
	passwordC: [
		(value) => {
			if (value) return true
			return "O campo é obrigatório"
		},
	],
}

// Funções
async function signIn() {
	// Verifica se o formulário está preenchido corretamente
	if (valid.value) {
		// Feedback de Loading
		notify({
			id: "loading",
			text: "Carregando...",
			type: "info",
		})
		// Envia os dados para o backend
		const formSignup = new FormData()
		formSignup.append("name", name.value)
		formSignup.append("email", email.value)
		formSignup.append("password", newPassword.value)
		formSignup.append("password_confirmation", newPasswordC.value)

		useDataLoader("/api/signup", {
			method: "POST",
			body: formSignup,
		})
			.then(() => {
				// Feedback do erro por meio da snackbar
				notify.close("loading")
				notify({
					title: "Sucesso",
					text: "Usuário criado com sucesso!",
					type: "success",
				})

				const router = useRouter()
				router.push("/login")
			})
			.catch((error) => {
				const errors = formatError(error)
				console.error(error)

				// Feedback do erro por meio da snackbar
				notify.close("loading")
				notify({
					title: "Não foi possível registrar",
					text: `${errors}`,
					type: "error",
				})
			})
	} else {
		notify({
			text: "Preencha os campos corretamente para continuar",
			type: "info",
		})
	}
}

// Layout da página e cabeçalho
definePageMeta({
	layout: "auth",
	middleware: ["auth"],
})
useSeoMeta({
	title: "Registro",
	description: "Página de registro para a dashboard.",
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
.auth-link {
	color: #3a7700;
	font-size: 1.1rem;
	text-decoration: none;
	font-weight: 600;
}

.auth-link:hover {
	color: #244407;
}
</style>
