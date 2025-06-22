<script setup>
import {ref} from 'vue'
import {useTheme} from "~/composables/theme/use.theme.ts";

const isOpen = ref(false)
const { currentTheme } = useTheme()
const menuThree = [
    {
        label: 'Dashboard',
        icon: PagesMap.page.home.icon,
        to: PagesMap.page.home.route,
    },
    {
        label: PagesMap.page.movement.manage.label,
        icon: PagesMap.page.movement.manage.icon,
        to: PagesMap.page.movement.manage.route,
    },
    // todo - plano de gastos
    // todo - plano de receitas
    {
        label: PagesMap.page.wallet.manage.label,
        icon: PagesMap.page.wallet.manage.icon,
        to: PagesMap.page.wallet.manage.route,
    },
    // todo - saúde financeira
]

function toggleMenu() {
    isOpen.value = !isOpen.value
}
</script>

<template>
    <aside
        :class="[
            isOpen ? currentTheme.sidebar : '',
            'overflow-y-auto overflow-x-hidden z-30 transition-all duration-400 fixed top-0',
            isOpen ? 'w-55 h-full rounded-r-lg shadow-2xl' : 'left-15 -translate-x-full h-15',
        ]"
    >
        <div class="flex items-center justify-between pl-4 pr-4 pt-4 pb-0">
            <Transition name="fade">
                <span v-if="isOpen" class="text-sm font-bold">
                    Navegação Principal
                </span>
            </Transition>
            <button :class="[(isOpen ? currentTheme.primaryColor : 'text-white')]" @click="toggleMenu">
                <Icon :name="isOpen ? 'mdi:menu-open' : 'mdi:menu'" :size="24" />
            </button>
        </div>
        <div v-if="isOpen" class="mt-5">
            <UNavigationMenu orientation="vertical" :items="menuThree" class="data-[orientation=vertical]:w-48"/>
        </div>
    </aside>
</template>
