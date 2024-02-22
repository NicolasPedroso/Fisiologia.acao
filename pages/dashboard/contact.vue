<template>
	<!-- SnackBar -->
	<v-snackbar
		v-model="snackbar.active"
		:color="snackbar.color"
		:timeout="4000"
		max-width="90vw"
		theme="light"
		position="fixed"
		close-on-content-click
		location="top right"
	>
		<div class="d-flex">
			<v-col cols="auto" class="d-flex align-center pa-2">
				<v-icon size="30">
					{{
						snackbar.color === "success" ? "mdi-check" : "mdi-alert"
					}}
				</v-icon>
			</v-col>
			<v-col cols="auto" class="pa-2">
				<h3>
					{{ snackbar.title }}
					<span v-if="snackbar.status">- {{ snackbar.status }}</span>
				</h3>
				<v-divider class="my-2" />
				<p>
					{{ snackbar.text }}
				</p>
			</v-col>
		</div>
	</v-snackbar>
	<!-- SnackBar -->
	<div class="ma-12">
		<!-- Primeira seção: Title, ADD, Search -->
		<v-row class="ml-1">
			<h1>Dashboard de Contato [FORMS]</h1>
		</v-row>
		<v-row class="my-6 mx-1 d-flex align-center">
			<v-spacer></v-spacer>
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
			:items="formItems"
			items-per-page="10"
		>
			<template #[`item.name`]="{ item }">
				{{ item.firstName + " " + item.lastName }}
			</template>
			<template #[`item.actions`]="{ item }">
				<!-- DELETE button -->
				<v-btn
					icon
					size="35"
					color="red"
					class="my-5"
					@click.stop="deleteContact(item.id)"
				>
					<v-icon>mdi-delete</v-icon>
				</v-btn>
				<!-- DELETE button -->
			</template>
		</v-data-table>
		<!-- Data Table -->
	</div>
</template>
<script setup>
// Campos e variaveis da snackbar
const snackbar = ref({
	text: "",
	color: "",
	active: false,
})

// Variaveis da DATA TABLE
const search = ref("")
const headers = [
	{ title: "ID", value: "id", sortable: true },
	{ title: "Nome", value: "name", sortable: true },
	{ title: "E-mail", value: "email", sortable: true },
	{ title: "Assunto", value: "subject", sortable: false },
	{ title: "Messagem", value: "content", sortable: true },
	{ title: "", value: "actions", sortable: false },
]

/*
	Requisição para pegar os dados da tabela
	formItems -> é o objeto retornado da requisição
	pending -> é um booleano que indica se a requisição está ocorrendo ou não
*/
const {
	refresh,
	pending,
	data: formItems,
} = await useAsyncData("contatos", () =>
	useDataLoader("/forms").catch((err) => {
		console.error(err)
		snackbar.value = {
			title: "Erro ao acessar os contatos",
			text: `${err.message}`,
			// status: 401,
			color: "error",
			active: true,
		}
		return []
	}),
)

// Deletar o testemunho
async function deleteContact(id) {
	const ok = window.confirm("Você quer mesmo deletar este contato?")
	if (ok) {
		await useDataLoader(`/forms/${id}`, {
			method: "DELETE",
		})
			.then(() => {
				snackbar.value = {
					title: "Sucesso",
					text: "Contato deletado com sucesso",
					color: "success",
					active: true,
				}
				refresh()
			})
			.catch((error) => {
				console.log(`Erro: ${error}`)
				snackbar.value = {
					text: `Erro ao deletar contato: ${error}`,
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
