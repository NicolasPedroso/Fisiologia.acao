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
				:src="formatImage(questions[actualQuestion].image)"
				alt="Quiz Image"
				class="quiz__image"
				width="100%"
				max-height="600"
				fill
				style="border-radius: 8px"
			/>
			<h2 class="mt-6">{{ questions[actualQuestion].question }}</h2>
			<div class="quiz__options d-flex flex-column ga-2 mt-6">
				<v-btn
					v-for="(option, index) in [
						questions[actualQuestion].option_a,
						questions[actualQuestion].option_b,
						questions[actualQuestion].option_c,
						questions[actualQuestion].option_d,
					]"
					:key="index"
					:disabled="selectedOptions.includes(index)"
					:color="
						selectedOptions.includes(index) &&
						optionsQuestion[index] ===
							questions[actualQuestion].correct_answer
							? 'light-green-accent-3'
							: 'blue-grey-lighten-5'
					"
					:style="{
						opacity:
							selectedOptions.includes(index) &&
							optionsQuestion[index] !==
								questions[actualQuestion].correct_answer
								? 0.5
								: 1,
					}"
					elevation="0"
					@click="selectOption(option, index)"
				>
					<v-icon
						v-if="
							selectedOptions.includes(index) &&
							optionsQuestion[index] ===
								questions[actualQuestion].correct_answer
						"
						class="mr-2"
						color="black"
					>
						mdi-check
					</v-icon>
					<v-icon
						v-if="
							selectedOptions.includes(index) &&
							optionsQuestion[index] !==
								questions[actualQuestion].correct_answer
						"
						class="mr-2"
						color="gray darken-2"
					>
						mdi-close
					</v-icon>

					{{ option }}
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
					}}
				</span>
			</v-btn>
		</div>
	</v-container>
</template>
<script setup>
const startTime = Date.now()
const actualQuestion = ref(0)
const selectedOptions = ref([])
const optionsQuestion = ["A", "B", "C", "D"]

const props = defineProps({
	questions: {
		type: Array,
		default: () => [
			{
				id: 1,
				fase_id: 1,
				question: "Nada",
				image: "",
				correct_answer: "A",
				option_a: "adsdsa",
				option_b: "adsads",
				option_c: "dasadsads",
				option_d: "dasadsads",
			},
		],
	},
	title: {
		type: String,
		default: "Quiz",
	},
})

const changeQuestion = (direction) => {
	if (
		direction === "next" &&
		actualQuestion.value <= props.questions.length - 1
	) {
		// Verifica se o usuario acertou a questão atual
		const currentQuestion = props.questions[actualQuestion.value]
		const correctAnswerIndex = optionsQuestion.indexOf(
			currentQuestion.correct_answer,
		)
		const isCorrect = selectedOptions.value.includes(correctAnswerIndex)

		if (isCorrect) {
			// Finalizar quiz
			if (actualQuestion.value === props.questions.length - 1) {
				const endTime = Date.now()
				const time = Math.floor((endTime - startTime) / 1000)
				finishQuiz(time)
				return
			}

			actualQuestion.value++
			selectedOptions.value = []
			return
		} else {
			// Se a resposta estiver errada, chama o evento nextError
			nextError()
			return
		}
	} else if (direction === "previous" && actualQuestion.value > 0) {
		actualQuestion.value--
		selectedOptions.value = []
		return
	}
}

const selectOption = (option, index) => {
	if (selectedOptions.value.includes(index)) {
		selectedOptions.value = selectedOptions.value.filter(
			(id) => id !== index,
		)
	} else {
		selectedOptions.value.push(index)
	}
}

const emit = defineEmits(["finishQuiz", "nextError", "abandonQuiz"])
const finishQuiz = (time) => {
	emit("finishQuiz", time)
}
const abortQuiz = () => {
	emit("abandonQuiz")
}
const nextError = () => {
	emit("nextError")
}
</script>
<style scoped>
.quiz__actions_text {
	letter-spacing: 0.5px;
	font-weight: 600;
}
</style>
