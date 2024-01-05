<template>
	<div
		class="data-wrapper ml-lg-16 d-flex flex-column align-center align-lg-start"
	>
		<span class="data-title">USA Office</span>
		<div
			v-for="(item, index) in dataInfos"
			:key="index"
			class="d-flex flex-row align-center"
		>
			<v-col cols="auto">
				<v-icon size="30">
					{{ item.icon }}
				</v-icon>
			</v-col>
			<v-col cols="auto">
				<span :class="item.class">
					{{ item.text }}
					<br />
					{{ item.text2 }}
				</span>
			</v-col>
		</div>
		<!--Australia-->
		<span class="data-title">Australia Office</span>
		<div
			v-for="(item, index) in dataInfos"
			:key="index"
			class="d-flex flex-row align-center"
		>
			<v-col cols="auto">
				<v-icon size="30">
					{{ item.icon }}
				</v-icon>
			</v-col>
			<v-col cols="auto">
				<span :class="item.class">
					{{ item.text }}
					<br />
					{{ item.text2 }}
				</span>
			</v-col>
		</div>
	</div>
</template>
<script setup>
// Variables
const dataInfos = [
	{
		text: "198 West 21th Street,",
		text2: "Suite 721 New York NY 10016",
		icon: "mdi-map-marker",
		class: "data-text-grey",
	},
	{
		text: "+ 1235 2355 98",
		icon: "mdi-phone",
		class: "data-text-green",
	},
	{
		text: "info@yoursite.com",
		icon: "mdi-email-outline",
		class: "data-text-green",
	},
	{
		text: "FreeHTML5.co",
		icon: "mdi-earth",
		class: "data-text-green",
	},
];
</script>
<style scoped>
.data-title {
	margin-top: 20px;
	font-family: Raleway;
	font-size: 25px;
}

.data-text-grey {
	font-family: Raleway;
	font-size: 18px;
	color: #878787;
	text-align: center;
}

.data-text-green {
	font-family: Raleway;
	font-size: 18px;
	color: #4527a0;
}
</style>
