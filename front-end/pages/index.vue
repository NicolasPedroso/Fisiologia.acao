<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container fluid class="ma-0 pa-0 text-center">
		<h1 class="text-center">Entre no Fisiologia Em Ação</h1>
		<h3 class="description text-center mb-12">
			Estude melhor, avance mais rápido. Faça login e mergulhe na
			fisiologia!
		</h3>

		<v-form v-model="valid" @submit.prevent>
			<v-text-field
				v-model="email"
				label="Insira seu E-mail"
				prepend-inner-icon="mdi-email-outline"
				variant="outlined"
				:rules="rules.email"
				class="field-content mt-3"
				tile
				hint
				type="email"
			/>
			<v-text-field
				v-model="password"
				class="field-content mt-3"
				label="Insira sua Senha"
				prepend-inner-icon="mdi-lock-outline"
				variant="outlined"
				:type="showPassword ? 'text' : 'password'"
				:rules="rules.password"
				:append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
				@click:append-inner="togglePassword"
			/>
			<v-row class="align-center justify-space-between mr-1">
				<v-checkbox
					v-model="remember_me"
					hide-details
					label="Permanecer logado"
				/>
				<!-- <nuxt-link class="link" to="/esqueceu-a-senha">
					Esqueceu a senha?
				</nuxt-link> -->
			</v-row>
			<v-btn
				type="submit"
				class="login-btn rounded-lg mt-8"
				variant="outlined"
				@click="login"
			>
				<span class="login-btn__text"> Entrar </span>
			</v-btn>
		</v-form>
		<div class="mt-1 text-center">
			<nuxt-link class="text-center link mb-4" to="/cadastro">
				<span>
					Não tem uma conta ainda?
					<strong>Clique aqui</strong>
				</span>
			</nuxt-link>
		</div>
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
const remember_me = ref(false)

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
		// Feedback que está carregando a requisição
		notify({
			id: "loading",
			text: "Carregando...",
			type: "info",
		})
		// Envia os dados para o backend
		try {
			await authenticateUser({
				email: email.value,
				password: password.value,
				remember_me: remember_me.value,
			})
			if (authenticated.value) {
				// Redireciona para a dashboard
				router.push("/fisiologia")
			} else {
				// Feedback de erro, caso a autenticação não tenha sido bem-sucedida
				notify.close("loading")
				notify({
					title: "Erro de autenticação",
					text: "Dados inválidos",
					type: "error",
				})
			}
		} catch (error) {
			notify.close("loading")
			notify({
				title: "Erro de autenticação",
				text: "Usuário inexistente",
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
	layout: "login",
	middleware: ["auth"],
})
useSeoMeta({
	title: "Login - Fisiologia em Ação",
	description: "Faça login na Fisiologia em Ação",
	keywords: "login, acesso, fisiologia, ação",
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
	--v-field-border-width: 2px !important;
	--v-field-border-opacity: 1 !important;
}
:deep(.v-field__overlay) {
	background-color: #ffff !important;
}

.login-btn {
	width: 100%;
	height: 3.5rem;
	font-size: 1.5rem;
	line-height: 0;
	font-weight: 600;
	background-color: var(--secondary-color);
	color: #ffffff;
	transition: background-color 1s ease;

	display: flex;
	justify-content: center;
	align-items: center;
}

.login-btn:hover {
	background-color: var(--primary-color);
}

.login-btn__text {
	font-size: 1.2rem;
	line-height: 1.2rem;
	letter-spacing: 0.05rem;
	text-transform: none;
	font-weight: 600;
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
