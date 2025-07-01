export interface ExpenseItem {
    id: number
    description: string
    type: number
    variable: boolean
    amount: number
    date_start: string
    date_end: string
    total_installments: number
    recurrence_interval: number
    observations: string|null
    created_at: string
    updated_at: string
    expense_id: number
    installment_number: number
    due_date: string
    paid_at: string|null
    paid: boolean
    bank_slip: string|null
    installment_id: number|null
    type_label: string
}
