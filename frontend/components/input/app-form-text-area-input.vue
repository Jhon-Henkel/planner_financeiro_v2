<script setup lang="ts">
import { computed } from 'vue'
import {useTheme} from "~/composables/theme/use.theme";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    modelValue: {
        type: [String, null],
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        default: '',
    },
    cssClass: {
        type: String,
        default: '',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits<{
    (e: 'update:modelValue', value: string|null): void
}>()

const model = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
})

const { currentTheme } = useTheme()
</script>

<template>
    <UFormField :name="name" :label="label">
        <UTextarea
            v-model="model"
            :placeholder="placeholder"
            :class="[cssClass]"
            :color="currentTheme.primaryColorRoot"
            :disabled="disabled"
        />
    </UFormField>
</template>
