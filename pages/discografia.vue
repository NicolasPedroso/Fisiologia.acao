<template>
	<v-container fluid class="disco-wrapper ma-0 pa-0">
		<Banner :title="'DISCOGRAFIA'" />
		<v-data-iterator
			:items="albums"
			:items-per-page="6"
			:search="search"
			class="disco-data-iterator"
		>
			<template #header>
				<v-row class="justify-center mt-16 mb-6">
					<v-text-field
						v-model="search"
						theme="dark"
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
			<template #default="{ items }">
				<v-container class="pa-2" fluid>
					<v-row class="d-flex justify-center">
						<v-col
							v-for="(music, i) in items"
							:key="i"
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
			<template #footer="{ page, pageCount, prevPage, nextPage }">
				<div class="d-flex align-center justify-center pa-4 pb-16">
					<v-btn
						:disabled="page === 1"
						icon="mdi-arrow-left"
						density="comfortable"
						variant="tonal"
						color="white"
						rounded
						@click="prevPage"
					></v-btn>
					<div class="mx-2 raleway" style="color: #fff">
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
import { shallowRef } from "vue"

import Banner from "@/components/global/Banner.vue"
import MusicCard from "@/components/sections/music/MusicCard.vue"

const search = shallowRef("")
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
	{
		title: "Vocal Collection Vol. 1",
		artist: "Carole & Tuesday",
		color: "#eb7a2e",
		percentage: 55,
		image: "https://m.media-amazon.com/images/I/71hlBkB5OPL._UF1000,1000_QL80_.jpg",
	},
	{
		title: "Barka EP",
		artist: "Makalister",
		color: "#696a20",
		percentage: 74,
		image: "https://images.genius.com/6fc9428f03e88da09ceb26d9c56ad127.500x500x1.jpg",
	},
	{
		title: "UTOPIA",
		artist: "Travis Scott",
		color: "#fff",
		percentage: 33,
		image: "data:image/jpeg;base64,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",
	},
	{
		title: "Zero",
		artist: "Yung Buda",
		color: "#00e902",
		percentage: 33,
		image: "https://images.genius.com/aaf59281c51b44c1d2184dddfd30a705.1000x1000x1.png",
	},
]

// Cabeçalhos da pagina
useSeoMeta({
	title: "Discografia",
	description:
		"Veja uma sequência de álbuns e músicas recomendadas por @tuildes :)",
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
