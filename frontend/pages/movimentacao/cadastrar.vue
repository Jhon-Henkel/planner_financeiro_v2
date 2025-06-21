<script setup lang="ts">
import {PagesMap} from "~/utils/pages.map";
import AppPage from "~/components/page/app-page.vue";
import AppPageTitle from "~/components/page/app-page-title.vue";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import AppTabs from "~/components/tabs/app-tabs.vue";
import TabsDto from "~/components/tabs/tabs.dto";
import {IconEnum} from "~/utils/enum/icon.enum";
import MovementForm from "~/components/modules/movement/movement-form.vue";
import {MovementTypeEnum} from "~/modules/movement/enum/movement.type.enum";
import type {TMovement} from "~/modules/movement/type/movement.type";

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
                <movement-form :type="MovementTypeEnum.spent as TMovement"/>
            </template>
            <template #received>
                <movement-form :type="MovementTypeEnum.received as TMovement"/>
            </template>
            <template #transfer>
                <movement-form :type="MovementTypeEnum.transfer as TMovement"/>
            </template>
        </app-tabs>
    </app-page>
</template>
