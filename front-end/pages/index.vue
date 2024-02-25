<template>
	<v-container fluid class="ma-0 pa-0 text-center">
		<Banner :title="'Bem-vindo'" />
		<WorkTypes />
		<!-- Bem vindo ao projeto base de 2024 :) -->
		<Gallery />
		<WeOffer />
		<v-divider />
		<Testimony :testimonies="requisicao.testimonies" />
	</v-container>
</template>
<script setup>
import Banner from "~/components/global/Banner.vue"
import WorkTypes from "~/components/sections/home/WorkTypes.vue"
import WeOffer from "~/components/sections/home/WeOffer.vue"
import Testimony from "~/components/sections/home/Testimony.vue"
import Gallery from "~/components/sections/home/Gallery.vue"

const { data: requisicao } = await useAsyncData("api-testemunhos", async () => {
	try {
		const [testimonies] = await Promise.all([useDataLoader("/testimonies")])

		return {
			testimonies,
		}
	} catch (error) {
		console.error(error)
		return {
			testimonies: [
				{
					id: 0,
					name: "Nome",
					from: "Fonte",
					text: "Testemunho",
					image: "/banco-testes/imagem-teste-03.jpg",
				},
			],
		}
	}
})

// Cabeçalhos da pagina
useSeoMeta({
	title: "Página inicial",
	description: "Página inicial do projeto base 2024 da Ecomp.",
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
