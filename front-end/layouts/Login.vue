<template>
	<v-app style="overflow-x: hidden !important">
		<div class="title-container">
			<span class="title">Fisiologia em ação</span>
		</div>
		<v-main fluid class="d-flex justify-center align-center">
			<NuxtPage />
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
	background-color: var(--primary-color);

	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 60px;
	font-weight: 500;
	color: #ffffff;
	text-align: center;
	height: 125px;
	width: 100vw;
}

.title {
	font-family: Kode Mono;
	font-weight: 500;
	font-size: 76px;
	line-height: 122.88px;
	letter-spacing: -5px;
	text-shadow: 6px 2px 4px rgba(0, 0, 0, 0.5);
}

@media (max-width: 959px) {
	.title {
		font-size: clamp(32px, 8vw, 60px) !important;
		letter-spacing: -4px;
	}
}

@media (max-width: 600px) {
	.auth-card {
		height: 50rem;
	}
}
</style>
