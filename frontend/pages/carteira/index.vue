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
import {PagesMap} from "~/utils/pages.map";

const tableRef = ref<InstanceType<typeof AppTableApi>>();
const service = new WalletService()
const page = PagesMap.page.wallet.manage

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(page)
])

const columns = new TableColumnHeaderDTO()
columns.addColumn('name', 'Nome')
columns.addCurrencyColumn('amount', 'Saldo')
columns.addBadgeStatusColumn()
columns.addBoolColumn('hidden', 'Oculta')
columns.addColumnOptions(actions)

// todo - Card de visível, oculto e total

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
                await service.delete(object.id, tableRef)
            },
            color: 'error',
        }
    ]
}
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="page.label">
        <app-crud-list-top :title="page.label" @btn-crud-list-top-click="RouteUtil.redirect(PagesMap.page.wallet.create)"/>
        <app-table-api ref="tableRef" :columns="columns" :service="service" fix-column="name" order-by="name"/>
    </app-page>
</template>
