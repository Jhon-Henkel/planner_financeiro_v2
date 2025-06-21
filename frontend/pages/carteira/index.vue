<script setup lang="ts">
import AppPage from "~/components/page/app-page.vue";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import AppCrudListTop from "~/components/page/app-crud-list-top.vue";
import AppTableApi from "~/components/table/app-table-api.vue";
import {TableColumnHeaderDTO} from "~/components/table/dto/table.column.header.dto";
import {WalletService} from "~/modules/wallet/wallet.service";
import {RouteUtil} from "~/utils/route/route.util";

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(PagesMap.page.wallet.manage)
])

const columns = new TableColumnHeaderDTO()
columns.addColumn('id', '#')
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="PagesMap.page.wallet.manage.label">
        <app-crud-list-top :title="PagesMap.page.wallet.manage.label" button-label="Nova Carteira" @btn-crud-list-top-click="RouteUtil.redirect(PagesMap.page.wallet.create)"/>
        <app-table-api :columns="columns" :service="new WalletService()"/>
    </app-page>
</template>
