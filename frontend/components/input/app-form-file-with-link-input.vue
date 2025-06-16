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
        default: '',
    },
    formats: {
        type: String,
        required: true,
    },
    maxSize: {
        type: String,
        required: true
    },
    urlFile: {
        type: String,
        required: false,
        default: ''
    }
})

const {currentTheme} = useTheme()
</script>

<template>
    <UFormField :name="name" :label="label" :url-file="urlFile" :required="required" :description="description">
        <template #label>
            {{ label }}
            <a v-if="urlFile" :href="urlFile" target="_blank" class="cursor-pointer text-blue-500 text-sm ml-2 float-right">
                Visualizar Arquivo
            </a>
        </template>
        <UInput
            type="file"
            :class="[cssClass]"
            :color="currentTheme.primaryColorRoot"
            :disabled="disabled"
            :multiple="multiple"
            :icon="multiple ? IconEnum.files : IconEnum.file"
            :accept="accept"
        />
        <p v-if="formats" class="text-xs text-gray-500 mt-1 float-right text-right">
            {{ formats ? `Formatos Suportados: ${formats}` : '' }} <br>
            {{ maxSize ? `Tamanho Máximo: ${maxSize}` : '' }}
        </p>
    </UFormField>
</template>
