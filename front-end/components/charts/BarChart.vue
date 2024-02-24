<template>
	<Bar :options="chartOptions" :data="chartData" />
</template>

<script>
import { Bar } from "vue-chartjs"
import {
	Chart as ChartJS,
	Title,
	Tooltip,
	Legend,
	BarElement,
	CategoryScale,
	LinearScale,
} from "chart.js"

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
	name: "BarChart",
	components: { Bar },
	data() {
		return {
			chartData: {
				labels: ["January", "February", "March"],
				datasets: [
					{
						label: "Erro",
						backgroundColor: "#f87979",
						data: [40, 20, 20],
					},
					{
						label: "Sucesso",
						backgroundColor: "#3cba9f",
						data: [40, 50, 30],
					},
				],
			},
			chartOptions: {
				responsive: true,
			},
		}
	},
}
</script>
