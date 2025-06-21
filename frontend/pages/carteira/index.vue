<script setup lang="ts">
import AppPage from "~/components/page/app-page.vue";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import AppCrudListTop from "~/components/page/app-crud-list-top.vue";
import AppTableApi from "~/components/table/app-table-api.vue";
import {TableColumnHeaderDTO} from "~/components/table/dto/table.column.header.dto";
import {WalletService} from "~/modules/wallet/wallet.service";
import {RouteUtil} from "~/utils/route/route.util";
import type {IWalletItem} from "~/modules/wallet/wallet.item.interface";
import type {TableActionItem} from "~/components/table/type/table.row.item.actions.type";
import {IconEnum} from "~/utils/enum/icon.enum";

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(PagesMap.page.wallet.manage)
])

const tableRef = ref<InstanceType<typeof AppTableApi>>();

const columns = new TableColumnHeaderDTO()
columns.addColumn('id', '#')
columns.addColumn('name', 'Nome')
columns.addCurrencyColumn('amount', 'Saldo')
columns.addBadgeStatusColumn()
columns.addBoolColumn('hidden', 'Oculta')
columns.addColumnOptions(actions)

function actions(object: IWalletItem): TableActionItem[] {
    return [
        {
            label: 'Editar',
            icon: IconEnum.pencil,
            onSelect() {
                RouteUtil.redirect(PagesMap.page.wallet.update(object.id))
            },
        },
        {
            label: 'Excluir',
            icon: IconEnum.trash2,
            onSelect: async () => {
                new WalletService().delete(object.id, tableRef)
            },
            color: 'error',
        }
    ]
}
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="PagesMap.page.wallet.manage.label">
        <app-crud-list-top :title="PagesMap.page.wallet.manage.label" @btn-crud-list-top-click="RouteUtil.redirect(PagesMap.page.wallet.create)"/>
        <app-table-api ref="tableRef" :columns="columns" :service="new WalletService()"/>
    </app-page>
</template>
