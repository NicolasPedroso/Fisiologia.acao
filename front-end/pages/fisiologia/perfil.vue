<template>
	<div style="width: 100%; height: 100%">
		<nuxt-notifications />
		<v-container
			v-if="status !== 'pending'"
			class="profile__wrapper pa-0 ma-0"
			full-height
			fluid
		>
			<div
				class="profile__content d-flex flex-column align-center justify-center py-12"
			>
				<v-avatar
					class="profile__image"
					size="200"
					:image="formatImage(user.image)"
				/>

				<h1 class="mt-2">{{ user.name }}</h1>

				<div class="profile__row__wrapper mt-6">
					<v-row class="pa-0 ma-0 ga-8 align-center justify-center">
						<div
							class="information__wrapper d-flex align-center"
							style="width: 90vw"
						>
							<div style="max-width: 50%">
								<h3>Informações do perfil</h3>
								<p>
									Altere suas informações pessoais e foto de
									perfil
								</p>
							</div>
							<v-spacer />
							<div class="information__actions d-flex ga-2">
								<!-- <v-btn
									elevation="0"
									color="error"
									variant="tonal"
									class="button__action"
									prepend-icon="mdi-delete"
									@click="deleteAccount"
								>
									Deletar conta
								</v-btn> -->
								<v-btn
									elevation="0"
									color="primary"
									variant="tonal"
									class="button__action"
									prepend-icon="mdi-logout"
									@click="logout()"
								>
									Sair da conta
								</v-btn>
								<v-btn
									elevation="0"
									color="var(--primary-color)"
									class="button__action"
									@click="openCreateUser"
								>
									<span style="color: var(--white)">
										Editar perfil
									</span>
								</v-btn>
							</div>
						</div>

						<v-divider class="border-opacity-75" length="90%" />

						<div
							class="personal__info__wrapper d-flex align-center"
							style="width: 90vw"
						>
							<div style="max-width: 50%">
								<h3>Perfil público</h3>
								<p>
									Seu nome é disponibilizado para outros
									<br />
									O seu email é privado
								</p>
							</div>
							<v-spacer />
							<div class="text-left">
								<span>
									<strong>Nome:</strong>
									{{ user.name }}
								</span>
								<br />
								<span>
									<strong>Email:</strong>
									{{ user.email }}
								</span>
							</div>
						</div>

						<v-divider class="border-opacity-75" length="90%" />

						<div
							class="personal__info__wrapper d-flex align-center"
							style="width: 90vw"
						>
							<div style="max-width: 50%">
								<h3>Foto de perfil</h3>
								<p>Foto compartilhada com outros usuários.</p>
							</div>
							<v-spacer />
							<div class="text-left">
								<v-img
									width="200px"
									height="200px"
									:src="formatImage(user.image)"
									:aspect-ratio="1 / 1"
									cover
									class="profile__image"
								/>
							</div>
						</div>

						<v-divider class="border-opacity-75" length="90%" />

						<div
							class="personal__info__wrapper d-flex align-center"
							style="width: 90vw"
						>
							<div style="max-width: 50%">
								<h3>Informações pessoais (opcionais)</h3>
								<p>Relacionado a contato, apenas.</p>
							</div>
							<v-spacer />
							<div class="text-left">
								<span>
									<strong>Endereço:</strong>
									{{ user.address }}
								</span>
								<br />
								<span>
									<strong>Telefone:</strong>
									{{ user.phone }}
								</span>
							</div>
						</div>
					</v-row>
				</div>
			</div>
			<Loading :status="status" />
			<v-dialog v-model="isEditing" transition="slide-y-transition">
				<v-card class="pa-8">
					<v-card-title class="text-center">
						Altere suas informações
					</v-card-title>

					<v-form v-model="validForm" @submit.prevent>
						<v-text-field
							v-model="userForm.name"
							label="Nome"
							prepend-inner-icon="mdi-account"
							variant="outlined"
							:rules="rules.required"
							class="field-content mt-3"
							tile
							hint
							hide-details="auto"
						/>
						<v-text-field
							v-model="userForm.email"
							label="E-mail"
							prepend-inner-icon="mdi-email-outline"
							variant="outlined"
							:rules="rules.email"
							class="field-content mt-3"
							tile
							hint
							hide-details="auto"
							type="email"
						/>
						<v-text-field
							v-model="userForm.address"
							label="Endereço"
							prepend-inner-icon="mdi-road-variant"
							variant="outlined"
							class="field-content mt-3"
							tile
							hint
							:rules="rules.required"
							hide-details="auto"
						/>
						<v-text-field
							v-model="userForm.phone"
							label="Telefone"
							prepend-inner-icon="mdi-phone"
							variant="outlined"
							class="field-content mt-3"
							tile
							hint
							hide-details="auto"
							type="tel"
							:rules="rules.phone"
							@input="formatPhone"
						/>

						<h3 class="mt-4">Foto de perfil (opcional)</h3>
						<v-file-input
							v-model="userForm.imageFile"
							label="Imagem de perfil"
							prepend-inner-icon="mdi-image"
							prepend-icon=""
							variant="outlined"
							:rules="rules.image"
							accept="image/jpg,image/jpeg,image/png"
							class="field-content mt-3"
							tile
							hint
							hide-details="auto"
							show-size
						/>

						<div class="d-flex justify-end ga-4">
							<v-btn
								class="rounded-lg mt-4"
								variant="text"
								color="error"
								:disabled="loadingRes"
								@click="cancelEdit()"
							>
								<span class="login-btn__text"> Cancelar </span>
							</v-btn>
							<v-btn
								type="submit"
								class="login-btn rounded-lg mt-4"
								color="primary"
								:loading="loadingRes"
								@click="updateUser()"
							>
								<span class="login-btn__text">
									Atualizar cadastro
								</span>
							</v-btn>
						</div>
					</v-form>
				</v-card>
			</v-dialog>
		</v-container>
	</div>
</template>
<script setup>
// Requisicao inicial
const {
	data: user,
	error,
	status,
	refresh,
} = useAsyncData("fetch-user-profile", () => useDataLoader(urlRequistion), {
	server: true,
})

watch(error, (newError) => {
	if (newError && process.client) {
		notify({
			title: "Erro!",
			type: "error",
			text: formatError(newError),
		})
	}
})

import { useAuthStore } from "~/store/auth"

const { logUserOut } = useAuthStore()
const { notify } = useNotification()

const urlRequistion = "/api/user"

const userForm = reactive({
	imageFile: null,
	name: "",
	address: "",
	email: "",
	phone: "",
})

const userNameForTitle = ref("Perfil")
const validForm = ref(false)
const isEditing = ref(false)
const loadingRes = ref(false)

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
			if (!value || value.length === 0) return true
			if (value[0] && value[0].size < 5000000) return true
			return "A imagem deve ser menor que 5MB"
		},
	],
}

const formatPhone = () => {
	let cleaned = userForm.phone.replace(/\D/g, "").slice(0, 11)

	if (cleaned.length > 2) {
		cleaned = `(${cleaned.slice(0, 2)}) ${cleaned.slice(2, 7)}-${cleaned.slice(7)}`
	}

	userForm.phone = cleaned
}

function openCreateUser() {
	isEditing.value = true
	userForm.imageFile = null
	userForm.name = user.value.name
	userForm.address = user.value.address
	userForm.email = user.value.email
	userForm.phone = user.value.phone
}

function deleteAccount() {
	// Implementar a lógica de exclusão de conta
	const ok = confirm("Tem certeza que deseja excluir sua conta?")
	if (!ok) return

	notify({
		title: "Conta excluída",
		type: "success",
	})

	// TODO: Implementar a exclusão de conta no backend
}

async function logout() {
	const ok = confirm("Tem certeza que deseja sair?")
	if (!ok) return

	const router = useRouter()
	await logUserOut()
	router.push("/")
}

async function updateUser() {
	// Validacoes
	if (!validForm.value) return

	loadingRes.value = true

	notify({
		id: "loading",
		text: "Carregando...",
		type: "info",
	})

	const formData = new FormData()
	formData.append("name", userForm.name)
	formData.append("email", userForm.email)
	formData.append("phone", userForm.phone)
	formData.append("address", userForm.address || "")

	//TODO: trocar senha

	if (userForm.imageFile) {
		// Verifica se uma nova imagem foi selecionada
		formData.append("image", userForm.imageFile)
	}
	formData.append("_method", "PUT")

	try {
		const response = await useDataLoader(`/api/user_update`, {
			method: "POST",
			body: formData,
		})

		refresh()
		notify({
			title: "Usuário atualizado",
			type: "success",
		})

		if (response && response.data.image) {
			const cookieImageProfile = useCookie("imageProfile", {
				sameSite: true,
			})
			cookieImageProfile.value = response.data.image
		}

		isEditing.value = false
	} catch (error) {
		console.error(error)
		notify({
			title: "Erro ao atualizar!",
			type: "error",
			text: formatError(error),
		})
	}

	notify.close("loading")
	loadingRes.value = false
}

function cancelEdit() {
	isEditing.value = false
}

// Cabeçalhos da pagina
useSeoMeta({
	title: userNameForTitle,
	description: "",
})
definePageMeta({
	middleware: ["guest"],
})
</script>
<style lang="css" scoped>
.profile__image {
	border: 5px solid #fff;
	box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}

.button__action {
	font-weight: 600;
	text-transform: none;
	letter-spacing: 0;
}
</style>
