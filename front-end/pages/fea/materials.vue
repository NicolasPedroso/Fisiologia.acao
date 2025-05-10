<template>
	<div class="container my-10">
		<div class="inner-container">
			<h1 class="title" v-if="currentIndex >= 1">
				{{ theme[currentIndex] }}
			</h1>
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
			<div class="buttons-container">
				<div class="personalized-button" @click="prevVideo">
					<button :disabled="currentIndex === youtubeUrls.length - 1">
						<span>Anterior</span>
					</button>
				</div>
				<div class="personalized-button" @click="nextVideo">
					<button class="button-area" :disabled="currentIndex === 0">
						<span>Próximo</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
import { ref } from "vue"

const { status } = useAsyncData(() =>
	useDataLoader("/api/tema_do_video")
		.then((response) => {
			response.data.forEach((value) => {
				console.log("valor = ", value)
				youtubeUrls.value.push(value.link)
				theme.value.push(value.tema)
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
const theme = ref([""])
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
	margin-top: 6rem;
	margin-right: 57rem;
	font-size: 48px;
}

.container {
	display: flex;
	align-items: center;
	flex-direction: column;
	justify-items: center;
}

.inner-container {
	margin-top: 150px;
	width: 50%;
	background-color: red;
	border-radius: 50px;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-items: center;
}

.buttons-container {
	width: 40%;
	display: flex;
	justify-content: space-between;
	align-items: center;
	margin-top: 10rem;
}

.video-container {
	position: relative;
	width: 40%;
	height: 0;
	padding-bottom: 25%;
	overflow: hidden;
	background-color: black;
	border-radius: 25px;
	margin-top: 3rem;
	border: 4px solid black;
}

.video-container iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: black;
}

.arrow-button {
	width: 40px;
	height: 40px;
	background-color: transparent;
	border: none;
	cursor: pointer;
	position: relative;
}

.arrow-button::before {
	content: "";
	position: absolute;
	top: 50%;
	left: 50%;
	width: 30px;
	height: 0px;
	border: solid white;
	border-width: 0 3px 3px 0;
	padding: 6px;
	transform: translate(-50%, -50%) rotate(45deg);
}

.arrow-button.left::before {
	transform: translate(-50%, -50%) rotate(135deg);
}

.arrow-button.right::before {
	transform: translate(-50%, -50%) rotate(315deg);
}

.personalized-button {
	height: 90px;
	width: 150px;
	background-color: blue;
	display: flex;
	justify-content: center;
	border-radius: 20px;
	cursor: pointer;
}
</style>
