export const StatusActiveInactiveEnum = {
    active: 1,
    inactive: 0,
    cssBadgeClass: (statusId: number): string => {
        switch (statusId) {
            case StatusActiveInactiveEnum.active:
                return 'bg-green-100 text-green-700'
            case StatusActiveInactiveEnum.inactive:
                return 'bg-error-100 text-error-700'
            default:
                return 'bg-gray-100 text-gray-700'
        }
    },
    listForSelect: (): {id: number, label: string}[] => {
        return [
            { id: StatusActiveInactiveEnum.active, label: 'Ativo' },
            { id: StatusActiveInactiveEnum.inactive, label: 'Inativo' },
        ]
    },
    label: (statusId: number) => {
        switch (statusId) {
            case StatusActiveInactiveEnum.active:
                return 'Ativo'
            case StatusActiveInactiveEnum.inactive:
                return 'Inativo'
            default:
                return ''
        }
    }
}
