<script setup lang="ts">
import { computed } from 'vue'
import {useTheme} from "~/composables/theme/use.theme";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    modelValue: {
        type: [Number, null],
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
    required: {
        type: Boolean,
        default: false,
    },
    description: {
        type: String,
        default: '',
    }
})

const emit = defineEmits<{
    (e: 'update:modelValue', value: number|null): void
}>()

const model = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
})

const { currentTheme } = useTheme()

const onWheel = (event: WheelEvent) => {
    (event.target as HTMLElement).blur();
};

</script>

<template>
    <UFormField :name="name" :label="label" :required="required" :description="description">
        <UInputNumber
            v-model="model"
            :step="0.01"
            :min="0"
            :max="100"
            :class="[cssClass]"
            :placeholder="placeholder"
            :disabled="disabled"
            :color="currentTheme.primaryColorRoot"
            :format-options="{
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }"
            orientation="vertical"
            @wheel.prevent="onWheel"
        />
    </UFormField>
</template>
