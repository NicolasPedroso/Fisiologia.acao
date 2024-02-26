<template>
	<div class="ma-12">
		<!-- Primeira seção: Title, ADD, Search -->
		<v-row class="ml-1">
			<h1>Dashboard de Contato [FORMS]</h1>
		</v-row>
		<p class="ml-1">Essa dash foi feita com json-server. Cuidado!</p>
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
const snackbar = useSnackbar()

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
	useDataLoader("/api/forms").catch((err) => {
		console.error(err)
		snackbar.add({
			type: "error",
			title: "Erro ao carregar os contatos",
			text: err.message,
		})
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
