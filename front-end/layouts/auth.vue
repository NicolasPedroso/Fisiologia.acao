<template>
	<NuxtSnackbar />
	<v-app full-height>
		<v-main fluid class="auth-wrapper d-flex justify-center align-center">
			<v-card
				min-width="300px"
				width="90vw"
				max-width="600px"
				color="rgba(255, 255, 255, 0.9)"
				class="auth-card pa-4 pa-sm-10"
			>
				<NuxtPage />
			</v-card>
		</v-main>
	</v-app>
</template>
<script setup></script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap");
.auth-wrapper {
	background: url("/imagens/banner.jpeg") no-repeat center center fixed;
	filter: grayscale(50%);
	background-size: cover;
}

.auth-card {
	border-radius: 25px;
}
</style>
