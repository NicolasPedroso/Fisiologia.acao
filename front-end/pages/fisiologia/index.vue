<template>
	<v-container fluid>
		<div class="shortcuts__container">
			<h1>Quizzes</h1>
			<v-row class="pa-2">
				<v-col cols="12" md="4" class="pa-1">
					<v-btn
						width="100%"
						elevation="0"
						color="var(--primary-color)"
						class="shortcut_help"
					>
						O que é o fisiologia em ação?
					</v-btn>
				</v-col>

				<v-col cols="12" md="4" class="pa-1">
					<v-btn
						width="100%"
						elevation="0"
						color="var(--primary-color)"
						class="shortcut_help"
						variant="outlined"
					>
						<v-icon class="mr-1" style="margin-bottom: 2px">
							mdi-progress-question
						</v-icon>
						Quiz aleatório
					</v-btn>
				</v-col>

				<v-col cols="12" md="4" class="pa-1">
					<v-btn
						width="100%"
						elevation="0"
						color="var(--primary-color)"
						class="shortcut_help"
						variant="outlined"
					>
						<v-icon class="mr-1" style="margin-bottom: 2px">
							mdi-progress-question
						</v-icon>
						Tema aleatório
					</v-btn>
				</v-col>
			</v-row>
		</div>

		<!-- TEMAS -->
		<div class="themes__container mt-12">
			<div class="themes__header d-flex align-center">
				<h1>Temas de estudo</h1>
				<v-spacer></v-spacer>
				<v-text-field
					v-model="search"
					label="Pesquisar tema"
					hide-details
					prepend-inner-icon="mdi-magnify"
					variant="outlined"
					style="min-width: 300px"
					clearable
				></v-text-field>
			</div>

			<v-data-iterator
				:items="themes"
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
							<theme-card :theme="item.raw" />
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
								type="card"
							></v-skeleton-loader>
						</v-col>
					</v-row>
				</template>
			</v-data-iterator>
		</div>

		<!-- Todos os QUIZZES -->
		<div class="datatable__wrapper mt-12">
			<div class="themes__header d-flex align-center">
				<h1>Todos os quizzes</h1>
				<v-spacer></v-spacer>
				<v-text-field
					v-model="searchAllQuizzes"
					label="Pesquisar quiz"
					hide-details
					prepend-inner-icon="mdi-magnify"
					variant="outlined"
					style="min-width: 300px"
					clearable
				></v-text-field>
			</div>
		</div>
	</v-container>
</template>

<script setup>
const search = shallowRef("")
const searchAllQuizzes = shallowRef("")
const themes = [
	{
		title: "Tema 1",
		icon: "mdi-cat",
		link: "/fisiologia",
		quantity: 5,
	},
]

const quizzes = [
	{
		image: "",
		title: "Quiz 1",
		dificulty: "Fácil",
		quantity: 10,
		status: "Completo",
		theme: "Tema 1",
		link: "/fisiologia/quiz/1",
	},
]

definePageMeta({
	middleware: ["guest"],
})

useSeoMeta({
	title: "Quizzes",
	description: "",
	keywords: "",
})
</script>
<style scoped>
.shortcut_help {
	color: var(--white);
	font-weight: 600;
	letter-spacing: 0;
	text-transform: none;
}

:deep(.v-field__overlay) {
	background-color: var(--white);
}
</style>
