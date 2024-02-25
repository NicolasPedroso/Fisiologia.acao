<template>
	<!-- Conteudo da pagina -->
	<v-container fluid class="ma-0 pa-0 text-center">
		<TitleAuth :title="'Registro'" />
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
// Importing components and vue functions
import TitleAuth from "~/components/auth/TitleAuth.vue"
import { ref } from "vue"

// Campos do formulário
const name = ref("")
const email = ref("")
const newPassword = ref("")
const newPasswordC = ref("")

// Campos e variaveis da snackbar
const snackbar = useSnackbar()

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
		// Envia os dados para o backend
		const formSignup = new FormData()
		formSignup.append("namr", name.value)
		formSignup.append("email", email.value)
		formSignup.append("password", newPassword.value)
		formSignup.append("password_confirmation", newPasswordC.value)

		useDataLoader("/api/signup", {
			method: "POST",
			body: formSignup,
		})
			.then(() => {
				// Feedback do erro por meio da snackbar
				snackbar.add({
					type: "success",
					text: "Usuário criado com sucesso!",
				})
			})
			.catch(({ response: error }) => {
				// Snackbar alert
				const status = error.status

				// Formata os erros em uma string para
				const errors = arrayToString(extrairStrings(error._data))

				// Feedback do erro
				console.error(error)
				snackbar.add({
					type: "error",
					title: `Não foi possível registrar - ${status}`,
					text: `${errors}`,
				})
			})
	}
}

// Retorna todas as strings de um objeto de proprieades nao definidas
function extrairStrings(objeto) {
	const strings = []
	// Itera sobre todas as propriedades do objeto
	for (const chave in objeto) {
		// Verifica se a propriedade é um array
		if (Array.isArray(objeto[chave])) {
			// Itera sobre os elementos do array
			objeto[chave].forEach((item) => {
				// Verifica se o elemento é uma string
				if (typeof item === "string") {
					// Adiciona a string ao array de strings
					strings.push(item)
				}
			})
		}
	}
	return strings
}

// Pega um array e transforma numa string do tipo 'pos1 & pos2 & pos3'
function arrayToString(arr) {
	return arr.join(" & ")
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
