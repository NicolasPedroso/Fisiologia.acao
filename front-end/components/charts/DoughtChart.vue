<template>
	<Doughnut :data="data" :options="options" />
</template>

<script setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js"
import { Doughnut } from "vue-chartjs"

ChartJS.register(ArcElement, Tooltip, Legend)

const data = {
	labels: ["VueJs", "EmberJs", "ReactJs", "AngularJs"],
	datasets: [
		{
			backgroundColor: ["#41B883", "#E46651", "#00D8FF", "#DD1B16"],
			data: [40, 20, 80, 10],
		},
	],
}

const options = {
	responsive: true,
}
</script>
