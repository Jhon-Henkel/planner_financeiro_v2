import { z } from 'zod'
import {StatusActiveInactiveEnum} from "~/utils/enum/status.active.inactive.enum";

export const WalletSchema = z.object({
    name: z.string().nonempty().default(''),
    amount: z.number().min(0).default(0),
    hidden: z.boolean().default(false),
    status: z.number().default(StatusActiveInactiveEnum.active)
})

export type WalletSchemaType = z.output<typeof WalletSchema>
