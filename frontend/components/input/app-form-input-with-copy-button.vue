<script setup lang="ts">
import {computed} from 'vue'
import {useTheme} from "~/composables/theme/use.theme";
import {StringUtil} from "~/utils/string/string.util";
import {useClipboard} from '@vueuse/core'

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
    (e: 'update:modelValue', value: string | null): void
}>()

const model = computed({
    get: () => props.modelValue,
    set: (value) => {
        value = props.type == 'text' ? StringUtil.capitalizeFirstLetters(value) : value
        emit('update:modelValue', value)
    },
})

const {currentTheme} = useTheme()
const {copy, copied} = useClipboard()
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
            :ui="{ trailing: 'pr-0.5' }"
        >
            <template v-if="model?.length" #trailing>
                <UTooltip text="Copy to clipboard" :content="{ side: 'right' }">
                    <UButton
                        :color="copied ? 'success' : 'neutral'"
                        variant="link"
                        size="sm"
                        :icon="copied ? 'i-lucide-copy-check' : 'i-lucide-copy'"
                        aria-label="Copy to clipboard"
                        @click="copy(model)"
                    />
                </UTooltip>
            </template>
        </UInput>
    </UFormField>
</template>
