<script setup lang="ts">
import {useTheme} from "~/composables/theme/use.theme";

const {currentTheme} = useTheme()
</script>

<template>
    <!-- eslint-disable vue/no-duplicate-attributes -->
    <UCheckbox :color="currentTheme.primaryColorRoot" v-bind="$attrs"/>
</template>
