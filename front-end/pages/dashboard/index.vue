<template>
	<v-container
		fluid
		style="height: 100%"
		class="d-flex flex-column justify-center align-center text-center"
	>
		<h1>Introduction text...</h1>
		<p>t.b.a.</p>
	</v-container>
</template>
<script setup>
definePageMeta({
	layout: "dashboard",
	middleware: ["guest", "admin"],
})
</script>
