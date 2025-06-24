import { z } from 'zod'

export const ExpenseSchema = z.object({
    description: z.string().nonempty(),
    type: z.number().min(1),
    variable: z.boolean(),
    dateStart: z.string().nonempty(),
    installments: z.number().min(0),
    amount: z.number().min(0).default(0),
    observations: z.string().nullable(),
})

export type ExpenseSchemaType = z.output<typeof ExpenseSchema>
