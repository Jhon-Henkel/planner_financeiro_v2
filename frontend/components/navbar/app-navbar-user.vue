<script setup lang="ts">
import {IconEnum} from "~/utils/enum/icon.enum";
import {RouteUtil} from "~/utils/route/route.util";
import {useAuthStore} from "~/modules/auth/auth.store";
import {useNotify} from "~/composables/notification/notify";
import type {DropdownMenuItem} from "#ui/components/DropdownMenu.vue";

const store = useAuthStore()
// todo - Desenvolver alterações do usuário
const items = ref<DropdownMenuItem[]>([
    {
        label: 'Perfil',
        icon: IconEnum.user,
        onSelect() {
            if (store.userId) {
                const userRoute = PagesMap.page.develop
                RouteUtil.redirect(userRoute)
                return
            }
            const toast = useNotify()
            toast.error('Usuário não encontrado, entre em contato com o administrador do sistema.')
        }
    }, {
        label: 'Sair',
        icon: IconEnum.logOut,
        onSelect() {
            store.logout()
        },
        color: 'error'
    }
])
</script>

<template>
    <UDropdownMenu :items="items" :content="{align: 'start'}" :ui="{content: 'w-48'}" size="xl">
        <UAvatar :icon="IconEnum.user" class="cursor-pointer"/>
    </UDropdownMenu>
</template>
