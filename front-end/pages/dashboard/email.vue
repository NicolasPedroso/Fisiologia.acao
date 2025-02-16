<template>
	<v-row class="ma-0 pa-0 h-100 d-flex justify-center">
		<nuxt-notifications />
		<v-col cols="12" class="content-container">
			<v-btn
				height="50"
				width="200"
				prepend-icon="mdi-email-sync"
				color="#1356D3"
				class="mt-2 ml-2"
				@click="dialog = true"
			>
				<span class="button"> Mudar e-mail </span>
			</v-btn>
		</v-col>
		<v-dialog v-model="dialog" width="380" height="325" persistent>
			<v-card
				max-width="400"
				min-width="200"
				class="pa-4"
				prepend-icon="mdi-update"
				text="Digite um e-mail válido"
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
	</v-row>
</template>

<script setup>
const { notify } = useNotification()

const email = ref("")
const loadingRes = ref(false)

const rules = {
	email: [
		(value) => !!value || "O campo é obrigatório",
		(value) => /\S+@\S+\.\S+/.test(value) || "E-mail inválido",
	],
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
				text: "E-mail atualizado",
				type: "success",
			})
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

definePageMeta({
	layout: "dashboard",
	middleware: ["guest", "admin"],
})

</script>

<style scoped>
.content-container {
	display: flex;
	flex-direction: column;
	align-items: center;
}

.buttons-container {
	display: flex;
	justify-content: start;
	justify-items: start;
}

.button {
	font-family: "Roboto", sans-serif !important;
	font-size: 16px !important;
	text-transform: capitalize !important;
}
</style>
