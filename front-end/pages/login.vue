<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container fluid class="ma-0 pa-0 text-center">
		<v-form v-model="valid" @submit.prevent>
			<h1 class="my-4">Email</h1>
			<v-text-field
				v-model="email"
				label="E-mail"
				variant="outlined"
				:rules="rules.email"
				class="field-content mt-3"
				tile
				hint
			/>
			<h1 class="my-4">Senha</h1>
			<v-text-field
				v-model="password"
				class="field-content mt-3"
				label="Senha"
				variant="outlined"
				:type="showPassword ? 'text' : 'password'"
				:rules="rules.password"
				:append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
				@click:append-inner="togglePassword"
			/>
			<v-btn
				type="submit"
				class="login-btn rounded-lg my-12"
				variant="outlined"
				@click="login"
			>
				<h1>Entrar</h1>
			</v-btn>
		</v-form>
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

const showPassword = ref(false)

const togglePassword = () => {
	showPassword.value = !showPassword.value
}

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
		console.log("ENTROU")
		console.log("email e senha =", email.value, password.value)
		// Feedback que está carregando a requisição
		notify({
			id: "loading",
			text: "Carregando...",
			type: "info",
		})
		console.log("ENTROU")
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
			console.log("Deu erro")
			router.push("/dashboard")
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
h1 {
	align-self: flex-start;
	text-align: left;
	font-size: 28px;
}

:deep(.v-field__outline) {
	--v-field-border-width: 3px !important;
	--v-field-border-opacity: 1 !important;
}

.login-btn {
	width: 100%;
	height: 5rem;
	background-color: #0d45ae;
	color: #ffffff;
	box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
	transition: box-shadow 0.3s ease;
}

.login-btn:hover {
	box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.register-link {
	font-size: 28px;
}

.auth-link {
	color: black;
	font-size: 1.1rem;
	text-decoration: none;
	font-weight: 600;
}

:deep(.v-text-field input) {
	font-size: 1.5rem;
}

.auth-link:hover {
	color: #0d45ae;
}
</style>
