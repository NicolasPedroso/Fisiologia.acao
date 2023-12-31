<template>
	<!-- SnackBar -->
	<v-snackbar
		v-model="snackbar.active"
		:color="snackbar.color"
		position="fixed"
		location="top right"
	>
		{{ snackbar.text }}
	</v-snackbar>
	<!-- SnackBar -->
	<div class="ma-12">
		<!-- Primeira seção: Title, ADD, Search -->
		<v-row class="ml-1">
			<h1>Dashboard de testemunhos</h1>
		</v-row>
		<v-row class="my-6 mx-1 d-flex align-center">
			<v-btn color="#00B0FF" variant="outlined" @click="openCreate">
				Adicionar testemunho
			</v-btn>
			<v-spacer></v-spacer>
			<v-text-field
				label="Pesquisar"
				variant="solo"
				hide-details
				prepend-icon="mdi-magnify"
				clearable
				v-model="search"
			></v-text-field>
		</v-row>
		<!-- Primeira seção: Title, ADD, Search -->
		<!-- Data Table -->
		<v-data-table
			:headers="headers"
			:loading="pending"
			:search="search"
			:items="testimonyItems"
			items-per-page="10"
		>
			<template v-slot:item.image="{ value }">
				<v-avatar size="150">
					<v-img :src="value" cover />
				</v-avatar>
			</template>
			<template v-slot:item.actions="{ item }">
				<div class="d-flex" style="gap: 5px">
					<!-- EDIT button -->
					<v-btn icon size="35" color="blue" @click="openEdit(item)">
						<v-icon>mdi-pencil</v-icon>
					</v-btn>
					<!-- EDIT button -->
					<!-- DELETE button -->
					<v-btn
						icon
						size="35"
						color="red"
						@click.stop="deleteTestimony(item.id)"
					>
						<v-icon>mdi-delete</v-icon>
					</v-btn>
				</div>
				<!-- DELETE button -->
			</template>
		</v-data-table>
		<!-- Data Table -->
		<!-- Dialog de CRUD -->
		<v-dialog
			width="95vw"
			max-width="800px"
			v-model="dialog"
			persistent
			scrim="black"
		>
			<v-card class="pa-3">
				<v-card-title>
					<span>
						{{ editing ? "Editar" : "Adicionar" }} testemunho
					</span>
				</v-card-title>
				<v-form @submit.prevent v-model="valid">
					<v-card-text>
						<v-row>
							<v-col cols="12" md="6">
								<v-text-field
									label="Nome"
									v-model="testimonyForm.name"
									:rules="[rules.required]"
								></v-text-field>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									label="Fonte"
									v-model="testimonyForm.from"
									:rules="[rules.required]"
								></v-text-field>
							</v-col>
							<v-col cols="12" md="6">
								<v-text-field
									label="Imagem [URL]"
									v-model="testimonyForm.image"
									:rules="[rules.required]"
								></v-text-field>
							</v-col>
							<v-col cols="12" md="6">
								<v-textarea
									label="Texto"
									no-resize
									rows="7"
									v-model="testimonyForm.text"
									:rules="[rules.required]"
								></v-textarea>
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
});
// Variaveis do formulario de CRUD do testemunho
const valid = ref(false);
const dialog = ref(false);
const editing = ref(false);
const testimonyForm = ref({
	id: 0,
	name: "",
	from: "",
	image: "",
	text: "",
});
const rules = {
	required: (value) => !!value || "Campo obrigatório",
};

// Variaveis da DATA TABLE
const search = ref("");
const headers = [
	{ title: "ID", value: "id", sortable: true },
	{ title: "Nome", value: "name", sortable: true },
	{ title: "Fonte", value: "from", sortable: true },
	{ title: "Imagem", value: "image", sortable: false },
	{ title: "Texto", value: "text", sortable: true },
	{ title: "", value: "actions", sortable: false },
];

/*
	Requisição para pegar os dados da tabela
	testimonyItems -> é o objeto retornado da requisição
	pending -> é um booleano que indica se a requisição está ocorrendo ou não
*/
const {
	refresh,
	pending,
	data: testimonyItems,
} = await useAsyncData("get", () =>
	$fetch(`http://localhost:8000/testimonies`)
);

// Function para abrir o formulario de criação
function openCreate() {
	editing.value = false;
	dialog.value = true;
	testimonyForm.value = {
		name: "",
		from: "",
		image: "",
		text: "",
	};
}

function openEdit(item) {
	editing.value = true;
	dialog.value = true;
	testimonyForm.value = {
		id: item.id,
		name: item.name,
		from: item.from,
		image: item.image,
		text: item.text,
	};
}

// Criar o testemunho
async function sendTestimony() {
	// Verifica se o formulario é valido
	if (!valid.value) return;

	// Envia para o backend
	await $fetch("http://localhost:8000/testimonies", {
		method: "POST",
		body: testimonyForm.value,
	})
		.then(() => {
			snackbar.value = {
				text: "Testemunho criado com sucesso",
				color: "success",
				active: true,
			};
			dialog.value = false;
			refresh();
		})
		.catch((error) => {
			console.log(`Erro: ${error}`);
			snackbar.value = {
				text: `Erro ao criar testemunho: ${error}`,
				color: "error",
				active: true,
			};
		});
}

async function updateTestimony(id) {
	// Verifica se o formulario é valido
	if (!valid.value) return;

	// Envia para o backend
	await $fetch(`http://localhost:8000/testimonies/${id}`, {
		method: "PUT",
		body: testimonyForm.value,
	})
		.then(() => {
			snackbar.value = {
				text: "Testemunho atualizado com sucesso",
				color: "success",
				active: true,
			};
			dialog.value = false;
			refresh();
		})
		.catch((error) => {
			console.log(`Erro: ${error}`);
			snackbar.value = {
				text: `Erro ao atualizar testemunho: ${error}`,
				color: "error",
				active: true,
			};
		});
}

// Deletar o testemunho
async function deleteTestimony(id) {
	const ok = window.confirm("Você quer mesmo deletar este testemunho?");
	if (ok) {
		await $fetch(`http://localhost:8000/testimonies/${id}`, {
			method: "DELETE",
		})
			.then(() => {
				snackbar.value = {
					text: "Testemunho deletado com sucesso",
					color: "success",
					active: true,
				};
				refresh();
			})
			.catch((error) => {
				console.log(`Erro: ${error}`);
				snackbar.value = {
					text: `Erro ao deletar testemunho: ${error}`,
					color: "error",
					active: true,
				};
			});
	}
}

// Cabeçalho da pagina
definePageMeta({
	layout: "dashboard",
});
</script>
<style scoped></style>
