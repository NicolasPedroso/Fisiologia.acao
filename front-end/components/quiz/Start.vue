<template>
	<v-container
		fluid
		class="d-flex align-center justify-center"
		width="100%"
		height="100%"
	>
		<div class="quiz__card__wrapper align-center d-none d-md-flex">
			<v-card
				class="quiz__card d-flex flex-column align-center pa-4"
				min-width="264"
				width="min-content"
				elevation="4"
			>
				<span class="mb-6 text-caption"> FISIOLOGIA EM AÇÃO </span>
				<v-img
					:src="image"
					class="quiz__card__image"
					width="100%"
					min-width="280"
					cover
					height="200"
					alt=""
					style="border-radius: 8px"
				/>
				<div
					class="d-flex flex-column align-start mt-2"
					style="width: 100%"
				>
					<h2 class="quiz__card__title">
						{{ title }}
					</h2>
					<strong
						class="quiz__card__subtitle text-subtitle-2"
						style="margin-top: -8px"
					>
						{{ themeTitle }} - {{ quantity }} questões
					</strong>
					<span
						class="quiz__card__text text-body-2 mt-2"
						style="max-width: 360px"
					>
						{{ description.split(" ").slice(0, 24).join(" ") }}...
					</span>
				</div>
				<div>
					<v-img
						src="/layout/logoEmblem.svg"
						width="24"
						height="24"
						class="mt-6"
					/>
				</div>
			</v-card>
		</div>
		<div class="quiz__content d-flex flex-column" style="max-width: 480px">
			<h1>{{ title }}</h1>
			<h3>Tema: {{ themeTitle }}</h3>
			<p class="mt-4">{{ description }}</p>
			<v-btn class="start-btn mt-5" elevation="0" @click="startVideo()">
				<span class="start-btn__text"> Iniciar Quiz </span>
			</v-btn>
		</div>
	</v-container>
</template>
<script setup>
// Emit para iniciar o quiz
const emit = defineEmits(["startVideo"])
function startVideo() {
	emit("startVideo", 2)
}

defineProps({
	title: {
		type: String,
		default: "Iniciar Quiz",
	},
	image: {
		type: String,
		default: "/layout/profile.jpeg",
	},
	description: {
		type: String,
		default:
			"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
	},
	quantity: {
		type: Number,
		default: 10,
	},
	themeTitle: {
		type: String,
		default: "Tema",
	},
})
</script>
<style scoped>
.quiz__card__wrapper {
	padding: 32px 64px;
}
.quiz__card {
	transform: rotate(-8deg);
	border-radius: 16px;
}

.start-btn {
	width: 100%;
	font-size: 1.5rem;
	line-height: 0;
	font-weight: 600;
	background-color: var(--secondary-color);
	color: #ffffff;
	transition: background-color 1s ease;
	padding: 20px 0;

	display: flex;
	justify-content: center;
	align-items: center;
}

.start-btn:hover {
	background-color: var(--primary-color);
}

.start-btn__text {
	font-size: 1.2rem;
	line-height: 1.2rem;
	letter-spacing: 0.05rem;
	text-transform: none;
	font-weight: 600;
}
</style>
