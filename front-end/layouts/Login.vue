<template>
	<v-app full-height>
		<div class="title-container">
			<span class="title">Conecte-se ao Endogames</span>
		</div>
		<v-main fluid class="d-flex justify-center align-center">
			<v-card
				min-width="300px"
				width="90vw"
				max-width="900px"
				class="auth-card rounded-xl pa-2 px-8 pa-sm-10 mt-9"
			>
				<NuxtPage />
			</v-card>
		</v-main>
	</v-app>
</template>
<script setup></script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400;700&display=swap");

.auth-card {
	box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
}

.title-container {
	background-color: #1356d3;
	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 96px;
	font-weight: 500;
	color: #ffffff;
	text-align: center;
	height: 25vh;
	width: 100vw;
}

.title {
	font-family: Kode Mono;
	font-weight: 500;
	font-size: 76px;
	line-height: 122.88px;
	letter-spacing: 0%;
	text-shadow: 6px 2px 4px rgba(0, 0, 0, 0.5);
}

@media (max-width: 900px) {
	.title {
		font-size: 60px;
		text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
	}
}

@media (max-width: 600px) {
	.auth-card {
		height: 50rem;
	}
}
</style>
