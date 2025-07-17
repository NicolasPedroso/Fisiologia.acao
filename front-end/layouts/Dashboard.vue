<template>
	<v-app full-height theme="light">
		<!-- Drawer que contém os links para as páginas -->
		<v-no-ssr>
			<v-navigation-drawer v-model="drawer" color="var(--primary-color)">
				<template #image>
					<div class="drawer-color" />
				</template>
				<!-- Logo e nome do Projeto -->
				<v-list lines="3" class="my-2">
					<v-list-item
						class="drawer-logo"
						title="Fisiologia em ação"
						subtitle="@fisiologia.em.acao"
						prepend-avatar="/layout/logoEmblem.svg"
					/>
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
		</v-no-ssr>
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
				<v-btn class="text-color" @click="logout()"> Voltar </v-btn>
			</template>
		</v-app-bar>
		<!-- Navbar que contém TITULO, DRAWER-OPENER e LOGOUT BTN -->
		<!-- Conteúdo -->
		<v-main class="background__main">
			<NuxtPage />
		</v-main>
		<!-- Conteúdo -->
	</v-app>
</template>
<script setup>
// Import do roteamento e dos arquivos de STORE
import { useRouter } from "vue-router"

// Variáveis de ambiente
const router = useRouter()
const drawer = ref(true)

// Array de paginas que serão exibidas no drawer
const drawerItems = [
	{ type: "subheader", title: "Ajuda" },
	{
		icon: "mdi-help",
		title: "Tutorial de uso",
		subtitle: "Entenda como funciona o painel do adminstrador",
		link: "/fisiologia/dashboard/",
	},
	// {
	// 	icon: "mdi-video-box",
	// 	title: "Temas e vídeos",
	// 	subtitle: "Edite os vídeos/temas",
	// 	link: "/fisiologia/dashboard/video",
	// },
	{ type: "subheader", title: "Segurança" },
	{
		icon: "mdi-email-edit",
		title: "Edição de e-mail",
		subtitle: "Atualize seu e-mail",
		link: "/fisiologia/dashboard/email",
	},
	{
		icon: "mdi-account-multiple",
		title: "Usuários",
		subtitle: "Gerencie os usuários",
		link: "/fisiologia/dashboard/users",
	},
	{ type: "subheader", title: "Edição de conteúdo" },
	{
		icon: "mdi-book-open-page-variant",
		title: "Quizzes",
		subtitle: "Edite os quizzes",
		link: "/fisiologia/dashboard/quizzes",
	},
	{
		icon: "mdi-note-text",
		title: "Temas",
		subtitle: "Edite os temas",
		link: "/fisiologia/dashboard/themes",
	},
]

// Tema que será utilizado na dashboard
const theme = {
	/* Fundo do Drawer da dashboard */
	drawerTextColor: "#fff",
	/* Cores de fundo da dashboard  */
	backgroundColor: "var(--primary-color)",
	/* Cores de texto da dashboard  */
	textColor: "#fff",
}

// Métodos e funções
function logout() {
	router.push("/")
}

// Cabeçalhos da pagina
useSeoMeta({
	title: "Dashboard",
	description: "Página para controlar os conteudos da DataBase",
	middleware: ["guest"],
	// Endereço da imagem que será exibida quando a página for compartilhada
	// ogImage: "endereco-da-imagem",
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
	background: linear-gradient(
		180deg,
		var(--secondary-color) 0%,
		var(--secondary-color-alt) 100%
	);
	background-size: cover;
	background-position: center center;
}
.primary-color {
	background-color: v-bind("theme.backgroundColor") !important;
}
.text-color {
	color: v-bind("theme.textColor") !important;
}

.v-navigation-drawer--left {
	border: none !important;
}

.drawer-logo :deep(.v-list-item-title),
.drawer-logo :deep(.v-list-item-subtitle),
.drawer-text :deep(.v-list-item-subtitle) {
	word-break: normal !important;
	color: #fff !important;
}

.background__main {
	background: white;
	background-image: radial-gradient(rgba(0, 0, 0, 0.25) 1px, transparent 0);
	background-size: 20px 20px;
	background-position: -16px -16px;

	width: 100%;
}
</style>
