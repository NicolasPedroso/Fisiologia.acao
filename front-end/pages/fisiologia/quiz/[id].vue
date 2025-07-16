<template>
	<v-container fluid> Quiz de {{ $route.params.id }} </v-container>
</template>
<script setup>
const quiz = {
	title: "Quiz 1",
	image: "/layout/profile.jpeg",
	dificulty: 0,
	status: "Completo",
	quantity: 10,
	theme: { title: "Tema 1", icon: "mdi-cat" },
	link: "/fisiologia/quiz/1",
}

definePageMeta({
	middleware: ["guest", "id-check"],
})

const route = useRoute()
useSeoMeta({
	title: "Quiz " + route.params.id,
	description: "",
	keywords: "",
})
</script>
<style scoped></style>
