<template>
	<v-app full-height>
		<v-main fluid class="auth-wrapper d-flex justify-center align-center">
			<v-card
				min-width="300px"
				width="90vw"
				max-width="600px"
				class="rounded-xl pa-4 pa-sm-10"
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
	background: url("/images/auth/background.jpeg") no-repeat center center
		fixed;
}
</style>
