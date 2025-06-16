<script setup lang="ts">
import type TabsDto from "~/components/tabs/tabs.dto";
import {useTheme} from "~/composables/theme/use.theme";
import {watch} from "vue";

const props = defineProps({
    items: {
        type: Array<TabsDto>,
        required: true
    },
    activeSlot: {
        type: String,
        required: false,
        default: undefined
    }
})

const { currentTheme } = useTheme()
const activeTab = ref(props.activeSlot === undefined ? props.items[0].value : props.activeSlot)

watch(() => props.activeSlot, async () => {
    if (props.activeSlot !== undefined) {
        activeTab.value = props.activeSlot;
    }
}, { immediate: true })

</script>

<template>
    <u-tabs v-model="activeTab" :items="items" variant="link" :color="currentTheme.primaryColorRoot" :ui="{ label: 'cursor-pointer' }">
        <template v-for="(item, id) in items" :key="id" #[item.slot]>
            <slot :name="item.slot"/>
        </template>
    </u-tabs>
</template>
