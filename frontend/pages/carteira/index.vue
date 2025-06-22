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
import {NumberUtil} from "~/utils/number/number.util";
import AppNotice from "~/components/notice/app-notice.vue";

const tableRef = ref<InstanceType<typeof AppTableApi>>();
const service = new WalletService()
const page = PagesMap.page.wallet.manage
const details = ref()

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(page)
])

const columns = new TableColumnHeaderDTO()
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
                await service.delete(object.id, tableRef)
            },
            color: 'error',
        }
    ]
}

onMounted(async () => {
    details.value = await service.details()
})
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="page.label">
        <app-crud-list-top :title="page.label" @btn-crud-list-top-click="RouteUtil.redirect(PagesMap.page.wallet.create)" @btn-crud-list-reload-click="tableRef?.refresh()"/>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <app-notice title="Visível" :description="NumberUtil.toCurrency(details?.visible ?? 0, true)" color="neutral"/>
            <app-notice title="Oculto" :description="NumberUtil.toCurrency(details?.hidden ?? 0, true)" color="neutral"/>
        </div>
        <app-notice class="mt-4" title="Total" :description="NumberUtil.toCurrency(details?.total ?? 0, true)" color="neutral"/>
        <app-table-api ref="tableRef" :columns="columns" :service="service" fix-column="name" order-by="name"/>
    </app-page>
</template>
