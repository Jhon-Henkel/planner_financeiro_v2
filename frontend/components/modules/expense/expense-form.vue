<script setup lang="ts">
import {ExpenseService} from "~/modules/expensse/expense.service";
import {ExpenseSchema, type ExpenseSchemaType} from "~/modules/expensse/expense.schema";
import type {FormSubmitEvent} from "@nuxt/ui";
import AppGrid from "~/components/grid/app-grid.vue";
import AppFormInputWithClearButton from "~/components/input/app-form-input-with-clear-button.vue";
import AppFormSelect from "~/components/select/app-form-select.vue";
import {ExpenseTypeEnum} from "~/modules/expensse/expense.type.enum";
import AppFormSwitch from "~/components/input/app-form-switch.vue";
import AppFormDatepicker from "~/components/input/app-form-datepicker.vue";
import AppFormInputNumber from "~/components/input/app-form-input-number.vue";
import AppFormSaveButton from "~/components/button/app-form-save-button.vue";

const service = new ExpenseService()
const state = reactive<ExpenseSchemaType>(service.makeState())
const loading = ref(false)

async function submit(event: FormSubmitEvent<ExpenseSchemaType>) {
    try {
        loading.value = true

        await service.create(event)

        loading.value = false
    } catch {
        loading.value = false
    }
}
</script>

<template>
    <UForm :schema="ExpenseSchema" :state="state" class="space-y-4" @submit="submit">
        <app-grid>
            <app-form-input-with-clear-button v-model="state.description" label="Descrição" name="description" placeholder="Descrição" required/>
            <app-form-select v-model="state.type" :items="ExpenseTypeEnum.listForSelect()" label="Tipo de despesa" name="type"/>
            <app-form-input-number v-if="state.type === ExpenseTypeEnum.installment" v-model="state.installments" label="parcelas" name="installments" required/>
            <app-form-input-number v-model="state.amount" label="Valor" name="amount" :fraction-digits="2" hint="R$" required/>
            <app-form-datepicker v-model="state.dateStart" label="Data pagamento" required/>
            <app-form-input-with-clear-button v-model="state.observations" label="Observações" name="observations" placeholder="Observações"/>
            <app-form-switch v-model="state.variable" label="Variável" name="variable"/>
        </app-grid>
        <app-form-save-button/>
    </UForm>
</template>
