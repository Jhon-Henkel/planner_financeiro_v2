export const NumberUtil = {
    toCurrency: (value: number|string): string => {
        value = Number(value);
        if (Number.isNaN(value)) {
            value = 0
        }
        return `${value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`
    },
    strPadZeros: (string: number, zeros: number): string => {
        return string.toString().padStart(zeros, '0')
    }
}
