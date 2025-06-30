<script setup lang="ts">
import {IconEnum} from "~/utils/enum/icon.enum";
import AppButton from "~/components/button/app-button.vue";

defineProps({
    loading: {
        type: Boolean,
        required: false,
        default: false,
    },
    full: {
        type: Boolean,
        required: false,
        default: false,
    },
    icon: {
        type: String,
        required: false,
        default: IconEnum.save,
    },
    label: {
        type: String,
        required: false,
        default: 'Salvar',
    },
    loadingLabel: {
        type: String,
        required: false,
        default: 'Salvando...',
    }
})

const device = useDevice()

</script>

<template>
    <app-button type="submit" :position-end="! device.isMobile" :icon="icon" :class="(device.isMobile || full) ? 'w-full justify-center mt-4 cursor-pointer' : 'mt-4 cursor-pointer'" :loading="loading">
        {{ loading ? loadingLabel : label }}
    </app-button>
</template>
