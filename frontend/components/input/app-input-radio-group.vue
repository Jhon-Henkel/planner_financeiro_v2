<script setup lang="ts">
import {useTheme} from "~/composables/theme/use.theme";
import {computed} from "vue";

const props = defineProps({
    items: {
        type: Array<{id: number, label: string}>,
        required: true,
    },
    modelValue: {
        type: Number,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    orientation: {
        type: String as PropType<"horizontal" | "vertical">,
        default: 'horizontal',
        required: false,
    },
    disabled: {
        type: Boolean,
        default: false,
        required: false,
    }
})

const emit = defineEmits<{
    (e: 'update:modelValue', value: number): void
}>()

const model = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
})

const { currentTheme } = useTheme()
</script>

<template>
    <URadioGroup
        v-model="model"
        :legend="label"
        value-key="id"
        :color="currentTheme.primaryColorRoot"
        :items="items"
        :orientation="orientation"
        :disabled="disabled"
        :ui="{
            label: 'cursor-pointer',
            base: 'cursor-pointer'
        }"
    />
</template>
