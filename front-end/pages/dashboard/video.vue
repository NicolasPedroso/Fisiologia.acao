<template>
	<v-container fluid style="height: 100%" class="editor__wrapper">
		<div class="editor__content">
			<v-row class="editor__firstLine">
				<v-btn height="46" prepend-icon="mdi-plus" color="#1356D3">
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
				:density="compact"
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
			</v-data-table>
		</div>
	</v-container>
</template>
<script setup>
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
	{ title: "Ações", key: "actions", align: "end", sortable: false },
]
const data = ref([
	{ id: 0, link: "/", theme: "a" },
	{ id: 1, link: "/", theme: "b" },
	{ id: 2, link: "/", theme: "teste 3" },
	{ id: 0, link: "/", theme: "b" },
	{ id: 0, link: "/", theme: "teste 2" },
])
const loading = ref(false)

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
</style>
