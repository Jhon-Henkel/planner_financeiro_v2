<script setup lang="ts">
import {useTheme} from "~/composables/theme/use.theme";
import {IconEnum} from "~/utils/enum/icon.enum";

defineProps({
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    cssClass: {
        type: String,
        default: '',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    required: {
        type: Boolean,
        default: false,
    },
    description: {
        type: String,
        default: '',
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    accept: {
        type: String,
        default: '.pdf', // Caso mais de um tipo, separe com ', '. Ex.: '.pdf, .doc'
    }
})

const { currentTheme } = useTheme()
</script>

<template>
    <UFormField :name="name" :label="label" :required="required" :description="description">
        <UInput
            type="file"
            :class="[cssClass]"
            :color="currentTheme.primaryColorRoot"
            :disabled="disabled"
            :multiple="multiple"
            :icon="multiple ? IconEnum.files : IconEnum.file"
            :accept="accept"
        />
    </UFormField>
</template>
