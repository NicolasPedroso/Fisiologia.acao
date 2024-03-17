<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container fluid class="ma-0 pa-0 text-center">
		<auth-title :title="'Login'" />
		<v-form v-model="valid" @submit.prevent>
			<v-text-field
				v-model="email"
				class="mt-3"
				label="E-mail"
				prepend-icon="mdi-email"
				:rules="rules.email"
			/>
			<v-text-field
				v-model="password"
				class="mt-3"
				label="Senha"
				type="password"
				prepend-icon="mdi-lock"
				:rules="rules.password"
			/>
			<v-btn
				type="submit"
				class="mb-6 mt-4"
				variant="outlined"
				color="#244407"
				@click="login"
			>
				Entrar
			</v-btn>
		</v-form>
		<v-row class="mt-2 d-flex flex-column justify-center">
			<!-- <nuxt-link class="auth-link" to="/"> Esqueceu a senha? </nuxt-link> -->
			<nuxt-link class="auth-link mb-4" to="/registro">
				Registro
			</nuxt-link>
		</v-row>
	</v-container>
	<!-- Conteudo da pagina -->
</template>
<script setup>
// Import das funções e gerenciamento de STORE
import { storeToRefs } from "pinia"
import { useAuthStore } from "~/store/auth"

// Campos do formulário
const email = ref("")
const password = ref("")

// Usar o snackbar
const { notify } = useNotification()

// Regras e validade do formulário
const valid = ref(false)
const rules = {
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
}

// Função de autenticação da STORE
const { authenticateUser } = useAuthStore()
const { authenticated } = storeToRefs(useAuthStore())
const router = useRouter()

// Funções
async function login() {
	// Verifica se o formulário está preenchido corretamente
	if (valid.value) {
		// Feedback que está carregando a requisição
		notify({
			id: "loading",
			text: "Carregando...",
			type: "info",
		})

		// Envia os dados para o backend
		await authenticateUser({
			email: email.value,
			password: password.value,
		})
		if (authenticated.value) {
			// Redireciona para a dashboard
			router.push("/dashboard")
		} else {
			// Feedback de erro
			notify.close("loading")
			notify({
				title: "Erro de autenticação",
				text: "Não foi possível autenticar o usuário. Verifique os dados e tente novamente.",
				type: "error",
			})
		}
	} else {
		// feedback de erro
		notify({
			text: "Preencha os campos corretamente para continuar",
			type: "info",
		})
	}
}

// Layout da página e middlewares
definePageMeta({
	layout: "auth",
	middleware: ["auth"],
})

// Cabeçalho da página
useSeoMeta({
	description: "Página para login para acesso a dashboard.",
	keywords: "login, dashboard, acesso",
	title: "Login",
})
useHead({
	htmlAttrs: {
		lang: "pt-br",
	},
	link: [
		{
			rel: "icon",
			type: "image/png",
			href: "/favicon.png",
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
