<template>
	<v-container
		fluid
		class="quiz__wrapper text-center d-flex flex-column mt-12 mb-6"
		width="100%"
		style="max-width: 1280px"
	>
		<h1>{{ title }}</h1>
		<h4>{{ actualQuestion + 1 }}/{{ questions.length }}</h4>
		<div class="quiz__main mt-4">
			<v-img
				:src="questions[actualQuestion].image"
				alt="Quiz Image"
				class="quiz__image"
				width="100%"
				:aspect-ratio="3 / 1"
				cover
				style="border-radius: 8px"
			/>
			<h2 class="mt-6">{{ questions[actualQuestion].question }}</h2>
			<div class="quiz__options d-flex flex-column ga-2 mt-6">
				<v-btn
					v-for="option in questions[actualQuestion].options"
					:key="option.id"
					:disabled="selectedOptions.includes(option.id)"
					:color="
						selectedOptions.includes(option.id) &&
						option.id === questions[actualQuestion].correct
							? 'light-green-accent-3'
							: 'blue-grey-lighten-5'
					"
					:style="{
						opacity:
							selectedOptions.includes(option.id) &&
							option.id !== questions[actualQuestion].correct
								? 0.5
								: 1,
					}"
					elevation="0"
					@click="selectOption(option)"
				>
					<v-icon
						v-if="
							selectedOptions.includes(option.id) &&
							option.id === questions[actualQuestion].correct
						"
						class="mr-2"
						color="black"
					>
						mdi-check
					</v-icon>
					<v-icon
						v-if="
							selectedOptions.includes(option.id) &&
							option.id !== questions[actualQuestion].correct
						"
						class="mr-2"
						color="gray darken-2"
					>
						mdi-close
					</v-icon>

					{{ option.text }}
				</v-btn>
			</div>
		</div>
		<div class="quiz__actions d-flex mt-8">
			<v-btn elevation="0" color="grey darken-2" @click="abortQuiz()">
				<span class="quiz__actions_text">Abandonar</span>
			</v-btn>
			<v-spacer />
			<v-btn
				elevation="0"
				variant="text"
				prepend-icon="mdi-chevron-left"
				:disabled="actualQuestion === 0"
				@click="changeQuestion('previous')"
			>
				<span class="quiz__actions_text">Anterior</span>
			</v-btn>
			<v-btn
				elevation="0"
				append-icon="mdi-chevron-right"
				color="blue-darken-4"
				@click="changeQuestion('next')"
			>
				<span class="quiz__actions_text">
					{{
						actualQuestion + 1 === questions.length
							? "Finalizar"
							: "Próximo"
					}}</span
				>
			</v-btn>
		</div>
	</v-container>
</template>
<script setup>
const startTime = Date.now()
const actualQuestion = ref(0)
const selectedOptions = ref([])
const questions = [
	{
		id: 1,
		question: "What is the capital of France?",
		image: "/layout/profile.jpeg",
		options: [
			{ id: 1, text: "Paris" },
			{ id: 2, text: "London" },
			{ id: 3, text: "Berlin" },
			{ id: 4, text: "Madrid" },
		],
		correct: 1,
	},
	{
		id: 2,
		question: "Desde qué ciudad se puede ver la Torre Eiffel?",
		image: "https://picsum.photos/480/320?random=1",
		options: [
			{ id: 1, text: "Paris" },
			{ id: 2, text: "London" },
			{ id: 3, text: "Berlin" },
			{ id: 4, text: "Madrid" },
		],
		correct: 1,
	},
	{
		id: 3,
		question: "Cuál es la capital de Francia?",
		image: "https://picsum.photos/480/320?random=1",
		options: [
			{ id: 1, text: "Paris" },
			{ id: 2, text: "London" },
			{ id: 3, text: "Berlin" },
			{ id: 4, text: "Madrid" },
		],
		correct: 1,
	},
]

const changeQuestion = (direction) => {
	if (direction === "next" && actualQuestion.value <= questions.length - 1) {
		// Verifica se o usuario acertou a questão atual
		const currentQuestion = questions[actualQuestion.value]
		const isCorrect = selectedOptions.value.includes(
			currentQuestion.correct,
		)

		if (isCorrect) {
			// Finalizar quiz
			if (actualQuestion.value === questions.length - 1) {
				const endTime = Date.now()
				const time = Math.floor((endTime - startTime) / 1000)
				finishQuiz(time)
				return
			}

			actualQuestion.value++
			selectedOptions.value = []
			return
		}
	} else if (direction === "previous" && actualQuestion.value > 0) {
		actualQuestion.value--
		selectedOptions.value = []
		return
	}
}

const abortQuiz = () => {
	const ok = confirm("Tem certeza que deseja abandonar o quiz?")
	if (!ok) return

	navigateTo("/fisiologia")
}

const selectOption = (option) => {
	if (selectedOptions.value.includes(option.id)) {
		selectedOptions.value = selectedOptions.value.filter(
			(id) => id !== option.id,
		)
	} else {
		selectedOptions.value.push(option.id)
	}
}

const emit = defineEmits(["finishQuiz"])
const finishQuiz = (time) => {
	emit("finishQuiz", time)
}

const title = "Quiz Title"
</script>
<style scoped>
.quiz__actions_text {
	letter-spacing: 0.5px;
	font-weight: 600;
}
</style>
