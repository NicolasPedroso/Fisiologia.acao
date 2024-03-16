<!--
	Componente de Título de autenticação
	LOGO da Ecomp + Título personalizado
	
	<auth-title :title="'Registro'" />
-->
<template>
	<div class="d-flex flex-column align-center">
		<v-img
			src="/images/logo.png"
			alt="Logo da Ecomp"
			contain
			class="auth-logo mb-3"
		/>
		<span class="auth-title"> {{ title }} </span>
	</div>
</template>
<script setup>
defineProps({
	title: {
		type: String,
		required: true,
	},
})
</script>
<style scoped>
.auth-logo {
	width: 75px;
	height: 112px;
	filter: grayscale(100%);
}

.auth-title {
	font-family: Poppins !important;
	font-weight: bold;
	font-size: 1.5rem;
	color: rgb(113, 113, 113);
	text-transform: capitalize;
}
</style>
