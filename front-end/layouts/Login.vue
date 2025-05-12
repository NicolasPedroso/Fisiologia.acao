<template>
	<v-app style="overflow-x: hidden !important">
		<v-row>
			<v-col cols="12" md="6" class="pa-0 ma-0">
				<v-img
					width="100%"
					height="100%"
					src="/login/image.png"
					class="gradient"
					cover
					alt=""
				/>
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

.gradient :deep(.v-img__img) {
	filter: brightness(0.6);
}

.main__content {
	background: white;
	background-image: radial-gradient(rgba(0, 0, 0, 0.25) 1px, transparent 0);
	background-size: 20px 20px;
	background-position: -16px -16px;

	width: 100%;
	height: 100%;
}
</style>
