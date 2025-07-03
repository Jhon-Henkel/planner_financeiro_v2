<script setup lang="ts">
import AppPage from "~/components/page/app-page.vue";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import {PagesMap} from "~/utils/pages.map";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import AppPageTitle from "~/components/page/app-page-title.vue";
import ExpenseForm from "~/components/modules/expense/expense-form.vue";
import type {ExpenseItem} from "~/modules/expensse/expense.item.interface";
import {ExpenseService} from "~/modules/expensse/expense.service";

const itemId = Number(useRoute().params.expenseid)
const installmentId = Number(useRoute().params.installmentid)
const page = PagesMap.page.expense.update(itemId, installmentId)
const item = ref<ExpenseItem>()

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(PagesMap.page.expense.manage),
    new BreadcrumbItemDTO(page),
])

onMounted(async () => {
    item.value = await new ExpenseService().get(itemId)
    item.value.installment_id = installmentId
})
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="page.label">
        <app-page-title :title="page.label"/>
        <expense-form :item="item"/>
    </app-page>
</template>
