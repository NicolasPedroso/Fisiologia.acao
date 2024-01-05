<template>
	<v-container fluid class="testimony-wrapper">
		<div class="testimony-header d-flex justify-center">
			<span class="testimony-title">Depoimentos</span>
		</div>
		<v-carousel
			hide-delimiter-background
			delimiter-icon="mdi-checkbox-blank-circle-outline"
			cycle
			continuous
			:show-arrows="false"
			height="300px"
			class="testtimony-carousel"
		>
			<v-carousel-item v-for="(item, index) in testimonies" :key="index">
				<div
					class="testimony-carousel-item d-flex flex-column justify-center align-center"
				>
					<v-avatar size="90">
						<v-img :alt="item.name" :src="item.image" />
					</v-avatar>

					<div class="testimony-apresentation py-4">
						<span> {{ item.name }}, via </span>
						<span class="testimony-apresentation-ocupation">
							{{ item.from }}
						</span>
					</div>

					<span class="testimony-text">
						{{ item.text }}
					</span>
				</div>
			</v-carousel-item>
		</v-carousel>
	</v-container>
</template>
<script setup>
defineProps({
	testimonies: {
		type: Array,
		required: true,
	},
})
</script>
<style scoped>
@import url("http://fonts.googleapis.com/css2?family=Raleway&display=swap");

.testimony-wrapper {
	background-color: #efefef;
}

.testimony-header {
	padding: 60px 0;
}

.testimony-title {
	font-size: 36px;
	margin-bottom: 10px;
	line-height: 1.5;
	font-weight: bold;
	font-family: "Raleway", sans-serif;
}
.testimony-apresentation {
	font-size: 12px;
	text-transform: uppercase;
	letter-spacing: 2px;
	font-weight: 700;
	font-family: "Raleway", Arial, sans-serif;
	margin-bottom: 10px;
}

.testtimony-carousel:deep(.v-btn--active) {
	color: #6a1b9a !important;
}

.testtimony-carousel:deep(.v-btn--icon) {
	color: #6a1b9a !important;
}

.testimony-apresentation-ocupation {
	color: #6a1b9a;
}

.testimony-text {
	text-align: center;
	font-size: 17px;
	font-family: "Raleway", Arial, sans-serif;
	color: #828282;
	max-width: 800px;
}
</style>
