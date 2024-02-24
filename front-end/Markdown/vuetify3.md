# Vuetify 3

### Minha experiencia - 26/12/2023

#### Instalação:

1. rodei os seguintes comandos para colocar Vuetify3 no projeto:

```bash
npm i -D vuetify vite-plugin-vuetify;
# Coloca o MDI-ICONS que a gente usa, pode ser usados outros como FE, mas vamos continuar por enquanto com o geral (licença gratuita garantida :)
npm i @mdi/font;
```

2. Seguindo o tutorial do Vuetify3, ele pediu para colocar no Nuxt.config.ts alguns imports

3. Adicionei uma pasta de plugin e coloquei o vuetify dentro

4. Criei a pasta de layouts e coloquei o default.vue
   4.1 Feito o default.vue na seguinte estrutura básica:

    ```html
    <template>
    	<v-app>
    		<NuxtPage></NuxtPage>
    	</v-app>
    </template>

    <script></script>
    ```
