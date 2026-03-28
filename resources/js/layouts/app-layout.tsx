import { usePage } from '@inertiajs/react'
import { useEffect } from 'react'
import { Toaster, toast } from 'sonner'
import AppLayoutTemplate from '@/layouts/app/app-sidebar-layout'
import type { BreadcrumbItem, Flash } from '@/types'

export default function AppLayout({
    breadcrumbs = [],
    children,
}: {
    breadcrumbs?: BreadcrumbItem[]
    children: React.ReactNode
}) {
    const { flash } = usePage<{ flash: Flash }>().props

    useEffect(() => {
        if (flash.success) toast.success(flash.success)
        if (flash.error) toast.error(flash.error)
    }, [flash])

    return (
        <>
            <AppLayoutTemplate breadcrumbs={breadcrumbs}>{children}</AppLayoutTemplate>
            <Toaster richColors closeButton />
        </>
    )
}
