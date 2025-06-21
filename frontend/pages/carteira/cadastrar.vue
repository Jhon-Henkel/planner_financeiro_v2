<script setup lang="ts">
import {PagesMap} from "~/utils/pages.map";
import AppPage from "~/components/page/app-page.vue";
import AppPageTitle from "~/components/page/app-page-title.vue";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import WalletForm from "~/components/modules/wallet/wallet-form.vue";

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(PagesMap.page.wallet.manage),
    new BreadcrumbItemDTO(PagesMap.page.wallet.create),
])
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="PagesMap.page.wallet.create.label">
        <app-page-title :title="PagesMap.page.wallet.create.label"/>
        <wallet-form/>
    </app-page>
</template>
