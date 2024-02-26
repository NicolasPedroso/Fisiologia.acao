<template>
	<NuxtSnackbar />
	<v-app theme="dark">
		<!-- Drawer que contém os links para as páginas -->
		<v-navigation-drawer v-model="drawer">
			<template #image>
				<div class="drawer-color" />
			</template>
			<!-- Logo e nome do Projeto -->
			<v-list lines="3" class="my-2">
				<v-list-item
					class="drawer-logo"
					title="Ecomp"
					subtitle="Empresa júnior de computação da UFPR"
				>
					<template #prepend>
						<v-img
							width="40"
							height="56"
							contain
							class="mr-4"
							src="/imagens/logo.png"
							alt="Logo da Ecomp"
						/>
					</template>
				</v-list-item>
			</v-list>
			<!-- Logo e nome do Projeto -->
			<!-- Itens do drawer -->
			<v-list nav>
				<v-list-item
					v-for="(item, i) in drawerItems"
					:key="i"
					:to="item.link"
					:base-color="theme.drawerTextColor"
					:prepend-icon="item.icon"
					:title="item.title"
					:subtitle="item.subtitle"
					lines="3"
					class="my-1 py-1 drawer-text"
				/>
			</v-list>
			<!-- Itens do drawer -->
		</v-navigation-drawer>
		<!-- Drawer que contém os links para as páginas -->
		<!-- Navbar que contém TITULO, DRAWER-OPENER e LOGOUT BTN -->
		<v-app-bar class="primary-color">
			<v-app-bar-nav-icon
				class="text-color"
				@click.stop="drawer = !drawer"
			/>
			<v-toolbar-title class="text-color">
				Painel do Administrador
			</v-toolbar-title>
			<template #append>
				<v-btn class="text-color" @click="logout()"> Sair </v-btn>
			</template>
		</v-app-bar>
		<!-- Navbar que contém TITULO, DRAWER-OPENER e LOGOUT BTN -->
		<!-- Conteúdo -->
		<v-main>
			<NuxtPage />
		</v-main>
		<!-- Conteúdo -->
		<!-- Footer -->
		<v-footer app inset class="primary-color">
			<span class="text-color"> &copy; Ecomp 2024 </span>
		</v-footer>
		<!-- Footer -->
	</v-app>
</template>
<script setup>
// Imports from Vue and Nuxt
import { useRouter } from "vue-router"
import { ref } from "vue"
import { useAuthStore } from "~/store/auth"

// Variáveis de ambiente
const router = useRouter()
const drawer = ref(false)

// Variáveis e funções da STORE
const { logUserOut } = useAuthStore()

// Array de paginas que serão exibidas no drawer
const drawerItems = [
	{
		icon: "mdi-monitor-dashboard",
		title: "Dashboard",
		subtitle: "Controle geral do sistema",
		link: "/dashboard/",
	},
	{
		icon: "mdi-account-badge",
		title: "Testemunhos",
		subtitle: "Altere os testemunhos exibidos na página inicial",
		link: "/dashboard/testimony",
	},
	{
		icon: "mdi-image-album",
		title: "Materiais",
		subtitle: "Usando /api/ do back-end real",
		link: "/dashboard/materials",
	},
	{
		icon: "mdi-card-account-mail",
		title: "Contatos",
		subtitle: "Veja os contatos feitos pelos usuários",
		link: "/dashboard/contact",
	},
	{
		icon: "mdi-alert-circle-outline",
		title: "error",
		subtitle: "Teste de um erro que pode ser chamado",
		link: "/dashboard/error-teste",
	},
]

// Tema que será utilizado na dashboard
const theme = {
	/* Fundo do Drawer da dashboard */
	drawerBackground: "url(/imagens/drawer/background.jpg)",
	drawerTextColor: "#ffffff",
	/* Cores de fundo da dashboard  */
	backgroundColor: "#041E33",
	/* Cores de texto da dashboard  */
	textColor: "#ffffff",
}

// Métodos e funções
function logout() {
	logUserOut()
	router.push("/login")
}

// Cabeçalhos da pagina
useSeoMeta({
	title: "Dashboard",
	description: "Página para controlar os conteudos da DataBase.",

	// Endereço da imagem que será exibida quando a página for compartilhada
	// ogImage: "endereco-da-imagem",
})
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
})
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");
.drawer-logo {
	/* Imagens e alterações do fundo do Drawer */
	font-family: "Poppins", sans-serif;
}
.drawer-color {
	height: 100%;
	width: 100%;
	/* Imagens e alterações do fundo do Drawer */
	background-image: v-bind("theme.drawerBackground");
	filter: brightness(0.5);
	background-size: cover;
	background-position: center center;
}

.drawer-text {
	font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
		"Lucida Sans Unicode", Geneva, Verdana, sans-serif;
}
.primary-color {
	background-color: v-bind("theme.backgroundColor") !important;
}
.text-color {
	font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
		"Lucida Sans Unicode", Geneva, Verdana, sans-serif;
	color: v-bind("theme.textColor") !important;
}

.drawer-logo :deep(.v-list-item-subtitle),
.drawer-text :deep(.v-list-item-subtitle) {
	word-break: normal !important;
}
</style>
