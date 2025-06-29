<script setup lang="ts">
import {PagesMap} from "~/utils/pages.map";
import {RouteUtil} from "~/utils/route/route.util";
import AppCrudListTop from "~/components/page/app-crud-list-top.vue";
import AppTableApi from "~/components/table/app-table-api.vue";
import AppPage from "~/components/page/app-page.vue";
import type {TableActionItem} from "~/components/table/type/table.row.item.actions.type";
import {IconEnum} from "~/utils/enum/icon.enum";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import {TableColumnHeaderDTO} from "~/components/table/dto/table.column.header.dto";
import {MovementService} from "~/modules/movement/movement.service";
import {UBadge} from "#components";
import {MovementTypeEnum} from "~/modules/movement/enum/movement.type.enum";
import type {IMovementItem} from "~/modules/movement/movement.item.interface";
import {appAlert} from "~/composables/alert/alert";

const tableRef = ref<InstanceType<typeof AppTableApi>>();
const service = new MovementService()
const page = PagesMap.page.movement.manage

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(page)
])

const columns = new TableColumnHeaderDTO()
columns.addColumnWithCell('type_label', 'Tipo', (row) => {
    return h(UBadge, { class: MovementTypeEnum.cssBadgeClass(row.original.type) }, { default: () => row.original.type_label });
})
columns.addColumn('description', 'Descrição')
columns.addCurrencyColumn('amount', 'Valor')
columns.addColumn('wallet_name', 'Carteira')
columns.addDateColumn('created_at', 'Data')
columns.addColumnOptions(actions)

function actions(object: IMovementItem): TableActionItem[] {
    return [
        {
            label: 'Editar',
            icon: IconEnum.pencil,
            onSelect() {
                if (object.type === MovementTypeEnum.transfer) {
                    appAlert.error('Ação não permitida!', 'Não é possível editar uma movimentação do tipo transferência!')
                    return
                }
                RouteUtil.redirect(PagesMap.page.movement.update(object.id))
            },
        },
        {
            label: 'Excluir',
            icon: IconEnum.trash2,
            onSelect: async () => {
                await service.delete(object.id, tableRef, object.type === MovementTypeEnum.transfer)
            },
            color: 'error',
        }
    ]
}

</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="page.label">
        <app-crud-list-top :title="page.label" @btn-crud-list-top-click="RouteUtil.redirect(PagesMap.page.movement.create)" @btn-crud-list-reload-click="tableRef?.refresh()"/>
        <app-table-api ref="tableRef" :columns="columns" :service="service" order-by="created_at" fix-column-right="actions" show-month-select/>
    </app-page>
</template>
