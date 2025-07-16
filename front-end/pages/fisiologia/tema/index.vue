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

			<div>
				<v-data-table
					:items="quizzes"
					:headers="headers"
					:search="searchAllQuizzes"
					:items-per-page="10"
					:loading="false"
					:items-per-page-options="[5, 10, 15]"
					:sort-by="sortBy"
					item-value="title"
					class="mt-6"
				>
					<!-- ITEM -->
					<template #item="{ item }">
						<tr
							class="cursor-pointer table__row"
							:class="{
								'table__row--completed':
									item.status === 'Completo',
							}"
							@click="item.link && $router.push(item.link)"
						>
							<td>
								<div class="d-flex align-center ga-2">
									<img
										:src="item.image"
										width="50"
										height="50"
										style="border-radius: 4"
										class="my-2"
									/>
									<strong>{{ item.title }}</strong>
									<span
										v-if="item.status !== 'Não iniciado'"
										class="text-caption"
									>
										({{ item.status }})
									</span>
								</div>
							</td>

							<td>
								<v-chip
									:color="getColor(item.dificulty)"
									:border="`${getColor(item.dificulty)} thin opacity-25`"
									text-color="white"
									class="ma-1"
								>
									{{ dificulty[item.dificulty] }}
								</v-chip>
							</td>

							<td>
								<strong>{{ item.quantity }}</strong> questões
							</td>

							<td>
								<v-icon :icon="item.theme.icon" class="mb-1" />
								{{ item.theme.title }}
							</td>
						</tr>
					</template>
					<!-- ITEM -->
				</v-data-table>
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

// Funcao para retorno de cores pra as dificuldades/status
const getColor = (status) => {
	switch (status) {
		case 0: // Dificuldade fácil
			return "success"
		case 1: // Dificuldade média
			return "warning"
		case 2: // Dificuldade difícil
			return "error"
		default: // Fallback
			return "grey"
	}
}

const sortBy = ref([
	{ key: "status", order: "desc" },
	{ key: "dificulty", order: "asc" },
	{ key: "title", order: "asc" },
])

const headers = [
	{
		title: "Nome do quiz",
		key: "title",
		align: "start",
		sortable: false,
	},
	{
		title: "Dificuldade",
		key: "dificulty",
		align: "start",
		sortable: false,
	},
	{
		title: "Questões",
		key: "quantity",
		align: "start",
		sortable: false,
	},
	{
		title: "Tema",
		key: "theme",
		align: "start",
		sortable: false,
	},
]

const dificulty = ["Fácil", "Médio", "Difícil"]
const quizzes = Array.from({ length: 50 }, (_, i) => ({
	title: "Quiz " + (i + 1),
	image: "/layout/profile.jpeg",
	dificulty: Math.floor(Math.random() * dificulty.length),
	status: Math.random() > 0.5 ? "Completo" : "Não iniciado",
	quantity: Math.floor(Math.random() * 20) + 1,
	theme: { title: "Tema 1", icon: "mdi-cat" },
	link: "/fisiologia/quiz/1",
}))

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

.table__row {
	transition: background-color 0.2s ease;
	transition: opacity 0.2s ease;
}
.table__row:hover {
	background-color: rgba(0, 12, 101, 0.05);
	opacity: 1;
}
.table__row--completed {
	background-color: rgba(0, 128f, 0, 0.05);
	opacity: 0.5;
}

:deep(.v-table) {
	background-color: #ffffffa6;
}
</style>
