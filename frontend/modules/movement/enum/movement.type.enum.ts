export const MovementTypeEnum = {
    spent: 5,
    received: 6,
    transfer: 7,
    cssBadgeClass: (statusId: number): string => {
        switch (statusId) {
        case MovementTypeEnum.received:
            return 'bg-green-100 text-green-700'
        case MovementTypeEnum.spent:
            return 'bg-error-100 text-error-700'
        default:
            return 'bg-blue-100 text-blue-700'
        }
    },
    label: (statusId: number): string => {
        switch (statusId) {
        case MovementTypeEnum.received:
            return 'Entrada'
        case MovementTypeEnum.spent:
            return 'Saída'
        default:
            return 'Transf.'
        }
    },
}
