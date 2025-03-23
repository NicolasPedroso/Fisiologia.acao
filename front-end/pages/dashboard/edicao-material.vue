<template>
	<v-app full-height theme="dark">
		<!-- Drawer que contém os links para as páginas -->
		<v-no-ssr>
			<v-navigation-drawer v-model="drawer">
				<template #image>
					<div class="drawer-color" />
				</template>
				<!-- Logo e nome do Projeto -->
				<v-list lines="3" class="my-2">
					<v-list-item class="drawer-logo" title="Endo Games"
						subtitle="O projeto de extensão FISIOLOGIA EM AÇÃO">
						<template #prepend>
							<v-img width="40" height="56" contain class="mr-4" src="/images/logo.png"
								alt="Logo Endo Games" />
						</template>
					</v-list-item>
				</v-list>
				<!-- Logo e nome do Projeto -->
				<!-- Itens do drawer -->
				<v-list nav>
					<v-list-item v-for="(item, i) in drawerItems" :key="i" :to="item.link"
						:base-color="theme.drawerTextColor" :prepend-icon="item.icon" :title="item.title"
						:subtitle="item.subtitle" lines="3" class="my-1 py-1 drawer-text" />
				</v-list>
				<!-- Itens do drawer -->
			</v-navigation-drawer>
		</v-no-ssr>
		<!-- Drawer que contém os links para as páginas -->
		<!-- Navbar que contém TITULO, DRAWER-OPENER e LOGOUT BTN -->
		<v-app-bar class="primary-color">
			<v-app-bar-nav-icon class="text-color" @click.stop="drawer = !drawer" />
			<v-toolbar-title class="text-color">
				Painel do Administrador
			</v-toolbar-title>
			<template #append>
				<v-btn class="text-color" @click="logout()"> Sair </v-btn>
			</template>
		</v-app-bar>
		<!-- Navbar que contém TITULO, DRAWER-OPENER e LOGOUT BTN -->
		<!-- Conteúdo -->
		<v-main>
			<div class="d-flex justify=start pl-3">
				<span class="dtitle">Dashboard de Edições Matrial</span>
			</div>
			<v-divider color="white" style="border-width: 1.5px" />
			<div class="pa-4">
				<v-btn color="success font-weight-black" @click="dialog = true">Adicionar nova pergunta</v-btn>
			</div>
			<div>
				<v-container fluid>
					<v-data-table disable-pagination class="elevation-1" :items="perguntas" item-value="id">
						<template #headers>
							<tr>
								<th class="text-left">Ações</th>
								<th class="text-left">ID</th>
								<th class="text-left">Fase</th>
								<th class="text-left">Pergunta</th>
								<th class="text-left">Resposta</th>
								<th class="text-left">Dificuldade</th>
								<th class="text-left">Link</th>
								<th class="text-left">Imagem</th>
							</tr>
						</template>

						<template #item="{ item }">
							<tr style="padding: 20px">
								<!-- Botões de ação -->
								<td style="padding: 20px">
									<div class="d-flex flex-row">
										<v-btn icon class="mx-2" @click="editarPergunta(item)">
											<v-icon color="secondary">mdi-pencil</v-icon>
										</v-btn>
										<v-btn icon class="mx-2" @click="verDetalhes(item)">
											<v-icon color="white">mdi-eye-outline</v-icon>
										</v-btn>
									</div>
								</td>

								<!-- Dados da pergunta -->
								<td style="padding: 20px">{{ item.id }}</td>
								<td style="padding: 20px">{{ item.fase }}</td>
								<td style="padding: 20px">{{ item.nome }}</td>
								<td style="padding: 20px">
									{{
				item.alternativas.find(
					(alt) => alt.correta,
				)?.texto || "sem correta"
			}}
								</td>

								<td style="padding: 20px">
									{{ item.dificuldade }}
								</td>
								<td style="padding: 20px">
									<a :href="item.link" target="_blank">Link</a>
								</td>
								<td style="padding: 20px">
									<img :src="item.imagem" width="80" height="80" style="border-radius: 5px" />
								</td>
								<td style="padding: 20px">
									<v-btn icon class="mx-2" @click="deletaPergunta(item)">
										<v-icon color="error">mdi-delete</v-icon>
									</v-btn>
								</td>
							</tr>
						</template>
					</v-data-table>
				</v-container>
			</div>
			<NuxtPage />

			<!-- DIALOG PARA ADICIONAR PERGUNTA -->
			<v-dialog v-model="dialog" max-width="600px">
				<v-card>
					<v-card-title class="headline">Adicionar Pergunta</v-card-title>
					<v-card-text>
						<v-container>
							<v-row>
								<v-col cols="12">
									<v-text-field v-model="novaPergunta.id" label="id (dps tirar)" outlined dense
										type="number"></v-text-field>
								</v-col>
								<v-col cols="12">
									<v-text-field v-model="novaPergunta.fase" label="Fase" outlined dense
										type="number"></v-text-field>
								</v-col>
								<v-col cols="12">
									<v-text-field v-model="novaPergunta.nome" label="Pergunta" outlined
										dense></v-text-field>
								</v-col>
								<v-col cols="12">
									<v-select v-model="novaPergunta.dificuldade" :items="['Fácil', 'Médio', 'Difícil']"
										label="Dificuldade" outlined dense></v-select>
								</v-col>
								<v-col cols="12">
									<v-text-field v-model="novaPergunta.link" label="Link do Vídeo" outlined
										dense></v-text-field>
								</v-col>
								<v-col cols="12">
									<v-text-field v-model="novaPergunta.imagem" label="imagem(link por enquanto)"
										outlined dense></v-text-field>
								</v-col>

								<!-- ALTERNATIVAS -->
								<v-col cols="12">
									<span class="font-weight-bold">Alternativas:</span>
									<v-row v-for="(
											alt, index
										) in novaPergunta.alternativas" :key="index" align="center">
										<v-col cols="8">
											<v-text-field v-model="alt.texto" label="Alternativa" outlined
												dense></v-text-field>
										</v-col>
										<v-col cols="4">
											<v-checkbox v-model="alt.correta" label="Correta"
												@change="marcarCorreta(index)"></v-checkbox>
										</v-col>
									</v-row>
								</v-col>
							</v-row>
						</v-container>
					</v-card-text>
					<v-card-actions>
						<v-btn color="red" text @click="dialog = false">Cancelar</v-btn>
						<v-btn color="green" text @click="adicionarPergunta()">Salvar</v-btn>
					</v-card-actions>
				</v-card>
			</v-dialog>

			<!-- Dialog para exibir detalhes da pergunta -->
			<v-dialog v-model="dialogView" max-width="600px">
				<v-card>
					<v-card-title class="headline text-h4 font-weight-bold d-flex justify-center">Detalhes da
						Pergunta</v-card-title>
					<v-card-text>
						<v-divider></v-divider>
						<v-container>
							<v-row>
								<v-col cols="4">
									<strong class="pa-4 text-h6 font-weight-bold d-flex justify-center">ID</strong>
									<span class="pa-4 text-subtitle-1 d-flex justify-center">
										{{ perguntaSelecionada.id }}
									</span>
								</v-col>
								<v-col cols="4">
									<strong class="pa-4 text-h6 font-weight-bold d-flex justify-center">Fase</strong>
									<span class="pa-4 text-subtitle-1 d-flex justify-center">
										{{ perguntaSelecionada.fase }}
									</span>
								</v-col>
								<v-col cols="4">
									<strong
										class="pa-4 text-h6 font-weight-bold d-flex justify-center">Dificuldade</strong>
									<span class="pa-4 text-subtitle-1 d-flex justify-center">
										{{ perguntaSelecionada.dificuldade }}
									</span>
								</v-col>
								<v-divider></v-divider>
								<v-col cols="12">
									<strong
										class="pa-4 text-h6 font-weight-bold d-flex justify-center">Pergunta</strong>
									<span class="pa-4 text-subtitle-1 d-flex justify-center">
										{{ perguntaSelecionada.nome }}
									</span>
								</v-col>
								<v-divider></v-divider>
								<v-col cols="12">
									<span
										class="pa-4 text-h6 font-weight-bold d-flex justify-center">Alternativas</span>
									<v-card class="pa-5">
										<v-row class="d-flex justify-center">
											<v-col v-for="(
													alt, index
												) in perguntaSelecionada.alternativas" :key="index" cols="auto">
												<span v-if="index == 0">
													a)
												</span>
												<span v-if="index == 1">
													b)
												</span>
												<span v-if="index == 2">
													c)
												</span>
												<span v-if="index == 3">
													d)
												</span>
												<span :class="alt.correta
					? 'text-green font-weight-bold'
					: 'text-red'
				">
													{{ alt.texto }}
												</span>
											</v-col>
										</v-row>
									</v-card>
								</v-col>
								<v-col cols="12">
									<strong class="pa-4 text-h6 font-weight-bold d-flex justify-center">Link:</strong>
									<span class="pa-4 text-subtitle-1 d-flex justify-center">
										{{ perguntaSelecionada.link }}
									</span>
								</v-col>
								<v-divider></v-divider>
								<v-col cols="12">
									<strong
										class="pa-4 text-h6 font-weight-bold d-flex justify-center">Imagem:</strong><br />
									<img v-if="perguntaSelecionada.imagem" :src="perguntaSelecionada.imagem"
										width="100%" style="border-radius: 5px" />
								</v-col>
							</v-row>
						</v-container>
					</v-card-text>
					<v-card-actions>
						<v-spacer />
						<v-btn color="red" text @click="dialogView = false">Fechar</v-btn>
					</v-card-actions>
				</v-card>
			</v-dialog>

			<v-dialog v-model="dialogEdit" max-width="600px">
				<v-card>
					<v-card-title class="headline">Editar Pergunta</v-card-title>
					<v-card-text>
						<v-container>
							<v-row>
								<v-col cols="12">
									<v-text-field v-model="perguntaEdit.id" label="ID" outlined dense type="number"
										disabled></v-text-field>
								</v-col>
								<v-col cols="12">
									<v-text-field v-model="perguntaEdit.fase" label="Fase" outlined dense
										type="number"></v-text-field>
								</v-col>
								<v-col cols="12">
									<v-text-field v-model="perguntaEdit.nome" label="Pergunta" outlined
										dense></v-text-field>
								</v-col>
								<v-col cols="12">
									<v-select v-model="perguntaEdit.dificuldade" :items="['Fácil', 'Médio', 'Difícil']"
										label="Dificuldade" outlined dense></v-select>
								</v-col>
								<v-col cols="12">
									<v-text-field v-model="perguntaEdit.link" label="Link do Vídeo" outlined
										dense></v-text-field>
								</v-col>
								<v-col cols="12">
									<v-text-field v-model="perguntaEdit.imagem" label="Imagem (Link)" outlined
										dense></v-text-field>
								</v-col>
								<v-col cols="12">
									<span class="font-weight-bold">Alternativas:</span>
									<v-row v-for="(
											alt, index
										) in perguntaEdit.alternativas" :key="index" align="center">
										<v-col cols="8">
											<v-text-field v-model="alt.texto" label="Alternativa" outlined
												dense></v-text-field>
										</v-col>
										<v-col cols="4">
											<v-checkbox v-model="alt.correta" label="Correta" @change="
				marcarCorretaEdit(index)
				"></v-checkbox>
										</v-col>
									</v-row>
								</v-col>
							</v-row>
						</v-container>
					</v-card-text>
					<v-card-actions>
						<v-btn color="red" text @click="dialogEdit = false">Cancelar</v-btn>
						<v-btn color="green" text @click="atualizarPergunta()">Salvar</v-btn>
					</v-card-actions>
				</v-card>
			</v-dialog>
		</v-main>
		<!-- Conteúdo -->
		<!-- Footer -->
		<v-no-ssr>
			<v-footer app inset class="primary-color">
				<span class="text-color"> &copy; Endo Games 2025 </span>
			</v-footer>
		</v-no-ssr>
		<!-- Footer -->
	</v-app>
</template>
<script setup>
// Import do roteamento e dos arquivos de STORE
import { useRouter } from "vue-router"
import { useAuthStore } from "~/store/auth"
import { ref, onMounted } from "vue"
import axios from "axios"

// Variável reativa para armazenar as perguntas
const perguntas = ref([])
const fases = ref([])
const respostas = ref([])
const dialog = ref(false) // Estado do diálogo
const dialogView = ref(false) // Estado do diálogo
const perguntaSelecionada = ref({})
const dialogEdit = ref(false)
const novaPergunta = ref({
	if: "",
	fase: "",
	nome: "",
	dificuldade: "",
	link: "",
	imagem: "",
	alternativas: [
		{ texto: "", correta: false },
		{ texto: "", correta: false },
		{ texto: "", correta: false },
		{ texto: "", correta: false },
	],
})

const perguntaEdit = ref({
	id: "",
	fase: "",
	nome: "",
	dificuldade: "",
	link: "",
	imagem: "",
	alternativas: [
		{ texto: "", correta: false },
		{ texto: "", correta: false },
		{ texto: "", correta: false },
		{ texto: "", correta: false },
	],
})

// Função para buscar os dados da API
const fetchFases = async () => {
	try {
		const response1 = await axios.get("http://localhost:8000/api/fases")
		fases.value = response1.data // Armazena os dados na variável reativa
		console.log("fase", fases.value[0])
	} catch (error) {
		console.error("Erro ao buscar ddasdases:", error)
	}
}
const fetchPerguntas = async () => {
	try {
		const response2 = await axios.get("http://localhost:8000/api/perguntas")
		perguntas.value = response2.data.data // Armazena os dados na variável reativa
		console.log("pergunta", perguntas.value)
	} catch (error) {
		console.error("Erro ao buscar daaaaaaaases:", error)
	}
}
const fetchRespostas = async () => {
	try {
		const response3 = await axios.get("http://localhost:8000/api/respostas")
		respostas.value = response3.data // Armazena os dados na variável reativa
		console.log("respostas", respostas.value)
	} catch (error) {
		console.error("Erro ao buscar dbnases:", error)
	}
}

const marcarCorreta = (index) => {
	novaPergunta.value.alternativas.forEach((alt, i) => {
		alt.correta = i === index
	})
}

// Função para adicionar uma nova pergunta
const adicionarPergunta = async () => {
	if (validarFormularioAdd()) {
		try {
			await axios.post(
				"http://localhost:8000/perguntas",
				novaPergunta.value,
			)
			perguntas.value.push({ ...novaPergunta.value })
			// Limpa os campos do formulário
			novaPergunta.value = {
				id: "",
				fase: "",
				nome: "",
				dificuldade: "",
				link: "",
				imagem: "",
				alternativas: [
					{ texto: "", correta: false },
					{ texto: "", correta: false },
					{ texto: "", correta: false },
					{ texto: "", correta: false },
				],
			}

			dialog.value = false
		} catch (error) {
			console.error("Erro ao adicionar pergunta:", error)
		}
	}
}

const validarFormularioAdd = () => {
	const idValido = novaPergunta.value.id && !isNaN(novaPergunta.value.id)
	const faseValida =
		novaPergunta.value.fase && !isNaN(novaPergunta.value.fase)
	const nomePreenchido = novaPergunta.value.nome.trim() !== ""
	const dificuldadeValida = ["Fácil", "Médio", "Difícil"].includes(
		novaPergunta.value.dificuldade,
	)
	const linkPreenchido = novaPergunta.value.link.trim() !== ""
	const imagemPreenchida = novaPergunta.value.imagem.trim() !== ""
	const alternativasValidas = novaPergunta.value.alternativas.every(
		(alt) => alt.texto.trim() !== "",
	)
	const umaCorreta =
		novaPergunta.value.alternativas.filter((alt) => alt.correta).length ===
		1

	if (!idValido) {
		alert("O ID deve ser um número válido.")
		return false
	}
	if (!faseValida) {
		alert("A fase deve ser um número válido.")
		return false
	}
	if (!nomePreenchido) {
		alert("O campo Pergunta deve ser preenchido.")
		return false
	}
	if (!dificuldadeValida) {
		alert("Selecione uma dificuldade válida.")
		return false
	}
	if (!linkPreenchido) {
		alert("O campo Link deve ser preenchido.")
		return false
	}
	if (!imagemPreenchida) {
		alert("O campo Imagem deve ser preenchido.")
		return false
	}
	if (!alternativasValidas) {
		alert("Todas as alternativas devem ser preenchidas.")
		return false
	}
	if (!umaCorreta) {
		alert("Apenas uma alternativa deve ser marcada como correta.")
		return false
	}
	return true
}

const validarFormularioEdit = () => {
	const faseValida =
		perguntaEdit.value.fase && !isNaN(perguntaEdit.value.fase)
	const nomePreenchido = perguntaEdit.value.nome.trim() !== ""
	const dificuldadeValida = ["Fácil", "Médio", "Difícil"].includes(
		perguntaEdit.value.dificuldade,
	)
	const linkPreenchido = perguntaEdit.value.link.trim() !== ""
	const imagemPreenchida = perguntaEdit.value.imagem.trim() !== ""
	const alternativasValidas = perguntaEdit.value.alternativas.every(
		(alt) => alt.texto.trim() !== "",
	)
	const umaCorreta =
		perguntaEdit.value.alternativas.filter((alt) => alt.correta).length ===
		1

	if (!faseValida) {
		alert("A fase deve ser um número válido.")
		return false
	}
	if (!nomePreenchido) {
		alert("O campo Pergunta deve ser preenchido.")
		return false
	}
	if (!dificuldadeValida) {
		alert("Selecione uma dificuldade válida.")
		return false
	}
	if (!linkPreenchido) {
		alert("O campo Link deve ser preenchido.")
		return false
	}
	if (!imagemPreenchida) {
		alert("O campo Imagem deve ser preenchido.")
		return false
	}
	if (!alternativasValidas) {
		alert("Todas as alternativas devem ser preenchidas.")
		return false
	}
	if (!umaCorreta) {
		alert("Apenas uma alternativa deve ser marcada como correta.")
		return false
	}
	return true
}

const deletaPergunta = async (item) => {
	if (!confirm(`Tem certeza que deseja excluir a pergunta ID ${item.id}?`)) {
		return
	}

	try {
		await axios.delete(`http://localhost:8000/perguntas/${item.id}`)
		perguntas.value = perguntas.value.filter((p) => p.id !== item.id)
	} catch (error) {
		console.error("Erro ao excluir pergunta:", error)
	}
}

const editarPergunta = (item) => {
	perguntaEdit.value = { ...item, alternativas: [...item.alternativas] }
	dialogEdit.value = true
}

const atualizarPergunta = async () => {
	if (validarFormularioEdit()) {
		try {
			await axios.put(
				`http://localhost:8000/perguntas/${perguntaEdit.value.id}`,
				perguntaEdit.value,
			)
			const index = perguntas.value.findIndex(
				(p) => p.id === perguntaEdit.value.id,
			)
			if (index !== -1) perguntas.value[index] = { ...perguntaEdit.value }
			dialogEdit.value = false
		} catch (error) {
			console.error("Erro ao atualizar pergunta:", error)
		}
	}
}

// Função para abrir o dialog e preencher os detalhes
const verDetalhes = (item) => {
	perguntaSelecionada.value = item
	dialogView.value = true
}

// Chama a função quando o componente é montado
onMounted(() => {
	fetchPerguntas()
	fetchFases()
	fetchRespostas()
})

// Variáveis de ambiente
const router = useRouter()
const drawer = ref(false)

// Variáveis e funções da STORE
const { logUserOut } = useAuthStore()

// Array de paginas que serão exibidas no drawer
const drawerItems = [
	{
		icon: "mdi-monitor-dashboard",
		title: "Edição Material",
		subtitle: "Edição do material dos quizes",
		link: "/dashboard/edicao-material",
	},
	{
		icon: "mdi-monitor-dashboard",
		title: "Dashboard 2",
		subtitle: "Controle geral do sistema",
		link: "/dashboard/dashboard2",
	},
]

// Tema que será utilizado na dashboard
const theme = {
	/* Fundo do Drawer da dashboard */
	drawerBackground: "url(/images/drawer/background.jpg)",
	drawerTextColor: "#ffffff",
	/* Cores de fundo da dashboard  */
	backgroundColor: "#1f1f1f",
	/* Cores de texto da dashboard  */
	textColor: "#ffffff",
}

// Métodos e funções
async function logout() {
	await logUserOut()
	router.push("/login")
}

// Cabeçalhos da pagina
useSeoMeta({
	title: "Dashboard",
	description: "Página para controlar os conteudos da DataBase.",

	// Endereço da imagem que será exibida quando a página for compartilhada
	// ogImage: "endereco-da-imagem",
})
useHead({
	htmlAttrs: {
		lang: "pt-br",
	},
	link: [
		{
			rel: "icon",
			type: "image/ico",
			href: "/favicon.ico",
		},
	],
})
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");

.drawer-logo {
	/* Imagens e alterações do fundo do Drawer */
	font-family: "Poppins", sans-serif;
}

.drawer-color {
	height: 100%;
	width: 100%;
	/* Imagens e alterações do fundo do Drawer */
	background-image: v-bind("theme.drawerBackground");
	filter: brightness(0.5);
	background-size: cover;
	background-position: center center;
}

.drawer-text {
	font-family:
		"Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
		"Lucida Sans Unicode", Geneva, Verdana, sans-serif;
}

.primary-color {
	background-color: v-bind("theme.backgroundColor") !important;
}

.text-color {
	font-family:
		"Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
		"Lucida Sans Unicode", Geneva, Verdana, sans-serif;
	color: v-bind("theme.textColor") !important;
}

.drawer-logo :deep(.v-list-item-subtitle),
.drawer-text :deep(.v-list-item-subtitle) {
	word-break: normal !important;
}

.dtitle {
	font-size: 24px;
	font-weight: bold;
	margin-top: 10px;
	margin-bottom: 10px;
}
</style>
