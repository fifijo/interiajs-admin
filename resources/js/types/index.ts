export type * from './auth'
export type * from './navigation'
export type * from './ui'

export type Flash = {
    success?: string
    error?: string
}

export type PaginatedData<T> = {
    data: T[]
    links: {
        first: string | null
        last: string | null
        prev: string | null
        next: string | null
    }
    meta: {
        current_page: number
        from: number | null
        last_page: number
        links: {
            url: string | null
            label: string
            active: boolean
        }[]
        path: string
        per_page: number
        to: number | null
        total: number
    }
}

export type PageProps<T = Record<string, unknown>> = T & {
    auth: { user: import('./auth').User }
    flash: Flash
    name: string
}
