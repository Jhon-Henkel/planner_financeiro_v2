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
import AppModal from "~/components/modal/app-modal.vue";
import {ExpensePaySchema, type ExpensePaySchemaType} from "~/modules/expensse/expense.pay.schema";
import AppGrid from "~/components/grid/app-grid.vue";
import AppFormInputNumber from "~/components/input/app-form-input-number.vue";
import AppFormSelectSearchApi from "~/components/select/app-form-select-search-api.vue";
import {WalletService} from "~/modules/wallet/wallet.service";
import AppFormSaveButton from "~/components/button/app-form-save-button.vue";

const page = PagesMap.page.expense.manage
const tableRef = ref<InstanceType<typeof AppTableApi>>();
const service = new ExpenseService()
const payModalRef = ref<InstanceType<typeof AppModal>>();
const selectedExpense = ref()
const payState = reactive<ExpensePaySchemaType>(service.makePayState())
const payLoading = ref(false)

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
        // todo - Editar, Adicionar Valor, Adicionar Boleto, Deletar
        {
            label: 'Pagar',
            icon: IconEnum.wallet,
            onSelect() {
                selectedExpense.value = object
                payState.installmentId = object.installment_id
                payState.amount = object.amount
                payModalRef.value?.open()
            },
        },
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

function resetPayModal() {
    selectedExpense.value = undefined
    Object.assign(payState, service.makePayState())
}

async function submitPayment() {
    payLoading.value = true
    try {
        await service.pay(payState)
        tableRef.value?.refresh()
        payLoading.value = false
    } catch {
        payLoading.value = false
    }
}
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="page.label">
        <app-crud-list-top :title="page.label" @btn-crud-list-top-click="RouteUtil.redirect(PagesMap.page.expense.create)" @btn-crud-list-reload-click="tableRef?.refresh()"/>
        <app-table-api ref="tableRef" :columns="columns" :service="service" order-by="due_date" fix-column-right="actions" show-month-select/>
        <app-modal ref="payModalRef" modal-description="Selecione uma carteira para pagamento!" modal-title="Pagar" @modal-close="resetPayModal">
            <UForm :schema="ExpensePaySchema" :state="payState" class="space-y-4" @submit="submitPayment">
                <app-grid :cols="1">
                    <app-form-input-number v-model="payState.amount" label="Valor" name="amount" :fraction-digits="2" hint="R$" required/>
                    <app-form-select-search-api v-model="payState.walletId" :service="new WalletService()" label-key="name" label="Carteira" name="walletId" required/>
                    <app-form-save-button label="Pagar" :icon="IconEnum.circleDollarSign" loading-label="Pagando..." :loading="payLoading" full/>
                </app-grid>
            </UForm>
        </app-modal>
    </app-page>
</template>
