<script setup lang="ts">
import {IconEnum} from "~/utils/enum/icon.enum";
import {UButton} from "#components";
import {useTheme} from "~/composables/theme/use.theme";

const { currentTheme } = useTheme()

defineProps({
    title: {
        type: String,
        required: true
    },
    showButton: {
        type: Boolean,
        default: true
    },
    showReloadButton: {
        type: Boolean,
        default: true
    },
    buttonIcon: {
        type: String,
        default: IconEnum.plus
    },
})

defineEmits(['btn-crud-list-top-click', 'btn-crud-list-reload-click'])
</script>

<template>
    <div class="flex justify-between">
        <span :class="[currentTheme.pageTitle, 'text-2xl font-bold']">
            {{ title }}
        </span>
        <div class="flex items-center gap-2">
            <slot name="before-button"/>
            <u-button v-if="showReloadButton" :icon="IconEnum.rotateCcw" :color="currentTheme.primaryColorRoot" class="cursor-pointer" @click="$emit('btn-crud-list-reload-click')"/>
            <u-button v-if="showButton" :icon="buttonIcon" :color="currentTheme.primaryColorRoot" class="cursor-pointer" @click="$emit('btn-crud-list-top-click')"/>
            <slot name="after-button"/>
        </div>
        <slot name="content-one"/>
    </div>
</template>
