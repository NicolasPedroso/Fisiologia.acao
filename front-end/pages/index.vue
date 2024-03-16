<template>
	<v-container fluid class="ma-0 pa-0">
		<!-- Ao iniciar o projeto, deletar todo o conteúdo dentro do v-container -->
		<div
			style="
				background-color: #0b0b0b;
				height: 100vh;
				color: #fff;
				gap: 20px;
			"
			class="text-center d-flex flex-column justify-center align-center"
		>
			<h1 style="color: #00dc80">Bem-vindo(a) ao Projeto Base de 2024</h1>
			<p>
				1. Olhem e pesquisem sobre a estrutura das Pastas NUXT no drive
				de Projetos antes de iniciar
			</p>
			<p>
				2. Utilizem o Vuetify, contém vários componentes e scripts
				prontos
			</p>
			<p>
				3. Para pegar dados do backend, vejam o uso do
				<strong>useDataLoader</strong> que fizemos para vocês, ele está
				documentado em composables/useDataLoader.js e veja bem como
				$fetch e useFetch funciona no Nuxt3
			</p>
			<p>
				4. Sigam o padrão de código estabelecido por Qualidade na
				<a
					href="https://wiki-ecomp.vercel.app/docs/Padrao/Carreiras/Front-End/"
					target="_blank"
					style="color: #00dc80"
				>
					wiki deles
				</a>
			</p>
			<p>
				5. Utilize e abuse da documentação do Nuxt3, Vue3, Vuetify e dos
				materiais das capacitações
			</p>
			<p>
				6.
				<strong style="color: #00dc80">
					E por fim, não hesitem em perguntar, somos todos ECOMP
				</strong>
			</p>
		</div>
		<!-- Ao iniciar o projeto, deletar todo o conteúdo dentro do v-container -->
	</v-container>
</template>
<script setup>
// Cabeçalhos da pagina
useSeoMeta({
	title: "Página inicial",
	description: "Página inicial do projeto base 2024 da Ecomp.",
})
useHead({
	htmlAttrs: {
		lang: "pt-br",
	},
	link: [
		{
			rel: "icon",
			type: "image/ico",
			href: "/favicon.ico",
		},
	],
})
</script>
