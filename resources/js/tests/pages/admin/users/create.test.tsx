import { render, screen } from '@testing-library/react'
import { describe, expect, it, vi } from 'vitest'
import UsersCreate from '@/pages/admin/users/create'

vi.mock('@inertiajs/react', () => ({
    Head: ({ title }: { title: string }) => <title>{title}</title>,
    Link: ({ href, children, ...props }: { href: string; children: React.ReactNode; [key: string]: unknown }) => (
        <a href={href} {...props}>
            {children}
        </a>
    ),
    useForm: () => ({
        data: { name: '', email: '', password: '', password_confirmation: '' },
        setData: vi.fn(),
        post: vi.fn(),
        processing: false,
        errors: {},
    }),
}))

vi.mock('@/routes', () => ({
    dashboard: () => ({ url: '/dashboard' }),
}))

vi.mock('@/routes/admin/users', () => ({
    index: () => ({ url: '/admin/users' }),
    store: () => ({ url: '/admin/users' }),
}))

describe('UsersCreate', () => {
    it('renders the create user form', () => {
        render(<UsersCreate />)

        expect(screen.getByText('Create User', { selector: 'h1' })).toBeInTheDocument()
        expect(screen.getByLabelText('Name')).toBeInTheDocument()
        expect(screen.getByLabelText('Email')).toBeInTheDocument()
        expect(screen.getByLabelText('Password')).toBeInTheDocument()
        expect(screen.getByLabelText('Confirm Password')).toBeInTheDocument()
    })

    it('renders submit and cancel buttons', () => {
        render(<UsersCreate />)

        expect(screen.getByRole('button', { name: 'Create User' })).toBeInTheDocument()
        expect(screen.getByText('Cancel')).toBeInTheDocument()
    })

    it('cancel links back to users index', () => {
        render(<UsersCreate />)

        const cancelLink = screen.getByText('Cancel')
        expect(cancelLink).toHaveAttribute('href', '/admin/users')
    })
})
