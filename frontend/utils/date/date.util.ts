import { CalendarDate } from '@internationalized/date'
import { parseISO, differenceInDays } from 'date-fns';

export const DateUtil = {
    convertStringUsaToBr: (dateString: string|null) => {
        if (!dateString) {
            return '-';
        }

        const date = new Date(dateString);
        date.setTime(date.getTime() + date.getTimezoneOffset() * 60 * 1000);
        return date.toLocaleDateString('pt-BR', { year: 'numeric', month: '2-digit', day: '2-digit'})
    },
    convertStringDateTimeToBr: (dateString: string) => {
        if (!dateString) {
            return '-';
        }
        const date = new Date(dateString)
        return date.toLocaleDateString('pt-BR', { year: 'numeric', month: '2-digit', day: '2-digit', minute: '2-digit', hour: '2-digit' })
    },
    getTodayIso8601Format: (): string => {
        const date = new Date()
        return date.toISOString().split('T')[0]
    },
    convertDateCalendarFormat(date: Date): CalendarDate {
        date.setTime(date.getTime() + date.getTimezoneOffset() * 60 * 1000);
        return new CalendarDate(date.getFullYear(), date.getMonth() + 1, date.getDate());
    },
    getDbToIso8601Format: (dateDb: string): string => {
        if (!dateDb) {
            return '';
        }
        const date = new Date(dateDb)
        return date.toISOString().split('T')[0]
    },
    daysIntervalInDatesString: (dateOne: string, dateTwo: string): number => {
        const data1 = parseISO(dateOne);
        const data2 = parseISO(dateTwo);

        return differenceInDays(data2, data1);
    }
}
