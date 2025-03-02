<template>
	<nuxt-notifications />
	<v-container class="profile__wrapper pa-4 pa-md-8 ma-0" fluid>
		<div class="profile__title">
			<h1>Perfil</h1>
		</div>
		<div class="profile__imageLevel">
			<v-avatar class="text-center" size="82" color="#0D45AE">
				<span>
					LVL
					<br />
					<h2>
						{{ formData.level }}
					</h2>
				</span>
			</v-avatar>
			<v-avatar size="128" :image="formData.image" />
		</div>
		<div class="profile__forms">
			<v-form v-model="validForm" @submit.prevent>
				<v-row>
					<v-col cols="12" md="6">
						<h3 class="mb-2">Nome</h3>
						<v-text-field
							v-model="formData.name"
							:loading="status === 'pending'"
							:rules="rulesForm.name"
							type="text"
							variant="outlined"
							placeholder="Fulano..."
						/>
					</v-col>
					<v-col cols="12" md="6">
						<h3 class="mb-2">E-mail</h3>
						<v-text-field
							v-model="formData.email"
							:loading="status === 'pending'"
							:rules="rulesForm.email"
							type="email"
							variant="outlined"
							placeholder="fulano@ufpr.br"
						/>
					</v-col>
					<v-col cols="12" md="6">
						<h3 class="mb-2">Endereço (opcional)</h3>
						<v-text-field
							v-model="formData.address"
							:loading="status === 'pending'"
							type="text"
							variant="outlined"
							clearable
							placeholder="Rua dos hormônios"
						/>
					</v-col>
					<v-col cols="12" md="6">
						<h3 class="mb-2">Telefone (opcional)</h3>
						<v-text-field
							v-model="formData.telephone"
							:loading="status === 'pending'"
							type="tel"
							variant="outlined"
							clearable
							placeholder="(00) 12345-6789"
						/>
					</v-col>
					<v-col cols="12">
						<h3 class="mb-2">Trocar senha (opcional)</h3>
						<v-text-field
							v-model="formData.pwdChange"
							type="password"
							variant="outlined"
							clearable
							placeholder="Senha nova"
						/>
					</v-col>
				</v-row>
				<v-row class="ma-0 mt-4">
					<v-btn
						class="mr-4"
						color="#0D45AE"
						variant="outlined"
						@click="useRouter().push('/')"
					>
						Cancelar
					</v-btn>
					<v-btn
						:disabled="loadingRes"
						color="#0D45AE"
						type="submit"
						@click="updateUser()"
					>
						Salvar
					</v-btn>
				</v-row>
			</v-form>
		</div>
	</v-container>
</template>
<script setup lang="js">
// ENV (PAGE VARIABLES)
const urlRequistion = "/user"

const { notify } = useNotification()
const validForm = ref(true)
const loadingRes = ref(false)
const formData = reactive({
	image: "/images/placeholder/avatar.png",
	name: "",
	level: 0,
	address: "",
	email: "",
	telephone: "",
	pwdChange: "",
})
const rulesForm = {
	email: [
		(value) => (!value ? "O campo é obrigatório" : true),
		(value) =>
			!/^[\w+.]+@\w+\.\w{2,}(?:\.\w{2})?$/.test(value)
				? "O email deve ser válido"
				: true,
	],
	name: [(value) => (!value ? "O campo é obrigatório" : true)],
}

// Requisicao inicial
const { status, refresh } = useAsyncData("inicial-requistion", () =>
	useDataLoader(urlRequistion)
		.then((response) => {
			formData.image = response.image
			formData.name = response.name
			formData.level = response.level
			formData.address = response.address
			formData.email = response.email
			formData.telephone = response.telephone
			return response
		})
		.catch((error) => {
			console.error(error)
			notify({
				title: "Erro!",
				type: "error",
				text: formatError(error),
			})
			return {}
		}),
)

async function updateUser() {
	// Validacoes
	if (!validForm.value) return

	let __formDataOBJ = {}
	for (var key in formData) {
		if (key == "id" || key == "pwdChange") continue
		__formDataOBJ[key] = formData[key]
	}

	// // Trocar senha
	// if (formData.pwdChange !== "") {}

	const __formData = JSON.stringify(__formDataOBJ)

	loadingRes.value = true
	await useDataLoader(`${urlRequistion}`, {
		method: "PUT",
		body: __formData,
		"Content-Type": "application/json",
	})
		.then(() => {
			refresh()
			notify({
				title: "Usuário atualizado",
				type: "success",
			})
		})
		.catch((error) => {
			console.error(error)
			notify({
				title: "Erro ao atualizar!",
				type: "error",
				text: formatError(error),
			})
		})
	loadingRes.value = false
}

// Cabeçalhos da pagina
useSeoMeta({
	title: "Editar perfil",
	description: "",
})
definePageMeta({
	middleware: ["guest"],
})
</script>
<style lang="css" scoped>
.profile__wrapper {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	gap: 32px;
}

.profile__imageLevel,
.profile__forms,
.profile__title {
	width: 100%;
}

.profile__imageLevel {
	display: flex;
	justify-content: space-between;
	align-items: center;
}
</style>
