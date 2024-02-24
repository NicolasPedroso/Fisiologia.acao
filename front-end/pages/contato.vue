<template>
	<v-container fluid class="ma-0 pa-0">
		<Banner :title="'CONTATO'" />
		<v-row>
			<v-col cols="8">
				<BarChart> Isso aparece quando der um erro! </BarChart>
			</v-col>
			<v-col cols="4">
				<DoughtChart />
			</v-col>
		</v-row>
		<InfoBox />
	</v-container>
</template>
<script setup>
import Banner from "@/components/global/Banner.vue"
import InfoBox from "@/components/sections/contact/InfoBox.vue"

import BarChart from "@/components/charts/BarChart.vue"
import DoughtChart from "~/components/charts/DoughtChart.vue"

// Cabeçalhos da pagina
useSeoMeta({
	title: "Contato",
	description:
		"Veja como entrar em contato com a Ecomp ou mande uma mensagem para nós!",
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
<style scoped></style>
