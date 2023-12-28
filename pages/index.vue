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
	</v-container>
</template>
<script setup>
import Banner from "@/components/sections/home/Banner.vue";
</script>
