<template>
	<v-container fluid class="subscribe-wrapper">
		<div
			class="subscribe-content raleway d-flex flex-column justify-center align-center"
		>
			<span class="subscribe-title">Subscribe</span>
			<span class="subscribe-description">
				Seja o primeiro a saber dos meus trabalhos.
			</span>
			<form
				class="subscribe-button-section d-flex justify-center flex-column flex-md-row"
			>
				<input
					id="subcribe-email"
					class="subscribe-your"
					type="email"
					name="Your Email"
					placeholder="Your Email"
				/>
				<input
					id="subcribe-name"
					class="subscribe-your"
					type="text"
					name="Your Name"
					placeholder="Your name"
				/>
				<input
					id="subcribe-submit"
					class="subscribe-your-submit"
					type="submit"
					value="Subscribe"
					disabled
				/>
			</form>
		</div>
	</v-container>
</template>
<script setup></script>
<style scoped>
.subscribe-wrapper {
	background-color: #333333;
}

.subscribe-title {
	color: #fff;
	font-size: 36px;
	line-height: 1.5;
	font-weight: bold;

	margin-top: 100px;
}

.subscribe-description {
	font-size: 18px;
	line-height: 1.5;
	color: #828282;
	text-align: center;
}

.subscribe-button-section {
	margin-top: 50px;
	margin-bottom: 100px;
	gap: 30px;
	width: 70vw;
}

.subscribe-your {
	padding: 15px 10vw 15px 15px;
	border-radius: 5px;
	background-color: rgba(255, 255, 255, 0.2);
	color: #fff;
	font-weight: 500;
	outline: none;
	border: 2px solid transparent;

	transition: 0.5s;
}

.subscribe-your:focus-visible {
	background-color: transparent;
	border: 2px solid #ffffff;
}

.subscribe-your-submit {
	padding: 15px 8vw 15px 8vw;
	border-radius: 5px;
	background-color: #04aa6d;
	color: #fff;
	font-weight: 800;
	text-transform: uppercase;
	border: 2px solid transparent;
}
</style>
