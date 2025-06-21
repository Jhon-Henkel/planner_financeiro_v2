<script setup lang="ts">
import {IconEnum} from "~/utils/enum/icon.enum";
import AppButton from "~/components/button/app-button.vue";

defineProps({
    loading: {
        type: Boolean,
        required: false,
        default: false,
    }
})

const device = useDevice()

</script>

<template>
    <app-button type="submit" :position-end="! device.isMobile" :icon="IconEnum.save" :class="device.isMobile ? 'w-full justify-center mt-4' : 'mt-4'" :loading="loading">
        {{ loading ? 'Salvando...' : 'Salvar' }}
    </app-button>
</template>
