<template>
	<v-container fluid class="worktype-wrapper d-flex justify-center">
		<div class="worktype-div">
			<v-row class="worktype-row" align-center>
				<v-col
					v-for="(item, index) in typesLearn"
					:key="index"
					cols="12"
					md="4"
					class="worktype-item raleway d-flex flex-column align-center justify-center"
				>
					<v-avatar size="90" color="#efefef">
						<v-icon size="50" color="deep-purple darken-2">
							{{ item.icon }}
						</v-icon>
					</v-avatar>
					<span class="worktype-title">{{ item.name }}</span>
					<span class="worktype-description">{{ item.text }}</span>
					<v-btn
						class="worktype-btn banner-button-border"
						depressed
						text
						color="deep-purple darken-2"
						outlined
					>
						Learn More
					</v-btn>
				</v-col>
			</v-row>
		</div>
	</v-container>
</template>
<script setup>
const typesLearn = [
	{
		name: "Bom de vista",
		text: "Arco País de Wano (ワノ国編 Wano Kuni Hen?) é o trigésimo primeiro arco de One Piece",
		icon: "mdi-eye-circle-outline",
	},
	{
		name: "Responsividade",
		text: "Gear 5 is the awakened form of the Gomu Gomu no Mi, which strengthens the user's rubbery body.",
		icon: "mdi-palette-swatch",
	},
	{
		name: "Começo de Site Web",
		text: "The awakening of the Gomu Gomu no Mi, formerly known as the Hito Hito no Mi, Model: Nika",
		icon: "mdi-power",
	},
]
</script>
<style scoped>
.worktype-wrapper {
	background-color: #fdfdfd;
}

.worktype-div {
	width: 80vw;
	max-width: 1200px;
}

.worktype-row {
	margin: 100px 0px;
	row-gap: 80px;
}

.worktype-item {
	gap: 30px;
}

.worktype-title {
	font-size: 20px;
	text-transform: uppercase;
	color: #5d5d5d;
	text-align: center;
}

.worktype-description {
	font-size: 16px;
	color: #828282;
	text-align: center;
	margin-left: 1vw;
	margin-right: 1vw;
}

.worktype-btn {
	border: 2px solid;
	text-transform: capitalize;
	width: 150px !important;
	height: 40px !important;
}

.banner-button-border {
	border: 2px solid #4527a0 !important;
	transition:
		color 0.5s,
		background-color 0.5s;
}

.banner-button-border:hover {
	color: #fff !important;
	background-color: #4527a0 !important;
}
</style>
