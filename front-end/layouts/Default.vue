<template>
	<v-app style="overflow-x: hidden !important">
		<v-app-bar app color="#fff" dark elevation="0" height="64">
			<v-row class="align-center pa-0 ma-0 mx-4">
				<div class="d-flex justify-between align-center ga-4">
					<template v-for="(link, index) in links" :key="index">
						<nuxt-link
							v-if="!link.onlyAdmin || cookieAdmin"
							:class="{
								navbar__link: true,
								'navbar__link--active':
									$route.path === link.link,
							}"
							:to="link.link"
							class="d-flex align-center text-decoration-none"
						>
							<v-icon
								:icon="link.icon"
								size="24"
								:aria-label="link.arialLabel"
								class="mr-1"
							></v-icon>
							<span> {{ link.name }} </span>
						</nuxt-link>
					</template>
				</div>

				<nuxt-link
					:to="homeURL"
					class="d-flex align-center"
					style="
						position: absolute;
						left: 50%;
						transform: translateX(-50%);
					"
				>
					<v-img
						src="/layout/logoEmblem.svg"
						alt=""
						height="48"
						width="48"
					/>
				</nuxt-link>

				<v-spacer />

				<div class="d-flex align-center ga-1">
					<!-- <v-btn
						icon=""
						size="36"
						aria-label="Trocar entre claro e escuro"
					></v-btn>
					<v-btn
						icon="mdi-bell"
						size="36"
						aria-label="Notificações"
					></v-btn> -->
					<v-btn
						icon="mdi-exit-to-app"
						size="36"
						aria-label="Sair"
						class="mr-1"
						@click="logout()"
					></v-btn>
					<v-btn to="/fisiologia/perfil" icon aria-label="Perfil">
						<v-avatar
							class="navbar__profile"
							image="/layout/profile.jpeg"
						/>
					</v-btn>
				</div>
			</v-row>
		</v-app-bar>

		<v-main min-height="100vh" class="main__background">
			<NuxtPage />
		</v-main>

		<v-footer class="d-flex justify-space-between align-center">
			<div class="text-subtitle-2 text-left d-flex flex-column">
				<span>© 2025 Todos os direitos reservados</span>
				<span>
					Desenvolvido por discentes de
					<strong>Informática Biomédica</strong> da UFPR
				</span>
			</div>
			<a
				href="https://www.instagram.com/fisiologia.em.acao"
				target="_blank"
				class="d-flex align-center text-decoration-none"
				style="color: #000; font-weight: 600; font-size: 16px"
			>
				<v-icon class="mr-1">mdi-instagram</v-icon>
				@fisiologia.em.acao
			</a>
		</v-footer>
	</v-app>
</template>
<script setup>
import { useAuthStore } from "~/store/auth"

const cookieAdmin = useCookie("admin", {
	sameSite: true,
})

const { logUserOut } = useAuthStore()

const homeURL = "/fisiologia"
const links = [
	{
		name: "Quizzes",
		icon: "mdi-nintendo-game-boy",
		link: "/fisiologia",
		arialLabel: "Página inicial",
	},
	{
		name: "FAQ",
		icon: "mdi-tooltip-question",
		link: "/fisiologia/faq",
		arialLabel: "Perguntas frequentes",
	},
	{
		name: "Dashboard",
		icon: "mdi-shield-crown",
		link: "/fisiologia/dashboard",
		arialLabel: "Painel de controle",
		onlyAdmin: true,
	},
]

async function logout() {
	const router = useRouter()
	await logUserOut()
	router.push("/")
}
</script>
<style scoped>
.navbar__link {
	color: var(--primary-color);
	font-weight: 600;
	font-size: 16px;
	opacity: 0.25;
	transition: all 0.5s ease;
}
.navbar__link--active {
	opacity: 1;
	font-weight: 800;
	text-decoration: underline;
}
.navbar__link:hover {
	opacity: 1;
	color: var(--secondary-color);
}

.navbar__profile {
	background:
		linear-gradient(white, white) padding-box,
		linear-gradient(to right, blue, purple) border-box;
	border-radius: 50em;
	border: 2px solid transparent;
}

.main__background {
	background: white;
	background-image: radial-gradient(rgba(0, 0, 0, 0.25) 1px, transparent 0);
	background-size: 20px 20px;
	background-position: -16px -16px;

	width: 100%;
}
</style>
