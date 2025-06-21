import type {TableColumn} from "@nuxt/ui";
import {UBadge, UButton, UCheckbox, UDropdownMenu} from "#components";
import type {TableActionItem} from "~/components/table/type/table.row.item.actions.type";
import {IconEnum} from "~/utils/enum/icon.enum";
import type {Column} from '@tanstack/vue-table'
import type {Row} from "@tanstack/table-core";
import {DateUtil} from "~/utils/date/date.util";
import {NumberUtil} from "~/utils/number/number.util";
import {StatusActiveInactiveEnum} from "~/utils/enum/status.active.inactive.enum";

export class TableColumnHeaderDTO {
    protected object: TableColumn<any>[] = []
    protected haveSorting: boolean

    constructor(haveSorting: boolean = true) {
        this.haveSorting = haveSorting
    }

    public removeColumn(key: string): void {
        this.object = this.object.filter(item => (item as any).accessorKey !== key)
    }

    public addColumn(key: string, label: string, haveSorting: boolean = true): void {
        this.object.push({
            accessorKey: key,
            header: ({ column }) => this.getHeader(column, label, haveSorting),
        })
    }

    public addBoolColumn(key: string, label: string, haveSorting: boolean = true): void {
        this.object.push({
            accessorKey: key,
            header: ({ column }) => this.getHeader(column, label, haveSorting),
            cell: ({ row }) => {
                return h('div', {}, row.original[key] === true ? 'Sim' : 'Não');
            }

        })
    }

    public addColumnWithCell(key: string, label: string, cell: (row: Row<any>) => any): void {
        this.object.push({
            accessorKey: key,
            header: ({ column }) => this.getHeader(column, label),
            cell: ({ row }) => cell(row)
        })
    }

    public addDateColumn(key: string, label: string): void {
        this.object.push({
            accessorKey: key,
            header: ({ column }) => this.getHeader(column, label),
            cell: ({ row }) => {
                const date = DateUtil.convertStringUsaToBr(row.original[key]);
                if (date === '-') {
                    return h('div', {class: 'text-center'}, date);
                }
                return h('div', {}, date);
            }
        })
    }

    public addDateTimeColumn(key: string, label: string): void {
        this.object.push({
            accessorKey: key,
            header: ({ column }) => this.getHeader(column, label),
            cell: ({ row }) => {
                const date = DateUtil.convertStringDateTimeToBr(row.original[key])
                if (date === '-') {
                    return h('div', { class: 'text-center' }, date);
                }
                return h('div', {}, date);
            }
        })
    }

    public addCheckboxColumn(): void {
        this.object.push({
            id: 'select',
            header: ({ table }) => h(UCheckbox, {
                'modelValue': table.getIsSomePageRowsSelected() ? 'indeterminate' : table.getIsAllPageRowsSelected(),
                'onUpdate:modelValue': (value: boolean | 'indeterminate') => table.toggleAllPageRowsSelected(!!value),
                'aria-label': 'Selecionar Todos',
            }),
            cell: ({ row }) => h(UCheckbox, {
                'modelValue': row.getIsSelected(),
                'onUpdate:modelValue': (value: boolean | 'indeterminate') => row.toggleSelected(!!value),
                'aria-label': 'Selecionar Linha',
            }),
            enableSorting: false,
            enableHiding: false
        })
    }

    public addColumnWithJoin(key: string, label: string, join: string, separator: string = '-', textEnd: string = '', joinSide: "left" | "right" = "right"): void {
        this.object.push({
            accessorKey: key,
            header: ({ column }) => this.getHeader(column, label),
            cell: ({ row }) => {
                let joinColumn = row.original[join]
                if (joinColumn === null) {
                    joinColumn = ''
                } else {
                    if (joinSide === 'left') {
                        joinColumn = ` ${joinColumn} ${separator}`
                    } else {
                        joinColumn = ` ${separator} ${joinColumn}`
                    }
                }
                if (joinSide === 'left') {
                    return `${joinColumn}${row.original[key]}${textEnd}`
                }
                return `${row.original[key]}${joinColumn}${textEnd}`
            }
        })
    }

    public addCurrencyColumn(key: string, label: string): void {
        this.object.push({
            accessorKey: key,
            header: ({ column }) => this.getHeader(column, label),
            cell: ({ row }) => {
                const value: number = parseFloat(String(row.original[key]))
                return NumberUtil.toCurrency(value)
            }
        })
    }

    public addColumnOptions(actions: (object: any) => TableActionItem[]): void {
        this.object.push({
            id: 'actions',
            header: () => h('div', { class: 'text-right w-full' }, 'Ações'),
            cell: ({row}) => {
                return h(
                    'div',
                    { class: 'text-right'},
                    h(
                        UDropdownMenu as unknown as string,
                        {
                            content: {
                                align: 'end'
                            },
                            items: actions(row.original).map((item) => ({
                                ...item,
                                class: `cursor-pointer`
                            })),
                            'aria-label': 'Actions dropdown'
                        },
                        () => h(UButton, {
                            icon: 'i-lucide-ellipsis-vertical',
                            color: 'neutral',
                            variant: 'ghost',
                            class: 'ml-auto cursor-pointer',
                            'aria-label': 'Actions dropdown'
                        })
                    )
                )
            }
        })
    }

    public addBadgeStatusColumn(): void {
        this.object.push({
            accessorKey: 'status',
            header: ({ column }) => this.getHeader(column, 'Status'),
            cell: ({ row }) => {
                const id = row.original.status
                const label = row.original.status_label
                return h(UBadge, { class: StatusActiveInactiveEnum.cssBadgeClass(id) }, { default: () => label });
            }
        })
    }

    public getObject(): TableColumn<any>[] {
        return this.object
    }

    protected getHeader(column: Column<any>, label: string, haveSorting: boolean = true) {
        if (!this.haveSorting || !haveSorting) {
            return h('div', { class: 'text-left w-full' }, label)
        }

        const isSorted = column.getIsSorted()

        return h(
            UDropdownMenu as unknown as string,
            {
                content: {
                    align: 'start'
                },
                'aria-label': 'Actions dropdown',
                class: 'cursor-pointer',
                items: [
                    {
                        label: 'Asc',
                        type: 'checkbox',
                        icon: IconEnum.arrowUpNarrowWide,
                        checked: isSorted === 'asc',
                        onSelect: () => {
                            if (isSorted === 'asc') {
                                column.clearSorting()
                            } else {
                                column.toggleSorting(false)
                            }
                        }
                    },
                    {
                        label: 'Desc',
                        icon: IconEnum.arrowDownWideNarrow,
                        type: 'checkbox',
                        checked: isSorted === 'desc',
                        onSelect: () => {
                            if (isSorted === 'desc') {
                                column.clearSorting()
                            } else {
                                column.toggleSorting(true)
                            }
                        }
                    }
                ]
            },
            () => h(UButton, {
                color: 'neutral',
                variant: 'ghost',
                label,
                icon: isSorted ? isSorted === 'asc' ? IconEnum.arrowUpNarrowWide : IconEnum.arrowDownWideNarrow : IconEnum.arrowUpDown,
                class: '-mx-2.5 data-[state=open]:bg-elevated', 'aria-label': `Sort by ${isSorted === 'asc' ? 'descending' : 'ascending'}`
            })
        )
    }
}
