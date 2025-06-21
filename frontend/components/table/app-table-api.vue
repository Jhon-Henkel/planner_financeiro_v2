<script setup lang="ts">
import {getPaginationRowModel} from "@tanstack/vue-table";
import {UButton} from "#components";
import {useTheme} from "~/composables/theme/use.theme";
import type {IServiceList} from "~/utils/interface/service.list.interface";
import {TableColumnHeaderDTO} from "~/components/table/dto/table.column.header.dto";
import AppButton from "~/components/button/app-button.vue";
import {IconEnum} from "~/utils/enum/icon.enum";

const props = defineProps({
    service: {
        type: Object as PropType<IServiceList<any>>,
        required: true,
    },
    columns: {
        type: TableColumnHeaderDTO,
        required: true,
    },
    fixColumn: {
        type: String,
        required: false,
        default: '',
    },
    fixColumnRight: {
        type: String,
        required: false,
        default: '',
    },
    orderBy: {
        type: String,
        default: 'id',
    },
    orderByDirection: {
        type: String,
        default: 'desc',
    },
    secondaryListId: {
        type: Number,
        required: false,
        default: undefined,
    },
    showGlobalFilter: {
        type: Boolean,
        required: false,
        default: true,
    },
    showFilterButton: {
        type: Boolean,
        required: false,
        default: false,
    },
    filtersFixed: {
        type: String,
        required: false,
        default: '',
    },
})

defineEmits(['clear-filers'])

const data = ref()
const limit = ref(10)
const total = ref(0)
const from = ref(0)
const to = ref(0)
const loading = ref(false)
const showFilters = ref(false)
const filters = ref(props.filtersFixed)
const globalFilter = ref('')
const actualPage = ref(1)
const { currentTheme } = useTheme()
const table = useTemplateRef('table')
const orderBy = ref(props.orderBy)
const orderByDirection = ref(props.orderByDirection)
const device = useDevice()
const idsSelectedRows = ref<number[]>([]);
const selectedRows = ref<object[]>([]);

const list = async (page: number = 1) => {
    loading.value = true
    data.value = await props.service.list(page, limit.value, globalFilter.value, orderBy.value, orderByDirection.value, filters.value)
    limit.value = data.value.per_page
    actualPage.value = data.value.current_page
    pagination.value.pageSize = data.value.per_page
    total.value = data.value.total
    from.value = data.value.from
    to.value = data.value.to
    loading.value = false
    resetSelectedRows();
}

const resetSelectedRows = () => {
    idsSelectedRows.value = [];
    selectedRows.value = [];
    table.value?.tableApi.resetRowSelection();
};

const pagination = ref({
    pageIndex: 0,
    pageSize: limit.value,
})

const sorting = ref([{
    id: orderBy.value,
    desc: orderByDirection.value === 'desc',
}])

const columnPinning = ref({
    left: [props.fixColumn],
    right: [props.fixColumnRight],
})

async function refresh(): Promise<void> {
    loading.value = true
    limit.value = 10
    total.value = 0
    from.value = 0
    to.value = 0
    globalFilter.value = ''
    orderBy.value = props.orderBy
    orderByDirection.value = props.orderByDirection
    await list()
    loading.value = false
}

function defineFilters(filtersToSearch: string): void {
    filters.value = filtersToSearch
}

function onRowSelect(row: object): void {
    idsSelectedRows.value = Object.keys(row).map((key) => data.value?.data?.[key]?.id);
    selectedRows.value = Object.keys(row).map((key) => data.value?.data?.[key]);
}

defineExpose({
    refresh,
    idsSelectedRows,
    selectedRows,
    defineFilters
})

watch(globalFilter, () => {
    list()
})

watch(limit, () => {
    list()
})

watch(filters, () => {
    list()
})

watch(sorting, () => {
    if (sorting.value.length > 0) {
        orderBy.value = sorting.value[0].id
        orderByDirection.value = sorting.value[0].desc ? 'desc' : 'asc'
    } else {
        orderBy.value = props.orderBy
        orderByDirection.value = props.orderByDirection
    }
    list()
})

onMounted(async () => {
    await list()
})
</script>

<template>
    <div class="w-full space-y-4 pb-4 overflow-x-auto">
        <div class="border-b border-accented">
            <div class="flex py-3.5">
                <div v-if="showGlobalFilter">
                    <UInput v-model="globalFilter" placeholder="Procure por algo..." :ui="{ trailing: 'pe-1' }" :color="currentTheme.primaryColorRoot">
                        <template v-if="globalFilter?.length" #trailing>
                            <UButton color="neutral" variant="link" size="sm" icon="i-lucide-circle-x" aria-label="Clear input" @click="globalFilter = ''"/>
                        </template>
                    </UInput>
                </div>
                <div v-if="showFilterButton" class="space-x-2">
                    <slot name="before-filter"/>
                    <app-button variant="subtle" :icon="IconEnum.funnel" @click="showFilters = !showFilters">
                        Filtros
                    </app-button>
                    <app-button v-if="filters.length > 0" variant="subtle" color="error" :icon="IconEnum.funnelX" @click="$emit('clear-filers')">
                        Limpar Filtros
                    </app-button>
                </div>
                <div class="ml-auto flex space-x-2">
                    <div>
                        <slot name="before-items-select"/>
                    </div>
                    <div>
                        <span v-if="!device.isMobile" class="mr-3">Itens por página:</span>
                        <USelect v-model="limit" :items="[10, 25, 50, 100]" class="cursor-pointer" :ui="{item: 'cursor-pointer'}"/>
                    </div>
                </div>
            </div>
            <div v-if="showFilterButton && showFilters" class="mb-6">
                <slot name="filters-fields"/>
            </div>
        </div>
        <div class="overflow-x-auto w-full">
            <UTable
                ref="table"
                v-model:pagination="pagination"
                v-model:column-pinning="columnPinning"
                v-model:sorting="sorting"
                sticky
                :data="data?.data"
                :columns="columns.getObject()"
                :pagination-options="{ getPaginationRowModel: getPaginationRowModel() }"
                :empty="loading ? 'Carregando...' : 'Poxa, não encontramos nada aqui :('"
                :loading="loading"
                :loading-color="currentTheme.primaryColorRoot"
                loading-animation="swing"
                class="flex-1 max-h-[70vh]"
                @update:row-selection="onRowSelect"
            />
        </div>
        <div :class="[(device.isMobile ? 'grid justify-items-center text-center gap-y-2' : 'flex justify-between'), 'border-t border-default pt-4']">
            <span>Exibindo {{ from ?? 0 }} - {{ to ?? 0 }} de {{ total }} Registros</span>
            <UPagination
                v-model:page="actualPage"
                :default-page="1"
                :items-per-page="limit"
                :total="total"
                :active-color="currentTheme.primaryColorRoot"
                :ui="{ item: 'cursor-pointer' }"
                @update:page="(p) => list(p)"
            />
        </div>
    </div>
</template>
