<template>
	<v-container fluid full-height class="ma-0 pa-0 text-center">
		<v-row class="mt-12">
			<v-col cols="12" class="text-h3">
				<span class="font-weight-black">
					Questões frequentemente perguntadas (FAQ)
				</span>
			</v-col>
			<v-container>
				<v-row justify="center">
					<v-col cols="12" class="faq-container">
						<v-expansion-panels class="faq-panels">
							<v-expansion-panel
								v-for="(faq, index) in faqs"
								:key="index"
								class="faq-card"
							>
								<v-expansion-panel-title
									class="text-h5 font-weight-black faq-title"
								>
									{{ faq.pergunta }}
								</v-expansion-panel-title>
								<v-expansion-panel-text
									class="text-h6 font-weight-black"
								>
									{{ faq.resposta }}
								</v-expansion-panel-text>
							</v-expansion-panel>

							<v-expansion-panel class="faq-card">
								<v-expansion-panel-title
									class="text-h5 font-weight-black faq-title"
								>
									Quem produziu esse site?
								</v-expansion-panel-title>
								<v-expansion-panel-text
									class="text-h6 font-weight-black"
								>
									Uma equipe de desenvolvedores, como
									designers e programadores de Informática
									Biomédica da UFPR

									<br />

									<ul>
										<li>
											<a
												href="https://github.com/tuildes"
												target="_blank"
												aria-label="Github de tuildes"
											>
												<v-icon class="mr-1">
													mdi-github
												</v-icon>
												<strong>Gustavo Frehse:</strong>
												Design, Front-end e Back-end
											</a>
										</li>

										<li v-for="i in members" :key="i">
											<v-divider class="my-2" />
											<a
												:href="`https://github.com/${i.github}`"
												target="_blank"
												aria-label="Github de tuildes"
											>
												<strong>{{ i.name }}:</strong>
												{{ i.role }}
											</a>
										</li>
									</ul>
								</v-expansion-panel-text>
							</v-expansion-panel>
						</v-expansion-panels>
					</v-col>
				</v-row>
			</v-container>
		</v-row>
	</v-container>
</template>
<script setup>
definePageMeta({
	middleware: ["guest"],
})

const members = [
	{
		name: "...",
		role: "...",
		github: "",
	},
]

const faqs = [
	{
		pergunta: "FAQ, em breve",
		resposta: "...",
	},
]
</script>
<style scoped>
/* Define a largura para deixar 20% de margem nas laterais */
.faq-container {
	max-width: 800px;
	margin: 0 auto;
}

/* Define espaçamento entre os cards */
.faq-panels {
	display: flex;
	flex-direction: column;
	gap: 6px;
}

/* Estiliza os cards */
.faq-card {
	background-color: #ffffff !important;
	font-size: 2px !important;
	color: rgb(12, 12, 12) !important;
}

.faq-card:deep(.v-expansion-panel-title) {
	font-size: 1.5rem !important;
	display: flex !important;
	align-items: center !important;
	gap: 4px !important;
}

.faq-card:deep(.v-expansion-panel-text) {
	font-size: 1.2rem !important;
	font-weight: 200 !important;
	text-align: left !important;
}

ul {
	padding-left: 20px;
}

ul a {
	color: #6200ea;
	text-decoration: none;
}

.faq-title {
	padding: 20px;
}

/* Remove a borda padrão */
.faq-card::v-deep(.v-expansion-panel) {
	box-shadow: none;
}
</style>
