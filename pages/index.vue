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
		{{ post }}
		<br />
		<v-btn @click="enviarDado">Mandar dado random</v-btn>
	</v-container>
</template>
<script setup>
import Banner from "@/components/sections/home/Banner.vue";
import Gallery from "@/components/sections/home/Gallery.vue";

// O massa que da para atrelar uma VARIAVEL de loading :)
let postTeste = ref({
	name: "teste",
	imagem: "teste",
});

const { data: post, refresh } = await useAsyncData("get", () =>
	$fetch(`http://localhost:8000/gallery`)
);

async function enviarDado() {
	await $fetch("http://localhost:8000/gallery", {
		method: "POST",
		body: postTeste.value,
	})
		.then(() => {
			console.log(`Enviado!`);
		})
		.catch((error) => {
			console.log(`Erro: ${error}`);
		});
}
</script>
