export const ExpenseTypeEnum = {
    fixed: 1,
    oneTime: 2,
    installment: 3,
    listForSelect: (): {id: number, label: string}[] => {
        return [
            { id: ExpenseTypeEnum.fixed, label: 'Fixa' },
            { id: ExpenseTypeEnum.oneTime, label: 'Única' },
            { id: ExpenseTypeEnum.installment, label: 'Parcelada' },
        ]
    },
}
