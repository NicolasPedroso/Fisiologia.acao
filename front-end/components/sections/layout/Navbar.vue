<template>
	<section class="navbar-wrapper d-flex justify-center">
		<div class="navbar-content d-flex justify-space-between align-center">
			<span class="navbar-title pl-5 pl-lg-0">FZND GRN</span>

			<!--Links para pc-->
			<div class="hidden-md-and-down">
				<template v-for="(item, i) in navbarItems" :key="i">
					<v-menu
						v-if="item.menu"
						offset-y
						bottom
						flat
						transition="scroll-y-reverse-transition"
					>
						<template #activator="{ props }">
							<span v-bind="props" class="navbar-button px-3">
								{{ item.label }}
							</span>
						</template>

						<v-list class="navbar-list d-flex flex-column pa-4">
							<span
								v-for="(link, subIndex) in item.items"
								:key="subIndex"
								class="navbar-list-item pb-1"
							>
								{{ link }}
							</span>
						</v-list>
					</v-menu>
					<nuxt-link
						v-else
						:to="item.link"
						class="navbar-button px-3"
					>
						<span> {{ item.label }}</span>
					</nuxt-link>
				</template>
			</div>

			<!--Links para mobile-->
			<v-app-bar-nav-icon
				class="hidden-lg-and-up mr-6"
				color="white"
				@click="openDrawer()"
			/>
		</div>
		<!-- drawer diz se esta aberto ou fechado -->
		<ClientOnly>
			<v-navigation-drawer
				v-model="drawer"
				absolute
				location="right"
				color="#121212"
				disable-resize-watcher
				disable-route-watcher
				class="navbar-drawer"
			>
				<div class="d-flex flex-column">
					<div class="d-flex justify-end pr-6 pt-6">
						<v-icon color="white" size="40px" @click="openDrawer()">
							mdi-close
						</v-icon>
					</div>
					<template v-for="(item, i) in navbarItems" :key="i">
						<nuxt-link
							v-if="!item.menu"
							:to="item.link"
							class="navbar-panel-button px-3 mb-3 ml-6"
						>
							<span> {{ item.label }} </span>
						</nuxt-link>
						<template v-else>
							<nuxt-link
								v-for="(subItem, index) in item.items"
								:key="index"
								:to="item.link"
								class="navbar-panel-button px-3 mb-3 ml-6"
							>
								<span> {{ subItem }} </span>
							</nuxt-link>
						</template>
					</template>
				</div>
			</v-navigation-drawer>
		</ClientOnly>
	</section>
</template>
<script setup>
import { ref } from "vue"

const drawer = ref(false)
function openDrawer() {
	drawer.value = !drawer.value
}

const navbarItems = [
	{ link: "/dashboard", label: "Dashboard", menu: false },
	{ link: "/", label: "Home", menu: false },
	{ link: "/", label: "Sobre", menu: false },
	{
		link: "/discografia",
		label: "Discografia",
		menu: false,
	},
	{
		label: "Dropdown",
		menu: true,
		items: ["HTML5", "CSS3", "Sass", "JQuery"],
	},
	{ link: "/contato", label: "Contato", menu: false },
]
</script>
<style scoped>
@import url("http://fonts.googleapis.com/css2?family=Raleway&display=swap");
.navbar-content {
	max-width: 1100px;
	width: 100%;
	position: absolute;
	z-index: 10;
	padding: 30px 0;
}

.navbar-title {
	color: #ffffff;
	font-family: "FZNDGrana", Arial, sans-serif;
	font-size: 25px;
	line-height: 1.7;
	font-weight: bold;
	text-shadow: 0px 0px 50px #000000;
}

.navbar-button {
	font-family: "Raleway", Arial, sans-serif;
	color: #fff;
	font-size: 14px;
	font-weight: thin;
	text-decoration: none;
	text-shadow: 0px 0px 25px #000000;
	text-transform: uppercase;
	cursor: pointer;

	transition: opacity 1s;
	opacity: 0.75;
}

.navbar-button:hover {
	opacity: 1;
}

.navbar-list {
	background: #ffffff;
}

.navbar-list-item {
	color: #777;
	transition: color 0.5s;
}

.navbar-list-item:hover {
	color: #000;
	cursor: pointer;
}

.navbar-drawer {
	z-index: 100;
}

.navbar-panel-button {
	font-family: "Raleway", Arial, sans-serif;
	color: #ffffff;
	font-size: 16px;
	font-weight: thin;
	text-decoration: none;
}
</style>
