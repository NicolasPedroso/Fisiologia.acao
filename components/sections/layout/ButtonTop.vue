<template>
	<v-btn
		variant="tonal"
		icon="mdi-chevron-up"
		size="50px"
		color="#4527A0"
		@click.stop="scrollToTop"
		position="fixed"
		class="button"
	>
	</v-btn>
</template>
<script setup>
function scrollToTop() {
	window.scrollTo({
		top: 0,
		behavior: "smooth",
	});
}
</script>
<style scoped>
.button {
	bottom: 20px;
	right: 20px;
	z-index: 999;
}
</style>
