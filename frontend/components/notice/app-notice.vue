<script setup lang="ts">
import {IconEnum} from "~/utils/enum/icon.enum";
import type {PrimaryColor} from "~/composables/theme/use.theme";

defineProps({
    color: {
        type: String as PropType<PrimaryColor>,
        default: "primary"
    },
    icon: {
        type: String,
        default: IconEnum.check
    },
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    }
})
</script>

<template>
    <UAlert :color="color" :icon="icon" :title="title" :description="description" variant="soft" class="shadow-md"/>
</template>
