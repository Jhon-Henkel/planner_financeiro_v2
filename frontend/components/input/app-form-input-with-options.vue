<script setup lang="ts">
import {computed} from "vue";
import {useTheme} from "~/composables/theme/use.theme";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    modelValue: {
        type: [String, Number, undefined],
        required: true,
    },
    itemsSelect: {
        type: Array<string>,
        required: true,
    },
    modelValueSelect: {
        type: [String, Number],
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
    type: {
        type: String,
        default: 'text',
    },
})

const emit = defineEmits<{
    (e: 'update:modelValue' | 'update:modelValueSelect', value: string|number|undefined): void
}>()

const model = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
})

const modelSelect = computed({
    get: () => props.modelValueSelect,
    set: (value) => emit('update:modelValueSelect', value),
})

const { currentTheme } = useTheme()
</script>

<template>
    <UFormField :name="name" :label="label" :required="required" :description="description">
        <UButtonGroup :disabled="disabled" class="w-full flex">
            <UInput
                v-model="model"
                :placeholder="placeholder"
                :color="currentTheme.primaryColorRoot"
                :type="type"
                class="w-1/2"
            />
            <USelectMenu
                v-model="modelSelect"
                value-key="id"
                :items="itemsSelect"
                :color="currentTheme.primaryColorRoot"
                :search-input="{
                    placeholder: 'Pesquisar...',
                }"
                class="w-1/2 min-w-0"
            >
                <template #empty>
                    <div class="text-sm text-gray-500">
                        Nenhum resultado encontrado!
                    </div>
                </template>
            </USelectMenu>
        </UButtonGroup>
    </UFormField>
</template>

