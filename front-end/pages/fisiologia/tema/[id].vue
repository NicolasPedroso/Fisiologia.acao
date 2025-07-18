<template>
	<v-container fluid v-if="status === 'success'">
		<div
			class="shortcuts__container d-flex align-center justify-center ga-2"
		>
			<v-icon> {{ themeRes.icon }} </v-icon>
			<h1>{{ themeRes.title }}</h1>
		</div>

		<div
			v-for="(type, index) in dificultyOptions"
			:key="index"
			class="themes__container mt-12"
		>
			<div class="themes__header d-flex align-center">
				<h1 :class="`text-${type.color}-darken-4`">
					Quizzes {{ type.text }}
				</h1>
				<v-spacer></v-spacer>
				<v-text-field
					v-model="search"
					label="Pesquisar quiz"
					hide-details
					prepend-inner-icon="mdi-magnify"
					variant="outlined"
					style="min-width: 300px"
					clearable
				></v-text-field>
			</div>

			<v-data-iterator
				:items="
					themeRes.fases.filter(
						(item) => item.dificulty === type.value,
					)
				"
				:items-per-page="8"
				:search="search"
				:loading="false"
			>
				<template #default="{ items }">
					<v-row class="mt-6" dense>
						<v-col
							v-for="item in items"
							:key="item.title"
							cols="3"
							class="pa-2"
						>
							<quiz-card
								:quiz="item.raw"
								:blocked="type.blockedFunction()"
							/>
						</v-col>
					</v-row>
				</template>

				<template #no-data>
					<v-row class="mt-6" dense>
						<v-col cols="12" class="text-center">
							<h3 class="text-grey">Nenhum quiz encontrado</h3>
						</v-col>
					</v-row>
				</template>

				<template #footer="{ page, pageCount, prevPage, nextPage }">
					<div class="d-flex align-center justify-center pa-4">
						<v-btn
							:disabled="page === 1"
							density="comfortable"
							icon="mdi-arrow-left"
							variant="tonal"
							rounded
							@click="prevPage"
						></v-btn>

						<div class="mx-2 text-caption">
							Page {{ page }} of {{ pageCount }}
						</div>

						<v-btn
							:disabled="page >= pageCount"
							density="comfortable"
							icon="mdi-arrow-right"
							variant="tonal"
							rounded
							@click="nextPage"
						></v-btn>
					</div>
				</template>

				<template #loader>
					<v-row class="mt-6" dense>
						<v-col
							v-for="(_, k) in [0, 1, 2, 3, 4, 5, 6, 7]"
							:key="k"
							cols="3"
							class="pa-2"
						>
							<v-skeleton-loader
								:elevation="1"
								type="image"
							></v-skeleton-loader>
						</v-col>
					</v-row>
				</template>
			</v-data-iterator>
		</div>
	</v-container>
</template>

<script setup>
const search = shallowRef("")

const routeURL = useRoute()
const quizID = routeURL.params.id

const { data: themeRes, status } = await useAsyncData(
	`fetch-theme-data-${quizID}`,
	async () => {
		try {
			const response = await useDataLoader(`/api/themes/${quizID}`)
			return response.data
		} catch (e) {
			console.error(`Error fetching theme data: ${e.message || e}`)

			throw createError({
				statusCode: e.response?.status || 500,
				message: "Ocorreu um erro ao buscar o tema",
				fatal: true,
			})
		}
	},
)

const dificultyOptions = [
	{
		text: "Fáceis",
		color: "green",
		value: "Fácil",
		blockedFunction: () => {
			return false
		},
	},
	{
		text: "Intermediários",
		color: "yellow",
		value: "Médio",
		blockedFunction: () => {
			return false
		},
		// blockedFunction: (quizzes) => {
		// 	return !quizzes.some((quiz) => {
		// 		return quiz.dificulty == "Fácil" && quiz.status === "Completo"
		// 	})
		// },
	},
	{
		text: "Difíceis",
		color: "red",
		value: "Difícil",
		blockedFunction: () => {
			return false
		},
		// blockedFunction: (quizzes) => {
		// 	return !quizzes.some((quiz) => {
		// 		return quiz.dificulty == "Médio" && quiz.status === "Completo"
		// 	})
		// },
	},
]

definePageMeta({
	middleware: ["guest", "id-check"],
})

useSeoMeta({
	title: "Quizzes",
	description: "",
	keywords: "",
})
</script>
<style scoped>
.shortcuts__container {
	padding: 16px;
	font-size: 4rem;
}
.shortcuts__container h1 {
	font-size: 3rem;
	margin-top: 0.25rem;
}
</style>
