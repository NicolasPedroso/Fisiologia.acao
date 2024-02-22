<template>
	<!-- SnackBar -->
	<v-snackbar
		v-model="snackbar.active"
		:color="snackbar.color"
		:timeout="4000"
		elevation="24"
		theme="light"
		position="fixed"
		location="top right"
	>
		<div class="d-flex">
			<v-col cols="auto" class="d-flex align-center">
				<v-icon size="30">
					{{
						snackbar.color === "success" ? "mdi-check" : "mdi-alert"
					}}
				</v-icon>
			</v-col>
			<v-col cols="auto">
				<h3>
					{{ snackbar.title }}
					<span v-if="snackbar.status">- {{ snackbar.status }}</span>
				</h3>
				<v-divider class="my-1" />
				<p>
					{{ snackbar.text }}
				</p>
			</v-col>
		</div>
	</v-snackbar>
	<!-- SnackBar -->
	<div class="ma-6 ma-md-12">
		<!-- Primeira seção: Title, ADD, Search -->
		<v-row class="ml-1">
			<h1>Dashboard de Materiais Gratuitos</h1>
		</v-row>
		<v-row class="my-6 mx-1 d-flex align-center">
			<v-btn color="primary" variant="tonal" @click="openCreate">
				Adicionar material
			</v-btn>
			<v-spacer />
			<v-text-field
				v-model="search"
				label="Pesquisar"
				variant="solo"
				hide-details
				prepend-icon="mdi-magnify"
				clearable
			/>
		</v-row>
		<!-- Primeira seção: Title, ADD, Search -->
		<!-- Data Table -->
		<v-data-table
			:headers="headers"
			:loading="pending"
			:search="search"
			:items="materials"
			items-per-page="5"
		>
			<template #no-data> Não foi encontrado nenhum testemunho </template>
			<template #[`item.id`]="{ value }">
				<v-chip color="white"> {{ value }} </v-chip>
			</template>
			<template #[`item.image`]="{ value }">
				<v-avatar size="150" class="my-4">
					<v-img :src="formatImagePath(value)" cover />
				</v-avatar>
			</template>
			<template #[`item.actions`]="{ item }">
				<div class="d-flex flex-column" style="gap: 5px">
					<!-- EDIT button -->
					<v-btn
						variant="text"
						color="green-accent-3"
						prepend-icon="mdi-pencil"
						@click.stop="openEdit(item)"
					>
						Editar
					</v-btn>
					<!-- EDIT button -->
					<!-- DELETE button -->
					<v-btn
						variant="text"
						color="red-accent-3"
						prepend-icon="mdi-delete"
						@click.stop="deleteMaterial(item.id)"
					>
						Deletar
					</v-btn>
					<!-- DELETE button -->
				</div>
			</template>
		</v-data-table>
		<!-- Data Table -->
		<!-- Dialog de CRUD -->
		<v-dialog
			v-model="dialog"
			width="95vw"
			max-width="800px"
			persistent
			scrim="black"
		>
			<v-card class="pa-3">
				<v-card-title>
					<span>
						{{ editing ? "Editar" : "Adicionar" }} material
					</span>
				</v-card-title>
				<v-form v-model="valid" @submit.prevent>
					<v-card-text>
						<v-row>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="materialForm.title"
									label="Título"
									:rules="[rules.required]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="materialForm.summary"
									label="Summary"
									:rules="[rules.required]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-file-input
									v-model="materialForm.image"
									label="Imagem"
									clearable
									accept="image/*"
									show-size
									:rules="[rules.required, rules.imageLimit]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-textarea
									v-model="materialForm.description"
									label="Texto"
									no-resize
									rows="7"
									:rules="[rules.required]"
								/>
							</v-col>
						</v-row>
					</v-card-text>
					<v-card-actions>
						<v-btn
							v-if="!editing"
							color="success"
							type="submit"
							@click="sendMaterial"
						>
							Salvar
						</v-btn>
						<v-btn
							v-else
							color="success"
							type="submit"
							@click="updateMaterial(materialForm.id)"
						>
							Atualizar
						</v-btn>
						<v-btn color="red" @click="dialog = false">
							Cancelar
						</v-btn>
					</v-card-actions>
				</v-form>
			</v-card>
		</v-dialog>
		<!-- Dialog de CRUD -->
	</div>
</template>
<script setup>
// Campos e variaveis da snackbar
const snackbar = ref({
	text: "",
	color: "",
	active: false,
})
// Variaveis do formulario de CRUD do testemunho
const valid = ref(false)
const dialog = ref(false)
const editing = ref(false)
const materialForm = ref({
	id: 0,
	title: "",
	summary: "",
	description: "",
	image: null,
})
const rules = {
	required: (value) => !!value || "Campo obrigatório",
	imageLimit: (value) =>
		!value ||
		!value.some((file) => file.size > 2e6) ||
		"A imagem deve ter menos de 2MB",
}

// Variaveis da DATA TABLE
const search = ref("")
const headers = [
	{
		title: "ID",
		value: "id",
		sortable: true,
		align: "center",
		width: "50px",
	},
	{ title: "Titulo", value: "title", sortable: true },
	{ title: "Resumo", value: "summary", sortable: true },
	{ title: "Descrição", value: "description", sortable: true },
	{ title: "Imagem", value: "image", sortable: false },
	{ title: "", value: "actions", sortable: false },
]

/**
 * * Requisição para pegar os dados da tabela
 * 		testimonyItems -> é o array retornado da requisição
 *  	pending -> é um booleano que indica se a requisição está ocorrendo ou não
 *  	refresh -> é uma função que atualiza os dados da tabela
 *
 * * useAsyncData -> é um hook que retorna os dados da requisição e o estado dela
 * @param {string} key -> é a chave para identificar a requisição para evitar conflitos
 * @param {function} loader -> é uma função que faz a requisição para o backend -> useDataLoader
 *
 * * useDataLoader -> é uma função que faz a requisição para o backend com o método e a URL especificados
 * @param {string} url -> é a URL para onde a requisição será feita (/api/testimonies)
 * @param {object} options -> é um objeto que contém o método da requisição (GET, POST, PUT, DELETE) e outros parametros
 *
 * * .catch -> é um método que captura o erro da requisição
 * @param {object} error -> é o objeto que contém o erro da requisição
 *
 * * .then -> é um método que captura o sucesso da requisição
 * @param {object} response -> é o objeto que contém a resposta da requisição
 */
const {
	refresh,
	pending,
	data: materials,
} = await useAsyncData("materiais-gratuitos", () =>
	useDataLoader("/api/materials")
		.then((response) => {
			return response.Data
		})
		.catch((err) => {
			console.error(err)
			snackbar.value = {
				title: "Erro ao acessar os testemunhos",
				text: `${err.message}`,
				status: 401,
				color: "error",
				active: true,
			}
			return []
		}),
)

// Function para abrir o formulario de criação
function openCreate() {
	editing.value = false
	dialog.value = true
	materialForm.value = {
		id: 0,
		title: "",
		summary: "",
		description: "",
		image: null,
	}
}

function openEdit(item) {
	editing.value = true
	dialog.value = true
	const images = []
	images.push(item.image)
	materialForm.value = {
		id: item.id,
		title: item.title,
		summary: item.summary,
		image: images,
		description: item.description,
	}
}

// Criar o testemunho
async function sendMaterial() {
	// Verifica se o formulario é valido
	if (!valid.value) return

	// Cria um FormData para enviar a imagem
	const advertise = new FormData()
	advertise.append("image", materialForm.value.image[0])
	advertise.append("title", materialForm.value.title)
	advertise.append("summary", materialForm.value.summary)
	advertise.append("description", materialForm.value.description)

	// Envia para o backend
	await useDataLoader("/api/materials", {
		method: "POST",
		body: advertise,
	})
		.then(() => {
			snackbar.value = {
				text: "Material criado com sucesso",
				color: "success",
				active: true,
			}
			dialog.value = false
			refresh()
		})
		.catch((error) => {
			console.error(`Erro: ${error}`)
			snackbar.value = {
				title: "Erro ao criar material",
				status: error.status,
				text: `${error.message}`,
				color: "error",
				active: true,
			}
		})
}

async function updateMaterial(id) {
	// Verifica se o formulario é valido
	if (!valid.value) return

	// Envia para o backend
	await $fetch(`${URLBase}/${id}`, {
		method: "PUT",
		body: materialForm.value,
	})
		.then(() => {
			snackbar.value = {
				text: "Testemunho atualizado com sucesso",
				color: "success",
				active: true,
			}
			dialog.value = false
			refresh()
		})
		.catch((error) => {
			console.error(`Erro: ${error}`)
			snackbar.value = {
				text: `Erro ao atualizar testemunho: ${error.message}`,
				color: "error",
				active: true,
			}
		})
}

// Deletar o testemunho
async function deleteMaterial(id) {
	const ok = window.confirm("Você quer mesmo deletar este testemunho?")
	if (ok) {
		await $fetch(`${URLBase}/${id}`, {
			method: "DELETE",
		})
			.then(() => {
				snackbar.value = {
					text: "Testemunho deletado com sucesso",
					color: "success",
					active: true,
				}
				refresh()
			})
			.catch((error) => {
				console.log(`Erro: ${error}`)
				snackbar.value = {
					text: `Erro ao deletar testemunho: ${error}`,
					color: "error",
					active: true,
				}
			})
	}
}

// Cabeçalho da pagina
definePageMeta({
	layout: "dashboard",
	middleware: ["guest"],
})
</script>
<style scoped></style>
