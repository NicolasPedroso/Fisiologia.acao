<template>
	<v-app style="overflow-x: hidden !important">
		<v-row class="main__wrapper">
			<v-col cols="12" md="6" class="d-none d-md-block pa-0 ma-0">
				<div class="gradient">
					<v-img
						width="100%"
						height="100%"
						src="/login/background.png"
						cover
						alt=""
					/>
					<div class="image__overlay">
						<span class="text-center">
							<strong>FISIOLOGIA EM AÇÃO</strong>
						</span>
						<v-img
							src="/login/logo-vector.png"
							width="300"
							height="300"
							class="mx-auto mb-4"
							alt="Logo da Fisiologia em Ação"
						/>
						<span class="text-center">
							Transforme o estudo da fisiologia em um jogo de
							perguntas e respostas!
						</span>
					</div>
				</div>
			</v-col>
			<v-col
				cols="12"
				md="6"
				class="main__content d-flex justify-content align-center pa-12 ma-0"
			>
				<NuxtPage />
			</v-col>
		</v-row>
	</v-app>
</template>
<script setup></script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400;700&display=swap");

.gradient {
	position: relative;
	height: 100%;
	width: 100%;
	overflow: hidden;
}

.gradient::after {
	position: absolute;
	content: "";
	height: 100%;
	width: 100%;
	top: 0;
	left: 0;
	background: var(--gradient);
	opacity: 0.85;
	z-index: 2;
}

.image__overlay {
	color: white;
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 10;
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: space-around;
	padding: 16px 16px;
}

.image__overlay span {
	font-size: 1.15rem;
	text-align: center;
}

.main__content {
	background: white;
	background-image: radial-gradient(rgba(0, 0, 0, 0.25) 1px, transparent 0);
	background-size: 20px 20px;
	background-position: -16px -16px;

	width: 100%;
	height: 100%;
}

.main__wrapper {
	margin: 0;
	padding: 0;
}
</style>
