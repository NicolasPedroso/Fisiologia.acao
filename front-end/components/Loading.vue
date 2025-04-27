<template>
	<Transition>
		<div v-if="status === 'pending'" class="loading-wrapper">
			<div class="loader"></div>
		</div>
	</Transition>
</template>
<script setup>
defineProps({
	status: String,
})
</script>
<style lang="css" scoped>
/* Transicao */
.v-enter-active,
.v-leave-active {
	transition: opacity 1s ease;
}

.v-enter-from,
.v-leave-to {
	opacity: 0;
}

/* CSS */
@keyframes bg {
	0% {
		background-position: 0% 0%;
	}
	50% {
		background-position: 50% 50%;
	}
	100% {
		background-position: 0% 0%;
	}
}

.loading-wrapper {
	position: fixed;
	width: 100vw;
	height: 100vh;
	display: flex;
	justify-content: center;
	align-items: center;
	background: var(--primary-color);
	background: linear-gradient(
		0deg,
		var(--primary-color) 0%,
		var(--secondary-color) 100%
	);
	background-size: 400% 400%;
	animation: bg 10s infinite;
	pointer-events: none;
}

.loader {
	width: fit-content;
	font-size: 11vw;
	letter-spacing: -5px;
	font-family: sans-serif;
	font-weight: bold;
	text-transform: uppercase;
	color: #ffffff00;
	-webkit-text-stroke: 1px #ffffff;
	background:
		radial-gradient(0.71em at 50% 1em, #ffffff 99%, #ffffff00 101%)
			calc(50% - 1em) 1em/2em 200% repeat-x text,
		radial-gradient(0.71em at 50% -0.5em, #ffffff00 99%, #ffffff 101%) 50%
			1.5em/2em 200% repeat-x text;
	animation:
		l10-0 0.8s linear infinite alternate,
		l10-1 4s linear infinite alternate;
	mix-blend-mode: overlay;
}
.loader:before {
	content: "Carregando...";
}
@keyframes l10-0 {
	to {
		background-position-x: 50%, calc(50% + 1em);
	}
}
@keyframes l10-1 {
	to {
		background-position-y: -0.5em, 0;
	}
}
</style>
