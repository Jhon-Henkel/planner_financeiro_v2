<script setup lang="ts">
import type {TMovement} from "~/modules/movement/type/movement.type";
import AppFormInputNumber from "~/components/input/app-form-input-number.vue";
import AppFormInput from "~/components/input/app-form-input.vue";
import AppGrid from "~/components/grid/app-grid.vue";
import AppFormSaveButton from "~/components/button/app-form-save-button.vue";
import type {FormSubmitEvent} from "@nuxt/ui";
import {MovementService} from "~/modules/movement/movement.service";
import {MovementSchema, type MovementSchemaType, MovementTransferSchema, type MovementTransferSchemaType} from "~/modules/movement/movement.schema";
import {MovementTypeEnum} from "~/modules/movement/enum/movement.type.enum";
import type {IMovementItem} from "~/modules/movement/movement.item.interface";
import AppFormSelectSearchApi from "~/components/select/app-form-select-search-api.vue";
import {WalletService} from "~/modules/wallet/wallet.service";
import AppFormInputWithClearButton from "~/components/input/app-form-input-with-clear-button.vue";

const props = defineProps({
    type: {
        type: Number as PropType<TMovement>,
        required: true,
    },
    movement: {
        type: Object as PropType<IMovementItem>,
        default: undefined
    }
})

const loading = ref(false)
const service = new MovementService()
const walletService = new WalletService()
const state = reactive<MovementSchemaType>(service.makeState(props.type))
const stateTransfer = reactive<MovementTransferSchemaType>(service.makeTransferState())

// todo - card com saldo da carteira selecionada

async function submit(event: FormSubmitEvent<MovementSchemaType>) {
    try {
        loading.value = true

        if (props.movement !== undefined) {
            await service.update(event, props.movement.id)
        } else {
            await service.create(event)
        }

        loading.value = false
    } catch {
        loading.value = false
    }
}

async function submitTransfer(event: FormSubmitEvent<MovementTransferSchemaType>) {
    try {
        loading.value = true
        await service.createTransfer(event)
        loading.value = false
    } catch {
        loading.value = false
    }
}

watch(() => props.movement, (newValue) => {
    if (newValue) {
        Object.assign(state, service.makeStateByItem(newValue))
    }
}, { immediate: true })
</script>

<template>
    <UForm v-if="type === MovementTypeEnum.transfer" :schema="MovementTransferSchema" :state="stateTransfer" class="space-y-4" @submit="submitTransfer">
        <app-grid class="mt-5">
            <app-form-input-number v-model="stateTransfer.amount" label="Valor" name="amount" :fraction-digits="2" hint="R$" required/>
            <app-form-select-search-api v-model="stateTransfer.from_id" :service="walletService" label-key="name" label="Origem" name="from_id" required/>
            <app-form-select-search-api v-model="stateTransfer.to_id" :service="walletService" label-key="name" label="Destino" name="to_id" required/>
        </app-grid>
        <app-form-save-button/>
    </UForm>
    <UForm v-else :schema="MovementSchema" :state="state" class="space-y-4" @submit="submit">
        <app-grid class="mt-5">
            <app-form-input-with-clear-button v-model="state.description" label="Descrição" name="name" placeholder="Descrição" required/>
            <app-form-input-number v-model="state.amount" label="Valor" name="amount" :fraction-digits="2" hint="R$" required/>
            <app-form-select-search-api v-if="movement === undefined" v-model="state.wallet_id" :service="walletService" label-key="name" label="Carteira" name="wallet_id" required/>
        </app-grid>
        <app-form-save-button/>
    </UForm>
</template>
