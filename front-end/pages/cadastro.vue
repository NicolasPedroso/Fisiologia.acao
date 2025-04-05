<template>
	<v-container fluid class="ma-0 pa-0">
		<v-row>
			<v-col cols="11">
				<v-row>
					<v-col
						cols="6"
						class="d-flex justify-start align-start"
						style="
							height: 250px;
							padding-left: 80px;
							padding-top: 50px;
						"
					>
						<v-img
							:width="150"
							aspect-ratio="1/1"
							cover
							src="../public/images/logo.png"
							style="max-width: 200px"
						></v-img>
					</v-col>

					<v-col
						cols="6"
						class="d-flex justify-center align-center flex-column"
						style="align-content: center; margin-top: 100px"
					>
						<v-file-input
							v-model="file"
							accept="image/*"
							label="Escolha uma imagem"
							prepend-icon="mdi-camera-plus-outline"
							color="black"
							hide-input
							rounded
							:rules="[imageRequired]"
							class="custom-icon-size"
							:error-messages="fileError"
							@change="previewImage"
						>
						</v-file-input>
						<span class="text-error"
							>Coloque uma foto de perfil. (obrigatório)</span
						>
					</v-col>
				</v-row>
			</v-col>
			<v-col cols="1" style="background-color: #1356d3"></v-col>
		</v-row>

		<v-row>
			<v-col
				cols="11"
				class="d-flex justify-center"
				style="margin-bottom: 30px"
			>
				<v-col cols="7">
					<v-card variant="outlined" style="padding: 40px">
						<v-col
							cols="12"
							class="d-flex justify-center font-weight-black text-blue-darken-4 text-h4"
						>
							<span>CADASTRE-SE</span>
						</v-col>
						<v-col cols="12">
							<span>NOME</span>
							<v-text-field
								v-model="name"
								label="Coloque seu nome"
								variant="outlined"
								prepend-inner-icon="mdi-account-check-outline"
								clearable
								required
								:rules="[nameRules]"
							></v-text-field>
						</v-col>

						<v-col cols="12">
							<span>EMAIL</span>
							<v-text-field
								v-model="email"
								hide-details="auto"
								label="Coloque seu email"
								hint="Digite um email válido"
								placeholder="exemplo@gmail.com"
								type="email"
								variant="outlined"
								:rules="emailRules"
								clearable
								required
								prepend-inner-icon="mdi-email-outline"
							></v-text-field>
						</v-col>

						<v-col cols="12">
							<span>TELEFONE</span>
							<v-text-field
								v-model="phone"
								label="(XX) XXXXXXXX"
								variant="outlined"
								prepend-inner-icon="mdi-phone-outline"
								clearable
								required
								:rules="[phoneRules]"
								@input="formatPhone"
							></v-text-field>
						</v-col>

						<v-col cols="12">
							<span>ENDEREÇO</span>
							<v-text-field
								v-model="address"
								label="Coloque seu endereço (opcional)"
								variant="outlined"
								prepend-inner-icon="mdi-home-outline"
								clearable
							></v-text-field>
						</v-col>

						<v-col cols="12">
							<span>SENHA</span>
							<v-text-field
								v-model="password"
								hint="Use uma senha segura"
								label="Senha"
								:type="show1 ? 'text' : 'password'"
								variant="outlined"
								clearable
								required
								:rules="passwordRules"
								:append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
								prepend-inner-icon="mdi-lock-outline"
								@click:append="show1 = !show1"
							></v-text-field>
						</v-col>

						<v-col cols="12">
							<span>CONFIRME SUA SENHA</span>
							<v-text-field
								v-model="password_confirm"
								label="Confirme sua senha"
								:type="show2 ? 'text' : 'password'"
								variant="outlined"
								clearable
								required
								:rules="[...passwordRules, passwordMatch]"
								:append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
								prepend-inner-icon="mdi-lock-outline"
								@click:append="show2 = !show2"
							></v-text-field>
						</v-col>

						<v-col cols="12" class="d-flex justify-center">
							<v-btn
								block
								color="#1356D3"
								size="large"
								:disabled="!isFormValid"
								@click="submit"
							>
								CADASTRAR
							</v-btn>
						</v-col>
					</v-card>
				</v-col>
			</v-col>

			<v-col cols="1" style="background-color: #1356d3"></v-col>
		</v-row>
	</v-container>
</template>

<script setup>
definePageMeta({
	layout: "Auth",
	middleware: ["auth"],
})

// Cabeçalho da página
useSeoMeta({
	description: "Página para cadastro",
})
useHead({
	htmlAttrs: {
		lang: "pt-br",
	},
	link: [
		{
			rel: "icon",
			type: "image/png",
			href: "/favicon.png",
		},
	],
})

import { ref, computed } from "vue"
import axios from "axios"
import { useRouter } from "vue-router"

const router = useRouter()

const name = ref("")
const email = ref("")
const phone = ref("")
const address = ref("")
const password = ref("")
const password_confirm = ref("")
const file = ref(null)
const fileError = ref("")
const show1 = ref(false)
const show2 = ref(false)

const imageRequired = (v) => {
	if (!v) {
		fileError.value = "Imagem de perfil é obrigatória"
		return false
	}
	fileError.value = ""
	return true
}

const nameRules = (v) => !!v || "Nome é obrigatório"

const emailRules = [
	(v) => !!v || "E-mail é obrigatório",
	(v) => /.+@.+\..+/.test(v) || "E-mail deve ser válido",
]

const phoneRules = (v) => !!v || "Telefone é obrigatório"

const passwordRules = [
	(v) => !!v || "Senha é obrigatória",
	(v) => v.length >= 8 || "Senha deve ter pelo menos 8 caracteres",
]

const passwordMatch = (v) => v === password.value || "As senhas não coincidem"

const isFormValid = computed(() => {
	return (
		name.value &&
		emailRules.every((rule) => rule(email.value) === true) &&
		phone.value &&
		passwordRules.every((rule) => rule(password.value) === true) &&
		passwordMatch(password_confirm.value) === true &&
		!!file.value
	)
})

const formatPhone = () => {
	let cleaned = phone.value.replace(/\D/g, "").slice(0, 11)

	if (cleaned.length > 2) {
		cleaned = `(${cleaned.slice(0, 2)}) ${cleaned.slice(2, 7)}-${cleaned.slice(7)}`
	}

	phone.value = cleaned
}

const submit = async () => {
	if (!isFormValid.value) {
		alert("Preencha todos os campos corretamente!")
		return
	}

	const formData = new FormData()
	formData.append("name", name.value)
	formData.append("email", email.value)
	formData.append("phone", phone.value)
	formData.append("address", address.value || "")
	formData.append("password", password.value)
	formData.append("password_confirmation", password_confirm.value)
	formData.append("image", file.value)

	try {
		const response = await axios.post(
			"http://127.0.0.1:8000/api/signup",
			formData,
			{
				headers: {
					"Content-Type": "multipart/form-data",
				},
			},
		)
		alert("Cadastro realizado com sucesso!")
		console.log(response.data)
		router.push("/login")
	} catch (error) {
		console.error(
			"Erro ao cadastrar:",
			error.response?.data || error.message,
		)
		alert("Erro ao cadastrar. Tente novamente.")
	}
}
</script>

<style scoped>
* {
	background-color: #ffffff;
}

.v-avatar {
	border-radius: 50%;
}

::v-deep .custom-icon-size .v-icon--size-default {
	font-size: 100px;
}

.text-error {
	color: red;
	font-size: 14px;
	font-weight: bold;
}
</style>

<style scoped>
* {
	background-color: #ffffff;
}

.v-avatar {
	border-radius: 50%;
}

::v-deep .custom-icon-size .v-icon--size-default {
	font-size: 100px;
	/* Ajuste o tamanho conforme necessário */
}
</style>
