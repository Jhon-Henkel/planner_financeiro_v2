import type {PrimaryColor} from "~/composables/theme/use.theme";

export interface IApiListResponseInterface<T> {
    current_page: number
    data: T[],
    first_page_url: string
    from: number
    last_page: number
    last_page_url: string
    links: {
        url: string | null
        label: string
        active: boolean
    }[]
    next_page_url: string | null
    path: string
    per_page: number
    prev_page_url: string | null
    to: number
    total: number
    status: number
    meta?: {
        details?: {
            label: string
            value: string|number
            color: PrimaryColor
            full: boolean
        }[]
    }
}
