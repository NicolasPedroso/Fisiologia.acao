<template>
	<v-container>
		<div class="my-5">
			<span class="contact-title raleway"> Get In Touch </span>
			<v-form v-model="valid" @submit.prevent class="mt-5">
				<v-row>
					<v-col cols="12" md="6" lg="6">
						<span class="forms-title">First Name</span>
						<v-text-field
							v-model="message.firstName"
							:rules="rules.firstName"
							class="mt-2"
							placeholder="Seu primeiro nome"
							variant="outlined"
							clearable
							single-line
							color="#04aa6d"
						/>
					</v-col>
					<v-col cols="12" md="6" lg="6">
						<span class="forms-title">Last Name</span>
						<v-text-field
							v-model="message.lastName"
							:rules="rules.lastName"
							class="mt-2"
							placeholder="Seu último nome"
							variant="outlined"
							clearable
							single-line
							color="#04aa6d"
						/>
					</v-col>
				</v-row>
				<div class="forms-content-extra mt-3">
					<span class="forms-title">Email</span>
					<v-text-field
						v-model="message.email"
						:rules="rules.email"
						class="mt-2"
						placeholder="Seu email de contato"
						variant="outlined"
						clearable
						single-line
						color="#04aa6d"
					/>
				</div>
				<div class="forms-content mt-3">
					<span class="forms-title">Subject</span>
					<v-text-field
						v-model="message.subject"
						:rules="rules.subject"
						class="mt-2"
						placeholder="Sobre o que quer conversar?"
						variant="outlined"
						clearable
						single-line
						color="#04aa6d"
					/>
				</div>
				<div class="forms-content mt-3">
					<span class="forms-title">Message</span>
					<ClientOnly>
						<v-textarea
							v-model="message.content"
							:rules="rules.content"
							class="mt-2"
							placeholder="Sua mensagem"
							variant="outlined"
							clearable
							auto-grow
							color="#04aa6d"
							density="comfortable"
						/>
					</ClientOnly>
				</div>
				<v-btn
					width="180"
					height="45"
					color="#04aa6d"
					class="form-button mt-3"
					type="submit"
					@click="sendMessage"
				>
					Send Message
				</v-btn>
			</v-form>
		</div>
	</v-container>
</template>
<script setup>
const URLBase = "http://localhost:8000/forms";
const valid = ref(false);
const message = ref({
	firstName: "",
	lastName: "",
	email: "",
	subject: "",
	content: "",
});
const rules = {
	firstName: [(v) => !!v || "Primeiro nome é obrigatório!"],
	lastName: [(v) => !!v || "Último nome é obrigatório!"],
	email: [
		(v) => !!v || "O e-mail é obrigatório!",
		(v) =>
			/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/.test(
				v
			) || "E-mail inválido",
	],
	subject: [(v) => !!v || "Assunto é obrigatório!"],
	content: [(v) => !!v || "Mensagem é obrigatória!"],
};

async function sendMessage() {
	if (!valid.value) return;

	// Envia para o backend
	await $fetch(`${URLBase}`, {
		method: "POST",
		body: message.value,
	}).catch((error) => {
		console.error(`Erro: ${error}`);
	});
}
</script>
<style scoped>
.contact-title {
	font-size: 25px;
}

.forms-title {
	font-family: "Raleway";
	color: #9b9b9b;
	font-size: 18px;
}

.forms-content-extra {
	width: 100%;
	margin-top: -15px;
}

.forms-content {
	width: 100%;
	margin-top: -5px;
}

.form-button {
	font-family: Raleway;
	font-weight: 400;
	font-size: 16px;
	text-transform: capitalize;
}
</style>
