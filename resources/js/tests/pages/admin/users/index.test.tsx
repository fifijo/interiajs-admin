import { render, screen } from '@testing-library/react'
import { describe, expect, it, vi } from 'vitest'
import UsersIndex from '@/pages/admin/users/index'

vi.mock('@inertiajs/react', () => ({
    Head: ({ title }: { title: string }) => <title>{title}</title>,
    Link: ({
        href,
        children,
        dangerouslySetInnerHTML,
        ...props
    }: {
        href: string
        children?: React.ReactNode
        dangerouslySetInnerHTML?: { __html: string }
        [key: string]: unknown
    }) =>
        dangerouslySetInnerHTML ? (
            <a href={href} {...props} dangerouslySetInnerHTML={dangerouslySetInnerHTML} />
        ) : (
            <a href={href} {...props}>
                {children}
            </a>
        ),
    router: { get: vi.fn(), delete: vi.fn() },
    usePage: () => ({
        props: {
            auth: { user: { id: 99, name: 'Admin', email: 'admin@example.com' } },
        },
    }),
}))

vi.mock('@/routes', () => ({
    dashboard: () => ({ url: '/dashboard' }),
}))

vi.mock('@/routes/admin/users', () => ({
    index: () => ({ url: '/admin/users' }),
    create: () => ({ url: '/admin/users/create' }),
    edit: (id: number) => ({ url: `/admin/users/${id}/edit` }),
    destroy: (id: number) => ({ url: `/admin/users/${id}` }),
}))

const emptyPagination = {
    current_page: 1,
    first_page_url: null,
    from: null,
    last_page: 1,
    last_page_url: null,
    links: [],
    next_page_url: null,
    path: '/admin/users',
    per_page: 10,
    prev_page_url: null,
    to: null,
    total: 0,
}

const users = [
    {
        id: 1,
        name: 'John Doe',
        email: 'john@example.com',
        email_verified_at: '2026-01-01T00:00:00Z',
        created_at: '2026-01-01T00:00:00Z',
        updated_at: '2026-01-01T00:00:00Z',
    },
    {
        id: 2,
        name: 'Jane Smith',
        email: 'jane@example.com',
        email_verified_at: '2026-02-01T00:00:00Z',
        created_at: '2026-02-01T00:00:00Z',
        updated_at: '2026-02-01T00:00:00Z',
    },
]

describe('UsersIndex', () => {
    it('renders the users table with data', () => {
        render(<UsersIndex users={{ data: users, ...emptyPagination }} filters={{}} />)

        expect(screen.getByText('John Doe')).toBeInTheDocument()
        expect(screen.getByText('john@example.com')).toBeInTheDocument()
        expect(screen.getByText('Jane Smith')).toBeInTheDocument()
        expect(screen.getByText('jane@example.com')).toBeInTheDocument()
    })

    it('shows empty state when no users', () => {
        render(<UsersIndex users={{ data: [], ...emptyPagination }} filters={{}} />)

        expect(screen.getByText('No users found.')).toBeInTheDocument()
    })

    it('renders Create User button', () => {
        render(<UsersIndex users={{ data: users, ...emptyPagination }} filters={{}} />)

        expect(screen.getByText('Create User')).toBeInTheDocument()
    })

    it('does not show delete button for current user', () => {
        const currentUser = {
            id: 99,
            name: 'Admin',
            email: 'admin@example.com',
            email_verified_at: '2026-01-01T00:00:00Z',
            created_at: '2026-01-01T00:00:00Z',
            updated_at: '2026-01-01T00:00:00Z',
        }

        render(<UsersIndex users={{ data: [currentUser, ...users], ...emptyPagination }} filters={{}} />)

        const deleteButtons = screen.getAllByText('Delete')
        expect(deleteButtons).toHaveLength(2) // only for non-current users
    })

    it('renders search input', () => {
        render(<UsersIndex users={{ data: users, ...emptyPagination }} filters={{}} />)

        expect(screen.getByPlaceholderText('Search users...')).toBeInTheDocument()
    })
})
