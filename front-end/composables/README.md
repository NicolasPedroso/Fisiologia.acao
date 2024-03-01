## 🚀 COMPOSABLES

> Autoimport de códigos para seu código. Não possui reatividade imbutida na pasta, porém pode ser feito utilizando do VUE. Normalmente utilizada para funções de API e manipulação de server

-   Códigos .vue, .js, .ts

### Padrão

-   Nome em inglês
-   CamelCase
-   Prefixo use

Exemplo: "**useDataLoader.js**"

### Imports

1. Autoimport pelo Nuxt

```javascript
// Sem a necessidade de importar manualmente, o Nuxt faz este trabalho
useDataLoader("/api/rota", {
	method: "POST",
})
```
