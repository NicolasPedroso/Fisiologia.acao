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
            <v-divider color="white" style="border-width: 1.5px;" />
            <div class="pa-4">
                <v-btn color="success font-weight-black">Adicionar nova pergunta</v-btn>
            </div>
            <div>
                <v-container fluid>
                    <v-data-table disable-pagination class="elevation-1" :items="perguntas" item-value="id">
                        <template v-slot:headers>
                            <tr>
                                <th class="text-center">Ações</th>
                                <th class="text-left">ID</th>
                                <th class="text-left">Fase</th>
                                <th class="text-left">Pergunta</th>
                                <th class="text-left">Resposta</th>
                                <th class="text-left">Dificuldade</th>
                                <th class="text-left">Link</th>
                                <th class="text-left">Imagem</th>
                            </tr>
                        </template>

                        <template v-slot:item="{ item }">
                            <tr style="padding: 20px;">
                                <!-- Botões de ação -->
                                <td style="padding: 20px;">
                                    <v-btn icon class="mx-2" @click="methodUpdate(item)">
                                        <v-icon color="secondary">mdi-pencil</v-icon>
                                    </v-btn>
                                    <v-btn icon class="mx-2" @click="deleteMethod(item)">
                                        <v-icon color="error">mdi-delete</v-icon>
                                    </v-btn>
                                    <v-btn icon class="mx-2" @click="viewDetails(item)">
                                        <v-icon color="white">mdi-eye-outline</v-icon>
                                    </v-btn>
                                </td>

                                <!-- Dados da pergunta -->
                                <td style="padding: 20px;">{{ item.id }}</td>
                                <td style="padding: 20px;">{{ item.fase }}</td>
                                <td style="padding: 20px;">{{ item.nome }}</td>
                                <td style="padding: 20px;">
                                    {{ item.alternativas.find(alt => alt.correta)?.texto || "Nenhuma alternativa correta encontrada" }}
                                </td>

                                <td style="padding: 20px;">{{ item.dificuldade }}</td>
                                <td style="padding: 20px;">
                                    <a :href="item.link" target="_blank">Ver Vídeo</a>
                                </td>
                                <td style="padding: 20px;">
                                    <img :src="item.imagem" width="80" height="80" style="border-radius: 5px;" />
                                </td>
                            </tr>
                        </template>
                    </v-data-table>
                </v-container>


            </div>
            <NuxtPage />
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
import { ref, onMounted } from "vue";
import axios from "axios";

// Variável reativa para armazenar as perguntas
const perguntas = ref([]);

// Função para buscar os dados da API
const fetchPerguntas = async () => {
    try {
        const response = await axios.get("http://localhost:8000/perguntas");
        perguntas.value = response.data; // Armazena os dados na variável reativa
        console.log("aaaa",perguntas.value[0])
    } catch (error) {
        console.error("Erro ao buscar perguntas:", error);
    }
};

// Chama a função quando o componente é montado
onMounted(() => {
    fetchPerguntas();
});

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
    font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
        "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
}

.primary-color {
    background-color: v-bind("theme.backgroundColor") !important;
}

.text-color {
    font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
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
