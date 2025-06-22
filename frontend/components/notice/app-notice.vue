<script setup lang="ts">
import type {PrimaryColor} from "~/composables/theme/use.theme";

defineProps({
    color: {
        type: String as PropType<PrimaryColor>,
        default: "primary"
    },
    icon: {
        type: String,
        default: undefined
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
    <UAlert
        :color="color"
        :icon="icon"
        :title="title"
        :description="description"
        variant="soft"
        class="shadow-md"
        :ui="{
            title: 'text-center',
            description: 'text-center',
        }"
    />
</template>
