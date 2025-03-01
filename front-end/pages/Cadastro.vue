<template>
    <v-container fluid class="ma-0 pa-0">
        <v-row>
            <v-col cols="11">
                <v-row>
                    <v-col cols="6" class="d-flex justify-start align-start"
                        style="height: 150px; padding-left: 80px; padding-top: 50px;">
                        <v-img :width="150" aspect-ratio="1/1" cover src="../public/images/logo.png"
                            style="max-width: 200px;"></v-img>
                    </v-col>

                    <v-col cols="6" class="d-flex justify-center align-center"
                        style="align-content: center; margin-top: 100px;">
                        <!-- Apenas o ícone da câmera -->
                        <v-file-input v-model="file" accept="image/*" label="Escolha uma imagem"
                            prepend-icon="mdi-camera-plus-outline" color="black" @change="previewImage" hide-input
                            rounded :rules="[imageRequired]" class="custom-icon-size">
                        </v-file-input>

                    </v-col>
                </v-row>
            </v-col>
            <!-- Coluna com fundo azul de 1/12 da largura -->
            <v-col cols="1" style="background-color: #1356D3;"></v-col>
        </v-row>

        <v-row>
            <!-- Coluna com conteúdo -->
            <v-col cols="11" class="d-flex justify-center" style="margin-bottom: 30px;">

                <v-col cols="7">
                    <v-card variant="outlined" style="padding: 40px;">
                        <v-col cols="12">
                            <span>NOME</span>
                            <v-text-field v-model="name" label="Coloque seu nome" variant="outlined"
                                prepend-inner-icon="mdi-account-check-outline" clearable required
                                :rules="[nameRules]"></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <span>EMAIL</span>
                            <v-text-field v-model="email" hide-details="auto" label="Coloque seu email"
                                hint="Digite um email válido" placeholder="exemplo@gmail.com" type="email"
                                variant="outlined" :rules="emailRules" clearable required
                                prepend-inner-icon="mdi-email-outline"></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <span>SENHA</span>
                            <v-text-field v-model="password" hint="Use uma senha segura" label="Senha"
                                :type="show1 ? 'text' : 'password'" variant="outlined" clearable required
                                :rules="passwordRules" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="show1 = !show1" prepend-inner-icon="mdi-lock-outline"></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <span>CONFIRME SUA SENHA</span>
                            <v-text-field v-model="confirmPassword" label="Confirme sua senha"
                                :type="show2 ? 'text' : 'password'" variant="outlined" clearable required
                                :rules="[...passwordRules, passwordMatch]"
                                :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'" @click:append="show2 = !show2"
                                prepend-inner-icon="mdi-lock-outline"></v-text-field>
                        </v-col>

                        <v-col cols="12" class="d-flex justify-center">
                            <v-btn block color="#1356D3" size="large" @click="submit" :disabled="!isFormValid">
                                CADASTRAR
                            </v-btn>
                        </v-col>
                    </v-card>
                </v-col>
            </v-col>

            <!-- Faixa azul 10% da tela -->
            <v-col cols="1" style="background-color: #1356D3;">
            </v-col>
        </v-row>

    </v-container>
</template>

<script setup>
import { ref, computed } from "vue";

const name = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");
const file = ref(null);
const show1 = ref(false);
const show2 = ref(false);

const nameRules = (v) => !!v || "Nome é obrigatório";

const emailRules = [
    (v) => !!v || "E-mail é obrigatório",
    (v) => /.+@.+\..+/.test(v) || "E-mail deve ser válido",
];

const passwordRules = [
    (v) => !!v || "Senha é obrigatória",
    (v) => v.length >= 8 || "Senha deve ter pelo menos 8 caracteres",
];

const passwordMatch = (v) => v === password.value || "As senhas não coincidem";

// Lógica para verificar se a imagem foi selecionada
const imageRequired = (v) => !!v || "Imagem de perfil é obrigatória";

// Computed para verificar se todos os campos estão preenchidos corretamente
const isFormValid = computed(() => {
    return (
        name.value &&
        emailRules.every((rule) => rule(email.value) === true) &&
        passwordRules.every((rule) => rule(password.value) === true) &&
        passwordMatch(confirmPassword.value) === true &&
        !!file.value // Verifica se a imagem foi carregada
    );
});

const submit = () => {
    alert("Cadastro realizado com sucesso!");
};

// Função para carregar a imagem de perfil
const previewImage = (file) => {
    // Não renderiza a imagem, apenas valida o input
};
</script>

<style scoped>

* {
    background-color: #ffffff;
}

.v-avatar {
    border-radius: 50%;
}

::v-deep .custom-icon-size .v-icon--size-default {
    font-size: 100px;
    /* Ajuste o tamanho conforme necessário */
}
</style>
