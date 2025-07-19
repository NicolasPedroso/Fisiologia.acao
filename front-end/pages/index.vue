<template>
	<NuxtNotifications />
	<!-- Página de login -->
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
</template>
<script setup>
/**
 * Página de login do sistema
 * Gerencia autenticação de usuários e redirecionamento
 */

import { storeToRefs } from "pinia"
import { useAuthStore } from "~/store/auth"

// Campos do formulário
const email = ref("")
const password = ref("")
const remember_me = ref(false)
const showPassword = ref(false)
const valid = ref(false)

const { notify } = useNotification()

/**
 * Alterna visibilidade da senha
 */
const togglePassword = () => {
	showPassword.value = !showPassword.value
}

// Regras de validação do formulário
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

// Store de autenticação
const { authenticateUser } = useAuthStore()
const { authenticated } = storeToRefs(useAuthStore())
const router = useRouter()

/**
 * Função de login
 * Valida formulário e autentica usuário
 */
async function login() {
	if (valid.value) {
		notify({
			id: "loading",
			text: "Carregando...",
			type: "info",
		})

		try {
			await authenticateUser({
				email: email.value,
				password: password.value,
				remember_me: remember_me.value,
			})

			if (authenticated.value) {
				router.push("/fisiologia")
			} else {
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

definePageMeta({
	layout: "login",
	middleware: ["auth"],
})

useSeoMeta({
	title: "Login - Fisiologia em Ação",
	description: "Faça login na Fisiologia em Ação",
	keywords: "login, acesso, fisiologia, ação",
})
</script>
<style scoped>
/* Estilo do título principal */
h1 {
	align-self: flex-start;
	text-align: left;
	font-size: 28px;
}

/* Customização dos campos de input */
:deep(.v-field__outline) {
	--v-field-border-width: 2px !important;
	--v-field-border-opacity: 1 !important;
}

:deep(.v-field__overlay) {
	background-color: #ffff !important;
}

/* Estilo do botão de login */
.login-btn {
	width: 100%;
	height: 3.5rem;
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
	text-transform: none;
	font-weight: 600;
}

/* Estilo dos links */
.link {
	color: var(--secondary-color);
	font-size: 1rem;
	text-decoration: underline;
	font-weight: 400;
	transition: all 0.25s;
	text-align: center;
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

/* Estilo dos campos de texto */
.field-content :deep(.v-field__outline) {
	border-radius: 8px;
}

:deep(.v-text-field input) {
	font-size: 1.2rem;
}

.description {
	font-weight: 400;
}
</style>
