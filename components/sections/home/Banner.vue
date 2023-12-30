<template>
	<div>
		<!--Primeiro elemento fora o navbar-->
		<v-parallax
			height="800"
			alt="Parralax de folhas"
			class="banner-image"
			src="/imagens/banner.jpeg"
		/>
		<div
			class="banner-content d-flex justify-center align-center flex-column"
		>
			<span class="banner-title">Eles queriam que eu vivesse</span>
			<span class="banner-subtitle">Imortal é ter que carregar isso</span>
			<div class="banner-btns d-flex flex-row">
				<v-btn flat color="#558B2F" class="banner-button">
					Ouvir
				</v-btn>
				<v-btn
					flat
					color="white"
					variant="outlined"
					class="banner-button banner-button-border"
				>
					Buscar
				</v-btn>
			</div>
		</div>
	</div>
</template>
<script setup></script>
<style scoped>
@import url("http://fonts.googleapis.com/css2?family=Raleway&display=swap");

@media (max-width: 600px) {
	.banner-content {
		top: 5% !important;
	}

	.banner-image {
		height: 1000px !important;
	}
	.banner-title {
		font-size: 30px !important;
	}
}

@media (min-width: 601px) and (max-width: 1263px) {
	.banner-image {
		height: 1000px !important;
	}
	.banner-content {
		top: 6% !important;
	}

	.banner-title {
		font-size: 50px !important;
	}
}

.banner-image {
	filter: grayscale(0.25) brightness(0.75);
	height: 800px;
}

.banner-content {
	width: 100vw;
	position: absolute;
	top: 10%;
}

.banner-title {
	text-align: center;
	color: #fff;
	font-size: 70px;
	line-height: 1.5;
	font-family: "Raleway", Arial, sans-serif;
	font-weight: 400;
	text-transform: uppercase;
	margin: 0px 20px 0px 20px;
}

.banner-subtitle {
	text-align: center;
	color: #fff;
	font-size: 20px;
	line-height: 1.5;
	font-family: "Raleway", Arial, sans-serif;
	font-weight: 400;
	text-transform: uppercase;
	margin: 0px 20px 30px 20px;
}

.banner-btns {
	gap: 40px;
	margin: 0px 20px 0 20px;
	flex-wrap: wrap;
	justify-content: center;
}

.banner-button {
	text-transform: none !important;
	font-size: 16px;
	width: 180px;
	height: 60px !important;
	color: #ffffffb3;
	font-weight: bold;
	font-family: "Raleway", Arial, sans-serif;

	/*Se aplicado direto, ele funciona na ida e volta :)*/
	transition:
		color 0.5s,
		background-color 0.5s;
}

.banner-button-border {
	border: 2px solid white !important;
}

.banner-button-border:hover {
	color: #000000 !important;
	background-color: #fff !important;
}
</style>
