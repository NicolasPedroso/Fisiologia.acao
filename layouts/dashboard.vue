<template>
	<Head>
		<Title>Dashboard</Title>
		<meta
			name="description"
			content="Página para controlar os conteudos da DataBase."
		/>
	</Head>
	<v-app theme="dark">
		<!-- Drawer que contém os links para as páginas -->
		<ClientOnly>
			<v-navigation-drawer v-model="drawer">
				<template v-slot:image>
					<div class="drawer-color" />
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
						<template v-slot:prepend>
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
				<template v-slot:append>
					<v-btn @click="logout()" class="text-color"> Sair </v-btn>
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
// Variables
const router = useRouter();
const drawer = ref(false);
const dashboardPages = [
	{
		icon: "mdi-monitor-dashboard",
		text: "Dashboard 1",
		link: "/",
	},
	{
		icon: "mdi-account",
		text: "Testemunhos",
		link: "/dashboard/testimony",
	},
];

function logout() {
	router.push("/login");
}
</script>
<style scoped>
/* 
	Fundo do Drawer da dashboard
	Comentar esta CLASSE definira o drawer para o padrao: Dark Theme - Vuetify
*/
.drawer-color {
	height: 100%;
	width: 100%;

	/* Imagens e alterações do fundo do Drawer */
	background-image: url(/banco-testes/imagem-teste-06.jpg);
	filter: brightness(0.5);
	background-size: cover;
	background-position: center center;
}

.drawer-text {
	font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
		"Lucida Sans Unicode", Geneva, Verdana, sans-serif;
	color: rgb(255, 255, 255) !important;
}
/* 
	Cores de fundo da dashboard 
	Comentar esta CLASSE definira o drawer para o padrao: Dark Theme - Vuetify	
*/
.primary-color {
	background-color: #202224 !important;
}
/* 
	Cores de texto da dashboard 
	Comentar esta CLASSE definira o drawer para o padrao: Dark Theme - Vuetify	
*/
.text-color {
	font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
		"Lucida Sans Unicode", Geneva, Verdana, sans-serif;
	color: rgb(255, 255, 255) !important;
}
</style>
