<template>
	<v-container>
		<h1>teste</h1>
	</v-container>
</template>

<script setup>
definePageMeta({
	layout: "dashboard",
	middleware: ["guest", "admin"],
})
</script>

<style scoped></style>
