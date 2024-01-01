<template>
	<Head>
		<Title>Página inicial</Title>
		<meta
			name="description"
			content="Página inicial do projeto base 2024 da Ecomp."
		/>
	</Head>
	<v-container fluid class="ma-0 pa-0 text-center">
		<Banner />
		<!-- Bem vindo ao projeto base de 2024 :) -->
		<Gallery />
		<v-divider />
		<ClientOnly>
			<Testimony :testimonies="testimonies" />
		</ClientOnly>
	</v-container>
</template>
<script setup>
import Banner from "@/components/sections/home/Banner.vue";
import Testimony from "~/components/sections/home/Testimony.vue";
import Gallery from "@/components/sections/home/Gallery.vue";

const { data: testimonies } = await useAsyncData("get", () =>
	$fetch(`http://localhost:8000/testimonies`)
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
				  ];
		})
		.catch((err) => {
			console.log(err);
			return [
				{
					id: 0,
					name: "Nome",
					from: "Fonte",
					text: "Testemunho",
					image: "/banco-testes/imagem-teste-03.jpg",
				},
			];
		})
);
</script>
