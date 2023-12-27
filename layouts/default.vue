<template>
	<v-app full-height>
		<NuxtPage></NuxtPage>
		<Subscribe />
		<Footer />
	</v-app>
</template>

<script setup>
import Footer from "~/components/sections/layout/Footer.vue";
import Subscribe from "~/components/sections/layout/Subscribe.vue";
</script>
