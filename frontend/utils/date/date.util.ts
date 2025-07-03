import { startOfMonth, endOfMonth, format, addMonths, parseISO } from 'date-fns';
import { ptBR } from 'date-fns/locale';
import {StringUtil} from "~/utils/string/string.util";

export const DateUtil = {
    convertStringUsaToBr: (dateString: string|null): string => {
        if (!dateString) {
            return '-';
        }

        const date = new Date(dateString);
        date.setTime(date.getTime() + date.getTimezoneOffset() * 60 * 1000);
        return date.toLocaleDateString('pt-BR', { year: 'numeric', month: '2-digit', day: '2-digit'})
    },
    getTodayIso8601Format: (): string => {
        const date = new Date()
        return date.toISOString().split('T')[0]
    },
    getDateStringIso8601Format: (dateString: string): string => {
        const date = parseISO(dateString)
        return date.toISOString().split('T')[0]
    },
    getMonthStartString: (): string => {
        const date = new Date()
        const start = startOfMonth(date);
        return format(start, 'yyyy-MM-dd');
    },
    getMonthEndString: (): string => {
        const date = new Date()
        const end = endOfMonth(date);
        return format(end, 'yyyy-MM-dd');
    },
    getDateLabel: (dateString: string): string => {
        const date = parseISO(dateString)
        const month = format(date, 'MMMM', { locale: ptBR });
        return `${StringUtil.capitalizeFirstLetters(month)} de ${date.getFullYear()}`
    },
    nextMonthDateStart: (dateString: string): string => {
        const date = parseISO(dateString)
        const nextMonth = addMonths(date, 1);
        return format(startOfMonth(nextMonth), 'yyyy-MM-dd')
    },
    nextMonthDateEnd: (dateString: string): string => {
        const date = parseISO(dateString)
        const nextMonth = addMonths(date, 1);
        return format(endOfMonth(nextMonth), 'yyyy-MM-dd')
    },
    prevMonthDateStart: (dateString: string): string => {
        const date = parseISO(dateString)
        const prevMonth = addMonths(date, -1);
        return format(startOfMonth(prevMonth), 'yyyy-MM-dd')
    },
    prevMonthDateEnd: (dateString: string): string => {
        const date = parseISO(dateString)
        const prevMonth = addMonths(date, -1);
        return format(endOfMonth(prevMonth), 'yyyy-MM-dd')
    },
}
