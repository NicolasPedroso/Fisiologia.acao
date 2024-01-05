<template>
	<v-container
		fluid
		class="we-offer-wrapper raleway d-flex flex-column align-center"
	>
		<span class="we-offer-title">O que ofertamos</span>
		<span class="we-offer-description"
			>You're now tuned in to the realest ever
			<br />
			The one and only.
		</span>

		<!--Parte que divide o conteudo em 4 partes de seleção-->
		<div class="we-offer-tab raleway">
			<v-tabs v-model="tabs" hide-slider grow height="70px">
				<v-tab
					v-for="(item, index) in tabsIcons"
					:key="index"
					:value="index"
					class="we-offer-tab-disabled"
					selected-class="we-offer-tab-enabled"
				>
					<span class="d-none d-lg-flex">{{ item.name }}</span>
					<v-icon
						class="d-flex d-lg-none"
						color="deep-purple darken-3"
						size="40"
					>
						{{ item.icon }}
					</v-icon>
				</v-tab>
			</v-tabs>
			<v-window v-model="tabs">
				<!--Item 1-->
				<v-window-item
					:value="0"
					transition="slide-y-reverse-transition"
					reverse-transition="slide-y-reverse-transition"
				>
					<v-card
						flat
						style="
							width: 80vw;
							max-width: 1200px;
							margin-bottom: 100px;
						"
					>
						<v-card-text>
							<v-row style="margin-top: 10px">
								<v-col cols="12" lg="6">
									<v-img
										class="we-offer-tab-image"
										alt="Imagem do jogo Gris"
										src="https://www.ultimaficha.com.br/wp-content/uploads/2018/12/ss_631d99cc6462cce94081032b7e600a6b87c3f7d3.0.jpg"
									/>
								</v-col>
								<v-col cols="12" lg="6">
									<h1
										class="we-offer-ttl text-center text-lg-start"
									>
										Web Design
									</h1>
									<p class="we-offer-paragraph">
										Paragraph placeat quis fugiat provident
										veritatis quia iure a debitis adipisci
										dignissimos consectetur magni quas eius
										nobis reprehenderit soluta eligendi quo
										reiciendis fugit? Veritatis tenetur odio
										delectus quibusdam officiis est.
									</p>
									<p class="we-offer-paragraph">
										Ullam dolorum iure dolore dicta fuga
										ipsa velit veritatis molestias totam
										fugiat soluta accusantium omnis quod
										similique placeat at. Dolorum ducimus
										libero fuga molestiae asperiores
										obcaecati corporis sint illo facilis.
									</p>
									<v-row class="we-offer-paragraph">
										<v-col cols="6">
											<h3>Keep it simple</h3>
											<span>
												Ullam dolorum iure dolore dicta
												fuga ipsa velitveritatis
											</span>
										</v-col>
										<v-col cols="6">
											<h3>Less is more</h3>
											<span>
												Ullam dolorum iure dolore dicta
												fuga ipsa velitveritatis
											</span>
										</v-col>
									</v-row>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-window-item>

				<!--Item 2-->
				<v-window-item
					:value="1"
					transition="slide-y-reverse-transition"
					reverse-transition="slide-y-reverse-transition"
				>
					<v-card
						flat
						style="
							width: 80vw;
							max-width: 1200px;
							margin-bottom: 100px;
						"
					>
						<v-card-text>
							<v-row style="margin-top: 10px">
								<v-col cols="12" lg="6">
									<h1
										class="we-offer-ttl text-center text-lg-start"
									>
										Online Marketing
									</h1>
									<p class="we-offer-paragraph">
										Paragraph placeat quis fugiat provident
										veritatis quia iure a debitis adipisci
										dignissimos consectetur magni quas eius
										nobis reprehenderit soluta eligendi quo
										reiciendis fugit? Veritatis tenetur odio
										delectus quibusdam officiis est.
									</p>
									<p class="we-offer-paragraph">
										Ullam dolorum iure dolore dicta fuga
										ipsa velit veritatis molestias totam
										fugiat soluta accusantium omnis quod
										similique placeat at. Dolorum ducimus
										libero fuga molestiae asperiores
										obcaecati corporis sint illo facilis.
									</p>
									<v-row class="we-offer-paragraph">
										<v-col cols="6">
											<h3>Keep it simple</h3>
											<span>
												Ullam dolorum iure dolore dicta
												fuga ipsa velitveritatis
											</span>
										</v-col>
										<v-col cols="6">
											<h3>Less is more</h3>
											<span>
												Ullam dolorum iure dolore dicta
												fuga ipsa velitveritatis
											</span>
										</v-col>
									</v-row>
								</v-col>
								<v-col cols="12" lg="6">
									<v-img
										class="we-offer-tab-image"
										alt="Imagem do jogo Gris"
										src="https://www.ultimaficha.com.br/wp-content/uploads/2018/12/ss_631d99cc6462cce94081032b7e600a6b87c3f7d3.0.jpg"
									/>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-window-item>

				<!--Item 3-->
				<v-window-item
					:value="2"
					transition="slide-y-reverse-transition"
					reverse-transition="slide-y-reverse-transition"
				>
					<v-card
						flat
						style="
							width: 80vw;
							max-width: 1200px;
							margin-bottom: 100px;
						"
					>
						<v-card-text>
							<v-row style="margin-top: 10px">
								<v-col cols="12" lg="6">
									<v-img
										class="we-offer-tab-image"
										alt="Imagem do jogo Gris"
										src="https://www.ultimaficha.com.br/wp-content/uploads/2018/12/ss_631d99cc6462cce94081032b7e600a6b87c3f7d3.0.jpg"
									/>
								</v-col>
								<v-col cols="12" lg="6">
									<h1
										class="we-offer-ttl text-center text-lg-start"
									>
										E-Commerce
									</h1>
									<p class="we-offer-paragraph">
										Paragraph placeat quis fugiat provident
										veritatis quia iure a debitis adipisci
										dignissimos consectetur magni quas eius
										nobis reprehenderit soluta eligendi quo
										reiciendis fugit? Veritatis tenetur odio
										delectus quibusdam officiis est.
									</p>
									<p class="we-offer-paragraph">
										Ullam dolorum iure dolore dicta fuga
										ipsa velit veritatis molestias totam
										fugiat soluta accusantium omnis quod
										similique placeat at. Dolorum ducimus
										libero fuga molestiae asperiores
										obcaecati corporis sint illo facilis.
									</p>
									<v-row class="we-offer-paragraph">
										<v-col cols="6">
											<h3>Keep it simple</h3>
											<span>
												Ullam dolorum iure dolore dicta
												fuga ipsa velitveritatis
											</span>
										</v-col>
										<v-col cols="6">
											<h3>Less is more</h3>
											<span>
												Ullam dolorum iure dolore dicta
												fuga ipsa velitveritatis
											</span>
										</v-col>
									</v-row>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-window-item>

				<!--Item 4-->
				<v-window-item
					:value="3"
					transition="slide-y-reverse-transition"
					reverse-transition="slide-y-reverse-transition"
				>
					<v-card
						flat
						style="
							width: 80vw;
							max-width: 1200px;
							margin-bottom: 100px;
						"
					>
						<v-card-text>
							<v-row style="margin-top: 10px">
								<v-col cols="12" lg="6">
									<h1
										class="we-offer-ttl text-center text-lg-start"
									>
										Logo & Branding
									</h1>
									<p class="we-offer-paragraph">
										Paragraph placeat quis fugiat provident
										veritatis quia iure a debitis adipisci
										dignissimos consectetur magni quas eius
										nobis reprehenderit soluta eligendi quo
										reiciendis fugit? Veritatis tenetur odio
										delectus quibusdam officiis est.
									</p>
									<p class="we-offer-paragraph">
										Ullam dolorum iure dolore dicta fuga
										ipsa velit veritatis molestias totam
										fugiat soluta accusantium omnis quod
										similique placeat at. Dolorum ducimus
										libero fuga molestiae asperiores
										obcaecati corporis sint illo facilis.
									</p>
									<v-row class="we-offer-paragraph">
										<v-col cols="6">
											<h3>Keep it simple</h3>
											<span>
												Ullam dolorum iure dolore dicta
												fuga ipsa velitveritatis
											</span>
										</v-col>
										<v-col cols="6">
											<h3>Less is more</h3>
											<span>
												Ullam dolorum iure dolore dicta
												fuga ipsa velitveritatis
											</span>
										</v-col>
									</v-row>
								</v-col>
								<v-col cols="12" lg="6">
									<v-img
										class="we-offer-tab-image"
										alt="Imagem do jogo Gris"
										src="https://www.ultimaficha.com.br/wp-content/uploads/2018/12/ss_631d99cc6462cce94081032b7e600a6b87c3f7d3.0.jpg"
									/>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-window-item>
			</v-window>
		</div>
	</v-container>
</template>
<script setup>
const tabs = ref(null)
const tabsIcons = [
	{
		name: "Web Design",
		icon: "mdi-palette-swatch",
	},
	{
		name: "Online Marketing",
		icon: "mdi-chart-bell-curve-cumulative",
	},
	{
		name: "E-Commerce",
		icon: "mdi-briefcase-outline",
	},
	{
		name: "Logo & Branding",
		icon: "mdi-cube-outline",
	},
]
</script>
<style scoped>
@media (max-width: 500px) {
	.we-offer-tab-disabled {
		padding: 0px !important;
		min-width: 60px;
	}
}

@media (min-width: 501px) and (max-width: 1262px) {
	.we-offer-tab-disabled {
		padding: 0px 30px !important;
	}
}
.we-offer-title {
	font-size: 36px;
	line-height: 1.5;
	font-weight: bold;
	color: #000000a4;
	text-align: center;

	margin-top: 80px;
}

.we-offer-description {
	text-align: center;
	font-size: 18px;
	line-height: 1.5;
	color: #828282;

	width: 80vw;
	max-width: 800px;
	margin-top: 5px;
}

.we-offer-tab {
	margin-top: 80px;
}

.we-offer-tab-enabled {
	color: #4527a0 !important;
	background-color: #fff !important;
}

.we-offer-tab-disabled {
	text-transform: capitalize;
	background-color: #f2f2f2;
	color: #00000068;
	padding: 0px 80px;
	border-radius: 5px;
	border: 2px solid #f2f2f2;
}

.we-offer-tab-disabled:hover {
	color: black !important;
}

.we-offer-tab-image {
	border-radius: 20px;
	height: 500px;
}

.we-offer-ttl {
	margin-top: 40px;
	color: rgba(0, 0, 0, 0.6);
	font-size: 40px;
}

.we-offer-paragraph {
	font-weight: 400;
	font-size: 16px;
	line-height: 1.7;
	color: #828282;
	text-align: justify;

	margin-top: 30px;
}
</style>
