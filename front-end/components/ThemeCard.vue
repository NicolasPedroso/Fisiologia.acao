<template>
	<!-- Card de tema com ícone decorativo -->
	<v-card
		:to="`/fisiologia/tema/${theme.id}`"
		class="theme-card__wrapper d-flex flex-column"
	>
		<h3 class="w50">{{ theme.title }}</h3>
		<p class="w50">{{ theme.fases_count }} quizzes disponíveis</p>
		<v-icon class="theme-card__image"> {{ theme.icon }} </v-icon>
	</v-card>
</template>
<script setup>
/**
 * Componente de card para exibição de temas
 * Mostra título, quantidade de quizzes e ícone decorativo
 */
defineProps({
	theme: {
		type: Object,
		required: true,
		default: () => ({
			title: "Tema de exemplo",
			icon: "mdi-cat",
			quantity: 0,
		}),
	},
})
</script>
<style scoped>
/* Card principal do tema */
.theme-card__wrapper {
	background-color: var(--white);
	color: var(--text-color);
	padding: 16px;
	border-radius: 8px;
	text-align: left;
	box-shadow: 0 0px 4px rgba(0, 0, 0, 0.25);
	width: 100%;
	height: 100%;
	min-height: 200px;
	position: relative;
	overflow: hidden;
}

/* Ícone decorativo posicionado no canto */
.theme-card__image {
	position: absolute;
	right: -96px;
	bottom: -64px;
	font-size: 280px;
	transform: rotate(20deg) scaleX(-1);
}

/* Largura para texto */
.w50 {
	width: 50%;
}
</style>
