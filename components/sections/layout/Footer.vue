<template>
	<v-container fluid class="footer-wrapper">
		<!--Linha de cima-->
		<v-row class="footer-first-row">
			<v-col
				v-for="(item, index) in footerItems"
				:key="index"
				cols="6"
				md="4"
				lg="2"
				class="footer-links d-flex flex-column align-center align-md-start"
			>
				<a v-for="(link, subIndex) in item" :key="subIndex" href="#">
					{{ link }}</a
				>
			</v-col>
		</v-row>
		<!--Linha de baixo-->
		<v-row>
			<!--Copyright-->
			<v-col
				cols="12"
				md="6"
				class="d-flex flex-column align-center align-md-start"
			>
				<span class="footer-copyright">
					© 2024. Nem todos os direitos reservados.
				</span>
				<span class="footer-copyright">
					Feito para a
					<a href="https://ecomp.co/" class="footer-copyright-link">
						Ecomp
					</a>
					por
					<a
						href="https://github.com/tuildes"
						class="footer-copyright-link"
					>
						@tuildes
					</a>
				</span>
			</v-col>
			<!--Links de Redes Sociais-->
			<v-col
				cols="12"
				md="6"
				class="d-flex justify-center justify-md-end"
			>
				<a href="#">
					<v-icon class="footer-icon mx-3">mdi-twitter</v-icon>
				</a>
				<a href="#">
					<v-icon class="footer-icon mx-3">mdi-facebook</v-icon>
				</a>
				<a href="#">
					<v-icon class="footer-icon mx-3">mdi-linkedin</v-icon>
				</a>
				<a href="#">
					<v-icon class="footer-icon mx-3">mdi-basketball</v-icon>
				</a>
			</v-col>
		</v-row>
	</v-container>
</template>

<script setup>
// Variaveis
let footerItems = [
	["Sobre", "Ajuda", "Contato", "Termos", "Encontros"],
	[
		"Design Creativo",
		"Divulgação",
		"Ilustração",
		"Inscreva-se",
		"Evento mensal",
	],
	["Sobre", "Ajuda", "Contato", "Termos", "Encontros"],
	["Shop", "Privacidade", "Testemunhas", "Manual", "Tradução"],
	["Ache Designers", "Encontre Devs", "Times", "Anuncie", "API"],
	["Sobre", "Ajuda", "Contato", "Termos", "Encontros"],
]
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Raleway&display=swap");

.footer-wrapper {
	width: 1100px;
}

a {
	text-decoration: none;
	color: black;
	font-weight: 400;
	font-size: 16px;
	font-family: Raleway;
}

.footer-links {
	gap: 10px;
}

.footer-first-row {
	padding: 100px 0;
}

.footer-copyright {
	font-size: 85%;
	color: #828282;
	font-weight: 400px;
	font-family: Raleway;
}

.footer-copyright-link {
	font-size: 90%;
	font-weight: 800px;
	font-family: Raleway;
	color: #4527a0 !important;
}

.footer-icon {
	color: #4527a0;
}
</style>
