import { z } from 'zod'
import {StatusActiveInactiveEnum} from "~/utils/enum/status.active.inactive.enum";
import {MovementTypeEnum} from "~/modules/movement/enum/movement.type.enum";

export const MovementSchema = z.object({
    description: z.string().nonempty().default(''),
    amount: z.number().min(0).default(0),
    type: z.number(),
    wallet_id: z.number().min(0),
})

export const MovementTransferSchema = z.object({
    amount: z.number().min(0).default(0),
    from_id: z.number().min(0),
    to_id: z.number().min(0),
})

export type MovementSchemaType = z.output<typeof MovementSchema>
export type MovementTransferSchemaType = z.output<typeof MovementTransferSchema>
