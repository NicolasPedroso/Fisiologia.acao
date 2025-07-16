<template>
	<v-container
		fluid
		class="d-flex align-center justify-center"
		height="calc(100% - 64px)"
	>
		<quiz-start
			v-if="selected === 0"
			:title="quiz.title"
			:image="quiz.image"
			:description="quiz.description"
			:theme-title="quiz.theme.title"
			:quantity="quiz.quantity"
			:link="quiz.link"
			@start-video="selected = 1"
		/>
		<quiz-video
			v-else-if="selected === 1"
			:title="quiz.title"
			@start-quiz="selected = 2"
		/>
		<quiz-main v-else-if="selected === 2" @finish-quiz="finishQuiz" />
	</v-container>
</template>
<script setup>
// Propriedade que diz o momento do quiz
const selected = ref(0)

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

const finishQuiz = (time) => {
	if (time) {
		alert(`Tempo gasto: ${time} segundos`)
	}
	selected.value = 0

	// TODO: Implementar lógica de finalização do quiz, como salvar resultados ou redirecionar
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
