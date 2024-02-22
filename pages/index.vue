<template>
	<v-container fluid class="ma-0 pa-0 text-center">
		<Banner />
		<WorkTypes />
		<!-- Bem vindo ao projeto base de 2024 :) -->
		<Gallery />
		<WeOffer />
		<v-divider />
		<Testimony :testimonies="testimonies" />
	</v-container>
</template>
<script setup>
import Banner from "~/components/sections/home/Banner.vue"
import WorkTypes from "~/components/sections/home/WorkTypes.vue"
import WeOffer from "~/components/sections/home/WeOffer.vue"
import Testimony from "~/components/sections/home/Testimony.vue"
import Gallery from "~/components/sections/home/Gallery.vue"

const { data: testimonies } = await useAsyncData("testemunhos", () =>
	useDataLoader("/api/testimonies")
		.then((res) => {
			return res.length > 0
				? res
				: [
						{
							id: 0,
							name: "Nome",
							from: "Fonte",
							text: "Testemunho",
							image: "/banco-testes/imagem-teste-03.jpg",
						},
					]
		})
		.catch((err) => {
			console.error(`Um erro aconteceu ao buscar os dados: ${err}`)
			return [
				{
					id: 0,
					name: "Nome",
					from: "Fonte",
					text: "Testemunho",
					image: "/banco-testes/imagem-teste-03.jpg",
				},
			]
		}),
)

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
