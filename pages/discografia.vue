<template>
	<v-container fluid class="disco-wrapper ma-0 pa-0">
		<Banner :title="'DISCOGRAFIA'" />
		<v-data-iterator
			:items="albums"
			:items-per-page="6"
			:search="search"
			class="disco-data-iterator"
		>
			<template v-slot:header>
				<v-row class="justify-center mt-16 mb-6">
					<v-text-field
						theme="dark"
						v-model="search"
						clearable
						density="comfortable"
						hide-details
						placeholder="Procurar"
						prepend-inner-icon="mdi-magnify"
						style="max-width: 310px"
						variant="solo"
					></v-text-field>
				</v-row>
			</template>
			<template v-slot:default="{ items }">
				<v-container class="pa-2" fluid>
					<v-row class="d-flex justify-center">
						<v-col
							v-for="music in items"
							cols="12"
							md="6"
							lg="4"
							class="d-flex justify-center py-12"
						>
							<MusicCard :music="music.raw" />
						</v-col>
					</v-row>
				</v-container>
			</template>
			<template v-slot:footer="{ page, pageCount, prevPage, nextPage }">
				<div class="d-flex align-center justify-center pa-4">
					<v-btn
						:disabled="page === 1"
						icon="mdi-arrow-left"
						density="comfortable"
						variant="tonal"
						color="white"
						rounded
						@click="prevPage"
					></v-btn>
					<div class="mx-2 text-caption raleway" style="color: #fff">
						Page {{ page }} of {{ pageCount }}
					</div>
					<v-btn
						:disabled="page >= pageCount"
						icon="mdi-arrow-right"
						color="white"
						density="comfortable"
						variant="tonal"
						rounded
						@click="nextPage"
					></v-btn>
				</div>
			</template>
		</v-data-iterator>
	</v-container>
</template>
<script setup>
import { shallowRef } from "vue";

import Banner from "@/components/global/Banner.vue";
import MusicCard from "@/components/sections/music/MusicCard.vue";

const search = shallowRef("");
const albums = [
	{
		title: "bittersweet memories",
		artist: "Yung Li (feat Biffe & Hakuro)",
		color: "orange",
		percentage: 25,
		image: "https://pbs.twimg.com/media/GBwWPX4WEAAqSMg.jpg",
	},
	{
		title: "Grana Azul",
		artist: "Rodrigo Zin",
		color: "red",
		percentage: 87,
		image: "https://cdns-images.dzcdn.net/images/cover/278d95040860131e0770033e59ca7985/500x500.jpg",
	},
	{
		title: "Invasor",
		artist: "Rodrigo Zin",
		color: "#fa6508",
		percentage: 55,
		image: "https://i.scdn.co/image/ab67616d0000b2730796832ffa9022f359a37412",
	},
	{
		title: "Validation",
		artist: "Yung Li",
		color: "#287048",
		percentage: 98,
		image: "https://pbs.twimg.com/media/FlrkeV9WQAEo6uW?format=jpg&name=4096x4096",
	},
	{
		title: "good kid, m.A.A.d city",
		artist: "Kendrick Lamar",
		color: "green",
		percentage: 28,
		image: "https://s3.amazonaws.com/img.iluria.com/product/54F2EE/CEC9D2/450xN.jpg",
	},
	{
		title: "Across The Spiderverse",
		artist: "Metro Boomin",
		color: "purple",
		percentage: 38,
		image: "https://steamuserimages-a.akamaihd.net/ugc/2011467004295931235/5E97DB1B34585CAD915BDBF583BD9E991C9AC26E/?imw=512&&ima=fit&impolicy=Letterbox&imcolor=%23000000&letterbox=false",
	},
	{
		title: "O Pior Disco do Ano",
		artist: "Froid",
		color: "#ad243a",
		percentage: 77,
		image: "https://akamai.sscdn.co/letras/360x360/albuns/5/f/1/4/614831515074068.jpg",
	},
];

// Cabeçalhos da pagina
useSeoMeta({
	title: "Discografia",
	description:
		"Veja uma sequência de álbuns e músicas recomendadas por @tuildes :)",
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
<style scoped>
/* @media (max-width: 959px) {
	.disco-data-iterator {
		height: 3200px !important;
	}
}

@media (max-width: 1279px) and (min-width: 960px) {
	.disco-data-iterator {
		height: 1700px !important;
	}
}
.disco-data-iterator {
	height: 1200px;
} */
.disco-wrapper {
	background:
		radial-gradient(
				circle,
				transparent 20%,
				#121212 20%,
				#121212 80%,
				transparent 80%,
				transparent
			)
			0% 0% / 80px 80px,
		radial-gradient(
				circle,
				transparent 20%,
				#121212 20%,
				#121212 80%,
				transparent 80%,
				transparent
			)
			40px 40px / 80px 80px,
		linear-gradient(#343434 2px, transparent 2px) 0px -1px / 40px 40px,
		linear-gradient(90deg, #343434 2px, #121212 2px) -1px 0px / 40px 40px #121212;
	background-size:
		80px 80px,
		80px 80px,
		40px 40px,
		40px 40px;
	background-color: #121212;
}
</style>
