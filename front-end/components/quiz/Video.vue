<template>
	<v-container
		fluid
		class="d-flex align-center justify-center"
		width="100%"
		height="100%"
	>
		<div class="quiz__content d-flex align-center flex-column">
			<h1>{{ title }}</h1>
			<YouTube
				ref="youtube"
				:src="linkYoutube"
				:width="640 * 1.25"
				:height="360 * 1.25"
				class="my-4"
				@ready="onReadyYTB"
			/>
			<v-btn class="start-btn mt-5" elevation="0" @click="startQuiz()">
				<span class="start-btn__text"> Começar quiz </span>
			</v-btn>
		</div>
	</v-container>
</template>
<script setup>
import YouTube from "vue3-youtube"

// Emit para iniciar o quiz
const emit = defineEmits(["startQuiz"])
function startQuiz() {
	emit("startQuiz", 1)
}

defineProps({
	title: {
		type: String,
		default: "Iniciar Quiz",
	},
	linkYoutube: {
		type: String,
		default: "https://www.youtube.com/watch?v=LACbVhgtx9I",
	},
})

const youtube = useTemplateRef("youtube")
function onReadyYTB() {
	youtube.playVideo()
}
</script>
<style scoped>
.quiz__card__wrapper {
	padding: 32px 64px;
}
.quiz__card {
	transform: rotate(-8deg);
	border-radius: 16px;
}

.start-btn {
	width: 100%;
	font-size: 1.5rem;
	line-height: 0;
	font-weight: 600;
	background-color: var(--secondary-color);
	color: #ffffff;
	transition: background-color 1s ease;
	padding: 20px 0;

	display: flex;
	justify-content: center;
	align-items: center;
}

.start-btn:hover {
	background-color: var(--primary-color);
}

.start-btn__text {
	font-size: 1.2rem;
	line-height: 1.2rem;
	letter-spacing: 0.05rem;
	text-transform: none;
	font-weight: 600;
}
</style>
