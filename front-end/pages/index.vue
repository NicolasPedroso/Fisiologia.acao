<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container fluid class="ma-0 pa-0 text-center">
		<v-row>
			<v-col cols="12" md="7" class="ma-12">
				<v-form v-model="valid" @submit.prevent>
					<h1>E-mail</h1>
					<v-text-field
						v-model="email"
						label="Insira seu E-mail"
						variant="outlined"
						:rules="rules.email"
						class="field-content mt-3"
						tile
						hint
					/>
					<h1 class="mt-2">Senha</h1>
					<v-text-field
						v-model="password"
						class="field-content mt-3"
						label="Insira sua Senha"
						variant="outlined"
						:type="showPassword ? 'text' : 'password'"
						:rules="rules.password"
						:append-inner-icon="
							showPassword ? 'mdi-eye-off' : 'mdi-eye'
						"
						@click:append-inner="togglePassword"
					/>
					<v-row class="align-center justify-space-between mr-1">
						<v-checkbox hide-details label="Permanecer logado" />
						<nuxt-link class="auth-link" to="/">
							Esqueceu a senha?
						</nuxt-link>
					</v-row>
					<v-btn
						type="submit"
						class="login-btn rounded-lg mt-8"
						variant="outlined"
						@click="login"
					>
						<h1>Entrar</h1>
					</v-btn>
				</v-form>
				<div class="mt-1 text-start">
					<nuxt-link class="text-start auth-link mb-4" to="/cadastro">
						<span>
							Não tem uma conta ainda?
							<strong>Clique aqui</strong>
						</span>
					</nuxt-link>
				</div>
			</v-col>
			<v-col
				class="d-none d-md-flex align-center justify-center"
				cols="12"
				md="4"
			>
				<!-- Imagem-->
			</v-col>
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
			})
			if (authenticated.value) {
				// Redireciona para a dashboard
				router.push("/Endogames")
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

// Cabeçalho da página
useSeoMeta({
	description: "Página para login para acesso a dashboard.",
	keywords: "login, dashboard, acesso",
})
useHead({
	htmlAttrs: {
		lang: "pt-br",
	},
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

.login-btn {
	width: 100%;
	height: 4.5rem;
	background-color: var(--primary-color);
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
	font-size: 1rem;
	text-decoration: none;
	font-weight: 200;
	transition: all 0.25s;
}

.field-content :deep(.v-field__outline) {
	border-radius: 8px;
}

:deep(.v-text-field input) {
	font-size: 1.2rem;
}

.auth-link strong {
	font-weight: 800;
	color: var(--secondary-color);
}

.auth-link:hover {
	color: var(--secondary-color);
	text-decoration: underline;
}
</style>
