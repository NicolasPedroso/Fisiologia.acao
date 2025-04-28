<template>
	<v-app style="overflow-x: hidden !important">
		<v-navigation-drawer expand-on-hover rail permament color="#fff">
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
				/>
			</v-list>
			<template #append>
				<v-list density="compact" nav>
					<v-list-item
						nav
						prepend-icon="mdi-logout"
						title="Sair da conta"
						@click="logout()"
					/>
				</v-list>
			</template>
		</v-navigation-drawer>
		<v-main>
			<NuxtPage />
		</v-main>
	</v-app>
</template>
<script setup>
import { useAuthStore } from "~/store/auth"

const { logUserOut } = useAuthStore()
const links = [
	{
		name: "Página inicial",
		icon: "mdi-home",
		link: "/fea",
	},
	{
		name: "Perfil",
		icon: "mdi-account",
		link: "/fea/profile",
	},
]

async function logout() {
	const router = useRouter()
	await logUserOut()
	router.push("/")
}
</script>
