import { z } from 'zod'

export const ExpensePaySchema = z.object({
    walletId: z.number().min(1),
    amount: z.number().min(0.01),
    installmentId: z.number().nullable(),
    expenseId: z.number().min(1),
    bankSlip: z.string().nullable(),
})

export type ExpensePaySchemaType = z.output<typeof ExpensePaySchema>
