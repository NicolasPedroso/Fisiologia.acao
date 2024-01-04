<template>
	<v-container fluid class="ma-0 pa-0">
		<Banner :title="'CONTATO'" />
		<InfoBox />
	</v-container>
</template>
<script setup>
import Banner from "@/components/sections/contact/Banner.vue";
import InfoBox from "~/components/sections/contact/InfoBox.vue";

// Cabeçalhos da pagina
useSeoMeta({
	title: "Contato",
	description:
		"Veja como entrar em contato com a Ecomp ou mande uma mensagem para nós!",
});
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
});
</script>
<style scoped></style>
