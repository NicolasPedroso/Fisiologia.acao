<template>
	<v-dialog v-model="dialog" max-width="500px" persistent scrim="true">
		<v-card
			class="colored-border-card"
			:style="{ borderColor: borderColor }"
		>
			<div class="d-flex align-center flex-column">
				<v-avatar :color="color" size="64" class="icon-avatar">
					<v-icon :color="white" size="32">{{ icon }}</v-icon>
				</v-avatar>
				<strong class="text-h6 mt-9">
					<strong>{{ title }}</strong>
				</strong>
			</div>

			<p class="text-body-1 text-center my-4">
				{{ text }}
			</p>

			<v-card-actions>
				<v-spacer />
				<v-btn
					:text="cancelText"
					variant="text"
					@click="onCancel"
					style="
						text-transform: none;
						font-weight: 600;
						letter-spacing: 0;
					"
				/>
				<v-btn
					:color="color"
					:text="confirmText"
					:loading="loading"
					variant="flat"
					@click="onConfirm"
					class="px-6"
					style="
						text-transform: none;
						font-weight: 600;
						letter-spacing: 0;
					"
				/>
				<v-spacer />
			</v-card-actions>
		</v-card>
	</v-dialog>
</template>

<script setup>
import { computed } from "vue"

// --- Props ---
// Definimos as "entradas" do nosso componente, o que o torna customizável.
const props = defineProps({
	// Controla a visibilidade do popup (usado com v-model)
	modelValue: {
		type: Boolean,
		default: false,
	},
	// Título do popup
	title: {
		type: String,
		required: true,
		default: "",
	},
	// Texto principal do popup
	text: {
		type: String,
		required: true,
		default: "",
	},
	// Ícone a ser exibido (ex: 'mdi-check-circle')
	icon: {
		type: String,
		default: "mdi-information",
	},
	// Cor principal para a borda, ícone e botão de confirmação
	color: {
		type: String,
		default: "blue",
	},
	// Texto do botão de confirmação
	confirmText: {
		type: String,
		default: "Confirmar",
	},
	// Texto do botão de cancelar
	cancelText: {
		type: String,
		default: "Cancelar",
	},
	// Estado de loading para o botão de confirmação
	loading: {
		type: Boolean,
		default: false,
	},
})

// --- Events ---
const emit = defineEmits(["update:modelValue", "confirm", "cancel"])

// --- Computed ---
const dialog = computed({
	get: () => props.modelValue,
	set: (value) => emit("update:modelValue", value),
})

// Passa a cor da prop para a variável CSS que usamos no <style>
const borderColor = computed(() => props.color)

// --- Methods ---
function onConfirm() {
	emit("confirm")
}

function onCancel() {
	emit("cancel")
	dialog.value = false
}
</script>

<style scoped>
.colored-border-card {
	/* A mágica da borda colorida acontece aqui */
	border-top-width: 6px;
	border-top-style: solid;
	overflow: visible !important;
	border-radius: 16px !important;
	padding: 8px;
}

.icon-avatar {
	position: absolute;
	top: -32px;
}
</style>
