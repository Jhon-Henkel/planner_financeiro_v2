<script setup>
import {useTheme} from "~/composables/theme/use.theme.js";

const colorMode = useColorMode()
const {currentTheme} = useTheme()

const isDark = computed({
    get() {
        return colorMode.value === 'dark'
    },
    set(_isDark) {
        colorMode.preference = _isDark ? 'dark' : 'light'
    }
})
const icon = computed(() => {
    return isDark.value ? 'i-lucide-moon' : 'i-lucide-sun'
})
</script>

<template>
    <ClientOnly v-if="!colorMode?.forced">
        <UButton :icon="icon" color="neutral" variant="ghost" :class="[currentTheme.bgHover300, 'text-white cursor-pointer']" @click="isDark = !isDark"/>
        <template #fallback>
            <div class="size-8"/>
        </template>
    </ClientOnly>
</template>
