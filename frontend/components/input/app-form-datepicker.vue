<script setup lang="ts">
import {ref, watch} from 'vue'
import {CalendarDate, parseDate} from '@internationalized/date'
import {format, parse} from 'date-fns'
import {ptBR} from 'date-fns/locale'
import {IconEnum} from "~/utils/enum/icon.enum"
import AppButton from "~/components/button/app-button.vue"
import {useTheme} from "~/composables/theme/use.theme";

const props = defineProps({
    modelValue: {
        type: [String, CalendarDate, null],
        default: null
    },
    label: {
        type: String,
        default: 'Data'
    },
    description: {
        type: String,
        default: ''
    },
    required: {
        type: Boolean,
        default: false
    },
    minDate: {
        type: CalendarDate,
        required: false,
        default: null
    },
    maxDate: {
        type: CalendarDate,
        required: false,
        default: null
    },
    disabled: {
        type: Boolean,
        required: false,
        default: false
    }
})

const calendarDate = ref(props.modelValue instanceof CalendarDate
    ? props.modelValue
    : props.modelValue
        ? parseDate(props.modelValue)
        : ''
);

const inputValue = ref('')
const inputRef = ref(null)
const emit = defineEmits<{(e: 'update:modelValue', value: string): void}>()
const { currentTheme } = useTheme()
const open = ref(false)

function formatToYmd(date: string|CalendarDate): string {
    if (date instanceof CalendarDate) {
        return `${date.year}-${String(date.month).padStart(2, '0')}-${String(date.day).padStart(2, '0')}`
    }
    return date
}

function formatForDisplay(date: string|CalendarDate): string {
    if (date instanceof CalendarDate) {
        const jsDate = new Date(date.year, date.month - 1, date.day)
        return format(jsDate, 'dd/MM/yyyy', { locale: ptBR })
    }
    return date
}

function handleInputChange(event: Event) {
    const value = (event.target as HTMLInputElement).value
    inputValue.value = value

    const datePattern = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/
    const match = value.match(datePattern)

    if (match) {
        const day = parseInt(match[1], 10)
        const month = parseInt(match[2], 10)
        const year = parseInt(match[3], 10)

        if (month >= 1 && month <= 12 && day >= 1 && day <= 31) {
            calendarDate.value = new CalendarDate(year, month, day)
        }
    }
}

function handleBlur() {
    if (!inputValue.value) {
        calendarDate.value = ''
        emit('update:modelValue', '')
        return
    }

    const parsedDate = parse(inputValue.value, 'dd/MM/yyyy', new Date())

    if (parsedDate && !isNaN(parsedDate.getTime())) {
        inputValue.value = format(parsedDate, 'dd/MM/yyyy', { locale: ptBR })

        calendarDate.value = new CalendarDate(
            parsedDate.getFullYear(),
            parsedDate.getMonth() + 1,
            parsedDate.getDate()
        )
    } else {
        inputValue.value = calendarDate.value ? formatForDisplay(calendarDate.value) : ''
    }
}

function formatInput(event: Event) {
    let value = (event.target as HTMLInputElement).value
    value = value.replace(/\D/g, '')

    if (value.length > 0) {
        if (value.length <= 2) {
            inputValue.value = value
        } else if (value.length <= 4) {
            inputValue.value = `${value.slice(0, 2)}/${value.slice(2)}`
        } else {
            inputValue.value = `${value.slice(0, 2)}/${value.slice(2, 4)}/${value.slice(4, 8)}`
        }
    } else {
        inputValue.value = ''
    }
}

function handleCalendarChange(date: CalendarDate) {
    calendarDate.value = date
    triggerInputValidation()
    open.value = false
}

function triggerInputValidation() {
    setTimeout(() => {
        if (inputRef.value) {
            inputRef.value.$el.querySelector('input').dispatchEvent(new Event('blur'))
        }
    }, 100)
}

function updateFromModelValue(value: string|CalendarDate) {
    if (value) {
        if (value instanceof CalendarDate) {
            calendarDate.value = value
        } else {
            try {
                calendarDate.value = parseDate(value)
            } catch {
                calendarDate.value = ''
            }
        }
    } else {
        calendarDate.value = ''
    }

    if (calendarDate.value) {
        inputValue.value = formatForDisplay(calendarDate.value)
    } else {
        inputValue.value = ''
    }
}

watch(calendarDate, (newDate) => {
    if (newDate) {
        inputValue.value = formatForDisplay(newDate)
        emit('update:modelValue', formatToYmd(newDate))
    } else {
        inputValue.value = ''
        emit('update:modelValue', '')
    }
}, { immediate: true })

watch(() => props.modelValue, (newValue) => {
    if (newValue !== formatToYmd(calendarDate.value)) {
        updateFromModelValue(newValue)
    }
}, { immediate: true })
</script>

<template>
    <UFormField :name="label" :label="label" :required="required" :description="description">
        <div class="flex justify-between space-x-2">
            <UInput
                ref="inputRef"
                :value="inputValue"
                :color="currentTheme.primaryColorRoot"
                :disabled="disabled"
                class="w-full"
                placeholder="__/__/__"
                @input="formatInput"
                @change="handleInputChange"
                @blur="handleBlur"
            >
                <template #trailing>
                    <UPopover v-model:open="open">
                        <app-button :icon="IconEnum.calendar" variant="soft" :disabled="disabled"/>
                        <template #content>
                            <UCalendar
                                ref="calendar"
                                v-model="calendarDate"
                                :color="currentTheme.primaryColorRoot"
                                :min-value="minDate"
                                :max-value="maxDate"
                                @update:model-value="handleCalendarChange"
                            />
                        </template>
                    </UPopover>
                </template>
            </UInput>
        </div>
    </UFormField>
</template>
