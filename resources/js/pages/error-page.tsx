import { Head, Link } from '@inertiajs/react'
import { Button } from '@/components/ui/button'

interface Props {
    status: number
}

const titles: Record<number, string> = {
    403: 'Forbidden',
    404: 'Page Not Found',
    500: 'Server Error',
    503: 'Service Unavailable',
}

const descriptions: Record<number, string> = {
    403: 'Sorry, you are not authorized to access this page.',
    404: 'Sorry, the page you are looking for could not be found.',
    500: 'Whoops, something went wrong on our servers.',
    503: 'Sorry, we are doing some maintenance. Please check back soon.',
}

export default function ErrorPage({ status }: Props) {
    const title = titles[status] ?? 'Error'
    const description = descriptions[status] ?? 'An unexpected error occurred.'

    return (
        <>
            <Head title={title} />
            <div className="flex min-h-screen flex-col items-center justify-center gap-6">
                <div className="text-center space-y-2">
                    <h1 className="text-7xl font-bold text-muted-foreground">{status}</h1>
                    <h2 className="text-2xl font-semibold">{title}</h2>
                    <p className="text-muted-foreground">{description}</p>
                </div>
                <Button asChild>
                    <Link href="/">Go Home</Link>
                </Button>
            </div>
        </>
    )
}
