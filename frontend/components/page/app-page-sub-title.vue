<script setup lang="ts">
import {useTheme} from "~/composables/theme/use.theme";

defineProps({
    title: {
        type: String,
        required: true
    }
})

const { currentTheme } = useTheme()
</script>

<template>
    <div class="flex justify-between mb-8 mt-4">
        <span :class="[currentTheme.pageTitle, 'text-lg font-bold']">
            {{ title }}
        </span>
        <slot/>
    </div>
</template>
