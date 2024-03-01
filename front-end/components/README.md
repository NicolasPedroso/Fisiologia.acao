## 🚀 COMPONENTS

> Aqui ficam os componentes - partes de .vue que você pode utilizar repetidamente apenas importando como tags de html

-   Componentes .vue

### Padrão

-   Nomes em inglês
-   Pascal Case
-   Imports manuais

Exemplo: "**TitleAuth.vue**"

### Imports

1. **Import automático** pelo Nuxt (usando o nome das pastas)

Por exemplo, se o seu componente estiver localizado assim:

-   components/base/foo/button.vue

```html
<template>
	<BaseFooButton />
</template>
```

2. **Import manual** (recomendado)

```javascript
import TitleAuth from "@/components/auth/TitleAuth.vue"
```
