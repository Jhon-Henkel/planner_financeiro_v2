<script setup lang="ts">
import AppFormInput from "~/components/input/app-form-input.vue";
import AppGrid from "~/components/grid/app-grid.vue";
import type {IWalletItem} from "~/modules/wallet/wallet.item.interface";
import {WalletService} from "~/modules/wallet/wallet.service";
import {WalletSchema, type WalletSchemaType} from "~/modules/wallet/wallet.schema";
import type {FormSubmitEvent} from "@nuxt/ui";
import AppFormSaveButton from "~/components/button/app-form-save-button.vue";
import AppFormSelect from "~/components/select/app-form-select.vue";
import {StatusActiveInactiveEnum} from "~/utils/enum/status.active.inactive.enum";
import AppFormInputNumber from "~/components/input/app-form-input-number.vue";
import AppFormSwitch from "~/components/input/app-form-switch.vue";

const props = defineProps({
    wallet: {
        type: Object as PropType<IWalletItem>,
        default: undefined
    }
})

const service = new WalletService()
const state = reactive<WalletSchemaType>(service.makeState())
const loading = ref(false)

async function submit(event: FormSubmitEvent<WalletSchemaType>) {
    try {
        loading.value = true

        if (props.wallet !== undefined) {
            await service.update(event, props.wallet.id)
        } else {
            await service.create(event)
        }

        loading.value = false
    } catch {
        loading.value = false
    }
}

watch(() => props.wallet, (newValue) => {
    if (newValue) {
        Object.assign(state, service.makeStateByItem(newValue))
    }
}, { immediate: true })
</script>

<template>
    <UForm :schema="WalletSchema" :state="state" class="space-y-4" @submit="submit">
        <app-grid class="mt-5">
            <app-form-input v-model="state.name" label="Nome" name="name" placeholder="Nome da Carteira" required/>
            <app-form-input-number v-model="state.amount" label="Saldo" name="amount" :fraction-digits="2" required/>
            <app-form-select v-model="state.status" :items="StatusActiveInactiveEnum.listForSelect()" label="Status" name="status" required/>
            <app-form-switch v-model="state.hidden" label="Ocultar Saldo" name="hidden"/>
        </app-grid>
        <app-form-save-button/>
    </UForm>
</template>
