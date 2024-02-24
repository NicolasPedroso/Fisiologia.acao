<template>
	<div>
		<v-parallax
			alt="Parralax de folhas"
			height="600"
			class="banner-image"
			src="/imagens/banner.png"
		/>
		<div
			class="banner-content d-flex justify-center align-center flex-column"
		>
			<span class="banner-title">
				{{ title }}
			</span>
		</div>
	</div>
</template>
<script setup>
defineProps({
	title: {
		type: String,
		required: true,
	},
})
</script>
<style scoped>
@import url("http://fonts.googleapis.com/css2?family=Raleway&display=swap");

.banner-image {
	filter: grayscale(0.25) brightness(0.75);
	position: absolute;
	width: 100vw;
	z-index: 5;
}

.banner-content {
	width: 100vw;
	height: 600px;
	z-index: 6;
}

.banner-title {
	text-align: center;
	color: #eec9ff94;
	font-size: calc(4vw + 50px);
	line-height: 1.5;
	font-family: "FZNDGrana", Arial, sans-serif;
	font-weight: 400;
	text-transform: uppercase;
	margin: 0px 20px 0px 20px;
	z-index: 7;
}
</style>
