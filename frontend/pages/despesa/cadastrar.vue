<script setup lang="ts">
import {PagesMap} from "~/utils/pages.map";
import AppPage from "~/components/page/app-page.vue";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import AppPageTitle from "~/components/page/app-page-title.vue";
import ExpenseForm from "~/components/modules/expense/expense-form.vue";

const page = PagesMap.page.expense.create

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(PagesMap.page.expense.manage),
    new BreadcrumbItemDTO(PagesMap.page.expense.create),
])
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="page.label">
        <app-page-title :title="page.label"/>
        <expense-form/>
    </app-page>
</template>
