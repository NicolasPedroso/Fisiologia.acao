<template>
	<v-container fluid style="height: 100%" class="editor__wrapper">
		<div class="editor__content">
			<v-row class="editor__firstLine">
				<v-btn
					height="46"
					prepend-icon="mdi-plus"
					color="#1356D3"
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
				:headers="headers"
				:items="data"
				:loading="loading"
				:group-by="groupBy"
				density="compact"
				:hover="true"
				mobile-breakpoint="md"
				item-value="name"
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
					<div class="table__actions">
						<v-btn
							class="table__actions__button"
							color="warning"
							prepend-icon="mdi-pencil"
							@click="openEdit(item)"
						>
							Edit
						</v-btn>
						<v-btn
							class="table__actions__button"
							color="error"
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
				class="pa-4"
				:loading="loadingRes"
				:title="title"
				:subtitle="subtitle"
			>
				<v-card-text class="pt-4">
					<v-form rel="form">
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
							<v-autocomplete
								v-model="formData.theme"
								variant="outlined"
								label="Tema do vídeo"
								:items="themes"
								:rules="rules.theme"
								:disabled="typeDialog === 2"
								required
							/>
						</div>
					</v-form>
				</v-card-text>
				<v-card-actions>
					<v-btn
						v-if="typeDialog === 0"
						:loading="loadingRes"
						text="Salvar"
						color="primary"
						variant="flat"
					/>
					<v-btn
						v-else-if="typeDialog === 1"
						:loading="loadingRes"
						text="Atualizar"
						color="primary"
						variant="flat"
					/>
					<v-btn
						v-else
						:loading="loadingRes"
						text="Deletar"
						color="primary"
						variant="flat"
					/>
					<v-btn
						text="Cancelar"
						color="error"
						variant="text"
						@click="closeDialog"
					/>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</v-container>
</template>
<script setup>
// DataTable variables
const search = ref("")
const groupBy = ref([
	{
		key: "theme",
		order: "asc",
	},
])
const headers = [
	{ title: "ID", key: "id", align: "start", width: 20 },
	{ title: "Video", key: "link", align: "center", sortable: false },
	{
		title: "Ações",
		key: "actions",
		align: "end",
		width: 50,
		sortable: false,
	},
]
const data = ref([{ id: 0, link: "/", theme: "a" }])
const loading = ref(false)

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
})
const loadingRes = ref(false)
const title = ref("")
const subtitle = ref("")
const themes = ["Endócrino", "Renal", "Cardiovascular"]

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
	subtitle.value = "Confirme se quer realmente deletar e clique em 'DELETAR'"
}

// Functions (requisition)
// async function createItem() {}
// async function deleteItem() {}
// async function editItem() {}

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

.dialog__content__gap {
	display: flex;
	flex-direction: column;
	gap: 16px;
}
</style>
