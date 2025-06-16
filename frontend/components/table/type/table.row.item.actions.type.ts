export type TableActionItem = {
    type?: string,
    label?: string,
    onSelect?: (id: number) => void
    icon?: string
    color?: string
}
