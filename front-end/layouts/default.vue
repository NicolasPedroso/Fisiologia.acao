<template>
	<v-app style="overflow-x: hidden !important">
		<NuxtSnackbar />
		<Navbar />
		<NuxtPage />
		<!-- <Subscribe /> -->
		<ButtonTop />
		<Footer />
	</v-app>
</template>

<script setup>
import Navbar from "~/components/sections/layout/Navbar.vue"
// import Subscribe from "~/components/sections/layout/Subscribe.vue";
import ButtonTop from "~/components/sections/layout/ButtonTop.vue"
import Footer from "~/components/sections/layout/Footer.vue"
</script>
