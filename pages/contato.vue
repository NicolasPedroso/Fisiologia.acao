<template>
	<Head>
		<Title>Página inicial</Title>
		<meta
			name="description"
			content="Página inicial do projeto base 2024 da Ecomp."
		/>
	</Head>
	<v-container fluid class="ma-0 pa-0">
		<Banner :title="'CONTATO'" />
		<InfoBox />
	</v-container>
</template>
<script setup>
import Banner from "@/components/sections/contact/Banner.vue";
import InfoBox from "~/components/sections/contact/InfoBox.vue";
</script>
<style scoped></style>
