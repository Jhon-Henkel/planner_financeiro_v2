<script setup lang="ts">
import {IconEnum} from "~/utils/enum/icon.enum";
import {RouteUtil} from "~/utils/route/route.util";
import {useTheme} from "~/composables/theme/use.theme";

const {currentTheme} = useTheme()
const userRoute = PagesMap.page.develop
const items = ref([
    {
        label: userRoute.label,
        icon: userRoute.icon,
        onSelect() {
            RouteUtil.redirect(userRoute)
        }
    }
])
</script>

<template>
    <UDropdownMenu :items="items" :content="{align: 'start'}" :ui="{content: 'w-48'}" size="xl">
        <UButton color="neutral" variant="ghost" :icon="IconEnum.cog" :class="[currentTheme.bgHover300, 'text-white cursor-pointer']"/>
    </UDropdownMenu>
</template>
