<template>
	<v-row class="content-container">
		<nuxt-notifications />
		<div class="items-container">
			<div class="internal-blue-container pa-3 d-flex justify-center">
				<h1 class="title-internal-blue-container mr-1 mt-2">
					E-mail administrador
				</h1>
			</div>
			<div>
				<h1 class="title mb-8">Informações sobre o email</h1>
				<span class="label-title mb-2"> E-mail atual </span>
				<v-text-field
					v-model="currentEmail"
					label="E-mail atual"
					variant="solo-filled"
					class="email-text-field"
				></v-text-field>
				<span class="label-title mb-2"> Novo e-mail </span>
				<v-text-field
					v-model="email"
					class="email-text-field"
					variant="solo-filled"
					label="Novo E-mail"
					type="email"
					:rules="rules.email"
				/>
				<div class="d-flex justify-center">
					<v-btn
						prepend-icon="mdi-email-edit"
						color="var(--secondary-color)"
						class="email-btn mt-5 mb-9"
						@click="updateEmail"
					>
						<span class="button"> Mudar e-mail </span>
					</v-btn>
				</div>
			</div>
		</div>
	</v-row>
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
			// uso o primeiro usuário pelo admin ser definido no seeder, não existir a criação de usuário por outros métodos
			"http://127.0.0.1:8000/api/user/1",
			{
				method: "GET",
			},
		)
		currentEmail.value = response.data.email
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

	await useDataLoader("http://127.0.0.1:8000/api/user/1", {
		method: "PUT",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({ email: email.value }),
	})
		.then(() => {
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
onMounted(fetchEmail)

definePageMeta({
	layout: "dashboard",
	middleware: ["guest", "admin"],
})
</script>

<style scoped>
.content-container {
	display: flex;
	justify-content: center;
	align-content: center;
	height: 100%;
}

.label-title {
	display: flex;
	align-content: start;
	justify-content: start;
	font-family: "Roboto", sans-serif;
	font-weight: 600;
}

.blue-container-title {
	font-family: "Roboto", sans-serif;
	font-weight: 500;
	color: #ffffff;
}

.internal-blue-container {
	background-color: var(--secondary-color);
	width: 100%;
	height: 6rem;
	position: relative;
	bottom: 2rem;
	border-top-right-radius: 10px;
	border-top-left-radius: 10px;
	box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
}

.title-internal-blue-container {
	color: #ffffff;
	font-family: "Roboto", sans-serif;
	font-weight: 600;
}

.items-container {
	background-color: #ffffff;
	align-content: center;
	justify-items: center;
	width: 40rem;
	height: 33rem;
	border-radius: 10px;
	box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
}

.title {
	font-family: "Roboto", sans-serif;
}

.email-text-field {
	width: 25rem;
	font-family: "Roboto", sans-serif;
	font-size: 1rem;
	box-shadow: 10px rgba(70, 40, 40, 0.3);
}

.email-btn {
	display: flex;
	width: 25rem;
	height: 3rem;
	box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
}

:deep(.mdi-email-edit::before) {
	color: #fff !important;
}
.button {
	font-family: "Roboto", sans-serif !important;
	color: #fff !important;
	font-size: 1rem !important;
	text-transform: capitalize !important;
}
</style>
