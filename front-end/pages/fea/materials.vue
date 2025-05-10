<template>
	<div class="container my-10">
		<h1 class="title">Página dos vídeos</h1>
		<div>
			<button @click="prevVideo" :disabled="currentIndex === 0">
				Retroceder
			</button>
			<button
				@click="nextVideo"
				:disabled="currentIndex === youtubeUrls.length - 1"
			>
				Avançar
			</button>
		</div>
		<div class="card-container"></div>
		<div
			class="video-container"
			v-if="currentIndex >= 1 && currentIndex < youtubeUrls.length"
		>
			<iframe
				width="640"
				height="360"
				:src="getEmbedUrl(youtubeUrls[currentIndex])"
				frameborder="0"
				allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
				allowfullscreen
			></iframe>
		</div>
	</div>
</template>

<script setup>
import { ref } from "vue"

const { status } = useAsyncData(() =>
	useDataLoader("/api/tema_do_video")
		.then((response) => {
			response.data.forEach((value) => {
				console.log("valor = ", value.link)
				youtubeUrls.value.push(value.link)
			})
		})
		.catch((error) => {
			console.error(error)
			notify({
				title: "Erro ao carregar vídeos",
				text: error.message || "Falha ao buscar vídeos",
				type: "error",
			})
			return ""
		}),
)

const youtubeUrls = ref([""])
const currentIndex = ref(1)

const nextVideo = () => {
	if (currentIndex.value < youtubeUrls.value.length - 1) {
		currentIndex.value++
	}
}

const prevVideo = () => {
	if (currentIndex.value > 1) {
		currentIndex.value--
	}
}

const getEmbedUrl = (url) => {
	if (!url) return ""

	const match1 = url.match(/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/)
	const match2 = url.match(/youtu\.be\/([a-zA-Z0-9_-]+)/)

	const videoId = match1?.[1] || match2?.[1]
	return videoId ? `https://www.youtube.com/embed/${videoId}` : ""
}
</script>

<style scoped>

.title {
    
}

.container {
	display: flex;
	align-items: center;
	justify-items: center;
	flex-direction: column;
}

.video-container {
	position: relative;
	width: 40%;
	height: 0;
	padding-bottom: 25%;
	overflow: hidden;
	background-color: black;
}

.video-container iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
    background-color: black;
}
</style>
