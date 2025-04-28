<template>
	<nuxt-notifications />
	<v-container
		v-if="status !== 'pending'"
		class="profile__wrapper pa-0 ma-0"
		full-height
		fluid
	>
		<Transition>
			<div v-if="!isEditing" class="profile__content">
				<v-avatar
					class="profile__image"
					size="200"
					image="/placeholder/avatar.png"
				/>

				<h1>{{ user.name }}</h1>
				<h2>Level: 0</h2>

				<div class="profile__row__wrapper">
					<div class="profile__row">
						<strong>E-mail</strong>
						<span>{{ user.email }}</span>
					</div>
					<div class="profile__row">
						<strong>Telefone</strong>
						<span>{{ user.phone }}</span>
					</div>
					<div class="profile__row">
						<strong>Endereço</strong>
						<span>{{ user.address }}</span>
					</div>
					<div class="profile__row">
						<strong>Tipo de conta</strong>
						<span>
							{{
								user.isAdmin === 1
									? "Adminstrador"
									: "Estudante"
							}}
						</span>
					</div>

					<v-row class="mt-6 d-flex justify-center">
						<v-btn
							color="var(--secondary-color)"
							variant="outlined"
							theme="dark"
							width="100%"
							@click.stop="isEditing = true"
						>
							Editar informações
						</v-btn>
						<v-btn
							class="mt-2"
							color="var(--primary-color)"
							theme="dark"
							width="100%"
							variant="tonal"
							disabled
						>
							Deletar conta
						</v-btn>
					</v-row>
				</div>
			</div>
			<div v-else class="edit__wrapper">
				<div class="edit__card">
					<div class="edit__title">
						<h1>Edição de perfil</h1>
					</div>
					<div class="edit__content">
						<v-form v-model="validForm" @submit.prevent>
							<h3 class="mb-2">Nome</h3>
							<v-text-field
								v-model="formData.name"
								type="text"
								variant="outlined"
								placeholder="Fulano..."
								:disabled="loadingRes"
							/>
							<h3 class="mb-2">E-mail</h3>
							<v-text-field
								v-model="formData.email"
								type="email"
								variant="outlined"
								placeholder="fulano@ufpr.br"
								:disabled="loadingRes"
							/>
							<h3 class="mb-2">Endereço (opcional)</h3>
							<v-text-field
								v-model="formData.address"
								type="text"
								variant="outlined"
								clearable
								placeholder="Rua dos hormônios"
								:disabled="loadingRes"
							/>
							<h3 class="mb-2">Telefone (opcional)</h3>
							<v-text-field
								v-model="formData.phone"
								type="tel"
								variant="outlined"
								clearable
								placeholder="(XX) XXXXXXXX"
								prepend-inner-icon="mdi-phone-outline"
								:disabled="loadingRes"
								@input="formatPhone"
							/>
							<h3 class="mb-2">Troca de senha (opcional)</h3>
							<v-text-field
								v-model="formData.pwdChange"
								type="password"
								variant="outlined"
								clearable
								placeholder="Nova senha"
								:disabled="loadingRes"
							/>
							<div v-if="formData.pwdChange !== ''">
								<h3 class="mb-2">
									Confirmação da troca de senha
								</h3>
								<v-text-field
									v-model="formData.pwdChangeConfirmation"
									type="password"
									variant="outlined"
									clearable
									placeholder="Confirmação da nova senha"
									:disabled="loadingRes"
								/>
							</div>
							<v-row class="ma-0 mt-4">
								<v-col class="pa-0 pr-1" cols="12" md="6">
									<v-btn
										type="submit"
										class="cancel-btn rounded-lg"
										variant="outlined"
										color="var(--secondary-color-alt)"
										:disabled="loadingRes"
										@click="cancelEdit()"
									>
										<h1>Cancelar</h1>
									</v-btn>
								</v-col>
								<v-col class="pa-0 pl-1" cols="12" md="6">
									<v-btn
										type="submit"
										class="update-btn rounded-lg"
										color="var(--secondary-color)"
										theme="dark"
										:disabled="loadingRes"
										@click="updateUser()"
									>
										<h1>Salvar</h1>
									</v-btn>
								</v-col>
							</v-row>
						</v-form>
					</div>
				</div>
			</div>
		</Transition>
	</v-container>
	<Loading :status="status" />
</template>
<script setup lang="js">
// ENV (PAGE VARIABLES)
const urlRequistion = "/api/user"

const user = reactive({
	image: "/placeholder/avatar.jpg",
	name: "",
	address: "",
	email: "",
	phone: "",
	isAdmin: 1,
})

const formData = reactive({
	image: "/placeholder/avatar.jpg",
	name: "",
	address: "",
	email: "",
	phone: "",
	pwdChange: "",
	pwdChangeConfirmation: "",
})

const userNameForTitle = ref("Perfil")
const isEditing = ref(false)
const validForm = ref(false)
const loadingRes = ref(false)

// Requisicao inicial
const { status, refresh } = useAsyncData(
	() =>
		useDataLoader(urlRequistion)
			.then((response) => {
				user.image = response.image
				user.name = response.name
				userNameForTitle.value = response.name
				user.address = response.address
				user.email = response.email
				user.phone = response.phone

				user.isAdmin = response.admin || 0

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
	{
		server: false,
	},
)

async function updateUser() {
	// Validacoes
	if (!validForm.value) return

	loadingRes.value = true
	// await useDataLoader(`${urlRequistion}`, {
	// 	method: "PUT",
	// 	body: __user,
	// 	"Content-Type": "application/json",
	// })
	// 	.then(() => {
	// 		refresh()
	// 		notify({
	// 			title: "Usuário atualizado",
	// 			type: "success",
	// 		})
	// 	})
	// 	.catch((error) => {
	// 		console.error(error)
	// 		notify({
	// 			title: "Erro ao atualizar!",
	// 			type: "error",
	// 			text: formatError(error),
	// 		})
	// 	})
	loadingRes.value = false
}

const formatPhone = () => {
	let cleaned = user.phone.replace(/\D/g, "").slice(0, 11)

	if (cleaned.length > 2) {
		cleaned = `(${cleaned.slice(0, 2)}) ${cleaned.slice(2, 7)}-${cleaned.slice(7)}`
	}

	user.phone = cleaned
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
/* Transicao */
.v-enter-active,
.v-leave-active {
	transition: transform 0.5s ease;
	position: absolute;
}

.v-enter-from,
.v-leave-to {
	transform: scale(0);
}

@keyframes bg {
	0% {
		background-position: 0% 0%;
	}
	50% {
		background-position: 50% 50%;
	}
	100% {
		background-position: 0% 0%;
	}
}

.profile__wrapper {
	display: flex;
	flex-direction: column;
	align-items: center;
	min-height: 100vh;
	height: 100%;
	background: var(--primary-color);
	background: linear-gradient(
		0deg,
		var(--primary-color) 0%,
		var(--secondary-color) 100%
	);
	background-size: 400% 400%;
	animation: bg 10s infinite;
}

.profile__image {
	margin-top: -100px;
	border: 5px solid #fff;
}

.profile__content {
	background-color: #fff;
	width: 100%;
	height: calc(100% - 200px);
	margin-top: 200px;
	display: flex;
	align-items: center;
	flex-direction: column;
}

.profile__content h1 {
	color: var(--primary-color);
	font-size: 3.5rem;
	line-height: 3rem;
}

.profile__row__wrapper {
	display: flex;
	flex-direction: column;
	gap: 10px;
	margin: 32px 16px 0 16px;
}

.profile__row {
	display: flex;
	gap: 100px;
	justify-content: space-between;
	align-items: center;
	text-align: right;
}

.profile__row strong {
	font-weight: 800;
	color: var(--primary-color);
	text-align: left;
}

.edit__wrapper {
	width: 100%;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
}

.edit__card {
	background-color: #fff;
	width: 95%;
	max-height: 95%;
	border-radius: 15px;
	border: 1px solid #fff;
	flex-direction: column;
	overflow-x: hidden;
	overflow-y: auto;
}

.edit__form {
	width: 100%;
	height: 100%;
	justify-content: center;
	align-items: center;
}

.edit__title {
	width: 100%;
	height: 80px;
	background-color: var(--secondary-color);
	color: #fff;

	display: flex;
	justify-content: center;
	align-items: center;
}

.edit__content {
	padding: 32px;
}

.update-btn,
.cancel-btn {
	width: 100%;
	height: 48px;
	font-size: 0.75rem;
}
</style>
