<script setup lang="ts">
import { computed } from 'vue'
import {useTheme} from "~/composables/theme/use.theme";
import {StringUtil} from "~/utils/string/string.util";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    modelValue: {
        type: String,
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
    type: {
        type: String,
        default: 'text',
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
    },
    full: {
        type: Boolean,
        default: true,
    }
})

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void
}>()

const model = computed({
    get: () => props.modelValue,
    set: (value) => {
        value = props.type == 'text' ? StringUtil.capitalizeFirstLetters(value) : value
        emit('update:modelValue', value)
    },
})

const { currentTheme } = useTheme()
</script>

<template>
    <UFormField :name="name" :label="label" :required="required" :description="description">
        <UInput
            v-model="model"
            :placeholder="placeholder"
            :type="type"
            :class="[cssClass, (full ? 'w-full' : '')]"
            :color="currentTheme.primaryColorRoot"
            :disabled="disabled"
            :ui="{ trailing: 'pe-1' }"
        >
            <template v-if="model?.length" #trailing>
                <UButton color="neutral" variant="link" size="sm" icon="i-lucide-circle-x" aria-label="Clear input" @click="model = ''"/>
            </template>
        </UInput>
    </UFormField>
</template>
