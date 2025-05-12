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
					<span class="button"> Adicionar vídeo </span>
				</v-btn>
				<div class="text-field">
					<v-text-field
						v-model="search"
						label="Pesquisar na tabela"
						variant="outlined"
						:hide-details="true"
						type="text"
						clearable
						prepend-icon="mdi-magnify"
					/>
				</div>
			</v-row>
			<v-data-table
				:loading="status === 'idle' || status === 'pending'"
				:headers="headers"
				:items="!data ? [] : data"
				:group-by="groupBy"
				density="compact"
				:hover="true"
				mobile-breakpoint="md"
			>
				<template
					#group-header="{ item, columns, toggleGroup, isGroupOpen }"
				>
					<tr>
						<td :colspan="columns.length">
							<v-btn
								:icon="isGroupOpen(item) ? '$expand' : '$next'"
								size="small"
								variant="text"
								@click="toggleGroup(item)"
							/>
							<strong>Tema:</strong>
							{{ item.value }}
							<i>({{ item.items.length }} vídeos)</i>
						</td>
					</tr>
				</template>
				<template #[`item.id`]="{ value }">
					<v-chip>{{ value }}</v-chip>
				</template>
				<template #[`item.actions`]="{ item }">
					<div class="table__actions py-2">
						<v-btn
							class="table__actions__button"
							color="primary"
							prepend-icon="mdi-pencil"
							@click="openEdit(item)"
						>
							Edit
						</v-btn>
						<v-btn
							class="table__actions__button"
							color="primary"
							variant="outlined"
							prepend-icon="mdi-trash-can"
							@click="openDelete(item)"
						>
							Delete
						</v-btn>
					</div>
				</template>
			</v-data-table>
		</div>
		<v-dialog
			v-model="dialog"
			min-width="340px"
			width="70vw"
			max-height="80vh"
			persistent
		>
			<v-card
				class="dialog pa-4"
				:loading="loadingRes"
				:title="title"
				:subtitle="subtitle"
			>
				<v-form v-model="validForm" fast-fail @submit.prevent>
					<v-card-text class="pt-4">
						<div class="dialog__content__gap">
							<v-text-field
								v-model="formData.link"
								variant="outlined"
								label="Link do vídeo"
								placeholder="https://www.example.com/page"
								type="text"
								:rules="rules.link"
								:disabled="typeDialog === 2"
								required
							/>
							<v-text-field
								v-model="formData.identification"
								variant="outlined"
								label="Identificador do vídeo"
								placeholder="https://www.example.com/page"
								type="text"
								:rules="rules.link"
								disabled
								required
							/>
							<v-autocomplete
								v-model="formData.tema"
								variant="outlined"
								label="Tema do vídeo"
								:items="themes"
								:rules="rules.theme"
								:disabled="typeDialog === 2"
								required
							/>
						</div>
					</v-card-text>
					<v-card-actions>
						<v-btn
							v-if="typeDialog === 0"
							:loading="loadingRes"
							text="Salvar"
							color="primary"
							variant="flat"
							type="submit"
							@click.stop="createItem"
						/>
						<v-btn
							v-else-if="typeDialog === 1"
							:loading="loadingRes"
							text="Atualizar"
							color="primary"
							variant="flat"
							type="submit"
							@click.stop="editItem"
						/>
						<v-btn
							v-else
							:loading="loadingRes"
							text="Deletar"
							color="primary"
							variant="flat"
							type="submit"
							@click.stop="deleteItem"
						/>
						<v-btn
							text="Cancelar"
							color="primary"
							variant="outlined"
							@click="closeDialog"
						/>
					</v-card-actions>
				</v-form>
			</v-card>
		</v-dialog>
	</v-container>
</template>
<script setup>
// ENV (PAGE VARIABLES)
const urlRequistion = "/video"

// DataTable variables
const { notify } = useNotification()
const search = ref("")
const groupBy = ref([
	{
		key: "tema",
		order: "asc",
	},
])
const headers = [
	{ title: "ID", key: "id" },
	{ title: "Video", key: "link", sortable: false },
	{
		title: "Ações",
		key: "actions",
		width: 50,
		sortable: false,
	},
]
const data = ref([])

// Dialog variables
const dialog = ref(false)
const typeDialog = ref(0)
const rules = {
	link: [(value) => (!value ? "O campo é obrigatório" : true)],
	theme: [(value) => (!value ? "O campo é obrigatório" : true)],
}
const formData = reactive({
	id: 0,
	link: "",
	theme: "",
	identification: 2,
})
const loadingRes = ref(false)
const validForm = ref(false)
const title = ref("")
const subtitle = ref("")
const themes = ["Endócrino", "Renal", "Cardiovascular"]

// Requisicao inicial
const { status, refresh } = useAsyncData(() =>
	useDataLoader("/api/tema_do_video")
		.then((response) => {
			console.log("Deu certo", response)
			data.value = response.data
		})
		.catch((error) => {
			console.log("Deu erro")
			console.error(error)
			notify({
				title: "Erro!",
				type: "error",
				text: formatError(error),
			})
			return []
		}),
)

// Functions (open and close)
function closeDialog() {
	dialog.value = false
}
function openCreate() {
	dialog.value = true
	typeDialog.value = 0

	formData.id = null
	formData.link = ""
	formData.theme = themes[0]

	title.value = "Criar novo elemento"
	subtitle.value = "Preencha todos os campos necessários e clique em 'SALVAR'"
}
function openEdit({ id, link, theme }) {
	dialog.value = true
	typeDialog.value = 1

	formData.id = id
	formData.link = link
	formData.theme = theme

	title.value = `Editando elemento (ID ${id})`
	subtitle.value =
		"Preencha todos os campos necessários e clique em 'ATUALIZAR'"
}
function openDelete({ id, link, theme }) {
	dialog.value = true
	typeDialog.value = 2

	formData.id = id
	formData.link = link
	formData.theme = theme

	title.value = `Deletando o elemento (ID ${id})`
	subtitle.value =
		"Você tem certeza que deletar o elemento? Essa ação é permamente e não tem volta! Se sim, clique em 'DELETAR'"
}

// Functions (requisition)
async function createItem() {
	// Validacoes
	if (!validForm.value) return

	// const __formData = new FormData()
	// for (var key in formData) {
	// 	if (key == "id") continue
	// 	__formData.append(key, formData[key])
	// }

	// Para testes (JSON-SERVER)
	let newFormData = formData
	delete newFormData.id

	const __formData = JSON.stringify(newFormData)

	loadingRes.value = true

	console.log("Enviando = ", __formData)

	await useDataLoader("/api/tema_do_video", {
		method: "POST",
		body: __formData,
		"Content-Type": "application/json",
	})
		.then(() => {
			refresh()
			dialog.value = false
			loadingRes.value = false
			notify({
				title: "Elemento criado",
				type: "success",
			})
		})
		.catch((error) => {
			console.error(error)
			loadingRes.value = false
			notify({
				title: "Erro ao criar item!",
				type: "error",
				text: formatError(error),
			})
		})
}

async function editItem() {
	// Validacoes
	if (!validForm.value) return

	// const __formData = new FormData()
	// for (var key in formData) {
	// 	if (key == "id") continue
	// 	__formData.append(key, formData[key])
	// }

	const __formData = JSON.stringify(formData)

	loadingRes.value = true

	await useDataLoader(`${api / tema_do_video}/${formData.id}`, {
		method: "PUT",
		body: __formData,
		"Content-Type": "application/json",
	})
		.then(() => {
			refresh()
			dialog.value = false
			loadingRes.value = false
			notify({
				title: "Elemento atualizado",
				type: "success",
			})
		})
		.catch((error) => {
			console.error(error)
			loadingRes.value = false
			notify({
				title: "Erro ao atualizar item!",
				type: "error",
				text: formatError(error),
			})
		})
}

async function deleteItem() {
	loadingRes.value = true
	await useDataLoader(`${api / tema_do_video}/${formData.id}`, {
		method: "DELETE",
	})
		.then(() => {
			refresh()
			dialog.value = false
			loadingRes.value = false
			notify({
				title: "Elemento criado",
				type: "success",
			})
		})
		.catch((error) => {
			console.error(error)
			loadingRes.value = false
			notify({
				title: "Erro ao deletar item!",
				type: "error",
				text: formatError(error),
			})
		})
}

definePageMeta({
	layout: "dashboard",
	middleware: ["guest", "admin"],
})
useSeoMeta({
	title: "Dashboard - Edição de vídeos",
})
</script>
<style setup>
.editor__content,
.editor__wrapper {
	width: 100%;
	height: 100%;
}

.editor__content {
	padding: 16px;
}

.editor__firstLine {
	display: flex;
	align-items: center;
	justify-content: space-between;
	margin-bottom: 32px;
}

.editor__firstLine .button {
	font-family: "Roboto", sans-serif !important;
	font-size: 16px !important;
	text-transform: capitalize !important;
}

.editor__firstLine .text-field {
	width: 550px;
}

.table__actions {
	display: flex;
	flex-direction: column;
	gap: 4px;
}

.table__actions__button {
	font-family: "Roboto", sans-serif !important;
	font-size: 12px !important;
}

.v-card-title {
	font-weight: 800 !important;
}

.v-card-subtitle {
	text-wrap: auto !important;
}

.dialog__content__gap {
	display: flex;
	flex-direction: column;
	gap: 16px;
}

.v-field--disabled {
	opacity: 0.8 !important;
}
</style>
