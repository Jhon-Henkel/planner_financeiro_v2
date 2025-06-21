<script setup lang="ts">
import {computed} from 'vue'
import {useTheme} from "~/composables/theme/use.theme";
import {IconEnum} from "~/utils/enum/icon.enum";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    modelValue: {
        type: Boolean,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits<{
    (e: 'update:modelValue', value: boolean): void
}>()

const model = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
})

const {currentTheme} = useTheme()
</script>

<template>
    <div class="flex items-center">
        <USwitch
            v-model="model"
            :unchecked-icon="IconEnum.x"
            :checked-icon="IconEnum.check"
            default-value
            :label="label"
            :color="currentTheme.primaryColorRoot"
            :disabled="disabled"
        />
    </div>
</template>
