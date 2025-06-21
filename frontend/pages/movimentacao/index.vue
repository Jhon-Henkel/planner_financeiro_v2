<script setup lang="ts">
import {PagesMap} from "~/utils/pages.map";
import {RouteUtil} from "~/utils/route/route.util";
import AppCrudListTop from "~/components/page/app-crud-list-top.vue";
import AppTableApi from "~/components/table/app-table-api.vue";
import AppPage from "~/components/page/app-page.vue";
import type {IWalletItem} from "~/modules/wallet/wallet.item.interface";
import type {TableActionItem} from "~/components/table/type/table.row.item.actions.type";
import {IconEnum} from "~/utils/enum/icon.enum";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import {TableColumnHeaderDTO} from "~/components/table/dto/table.column.header.dto";
import {MovementService} from "~/modules/movement/movement.service";
import {UBadge} from "#components";
import {MovementTypeEnum} from "~/modules/movement/enum/movement.type.enum";

const tableRef = ref<InstanceType<typeof AppTableApi>>();
const service = new MovementService()
const page = PagesMap.page.movement.manage

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(page)
])

const columns = new TableColumnHeaderDTO()
columns.addColumn('description', 'Descrição')
columns.addColumnWithCell('type_label', 'Tipo', (row) => {
    return h(UBadge, { class: MovementTypeEnum.cssBadgeClass(row.original.type) }, { default: () => row.original.type_label });
})
columns.addCurrencyColumn('amount', 'Valor')
columns.addColumn('wallet_name', 'Carteira')
columns.addDateColumn('created_at', 'Data')
columns.addColumnOptions(actions)

// todo - card entradas, saídas e balanço do mês
// todo - poder selecionar mês

function actions(object: IWalletItem): TableActionItem[] {
    return [
        {
            label: 'Editar',
            icon: IconEnum.pencil,
            onSelect() {
            },
        },
        {
            label: 'Excluir',
            icon: IconEnum.trash2,
            onSelect: async () => {
            },
            color: 'error',
        }
    ]
}
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="page.label">
        <app-crud-list-top :title="page.label" @btn-crud-list-top-click="RouteUtil.redirect(PagesMap.page.movement.create)"/>
        <app-table-api ref="tableRef" :columns="columns" :service="service" order-by="created_at" fix-column="description"/>
    </app-page>
</template>
