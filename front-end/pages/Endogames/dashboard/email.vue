<template>
	<v-row class="content-container">
		<nuxt-notifications />
		<div class="items-container">
			<h1 class="title">Informações sobre o email</h1>
			<v-text-field
				v-model="currentEmail"
				label="E-mail atual"
				variant="solo-filled"
				class="email-text-field"
			></v-text-field>
			<v-btn
				prepend-icon="mdi-email-sync"
				color="#1356D3"
				class="email-btn mt-5"
				@click="dialog = true"
			>
				<span class="button"> Mudar e-mail </span>
			</v-btn>
		</div>
	</v-row>
	<v-dialog v-model="dialog" width="380" height="325" persistent>
		<v-card
			max-width="400"
			min-width="200"
			class="pa-4"
			prepend-icon="mdi-update"
			text="Digite o seu novo e-mail"
			title="Mudança de e-mail"
		>
			<v-card-text>
				<v-text-field
					v-model="email"
					variant="outlined"
					label="Novo E-mail"
					type="email"
					required
					:rules="rules.email"
				/>
			</v-card-text>
			<v-card-actions class="justify-start ml-5">
				<v-btn
					variant="flat"
					:loading="loadingRes"
					text="Atualizar"
					color="primary"
					@click="updateEmail"
				></v-btn>
				<v-btn
					variant="outlined"
					text="Cancelar"
					color="primary"
					@click="dialog = false"
				></v-btn>
			</v-card-actions>
		</v-card>
	</v-dialog>
</template>

<script setup>
const { notify } = useNotification()
const actualProjectId = useRoute().query.id

const email = ref("")
const currentEmail = ref("")
const loadingRes = ref(false)

const rules = {
	email: [
		(value) => !!value || "O campo é obrigatório",
		(value) => /\S+@\S+\.\S+/.test(value) || "E-mail inválido",
	],
}

async function fetchEmail() {
	try {
		const response = await useDataLoader(
			"http://127.0.0.1:8000/api/user/1",
			{
				method: "GET",
			},
		)
		console.log("Valor = ", response)
		currentEmail.value = response.email
	} catch (error) {
		notify({
			title: "Erro ao buscar e-mail",
			text: error.message || "Falha ao buscar o erro",
			type: "error",
		})
	}
}

async function updateEmail() {
	loadingRes.value = true

	if (!rules.email.every((rule) => rule(email.value) === true)) {
		notify({
			title: "Erro",
			text: "Insira um e-mail válido.",
			type: "error",
		})
		loadingRes.value = false
		return
	}

	const data = {
		id: 1,
		email: email.value,
	}

	await useDataLoader("http://localhost:4000/e-mail/1", {
		method: "PUT",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify(data),
	})
		.then(() => {
			dialog.value = false
			loadingRes.value = false
			notify({
				title: "Sucesso",
				text: "E-mail atualizado com sucesso",
				type: "success",
			})
			email.value = ""
			setTimeout(() => location.reload(), 500)
		})
		.catch((error) => {
			loadingRes.value = false
			notify({
				title: "Erro durante a requisição",
				type: "error",
				text: error.message || "Falha durante o processamento",
			})
		})
}

const dialog = ref(false)

watch(email, (newValue) => {
	console.log("E-mail digitado:", newValue)
})

onMounted(fetchEmail)

definePageMeta({
	layout: "dashboard",
	middleware: ["guest", "admin"],
})
</script>

<style scoped>
.content-container {
	padding: 2rem;
	display: flex;
	justify-content: center;
	align-content: center;
	height: 100%;
}

.items-container {
	background-color: #1356d3;
	align-content: center;
	justify-items: center;
	width: 30rem;
	height: 20rem;
	border-radius: 1rem;
	box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
}

.title {
	font-family: "Roboto", sans-serif;
	margin-bottom: 2.5em;
	margin-top: 1rem;
	color: #ffffff;
}

.email-text-field {
	width: 25rem;
	font-family: "Roboto", sans-serif;
	font-size: 1rem;
	box-shadow: 10px rgba(70, 40, 40, 0.3);
}

.email-btn {
	width: 15rem;
	height: 3rem;
	box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
}

.button {
	font-family: "Roboto", sans-serif !important;
	font-size: 1rem !important;
	text-transform: capitalize !important;
}
</style>
