<template>
	<v-app full-height>
		<Navbar />
		<NuxtPage></NuxtPage>
		<Subscribe />
		<Footer />
	</v-app>
</template>

<script setup>
import Footer from "~/components/sections/layout/Footer.vue";
import Subscribe from "~/components/sections/layout/Subscribe.vue";
import Navbar from "~/components/sections/layout/Navbar.vue";
</script>
