<template>
	<div class="container">
		<h1 class="title">Bem Vindo</h1>
		<h1 class="second-title mb-10">Jogador</h1>
		<div class="sub-container py-10">
			<h1 class="sub-title">Quiz</h1>
			<div>
				<div>
					<button @click="handlePlay" class="main-buttons mb-10">
						<h1 class="buttons-title">Jogar</h1>
					</button>
				</div>
				<div class="p-20">
					<button
						@click="handleMaterials()"
						class="main-buttons mb-15"
					>
						<h1 class="buttons-title">Material</h1>
					</button>
				</div>
			</div>
		</div>
	</div>
	<h1>Pagina inicial após logar</h1>
	<v-btn class="text-color" @click="logout()"> Sair </v-btn>
	<div>
		<nuxt-link class="auth-link mb-4" to="fea/dashboard">
			<span> Acessar dashboard </span>
		</nuxt-link>
	</div>
</template>

<script setup>
import { useAuthStore } from "~/store/auth"
import { useRouter } from "vue-router"

definePageMeta({
	middleware: ["guest"],
})

const { logUserOut } = useAuthStore()
const router = useRouter()

async function logout() {
	await logUserOut()
	window.location.reload()
	router.push("/")
}

async function handleMaterials() {
	router.push("/fea/materials")
}

async function handlePlay() {
	router.push("/fea/quiz")
}
</script>

<style scoped>
.title {
	font-family: Kode Mono;
	font-weight: 500;
	font-size: 96px;
	color: white;
	text-shadow:
		3px 0 #000000,
		-3px 0 #000000,
		0 3px #000000,
		0 3px #000000,
		1px 3px #000000,
		-1px 3px #000000,
		1px -3px #000000,
		-1px 1px #fff;
}

.second-title {
	font-family: Kode Mono;
	font-weight: 500;
	font-size: 96px;
	color: #0d45ae;
	text-shadow:
		3px 0 #000000,
		-3px 0 #000000,
		0 3px #000000,
		0 -2px #000000,
		1px 1px #000000,
		-1px -1px #000000,
		1px -1px #000000,
		-1px 1px #fff;
}

.sub-title {
	font-family: sans-serif;
	font-weight: 600;
	font-size: 96px;
	color: #052f7d;
	text-shadow:
		3px 0 #000000,
		-3px 0 #000000,
		0 3px #000000,
		0 -2px #000000,
		1px 1px #000000,
		-1px -1px #000000,
		1px -1px #000000,
		-1px 1px #fff;
}

.container {
	width: 100%;
	height: 100%;
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
}

.sub-container {
	width: 45%;
	height: 50%;
	background-color: white;
	border-radius: 15px;
	display: flex;
	flex-direction: column;
	text-align: center;
	justify-content: space-between;
	border: 3px solid #000000;
}

.sub-container-items {
}

.main-buttons {
	background-color: #0d45ae;
	width: 80%;
	margin-top: 50px;
	padding: 13px;
	color: white;
}
</style>
