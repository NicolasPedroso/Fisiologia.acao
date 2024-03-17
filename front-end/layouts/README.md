## 🚀 LAYOUTS

> Seções de código que definem o layout da aplicação, que são pedaços de interface que são repetidos e reusados entre páginas.

-   Códigos .vue

### ♻️ Padrão de nomenclatura

-   Nome em inglês
-   CamelCase

Exemplo: "**Dashboard.vue**"

### 📎 Definir onde fica o conteúdo da página

```html
<template>
	<!-- NuxtPage é o que determina onde fica o conteúdo da página -->
	<NuxtPage />
</template>
```

### 🗂 Usando o layout desejado

```javascript
// Trocar layout-name pelo nome do layout desejado
// Caso não tenha definição, o layout default sera usado
definePageMeta({
	layout: "layout-name",
})
```
