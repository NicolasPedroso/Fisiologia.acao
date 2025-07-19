<template>
	<v-container fluid>
		<!-- Atalhos rápidos -->
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
						@click="navigateTo(randomQuizLink(apiData.fases))"
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
						@click="navigateTo(randomThemeLink(apiData.themes))"
					>
						<v-icon class="mr-1" style="margin-bottom: 2px">
							mdi-progress-question
						</v-icon>
						Tema aleatório
					</v-btn>
				</v-col>
			</v-row>
		</div>

		<!-- Lista de temas -->
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
				:items="apiData.themes"
				:items-per-page="12"
				:search="search"
				:loading="false"
			>
				<template #default="{ items }">
					<v-row class="mt-6" dense>
						<template v-for="item in items" :key="item.title">
							<v-col
								v-if="
									item.raw.fases_count &&
									item.raw.fases_count !== 0
								"
								cols="4"
								lg="3"
								class="pa-2"
							>
								<theme-card :theme="item.raw" />
							</v-col>
						</template>
					</v-row>
				</template>

				<template #no-data>
					<div class="text-center py-6">
						<h2>Nenhum tema para {{ search }}</h2>
						<p>Tente ajustar sua pesquisa.</p>
					</div>
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
							cols="4"
							lg="3"
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
					:loading="status === 'pending'"
					:items="apiData.fases"
					:headers="headers"
					:search="searchAllQuizzes"
					:items-per-page="10"
					:items-per-page-options="[5, 10, 15]"
					:sort-by="sortBy"
					item-value="id"
					class="mt-6"
				>
					<!-- ITEM -->
					<template #item="{ item }">
						<tr
							class="cursor-pointer table__row"
							:class="{
								'table__row--completed':
									item.user_status === 'Completo',
							}"
							@click="$router.push(`/fisiologia/quiz/${item.id}`)"
						>
							<td>
								<div class="d-flex align-center ga-2">
									<img
										:src="formatImage(item.image)"
										width="50"
										height="50"
										style="border-radius: 4"
										class="my-2"
									/>
									<strong>{{ item.title }}</strong>
									<span
										v-if="
											item.user_status !== 'Não iniciado'
										"
										class="text-caption"
									>
										({{ item.user_status }})
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
									{{ item.dificulty }}
								</v-chip>
							</td>

							<td>
								<strong>{{ item.perguntas_count }}</strong>
								questões
							</td>

							<td>
								<!-- <v-icon :icon="item.theme.icon" class="mb-1" />
								{{ item.theme.title }} -->
								Sem tema ainda
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
const { data: apiData, status } = await useAsyncData(
	"fetch-fases-and-themes",
	async () => {
		try {
			const [fasesResponse, themesResponse] = await Promise.all([
				useDataLoader("/api/fase"),
				useDataLoader("/api/themes"),
			])

			return {
				fases: fasesResponse,
				themes: themesResponse.data || [],
			}
		} catch (e) {
			console.error(`Error fetching data: ${e.message || e}`)
			return { fases: [], themes: [] }
		}
	},
)

const search = shallowRef("")
const searchAllQuizzes = shallowRef("")

// Funcao para retorno de cores pra as dificuldades/status
const getColor = (status) => {
	switch (status) {
		case "Fácil": // Dificuldade fácil
			return "success"
		case "Médio": // Dificuldade média
			return "warning"
		case "Difícil": // Dificuldade difícil
			return "error"
		default: // Fallback
			return "grey"
	}
}

const sortBy = ref([
	{ key: "user_status", order: "desc" },
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

// Funcoes de sorteio de TEMA
const randomThemeLink = (arr) => {
	const length = arr.length || 0
	if (length === 0) {
		return "/fisiologia" // Retorna um tema padrão se não houver temas
	} else {
		const randomIndex = Math.floor(Math.random() * length)
		return `/fisiologia/tema/${arr[randomIndex].id}`
	}
}

// Funcoes de sorteio de QUIZ
const randomQuizLink = (arr) => {
	if (!arr || arr.length === 0) {
		return "/fisiologia" // Retorna um quiz padrão se não houver quizzes
	}
	// Filtra os quizzes nao completos
	const filteredQuizzes = arr.filter(
		(quiz) => quiz.user_status === "Não iniciado",
	)

	console.log("Filtered quizzes:", filteredQuizzes)

	// Tenta encontrar um quiz aleatório por dificuldade
	if (filteredQuizzes.length > 0) {
		for (let i = 0; i < 3; i++) {
			const difficultyQuizzes = filteredQuizzes.filter(
				(quiz) => quiz.dificulty === ["Fácil", "Médio", "Difícil"][i],
			)
			if (difficultyQuizzes.length > 0) {
				const randomIndex = Math.floor(
					Math.random() * difficultyQuizzes.length,
				)
				return `/fisiologia/quiz/${difficultyQuizzes[randomIndex].id}`
			}
		}
	}

	// Fallback (sorteia um quiz aleatório)
	const randomIndex = Math.floor(Math.random() * arr.length)
	return `/fisiologia/quiz/${arr[randomIndex].id}`
}

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
