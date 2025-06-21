import type {TStatusActiveInactive} from "~/types/TStatusActiveInactive";

export interface IWalletItem {
    id: number
    name: string
    amount: number
    hidden: boolean
    status: TStatusActiveInactive
    created_at: string
    updated_at: string
}
