<template>
	<v-card
		:to="`/fisiologia/quiz/${quiz.id}`"
		:disabled="blocked"
		class="theme-card__wrapper d-flex flex-column pa-1"
	>
		<div
			:class="{
				'theme-card__blocked_blur': blocked,
			}"
		>
			<v-img
				:src="formatImage(quiz.image)"
				class="theme-card__image"
				height="200"
				width="100%"
				cover
			></v-img>
			<div class="pa-2">
				<h3>
					{{ quiz.title }}
					<span v-if="quiz.user_status === 'Completo'">
						- Completo
					</span>
				</h3>
				<p class="text-caption">
					{{ quiz.description }}
				</p>
			</div>
		</div>

		<div
			v-if="blocked"
			class="theme-card__blocked d-flex flex-column align-center justify-center pa-2"
		>
			<v-icon>mdi-lock</v-icon>
			<span> Finalize um quiz da dificuldade anterior </span>
		</div>
	</v-card>
</template>
<script setup>
defineProps({
	quiz: {
		type: Object,
		required: true,
		default: () => ({
			title: "Quiz",
			image: "/layout/profile.jpeg",
			dificulty: 1,
			status: "Não iniciado",
			quantity: 8,
			theme: { title: "Tema 1", icon: "mdi-cat" },
			link: "/fisiologia/quiz/1",
		}),
	},
	blocked: {
		type: Boolean,
		default: true,
	},
})
</script>
<style scoped>
.theme-card__wrapper {
	background-color: var(--white);
	color: var(--text-color);
	padding: 16px;
	border-radius: 8px;
	text-align: left;
	box-shadow: 0 0px 4px rgba(0, 0, 0, 0.25);

	width: 100%;
	height: 100%;
	min-height: 200px;
	position: relative;
	overflow: hidden;
	transition: transform 0.3s ease;
}

.theme-card__wrapper:hover {
	transform: scale(1.05);
}

.theme-card__image {
	border-radius: 8px;
}

.theme-card__blocked {
	position: absolute;
	top: 4px;
	left: 4px;
	width: calc(100% - 8px);
	height: calc(100% - 8px);
	border-radius: 4px;

	background: rgba(0, 0, 0, 0.8);
	color: #fff;
}

.theme-card__blocked span {
	font-size: 1.5rem;
	text-align: center;
	line-height: 1.5rem;
	margin-top: 4px;
	font-weight: 800;
}

.theme-card__blocked_blur {
	filter: blur(16px);
}
</style>
