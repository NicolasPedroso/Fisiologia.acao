<template>
	<v-app full-height theme="light">
		<!-- Menu lateral de navegação -->
		<v-no-ssr>
			<v-navigation-drawer v-model="drawer" color="var(--primary-color)">
				<template #image>
					<div class="drawer-color" />
				</template>

				<!-- Logo do projeto -->
				<v-list lines="3" class="my-2">
					<v-list-item
						class="drawer-logo"
						title="Fisiologia em ação"
						subtitle="@fisiologia.em.acao"
						prepend-avatar="/layout/logoEmblem.svg"
					/>
				</v-list>

				<!-- Itens do menu -->
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
			</v-navigation-drawer>
		</v-no-ssr>

		<!-- Barra superior -->
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

		<!-- Conteúdo principal -->
		<v-main class="background__main">
			<NuxtPage />
		</v-main>
	</v-app>
</template>
<script setup>
/**
 * Layout do painel administrativo
 * Contém navegação lateral e barra superior
 */

import { useRouter } from "vue-router"

const router = useRouter()
const drawer = ref(true)

// Itens do menu de navegação
const drawerItems = [
	{ type: "subheader", title: "Ajuda" },
	{
		icon: "mdi-help",
		title: "Tutorial de uso",
		subtitle: "Entenda como funciona o painel do adminstrador",
		link: "/fisiologia/dashboard/",
	},
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

// Configuração de tema
const theme = {
	drawerTextColor: "#fff",
	backgroundColor: "var(--primary-color)",
	textColor: "#fff",
}

/**
 * Função de logout/voltar
 */
function logout() {
	router.push("/")
}

useSeoMeta({
	title: "Dashboard",
	description: "Página para controlar os conteudos da DataBase",
	middleware: ["guest"],
})
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");

/* Logo do drawer */
.drawer-logo {
	font-family: "Poppins", sans-serif;
}

/* Fundo do drawer */
.drawer-color {
	height: 100%;
	width: 100%;
	background: linear-gradient(
		180deg,
		var(--secondary-color) 0%,
		var(--secondary-color-alt) 100%
	);
	background-size: cover;
	background-position: center center;
}

/* Cor de fundo da barra superior */
.primary-color {
	background-color: v-bind("theme.backgroundColor") !important;
}

/* Cor do texto */
.text-color {
	color: v-bind("theme.textColor") !important;
}

/* Remove borda do drawer */
.v-navigation-drawer--left {
	border: none !important;
}

/* Cor do texto do drawer */
.drawer-logo :deep(.v-list-item-title),
.drawer-logo :deep(.v-list-item-subtitle),
.drawer-text :deep(.v-list-item-subtitle) {
	word-break: normal !important;
	color: #fff !important;
}

/* Fundo principal com padrão pontilhado */
.background__main {
	background: white;
	background-image: radial-gradient(rgba(0, 0, 0, 0.25) 1px, transparent 0);
	background-size: 20px 20px;
	background-position: -16px -16px;
	width: 100%;
}
</style>
