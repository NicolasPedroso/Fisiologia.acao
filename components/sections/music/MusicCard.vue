import type { SectionsMusicCard } from '#build/components';
<template>
	<v-card
		color="#121212"
		theme="dark"
		width="75%"
		min-width="300px"
		class="card--music"
	>
		<div
			class="d-flex flex-column align-center justify-space-between pa-10 pb-12"
		>
			<div>
				<v-card-title class="text-h5 text-center mx-2">
					{{ music.title }}
				</v-card-title>
				<v-card-subtitle class="text-center">
					{{ music.artist }}
				</v-card-subtitle>
			</div>
			<v-avatar class="mt-6 mb-3" size="125" rounded="0">
				<v-img :src="music.image" />
			</v-avatar>
			<v-progress-linear
				:model-value="music.percentage"
				:color="music.color"
				buffer-value="0"
				class="mt-4"
				stream
			></v-progress-linear>
			<v-row class="d-flex align-center mt-5">
				<v-icon size="30" color="#303030"> mdi-skip-backward </v-icon>
				<v-btn icon size="55" class="mx-1">
					<v-icon size="50" class="mx-3" color="#4d4d4d">
						mdi-pause-circle-outline
					</v-icon>
				</v-btn>
				<v-icon size="30" color="#303030"> mdi-skip-forward </v-icon>
			</v-row>
		</div>
	</v-card>
</template>
<script setup>
defineProps({
	music: {
		type: Object,
		required: true,
	},
});
</script>
<style scoped>
.card--music {
	border-radius: 20px;
	border: 1px solid v-bind("music.color");
}
</style>
