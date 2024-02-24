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
			<h1>Dashboard de Testemunhos</h1>
		</v-row>
		<v-row class="my-6 mx-1 d-flex align-center">
			<v-btn color="primary" variant="tonal" @click="openCreate">
				Adicionar testemunho
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
			:items="testimonyItems"
			items-per-page="5"
		>
			<template #no-data> Não foi encontrado nenhum testemunho </template>
			<template #[`item.id`]="{ value }">
				<v-chip color="white"> {{ value }} </v-chip>
			</template>
			<template #[`item.image`]="{ value }">
				<v-avatar size="150" class="my-4">
					<v-img :src="value" cover />
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
						@click.stop="deleteTestimony(item.id)"
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
						{{ editing ? "Editar" : "Adicionar" }} testemunho
					</span>
				</v-card-title>
				<v-form v-model="valid" @submit.prevent>
					<v-card-text>
						<v-row>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="testimonyForm.name"
									label="Nome"
									:rules="[rules.required]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="testimonyForm.from"
									label="Fonte"
									:rules="[rules.required]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									v-model="testimonyForm.image"
									label="Imagem [URL]"
									:rules="[rules.required]"
								/>
							</v-col>
							<v-col cols="12" md="6">
								<v-textarea
									v-model="testimonyForm.text"
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
							@click="sendTestimony"
						>
							Salvar
						</v-btn>
						<v-btn
							v-else
							color="success"
							type="submit"
							@click="updateTestimony(testimonyForm.id)"
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
const testimonyForm = ref({
	id: 0,
	name: "",
	from: "",
	image: "",
	text: "",
})
const rules = {
	required: (value) => !!value || "Campo obrigatório",
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
	{ title: "Nome", value: "name", sortable: true },
	{ title: "Fonte", value: "from", sortable: true },
	{ title: "Imagem", value: "image", sortable: false },
	{ title: "Texto", value: "text", sortable: true },
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
const { refresh, pending } = await useAsyncData("testemunhos", () =>
	useDataLoader("testimonies")
		.then((response) => {
			snackbar.value = {
				title: "Sucesso ao acessar os testemunhos",
				text: `${response.Data.length} testemunhos encontrados`,
				color: "success",
				active: true,
			}
			return response
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
	testimonyForm.value = {
		name: "",
		from: "",
		image: "",
		text: "",
	}
}

function openEdit(item) {
	editing.value = true
	dialog.value = true
	testimonyForm.value = {
		id: item.id,
		name: item.name,
		from: item.from,
		image: item.image,
		text: item.text,
	}
}

// Criar o testemunho
async function sendTestimony() {
	// Verifica se o formulario é valido
	if (!valid.value) return

	// Envia para o backend
	await $fetch(`${URLBase}`, {
		method: "POST",
		body: testimonyForm.value,
	})
		.then(() => {
			snackbar.value = {
				text: "Testemunho criado com sucesso",
				color: "success",
				active: true,
			}
			dialog.value = false
			refresh()
		})
		.catch((error) => {
			console.error(`Erro: ${error}`)
			snackbar.value = {
				text: `Erro ao criar testemunho: ${error.message}`,
				color: "error",
				active: true,
			}
		})
}

async function updateTestimony(id) {
	// Verifica se o formulario é valido
	if (!valid.value) return

	// Envia para o backend
	await $fetch(`${URLBase}/${id}`, {
		method: "PUT",
		body: testimonyForm.value,
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
async function deleteTestimony(id) {
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
