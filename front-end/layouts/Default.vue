<template>
	<v-app style="overflow-x: hidden !important">
		<v-navigation-drawer
			mobile-breakpoint="0"
			expand-on-hover
			rail
			permament
			color="#fff"
		>
			<v-list>
				<v-list-item
					prepend-avatar="/logo.png"
					title="Fisiologia em ação"
				/>
			</v-list>
			<v-list density="compact" nav>
				<v-list-item
					v-for="(item, index) in links"
					:prepend-icon="item.icon"
					:title="item.name"
					:to="item.link"
					color="var(--secondary-color-alt)"
				/>
				<v-list-item
					v-if="cookieAdmin === true"
					prepend-icon="mdi-layers-edit"
					title="Dashboard"
					subtitle="Altere as informações do site"
					to="/fisiologia/dashboard"
				/>
			</v-list>
			<template #append>
				<v-list density="compact" nav>
					<v-list-item
						nav
						prepend-icon="mdi-logout"
						title="Sair da conta"
						base-color="var(--primary-color)"
						@click="logout()"
					/>
				</v-list>
			</template>
		</v-navigation-drawer>

		<v-btn
			position="fixed"
			location="top, right"
			variant="text"
			elevation="0"
			style="margin: 24px"
			size="48"
			rounded
			disabled
		>
			<v-badge content="0" color="var(--secondary-color)">
				<v-icon size="36" color="var(--secondary-color-alt)">
					mdi-bell
				</v-icon>
			</v-badge>
		</v-btn>

		<v-main>
			<NuxtPage />
		</v-main>
	</v-app>
</template>
<script setup>
import { useAuthStore } from "~/store/auth"

const cookieAdmin = useCookie("admin", {
	sameSite: true,
})

const { logUserOut } = useAuthStore()
const links = [
	{
		name: "Página inicial",
		icon: "mdi-home",
		link: "/fisiologia",
	},
	{
		name: "Estastísticas",
		icon: "mdi-chart-bar",
		link: "/fisiologia/stats",
	},
	{
		name: "Perguntas frequentes",
		icon: "mdi-help",
		link: "/fisiologia/faq",
	},
	{
		name: "Perfil",
		icon: "mdi-account",
		link: "/fisiologia/profile",
	},
]

async function logout() {
	const router = useRouter()
	await logUserOut()
	router.push("/")
}
</script>
