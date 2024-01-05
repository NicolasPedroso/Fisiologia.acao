<template>
	<!-- SnackBar -->
	<v-snackbar
		v-model="snackbar.active"
		:color="snackbar.color"
		position="fixed"
		location="top right"
	>
		{{ snackbar.text }}
	</v-snackbar>
	<!-- SnackBar -->
	<!-- Conteudo da pagina -->
	<v-container fluid class="ma-0 pa-0 text-center">
		<TitleAuth :title="'Registro'" />
		<v-form @submit.prevent v-model="valid">
			<v-text-field
				class="mt-3 mr-10"
				label="Nome"
				prepend-icon="mdi-account"
				v-model="name"
				:rules="rules.name"
			/>
			<v-text-field
				class="mt-3 mr-10"
				label="E-mail"
				prepend-icon="mdi-email"
				v-model="email"
				:rules="rules.email"
			/>
			<v-text-field
				class="mt-3"
				label="Senha"
				prepend-icon="mdi-lock"
				v-model="password"
				:rules="rules.password"
				:type="show ? 'text' : 'password'"
				:append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
				@click:append="show = !show"
			/>
			<v-text-field
				class="mt-3"
				label="Confirmar senha"
				prepend-icon="mdi-lock"
				v-model="passwordC"
				:rules="rules.passwordC"
				:type="show ? 'text' : 'password'"
				:append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
				@click:append="show = !show"
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
import TitleAuth from "~/components/auth/TitleAuth.vue";
import { ref } from "vue";

// Campos do formulário
const name = ref("");
const email = ref("");
const password = ref("");
const passwordC = ref("");

const show = ref(false);

// Campos e variaveis da snackbar
const snackbar = ref({
	text: "",
	color: "",
	active: false,
});
// Regras e validade do formulário
const valid = ref(false);
const rules = {
	name: [
		(value) => {
			if (value) return true;
			return "O campo é obrigatório";
		},
	],
	email: [
		(value) => {
			if (value) return true;
			return "O campo é obrigatório";
		},
		(value) => {
			if (/^[a-z0-9.]+@[a-z0-9]+\.[a-z]+(\.[a-z]+)?$/i.test(value))
				return true;
			return "O e-mail deve ser válido";
		},
	],
	password: [
		(value) => {
			if (value) return true;
			return "O campo é obrigatório";
		},
	],
	passwordC: [
		(value) => {
			if (value) return true;
			return "O campo é obrigatório";
		},
		(value) => {
			if (value === password.value) return true;
			return "As senhas não se coincidem";
		},
	],
};

// Funções
function signIn() {
	// Verifica se o formulário está preenchido corretamente
	if (valid.value) {
		// Envia os dados para o backend

		// Snackbar alert
		snackbar.value = {
			text: "Não foi possível fazer o registro",
			color: "error",
			active: true,
		};
	}
}

// Layout da página e cabeçalho
definePageMeta({
	layout: "auth",
});
useSeoMeta({
	title: "Registro",
	description: "Página de registro para a dashboard.",
});
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
});
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
