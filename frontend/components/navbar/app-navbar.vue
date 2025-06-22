<script setup>
import {useTheme} from "~/composables/theme/use.theme.js";
import AppNavbarColorModeButton from "~/components/navbar/app-navbar-color-mode-button.vue";
import AppNavbarUser from "~/components/navbar/app-navbar-user.vue";
import AppNavbarSettingsButton from "~/components/navbar/app-navbar-settings-button.vue";

const {currentTheme} = useTheme()
</script>

<template>
    <div class="bg-info-950 top-0 z-50 shadow-md">
        <nav :class="[currentTheme.navbar, 'w-full px-4 py-4 flex items-center justify-end']">
            <div class="flex items-center space-x-3 md:mr-5">
                <app-navbar-color-mode-button/>
                <app-navbar-settings-button/>
                <app-navbar-user/>
            </div>
        </nav>
    </div>
</template>
