<template>
	<v-container
		fluid
		style="height: 100%"
		class="d-flex flex-column justify-center align-center text-center"
	>
		<h1>Bem-vindo a Dashboard</h1>
		<h4 class="mt-6">
			Esta é a dashboard do administrador. Aqui você pode gerenciar as
			seções, páginas, dados dinâmicos da sua aplicação.
		</h4>
		<p class="mt-4">
			As páginas que você pode acessar estão listadas no menu lateral a
			esquerda.
		</p>
		<p class="mt-4">
			Para acessar a dashboard, você precisa estar logado como
			administrador. Caso queira sair da dashboard, clique no botão
			"<strong>Sair</strong>" no canto superior direito da tela.
		</p>
	</v-container>
</template>
<script setup>
definePageMeta({
	layout: "dashboard",
	middleware: ["guest"],
})
</script>
