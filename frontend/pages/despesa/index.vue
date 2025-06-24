<script setup lang="ts">

// todo - listagem geral / listagem de parcelas da compra, mostrando pagas e restantes, poder pagar múltiplas
import AppPage from "~/components/page/app-page.vue";
import {RouteUtil} from "~/utils/route/route.util";
import {PagesMap} from "~/utils/pages.map";
import AppCrudListTop from "~/components/page/app-crud-list-top.vue";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import AppTableApi from "~/components/table/app-table-api.vue";

const page = PagesMap.page.expense.manage
const tableRef = ref<InstanceType<typeof AppTableApi>>();

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(page)
])
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="page.label">
        <app-crud-list-top :title="page.label" @btn-crud-list-top-click="RouteUtil.redirect(PagesMap.page.expense.create)" @btn-crud-list-reload-click="tableRef?.refresh()"/>

    </app-page>
</template>
