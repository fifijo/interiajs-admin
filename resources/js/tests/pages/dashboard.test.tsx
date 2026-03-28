import { render, screen } from '@testing-library/react'
import { describe, expect, it, vi } from 'vitest'
import Dashboard from '@/pages/dashboard'

vi.mock('@inertiajs/react', () => ({
    Head: ({ title }: { title: string }) => <title>{title}</title>,
    Link: ({ href, children, ...props }: { href: string; children: React.ReactNode; [key: string]: unknown }) => (
        <a href={href} {...props}>
            {children}
        </a>
    ),
}))

vi.mock('@/routes', () => ({
    dashboard: () => ({ url: '/dashboard' }),
}))

vi.mock('@/routes/admin/users', () => ({
    index: () => ({ url: '/admin/users' }),
}))

const stats = { totalUsers: 42, newThisMonth: 7 }

const recentUsers = [
    { id: 1, name: 'Alice', email: 'alice@example.com', created_at: '2026-03-01T00:00:00Z' },
    { id: 2, name: 'Bob', email: 'bob@example.com', created_at: '2026-03-15T00:00:00Z' },
]

describe('Dashboard', () => {
    it('renders stat cards with correct values', () => {
        render(<Dashboard stats={stats} recentUsers={recentUsers} />)

        expect(screen.getByText('42')).toBeInTheDocument()
        expect(screen.getByText('7')).toBeInTheDocument()
        expect(screen.getByText('Total Users')).toBeInTheDocument()
        expect(screen.getByText('New This Month')).toBeInTheDocument()
    })

    it('renders recent users table', () => {
        render(<Dashboard stats={stats} recentUsers={recentUsers} />)

        expect(screen.getByText('Alice')).toBeInTheDocument()
        expect(screen.getByText('alice@example.com')).toBeInTheDocument()
        expect(screen.getByText('Bob')).toBeInTheDocument()
        expect(screen.getByText('bob@example.com')).toBeInTheDocument()
    })

    it('shows empty state when no recent users', () => {
        render(<Dashboard stats={{ totalUsers: 0, newThisMonth: 0 }} recentUsers={[]} />)

        expect(screen.getByText('No users yet.')).toBeInTheDocument()
    })

    it('renders View all link to users index', () => {
        render(<Dashboard stats={stats} recentUsers={recentUsers} />)

        const viewAllLink = screen.getByText('View all')
        expect(viewAllLink).toHaveAttribute('href', '/admin/users')
    })
})
