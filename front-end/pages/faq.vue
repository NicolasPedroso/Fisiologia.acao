<template>
    <v-container fluid class="ma-0 pa-0 text-center">
        <v-row>
            <v-col cols="12" class="text-h3" style="margin: 3%">
                <span class="font-weight-black"> Questões frequentemente perguntadas (FAQ) </span>
            </v-col>
            <v-container>
                <v-row justify="center">
                    <v-col cols="12" class="faq-container">
                        <v-expansion-panels class="faq-panels">
                            <v-expansion-panel v-for="(faq, index) in faqs" :key="index" class="faq-card">
                                <v-expansion-panel-title class="text-h5 font-weight-black faq-title">{{ faq.pergunta
                                    }}</v-expansion-panel-title>
                                <v-expansion-panel-text class="text-h6 font-weight-black">{{ faq.resposta
                                    }}</v-expansion-panel-text>
                            </v-expansion-panel>
                        </v-expansion-panels>
                    </v-col>
                </v-row>
            </v-container>
        </v-row>
    </v-container>
    <!-- Conteudo da pagina -->
</template>
<script setup>
import { ref } from "vue"

const faqs = ref([
    {
        pergunta: "Quem pode usar essa plataforma?",
        resposta:
            "Qualquer pessoa que tenha se registrado anteriormente com seu email e senha.",
    },
    {
        pergunta: "As informações da página são confiáveis?",
        resposta:
            "Sim, todas as informações são verificadas por nossa equipe antes de serem publicadas.",
    },
    {
        pergunta: "Caso eu perca minha conta, o que fazer?",
        resposta:
            "Você pode redefinir sua senha através da opção 'Esqueci minha senha'.",
    },
    {
        pergunta: "Quem responde minhas perguntas referentes ao conteúdo?",
        resposta: "Nossa equipe de suporte e especialistas no assunto.",
    },
    {
        pergunta: "Qual o intuito do projeto?",
        resposta:
            "Facilitar o acesso a informações e criar uma comunidade engajada.",
    },
    {
        pergunta: "Quem produziu o projeto?",
        resposta:
            "O time da EndoGames, composto por desenvolvedores e designers experientes.",
    },
])
</script>
<style scoped>
/* Define a largura para deixar 20% de margem nas laterais */
.faq-container {
    width: 60%;
    /* 100% - (20% + 20%) = 60% */
    margin: 0 auto;
    /* Centraliza */
}

/* Define espaçamento entre os cards */
.faq-panels {
    display: flex;
    flex-direction: column;
    gap: 6px;
    /* Espaço entre os cards */
}

/* Estiliza os cards */
.faq-card {
    background-color: #616060 !important;
    /* Cinza escuro */
    color: white !important;
    /* Texto branco */
}

.faq-title {
    margin: 10px;
}

/* Remove a borda padrão */
.faq-card::v-deep(.v-expansion-panel) {
    box-shadow: none;
}
</style>
