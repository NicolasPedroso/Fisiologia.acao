### PUBLIC

Eh o antigo STATIC, funciona da mesma forma, mas agora com um nome mais intuitivo
eh necessario colocar "/" antes para acessar a pasta, ou seja:

```css
img="/imagens/name.jpg"
img="/name2.png"
```

### PAGES

Funciona que nem as paginas normais do Nuxt2
Index.vue -> é o principal que é o "/" \* Obs: se tiver um app.vue na raiz do projeto, vai ser ele o principal.

### COMPONENTS

Agora a parte engraçada, funciona igual o Nuxt2 tbm kakakak
Mas tem um porem, de padrao no Nuxt3 eh possivel nao importar os componentes, so falando o nome da rota tipo:

-   Tenho um componente na pasta **components/sections/Banner.vue**, invés de importar-lo, posso simplesmente chamar em qualquer pagina como <sectionsBanner/>
-   Isso pode ser desabilitado por:

```ts
    components: [
    {
      path: '~/components',
+     pathPrefix: false,
    },
  ],
```
