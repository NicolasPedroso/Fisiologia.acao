<template>
	<v-container
		v-if="status === 'success'"
		fluid
		class="d-flex align-center justify-center"
		height="calc(100% - 64px)"
	>
		<quiz-start
			v-if="selected === 0"
			:title="quizRes.title"
			:image="formatImage(quizRes.image)"
			:description="quizRes.description"
			theme-title="Placeholder"
			:quantity="quizRes.perguntas_count"
			@start-video="selected = 1"
		/>
		<quiz-video
			v-else-if="selected === 1"
			:title="quizRes.title"
			:link-youtube="quizRes.video_link"
			@start-quiz="selected = 2"
		/>
		<quiz-main
			v-else-if="selected === 2"
			:questions="quizRes.perguntas"
			@finish-quiz="finishQuiz"
		/>
	</v-container>
	<Loading :status="status" />
</template>
<script setup>
// Propriedade que diz o momento do quiz
const selected = ref(0)

const routeURL = useRoute()
const quizID = routeURL.params.id

const {
	data: quizRes,
	error,
	status,
} = await useAsyncData(`fetch-quiz-data-${quizID}`, async () => {
	try {
		const response = await useDataLoader(`/api/fase/${quizID}`)
		return response
	} catch (e) {
		console.error(`Error fetching quiz data: ${e.message || e}`)

		throw createError({
			statusCode: e.response?.status || 500,
			message: "Ocorreu um erro ao buscar o quiz",
			fatal: true,
		})

		return null
	}
})

const quiz = {
	title: "Quiz 1",
	image: "/layout/profile.jpeg",
	dificulty: 0,
	status: "Completo",
	quantity: 10,
	theme: { title: "Tema 1", icon: "mdi-cat" },
	description:
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
	link: "/fisiologia/quiz/1",
}

const finishQuiz = async (time) => {
	if (time) {
		alert(`Tempo gasto: ${time} segundos`)
	}
	selected.value = 0

	console.log(`/api/fase/${route.params.id}/status`)

	await useDataLoader(`/api/fase/${route.params.id}/status`, {
		method: "POST",
		body: {
			status: "Completo",
		},
	})
}

definePageMeta({
	middleware: ["guest", "id-check"],
})

const route = useRoute()
useSeoMeta({
	title: "Quiz " + route.params.id,
	description: "",
	keywords: "",
})
</script>
<style scoped></style>
