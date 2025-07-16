<template>
	<NuxtNotifications />
	<!-- Conteudo da pagina -->
	<v-container fluid class="ma-0 pa-0 text-left">
		<h1 class="text-center">Cadastre-se no Fisiologia em Ação</h1>
		<h3 class="description text-center mb-6">
			Estude com quizzes inteligentes. Cadastre-se e aproveite!
		</h3>

		<v-form v-model="valid" @submit.prevent>
			<v-text-field
				v-model="name"
				label="Nome"
				prepend-inner-icon="mdi-account"
				variant="outlined"
				:rules="rules.required"
				class="field-content mt-3"
				tile
				hint
				hide-details
			/>
			<v-text-field
				v-model="email"
				label="E-mail"
				prepend-inner-icon="mdi-email-outline"
				variant="outlined"
				:rules="rules.email"
				class="field-content mt-3"
				tile
				hint
				hide-details
				type="email"
			/>
			<v-file-input
				v-model="imageFile"
				label="Imagem de perfil"
				prepend-inner-icon="mdi-image"
				prepend-icon=""
				variant="outlined"
				:rules="rules.image"
				accept="image/jpg,image/jpeg,image/png"
				class="field-content mt-3"
				tile
				hint
				hide-details
				show-size
			/>
			<v-text-field
				v-model="address"
				label="Endereço"
				prepend-inner-icon="mdi-road-variant"
				variant="outlined"
				class="field-content mt-3"
				tile
				hint
				:rules="rules.required"
				hide-details
			/>
			<v-text-field
				v-model="phone"
				label="Telefone"
				prepend-inner-icon="mdi-phone"
				variant="outlined"
				class="field-content mt-3"
				tile
				hint
				hide-details
				type="tel"
				:rules="rules.phone"
				@input="formatPhone"
			/>
			<v-text-field
				v-model="password"
				class="field-content mt-3"
				label="Insira sua senha"
				prepend-inner-icon="mdi-lock-outline"
				variant="outlined"
				type="password"
				:rules="rules.required"
				hide-details
			/>
			<v-text-field
				v-model="passwordConfirmation"
				class="field-content mt-3"
				label="Confirme sua senha"
				prepend-inner-icon="mdi-lock-outline"
				variant="outlined"
				type="password"
				:rules="rules.passwordConfirmation"
				hide-details
			/>
			<v-btn
				type="submit"
				class="login-btn rounded-lg mt-4"
				variant="outlined"
				:disabled="!valid"
				@click="login"
			>
				<span class="login-btn__text"> Cadastrar </span>
			</v-btn>
		</v-form>
		<div class="mt-1 text-center">
			<nuxt-link class="text-center link mb-4" to="/">
				<span>
					Já tem uma conta?
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
const name = ref("")
const email = ref("")
const password = ref("")
const phone = ref("")
const address = ref("")
const passwordConfirmation = ref("")
const imageFile = ref(null)

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
	required: [
		(value) => {
			if (value) return true
			return "O campo é obrigatório"
		},
	],
	phone: [
		(value) => {
			if (value) return true
			return "O campo é obrigatório"
		},
		(value) => {
			if (value.length == 15) return true
			return "O telefone deve ser válido"
		},
	],
	image: [
		(value) => {
			if (value && value[0]) return true
			return "A imagem é obrigatória"
		},
		(value) => {
			if (value[0] && value[0].size < 5000000) return true
			return "A imagem deve ser menor que 5MB"
		},
	],
	passwordConfirmation: [
		(value) => {
			if (value) return true
			return "O campo é obrigatório"
		},
		(value) => {
			if (value === password.value) return true
			return "As senhas não coincidem"
		},
	],
}

const formatPhone = () => {
	let cleaned = phone.value.replace(/\D/g, "").slice(0, 11)

	if (cleaned.length > 2) {
		cleaned = `(${cleaned.slice(0, 2)}) ${cleaned.slice(2, 7)}-${cleaned.slice(7)}`
	}

	phone.value = cleaned
}

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

		const formData = new FormData()
		formData.append("name", name.value)
		formData.append("email", email.value)
		formData.append("phone", phone.value)
		formData.append("address", address.value || "")
		formData.append("password", password.value)
		formData.append("password_confirmation", passwordConfirmation.value)
		formData.append("image", imageFile.value)

		// Envia os dados para o backend
		try {
			await useDataLoader("/api/signup", {
				method: "POST",
				body: formData,
			})

			notify.close("loading")
			router.push("/")
		} catch (error) {
			notify.close("loading")
			notify({
				title: "Erro ao criar conta",
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
	layout: "login",
	middleware: ["auth"],
})
useSeoMeta({
	title: "Cadastro - Fisiologia em Ação",
	description: "",
	keywords: "cadastro, acesso, fisiologia, ação",
})
</script>
<style scoped>
h1 {
	align-self: flex-start;
	text-align: left;
	font-size: 28px;
}

:deep(.v-field__outline) {
	--v-field-border-width: 1px !important;
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
	font-size: 1rem;
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
