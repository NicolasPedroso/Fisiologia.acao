<template>
	<Head>
		<Title>Contato</Title>
		<meta
			name="description"
			content="Veja como entrar em contato com a Ecomp ou mande uma mensagem para nós!"
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
