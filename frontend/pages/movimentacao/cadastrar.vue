<script setup lang="ts">
import {PagesMap} from "~/utils/pages.map";
import AppPage from "~/components/page/app-page.vue";
import AppPageTitle from "~/components/page/app-page-title.vue";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import AppTabs from "~/components/tabs/app-tabs.vue";
import TabsDto from "~/components/tabs/tabs.dto";
import {IconEnum} from "~/utils/enum/icon.enum";

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(PagesMap.page.movement.manage),
    new BreadcrumbItemDTO(PagesMap.page.movement.create),
])

const tabs = [
    new TabsDto('Saída', 'spent', false, IconEnum.arrowDown),
    new TabsDto('Entrada', 'received', false, IconEnum.arrowUp),
    new TabsDto('Transferência', 'transfer', false, IconEnum.arrowUpDown),
]
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="PagesMap.page.movement.create.label">
        <app-page-title :title="PagesMap.page.movement.create.label"/>
        <app-tabs :items="tabs">
            <template #spent>
                Saída
            </template>
            <template #received>
                Entrada
            </template>
            <template #transfer>
                Transferência
            </template>
        </app-tabs>
    </app-page>
</template>
