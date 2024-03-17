## 🚀 MIDDLEWARE

> Seções de código que acontecem antes mesmo da página carregar.

-   Códigos .js, .ts

### ♻️ Padrão de nomenclatura

-   Nome em inglês
-   Snake Case

Exemplo: "**guest.js**"

### 📎 Estrutura

```javascript
/*
 * @param {Object} to - Pagina que o usuario esta tentando acessar
 * @param {Object} from - Pagina que o usuario esta vindo
 */
export default defineNuxtRouteMiddleware((to, from) => {
	// Codigo do seu middleware
})
```

### 🗂 Usando o(s) middleware(s) desejado(s)

```javascript
// Trocar no vetor os nomes dos middlewares
definePageMeta({
	middleware: ["auth", "admin"],
})
```
