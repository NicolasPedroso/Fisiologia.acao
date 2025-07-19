<template>
	<v-container fluid style="height: 100%" class="editor__wrapper">
		<nuxt-notifications />
		<div class="editor__content">
			<v-row class="editor__firstLine">
				<v-btn
					height="46"
					prepend-icon="mdi-plus"
					color="var(--secondary-color)"
					theme="dark"
					@click="openCreate()"
				>
					<span class="button"> Adicionar Quiz </span>
				</v-btn>
				<div class="text-field">
					<v-text-field
						v-model="search"
						label="Pesquisar quizzes"
						variant="outlined"
						:hide-details="true"
						type="text"
						clearable
						prepend-icon="mdi-magnify"
					/>
				</div>
			</v-row>

			<v-data-table
				:loading="
					status === 'idle' ||
					status === 'pending' ||
					loadingThemes === 'pending'
				"
				:headers="headers"
				:items="quizzes"
				:search="search"
				:group-by="groupBy"
				density="compact"
				:hover="true"
				mobile-breakpoint="md"
			>
				<template
					v-slot:group-header="{
						item,
						columns,
						toggleGroup,
						isGroupOpen,
					}"
				>
					<tr>
						<td :colspan="columns.length">
							<div class="d-flex align-center">
								<v-btn
									:icon="
										isGroupOpen(item) ? '$expand' : '$next'
									"
									color="medium-emphasis"
									density="comfortable"
									size="small"
									variant="outlined"
									@click="toggleGroup(item)"
								></v-btn>

								<span class="ms-4">
									Tema:
									{{
										themesList.find(
											(theme) => theme.id === item.value,
										)?.title || "Sem tema"
									}}
								</span>
							</div>
						</td>
					</tr>
				</template>

				<template #[`item.theme`]="{ item }">
					<div v-if="item.theme" class="d-flex align-center">
						<v-icon
							:icon="item.theme.icon"
							size="small"
							class="mr-2"
						/>
						<span>{{ item.theme.title }}</span>
					</div>
					<span v-else class="text--secondary">Sem tema</span>
				</template>

				<template #[`item.description`]="{ item }">
					<div v-if="item.description">
						<span style="text-wrap: wrap; word-wrap: break-word">
							{{ item.description }}
						</span>
					</div>
					<span v-else class="text--secondary">Sem descrição</span>
				</template>

				<template #[`item.image`]="{ item }">
					<div v-if="item.image">
						<v-img
							:src="formatImage(item.image)"
							height="300"
							width="300"
							fill
							class="rounded-lg"
						/>
					</div>
					<span v-else class="text--secondary">Sem imagem</span>
				</template>

				<template #[`item.video_link`]="{ item }">
					<a :href="item.video_link" target="_blank">Vídeo</a>
				</template>

				<template #[`item.actions`]="{ item }">
					<div class="table__actions flex-column py-2">
						<v-btn
							class="table__actions__button"
							color="primary"
							prepend-icon="mdi-pencil"
							disabled
						>
							Editar
						</v-btn>
						<v-btn
							class="table__actions__button"
							color="primary"
							variant="outlined"
							prepend-icon="mdi-trash-can"
							@click="openDelete(item)"
						>
							Deletar
						</v-btn>
					</div>
				</template>
			</v-data-table>
		</div>

		<v-dialog
			v-model="dialog"
			min-width="340px"
			width="80vw"
			max-width="900px"
			max-height="90vh"
			persistent
			scrollable
		>
			<v-card class="dialog pa-4" :loading="loadingRes" :title="title">
				<v-card-subtitle>{{ subtitle }}</v-card-subtitle>

				<v-form
					v-if="typeDialog === 0"
					v-model="validForm"
					fast-fail
					@submit.prevent
				>
					<v-card-text class="pt-4">
						<div class="dialog__content__gap">
							<v-select
								v-model="formData.theme_id"
								:items="themesList"
								item-title="title"
								item-value="id"
								label="Tema do Quiz"
								:rules="rules.required"
								:loading="loadingThemes === 'pending'"
								required
							>
								<template #item="{ props, item }">
									<v-list-item
										v-bind="props"
										:title="item.raw.title"
									>
										<template #prepend>
											<v-icon :icon="item.raw.icon" />
										</template>
									</v-list-item>
								</template>
							</v-select>

							{{ formData.theme_id }}

							<v-text-field
								v-model="formData.title"
								label="Título do Quiz"
								:rules="rules.required"
								required
							/>
							<v-textarea
								v-model="formData.description"
								label="Descrição"
								:rules="rules.required"
								rows="2"
							/>
							<v-select
								v-model="formData.difficulty"
								:items="difficulties"
								label="Dificuldade"
								:rules="rules.required"
								required
							/>
							<v-text-field
								v-model="formData.video_link"
								:rules="rules.youtube"
								label="Link do Vídeo de Apoio"
								type="url"
								placeholder="https://www.youtube.com/watch?v=..."
								clearable
							/>
							<v-file-input
								v-model="formData.image"
								label="Imagem de Capa do Quiz"
								accept="image/*"
								show-size
							/>

							<v-divider class="my-4" />

							<div
								class="d-flex justify-space-between align-center"
							>
								<h3>Perguntas</h3>
								<v-btn
									color="primary"
									prepend-icon="mdi-plus-circle"
									@click="addQuestion"
								>
									Adicionar Pergunta
								</v-btn>
							</div>

							<v-alert
								v-if="formData.perguntas.length === 0"
								type="info"
								variant="tonal"
								class="mt-4"
							>
								Clique em "Adicionar Pergunta" para começar a
								montar seu quiz.
							</v-alert>

							<v-expansion-panels v-else class="mt-4" multiple>
								<v-expansion-panel
									v-for="(
										pergunta, index
									) in formData.perguntas"
									:key="index"
									elevation="2"
								>
									<v-expansion-panel-title>
										<strong>
											Pergunta {{ index + 1 }}:
										</strong>
										<span class="text-truncate ml-2"
											>{{
												pergunta.question ||
												"Nova Pergunta"
											}}
										</span>
									</v-expansion-panel-title>
									<v-expansion-panel-text>
										<div class="dialog__content__gap py-4">
											<v-textarea
												v-model="pergunta.question"
												label="Enunciado da Pergunta"
												variant="outlined"
												rows="3"
												:rules="rules.required"
												required
											/>
											<v-text-field
												v-model="pergunta.option_a"
												label="Opção A"
												variant="outlined"
												:rules="rules.required"
												required
											/>
											<v-text-field
												v-model="pergunta.option_b"
												label="Opção B"
												variant="outlined"
												:rules="rules.required"
												required
											/>
											<v-text-field
												v-model="pergunta.option_c"
												label="Opção C"
												variant="outlined"
												:rules="rules.required"
												required
											/>
											<v-text-field
												v-model="pergunta.option_d"
												label="Opção D"
												variant="outlined"
												:rules="rules.required"
												required
											/>
											<v-select
												v-model="
													pergunta.correct_answer
												"
												label="Resposta Correta"
												:items="['A', 'B', 'C', 'D']"
												variant="outlined"
												:rules="rules.required"
												required
											/>
											<v-file-input
												v-model="pergunta.image"
												label="Imagem para a pergunta (Opcional)"
												variant="outlined"
												accept="image/*"
											/>
											<v-btn
												color="error"
												variant="text"
												prepend-icon="mdi-delete"
												@click="removeQuestion(index)"
											>
												Remover esta pergunta
											</v-btn>
										</div>
									</v-expansion-panel-text>
								</v-expansion-panel>
							</v-expansion-panels>
						</div>
					</v-card-text>

					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn
							text="Cancelar"
							variant="outlined"
							@click="closeDialog"
						/>
						<v-btn
							:loading="loadingRes"
							text="Salvar Quiz"
							color="primary"
							variant="flat"
							type="submit"
							@click.stop="createItem"
						/>
					</v-card-actions>
				</v-form>

				<div v-else class="pt-4">
					<v-card-text>
						Você tem certeza que deseja deletar o quiz
						<strong>"{{ formData.title }}"</strong> (ID
						{{ formData.id }})?
						<br />
						<strong class="text-error">
							Essa ação é permanente e não pode ser desfeita.
						</strong>
					</v-card-text>
					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn
							text="Cancelar"
							variant="outlined"
							@click="closeDialog"
						/>
						<v-btn
							:loading="loadingRes"
							text="Deletar"
							color="error"
							variant="flat"
							@click.stop="deleteItem"
						/>
					</v-card-actions>
				</div>
			</v-card>
		</v-dialog>
	</v-container>
</template>

<script setup>
// --- VARIÁVEIS DE ESTADO ---
// Notificações e helpers
const { notify } = useNotification()

// Tabela
const search = ref("")
// ATUALIZADO: Headers da tabela
const headers = [
	{ title: "ID", key: "id", width: 80 },
	{ title: "Título", key: "title" },
	{ title: "Descrição", key: "description", maxWidth: 400 },
	{ title: "Dificuldade", key: "dificulty" },
	{ title: "Nº de Perguntas", key: "perguntas_count" },
	{
		title: "Imagem",
		key: "image",
		width: 120,
		sortable: false,
		align: "center",
	},
	{
		title: "Link do Vídeo",
		key: "video_link",
		width: 120,
		sortable: false,
		align: "center",
	},
	{
		title: "Ações",
		key: "actions",
		width: 220,
		sortable: false,
		align: "center",
	},
]

// Dialog
const dialog = ref(false)
const typeDialog = ref(0) // 0: Create, 1: Edit (desativado), 2: Delete
const validForm = ref(false)
const loadingRes = ref(false)
const title = ref("")
const subtitle = ref("")
const difficulties = ["Fácil", "Médio", "Difícil"]
const rules = {
	required: [(v) => !!v || "Este campo é obrigatório."],
	youtube: [
		(v) =>
			!v || // Permite campo vazio
			/^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11}).*$/.test(
				v,
			) ||
			"O link do YouTube não é válido.",
	],
}
const groupBy = ref([{ key: "theme_id", order: "asc" }])

// ATUALIZADO: Objeto do formulário reativo
const formData = reactive({
	id: null,
	title: "",
	difficulty: "Fácil",
	image: null,
	video_link: "",
	description: "",
	perguntas: [],
	theme_id: null,
})

// --- FETCH DE DADOS ---

// Fetch de Quizzes
const {
	data: quizzes,
	status,
	refresh,
} = await useAsyncData(
	"fetch-quizzes",
	() =>
		useDataLoader("/api/fase")
			.then((response) => response)
			.catch((err) => {
				notify({
					title: "Erro ao carregar quizzes",
					type: "error",
					text: formatError(err),
				})
				return []
			}),
	{ server: true },
)

// NOVO: Fetch de Temas
const {
	data: themesList,
	refresh: refreshThemes,
	status: loadingThemes,
} = await useAsyncData(
	"fetch-themes-for-select",
	() =>
		useDataLoader("/api/themes")
			.then((response) => response.data || [])
			.catch(() => []),
	{ server: true },
)

// --- FUNÇÕES DO DIALOG ---
function closeDialog() {
	dialog.value = false
}

function openCreate() {
	// Reseta o formulário para um estado limpo
	Object.assign(formData, {
		id: null,
		title: "",
		difficulty: "Fácil",
		image: null,
		video_link: "",
		description: "",
		perguntas: [],
		theme_id: null, // NOVO
	})

	title.value = "Criar Novo Quiz"
	subtitle.value = "Preencha os dados do quiz e adicione as perguntas."
	typeDialog.value = 0
	dialog.value = true
}

function openDelete(item) {
	formData.id = item.id
	formData.title = item.title
	title.value = `Deletar Quiz`
	typeDialog.value = 2
	dialog.value = true
}

// --- FUNÇÕES DE MANIPULAÇÃO DAS PERGUNTAS ---
function addQuestion() {
	formData.perguntas.push({
		question: "",
		option_a: "",
		option_b: "",
		option_c: "",
		option_d: "",
		image: null,
		correct_answer: "A",
	})
}

function removeQuestion(index) {
	formData.perguntas.splice(index, 1)
}

// --- FUNÇÕES CRUD (Create, Read, Update, Delete) ---
async function createItem() {
	if (!validForm.value) {
		notify({
			title: "Formulário inválido!",
			type: "warning",
			text: "Por favor, preencha todos os campos obrigatórios.",
		})
		return
	}
	if (formData.perguntas.length === 0) {
		notify({
			title: "Sem perguntas!",
			type: "warning",
			text: "Um quiz precisa de pelo menos uma pergunta.",
		})
		return
	}

	loadingRes.value = true

	// ATUALIZADO: Payload com theme_id
	const payload = new FormData()
	payload.append("title", formData.title)
	payload.append("description", formData.description)
	payload.append("dificulty", formData.difficulty)
	payload.append("video_link", formData.video_link || "") // Garante que envie string vazia se nulo
	if (formData.image) payload.append("image", formData.image)
	payload.append("theme_id", formData.theme_id) // NOVO

	for (let i = 0; i < formData.perguntas.length; i++) {
		const pergunta = formData.perguntas[i]
		payload.append(`perguntas[${i}][question]`, pergunta.question)
		payload.append(`perguntas[${i}][option_a]`, pergunta.option_a)
		payload.append(`perguntas[${i}][option_b]`, pergunta.option_b)
		payload.append(`perguntas[${i}][option_c]`, pergunta.option_c)
		payload.append(`perguntas[${i}][option_d]`, pergunta.option_d)
		if (pergunta.image)
			payload.append(`perguntas[${i}][image]`, pergunta.image)
		payload.append(
			`perguntas[${i}][correct_answer]`,
			pergunta.correct_answer,
		)
	}

	await useDataLoader("/api/fase", {
		method: "POST",
		body: payload,
	})
		.then(() => {
			refresh()
			refreshThemes()
			closeDialog()
			notify({
				title: "Sucesso!",
				text: "Quiz criado com sucesso.",
				type: "success",
			})
		})
		.catch((error) => {
			console.error(error)
			notify({
				title: "Erro!",
				text: "Não foi possível criar o quiz: " + formatError(error),
				type: "error",
			})
		})
		.finally(() => {
			loadingRes.value = false
		})
}

async function deleteItem() {
	loadingRes.value = true
	await useDataLoader(`/api/fase/${formData.id}`, {
		method: "DELETE",
	})
		.then(() => {
			refresh()
			closeDialog()
			notify({
				title: "Sucesso!",
				text: "Quiz deletado com sucesso.",
				type: "success",
			})
		})
		.catch((error) => {
			console.error(error)
			notify({
				title: "Erro!",
				text: "Não foi possível deletar o quiz.",
				type: "error",
			})
		})
		.finally(() => {
			loadingRes.value = false
		})
}

// --- METADADOS DA PÁGINA (Nuxt) ---
definePageMeta({
	layout: "dashboard",
	middleware: ["guest", "admin"],
})

useSeoMeta({
	title: "Dashboard - Gestão de Quizzes",
})
</script>

<style scoped>
/* Estilos herdados do seu exemplo, com pequenos ajustes */
.editor__wrapper,
.editor__content {
	width: 100%;
	height: 100%;
}
.editor__content {
	padding: 24px;
}
.editor__firstLine {
	display: flex;
	align-items: center;
	justify-content: space-between;
	margin-bottom: 32px;
	gap: 16px;
	flex-wrap: wrap;
}
.editor__firstLine .text-field {
	max-width: 450px;
	flex-grow: 1;
}
.table__actions {
	display: flex;
	gap: 8px;
	justify-content: center;
}
.dialog__content__gap {
	display: flex;
	flex-direction: column;
	gap: 20px;
}
</style>
