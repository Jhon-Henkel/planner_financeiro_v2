import type {TMovement} from "~/modules/movement/type/movement.type";

export interface IMovementItem {
    id: number
    wallet_id: number
    description: string
    amount: number
    type: TMovement
    type_label: string
    wallet_name: string
    created_at: string
    updated_at: string
}
