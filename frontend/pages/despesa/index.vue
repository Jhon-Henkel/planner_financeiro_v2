<script setup lang="ts">

// todo - listagem geral / listagem de parcelas da compra, mostrando pagas e restantes, poder pagar múltiplas
import AppPage from "~/components/page/app-page.vue";
import {RouteUtil} from "~/utils/route/route.util";
import {PagesMap} from "~/utils/pages.map";
import AppCrudListTop from "~/components/page/app-crud-list-top.vue";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import AppTableApi from "~/components/table/app-table-api.vue";
import {ExpenseService} from "~/modules/expensse/expense.service";
import {TableColumnHeaderDTO} from "~/components/table/dto/table.column.header.dto";
import type {TableActionItem} from "~/components/table/type/table.row.item.actions.type";
import {IconEnum} from "~/utils/enum/icon.enum";
import type {ExpenseItem} from "~/modules/expensse/expense.item.interface";

const page = PagesMap.page.expense.manage
const tableRef = ref<InstanceType<typeof AppTableApi>>();
const service = new ExpenseService()

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(page)
])


const columns = new TableColumnHeaderDTO()
columns.addBadgeDayColumn('due_date')
columns.addColumn('type_label', 'Parcela')
columns.addCurrencyColumn('amount', 'Valor')
columns.addColumn('description', 'Descrição')
columns.addColumnOptions(actions)

function actions(object: ExpenseItem): TableActionItem[] {
    return [
        // todo - Pagar, Editar, Adicionar Valor, Adicionar Boleto, Deletar
        {
            label: 'Editar',
            icon: IconEnum.pencil,
            onSelect() {
                //
            },
        },
        {
            label: 'Excluir',
            icon: IconEnum.trash2,
            onSelect: async () => {
                //
            },
            color: 'error',
        }
    ]
}
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="page.label">
        <app-crud-list-top :title="page.label" @btn-crud-list-top-click="RouteUtil.redirect(PagesMap.page.expense.create)" @btn-crud-list-reload-click="tableRef?.refresh()"/>
        <app-table-api ref="tableRef" :columns="columns" :service="service" order-by="due_date" fix-column-right="actions" show-month-select/>
    </app-page>
</template>
