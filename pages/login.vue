<template>
	<Head>
		<Title>Página inicial</Title>
		<meta
			name="description"
			content="Página inicial do projeto base 2024 da Ecomp."
		/>
	</Head>
	<v-container fluid class="ma-0 pa-0 text-center">
		<TitleAuth :title="'Tela de Login'" />
		<v-form fast-fail @submit.prevent>
			<v-text-field
				class="mt-3"
				v-model="email"
				label="E-mail"
				:rules="emptyFieldRule"
			></v-text-field>
			<v-text-field
				class="mt-3"
				v-model="password"
				label="Senha"
				:rules="emptyFieldRule"
			></v-text-field>
		</v-form>
		<span class="mt-6"> Esqueceu a senha? </span>
	</v-container>
</template>
<script setup>
// Importing components
import TitleAuth from "~/components/sections/auth/TitleAuth.vue";

// Importing functions and vue hooks
import { ref } from "vue";

// Variables
const email = ref("");
const password = ref("");
const emptyFieldRule = [
	(value) => {
		if (value) return true;
		return "O campo é obrigatório";
	},
];

definePageMeta({
	layout: "auth",
});
</script>
<style scoped></style>
