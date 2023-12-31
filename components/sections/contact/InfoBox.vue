<template>
	<v-container fluid class="contact-info-wrapper">
		<v-row>
			<v-col cols="12" md="12" lg="8">
				<VForms />
			</v-col>
			<v-col cols="12" md="12" lg="4">
				<DataInfo />
			</v-col>
		</v-row>
	</v-container>
</template>
<script setup>
import VForms from "./VForms.vue";
import DataInfo from "./DataInfo.vue";
</script>
<style scoped>
.contact-info-wrapper {
	max-width: 1300px;
	width: 90vw;
	padding: 100px 0;
}
</style>
