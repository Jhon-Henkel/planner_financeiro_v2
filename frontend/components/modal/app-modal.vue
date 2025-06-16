<script setup lang="ts">
import {defineExpose, ref} from 'vue'

defineProps({
    submitLabel: {
        type: String,
        default: 'Salvar',
    },
    modalTitle: {
        type: String,
        required: true,
    },
    modalDescription: {
        type: String,
        required: true,
    }
})

const isOpen = ref(false)

function open() {
    isOpen.value = true
}

function close() {
    isOpen.value = false
}

defineEmits(['modal-submit', 'modal-close'])

defineExpose({
    open,
    close,
})
</script>

<template>
    <UModal
        v-model:open="isOpen"
        :dismissible="false"
        :title="modalTitle"
        :description="modalDescription"
        :ui="{ footer: 'justify-end' }"
        @after:leave="$emit('modal-close')"
    >
        <template #body>
            <slot/>
        </template>
    </UModal>
</template>
