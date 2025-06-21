<script setup lang="ts">
import {PagesMap} from "~/utils/pages.map";
import AppPage from "~/components/page/app-page.vue";
import AppPageTitle from "~/components/page/app-page-title.vue";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import WalletForm from "~/components/modules/wallet/wallet-form.vue";
import {RouteUtil} from "~/utils/route/route.util";
import {WalletService} from "~/modules/wallet/wallet.service";

const itemId = RouteUtil.getIdRouteAttribute()
const item = ref()
const page = PagesMap.page.wallet.update(itemId)

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(PagesMap.page.wallet.manage),
    new BreadcrumbItemDTO(page),
])

onMounted(async () => {
    item.value = await new WalletService().get(itemId)
})
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="page.label">
        <app-page-title :title="page.label"/>
        <wallet-form :wallet="item"/>
    </app-page>
</template>
