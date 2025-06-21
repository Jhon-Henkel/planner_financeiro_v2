<script setup lang="ts">
import {PagesMap} from "~/utils/pages.map";
import AppPage from "~/components/page/app-page.vue";
import {BreadcrumbDTO} from "~/components/breadcrumb/dto/breadcrumb.dto";
import {BreadcrumbItemDTO} from "~/components/breadcrumb/dto/breadcrumb.item.dto";
import {RouteUtil} from "~/utils/route/route.util";
import {MovementService} from "~/modules/movement/movement.service";
import AppPageTitle from "~/components/page/app-page-title.vue";
import {MovementTypeEnum} from "~/modules/movement/enum/movement.type.enum";
import MovementForm from "~/components/modules/movement/movement-form.vue";

const itemId = RouteUtil.getIdRouteAttribute()
const page = PagesMap.page.movement.update(itemId)
const item = ref()
const service = new MovementService()

const breadcrumb = new BreadcrumbDTO([
    new BreadcrumbItemDTO(PagesMap.page.movement.manage),
    new BreadcrumbItemDTO(page),
])

onMounted(async () => {
    item.value = await service.get(itemId)
})
</script>

<template>
    <app-page :breadcrumb="breadcrumb" :page-title="page.label">
        <app-page-title :title="`${page.label} ${MovementTypeEnum.label(item?.type)}`"/>
        <movement-form v-if="item" :type="item.type" :movement="item"/>
    </app-page>
</template>
