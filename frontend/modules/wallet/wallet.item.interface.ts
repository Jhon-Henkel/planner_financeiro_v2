import type {StatusActiveInactiveType} from "~/types/status.active.inactive.type";

export interface IWalletItem {
    id: number
    name: string
    amount: number
    hidden: boolean
    status: StatusActiveInactiveType
    created_at: string
    updated_at: string
}
