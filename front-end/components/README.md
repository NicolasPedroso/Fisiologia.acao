## 🚀 COMPONENTS

> Aqui ficam os componentes - partes de .vue que você pode utilizar repetidamente apenas importando como tags de html

-   Componentes .vue

### ♻️ Padrão de nomenclatura

-   Nomes em inglês
-   Pascal Case

Exemplo: "**TitleAuth.vue**"

### 🌐 Imports

1. **Import automático** pelo Nuxt (usando o nome das pastas)

Por exemplo, se o seu componente estiver localizado assim:

-   components/base/foo/button.vue

```html
<template>
	<BaseFooButton />
	<base-foo-button />
</template>
```

2. **Import manual**

```javascript
import TitleAuth from "@/components/auth/Title.vue"
```
