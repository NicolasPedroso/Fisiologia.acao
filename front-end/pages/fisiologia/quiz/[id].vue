<template>
	<v-container
		v-if="status === 'success'"
		fluid
		class="d-flex align-center justify-center"
		min-height="calc(100% - 64px)"
		:key="selected"
	>
		<quiz-start
			v-if="selected === 0"
			:title="quizRes.title"
			:image="formatImage(quizRes.image)"
			:description="quizRes.description"
			:theme-title="quizRes.theme.title"
			:is-completed="quizRes.user_status === 'Completo'"
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
			:title="quizRes.title"
			@finish-quiz="finishQuiz"
			@next-error="nextError"
			@abandon-quiz="abandonQuiz"
		/>
	</v-container>

	<Loading :status="status" />

	<ActionPopup
		v-model="showDialog"
		:title="popupConfig.title"
		:text="popupConfig.text"
		:icon="popupConfig.icon"
		:color="popupConfig.color"
		@confirm="popupConfig.action"
		@cancel="
			() => {
				showDialog = false
			}
		"
	/>
</template>
<script setup>
// Propriedade que diz o momento do quiz
const selected = ref(0)

const routeURL = useRoute()
const quizID = routeURL.params.id

const {
	data: quizRes,
	status,
	refresh,
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
	}
})

const showDialog = ref(false)
const popupConfig = ref({})

function handleSuccess() {
	showDialog.value = false
}

const nextError = () => {
	popupConfig.value = {
		title: "Acerte a questão antes",
		text: "Você precisa acertar a questão antes de prosseguir.",
		icon: "mdi-alert-circle",
		color: "red",
		action: () => {
			showDialog.value = false
		},
	}
	showDialog.value = true
}

const abandonQuiz = () => {
	popupConfig.value = {
		title: "Quiz abandonado",
		text: "Você abandonou o quiz. Deseja continuar?",
		icon: "mdi-alert",
		color: "orange",
		action: () => {
			showDialog.value = false
			selected.value = 0
		},
	}
	showDialog.value = true
}

const finishQuiz = async (time) => {
	selected.value = 0

	popupConfig.value = {
		title: "Quiz finalizado com sucesso!",
		text: "Tempo gasto: " + time + " segundos",
		icon: "mdi-check",
		color: "green",
		action: handleSuccess,
	}
	showDialog.value = true

	await useDataLoader(`/api/fase/${route.params.id}/status`, {
		method: "POST",
		body: {
			status: "Completo",
		},
	})

	refresh()
}

definePageMeta({
	middleware: ["id-check", "guest"],
})

const route = useRoute()
useSeoMeta({
	title: "Quiz " + route.params.id,
	description: "",
	keywords: "",
})
</script>
<style scoped></style>
