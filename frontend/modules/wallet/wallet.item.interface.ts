import type {TActiveInactive} from "~/types/active.inactive.type";

export interface IWalletItem {
    id: number
    name: string
    amount: number
    hidden: boolean
    status: TActiveInactive
    status_label: string
    created_at: string
    updated_at: string
}
