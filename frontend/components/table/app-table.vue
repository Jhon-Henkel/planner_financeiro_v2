<script setup lang="ts">
import { TableColumnHeaderDTO } from "~/components/table/dto/table.column.header.dto";

const props = defineProps({
    columns: {
        type: TableColumnHeaderDTO,
        required: true,
    },
    fixColumn: {
        type: String,
        required: false,
        default: undefined,
    },
    data: {
        type: Object,
        required: true
    }
})

const table = useTemplateRef('table')

const columnPinning = ref<object>({
    left: [props.fixColumn],
    right: []
})
</script>

<template>
    <div class="w-full space-y-4 pb-4 overflow-x-auto">
        <div class="overflow-x-auto w-full">
            <UTable
                ref="table"
                v-model:column-pinning="columnPinning"
                sticky
                :data="data"
                :columns="columns.getObject()"
                empty="Nenhum item para exibir!"
                class="flex-1"
            />
        </div>
    </div>
</template>
