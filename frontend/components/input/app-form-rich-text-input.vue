<script setup lang="ts">
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import {computed} from "vue";

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
})

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void
}>()

const model = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
})
</script>

<!-- DocumentaÃ§Ã£o do quill: https://vueup.github.io/vue-quill/ -->
<template>
    <ClientOnly>
        <UFormField :name="name" :label="label">
            <QuillEditor v-model:content="model" content-type="html" theme="snow" toolbar="essential"/>
        </UFormField>
    </ClientOnly>
</template>
