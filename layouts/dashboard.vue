<template>
	<v-app theme="dark">
		<!-- Drawer que contém os links para as páginas -->
		<ClientOnly>
			<v-navigation-drawer v-model="drawer">
				<template #image>
					<div class="drawer-color"></div>
				</template>
				<v-list>
					<v-list-item
						v-for="(item, i) in dashboardPages"
						:key="i"
						:to="item.link"
					>
						<v-list-item-title class="drawer-text">
							{{ item.text }}
						</v-list-item-title>
						<template #prepend>
							<v-icon class="drawer-text">{{ item.icon }}</v-icon>
						</template>
					</v-list-item>
				</v-list>
			</v-navigation-drawer>
		</ClientOnly>
		<!-- Drawer que contém os links para as páginas -->
		<!-- Navbar que contém TITULO, DRAWER-OPENER e LOGOUT BTN -->
		<ClientOnly>
			<v-app-bar app class="primary-color">
				<v-app-bar-nav-icon
					class="text-color"
					@click.stop="drawer = !drawer"
				></v-app-bar-nav-icon>
				<v-toolbar-title class="text-color">
					Painel do Administrador
				</v-toolbar-title>
				<template #append>
					<v-btn class="text-color" @click="logout()"> Sair </v-btn>
				</template>
			</v-app-bar>
		</ClientOnly>
		<!-- Navbar que contém TITULO, DRAWER-OPENER e LOGOUT BTN -->
		<!-- Conteúdo -->
		<v-main>
			<NuxtPage />
		</v-main>
		<!-- Conteúdo -->
		<!-- Footer -->
		<ClientOnly>
			<v-footer inset app class="primary-color">
				<span class="text-color"> &copy; Ecomp 2024 </span>
			</v-footer>
		</ClientOnly>
		<!-- Footer -->
	</v-app>
</template>
<script setup>
// Imports from Vue and Nuxt
import { useRouter } from "vue-router"
import { ref } from "vue"

// Variáveis de ambiente
const router = useRouter()
const drawer = ref(false)

// Array de paginas que serão exibidas no drawer
const dashboardPages = [
	{
		icon: "mdi-monitor-dashboard",
		text: "Dashboard",
		link: "/",
	},
	{
		icon: "mdi-account",
		text: "Testemunhos",
		link: "/dashboard/testimony",
	},

	{
		icon: "mdi-email",
		text: "Contato",
		link: "/dashboard/contact",
	},
]

// Tema que será utilizado na dashboard
const theme = {
	/* Fundo do Drawer da dashboard */
	drawerBackground: "url(/banco-testes/imagem-teste-06.jpg)",
	drawerTextColor: "#ffffff",
	/* Cores de fundo da dashboard  */
	backgroundColor: "#202224",
	/* Cores de texto da dashboard  */
	textColor: "#ffffff",
}

// Métodos e funções
function logout() {
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
	color: v-bind("theme.drawerTextColor") !important;
}
.primary-color {
	background-color: v-bind("theme.backgroundColor") !important;
}
.text-color {
	font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
		"Lucida Sans Unicode", Geneva, Verdana, sans-serif;
	color: v-bind("theme.textColor") !important;
}
</style>
