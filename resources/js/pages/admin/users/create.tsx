import { Head, Link, useForm } from '@inertiajs/react'
import type { FormEventHandler } from 'react'
import { Button } from '@/components/ui/button'
import { Field, FieldError, FieldGroup, FieldLabel } from '@/components/ui/field'
import { Input } from '@/components/ui/input'
import { dashboard } from '@/routes'
import { index as adminUsersIndex, store as adminUsersStore } from '@/routes/admin/users'

export default function UsersCreate() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    })

    const submit: FormEventHandler = (e) => {
        e.preventDefault()
        post(adminUsersStore().url)
    }

    return (
        <>
            <Head title="Create User" />
            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold tracking-tight">Create User</h1>
                </div>

                <form onSubmit={submit} className="max-w-lg space-y-6">
                    <FieldGroup>
                        <Field>
                            <FieldLabel htmlFor="name">Name</FieldLabel>
                            <Input
                                id="name"
                                type="text"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                required
                                autoFocus
                            />
                            {errors.name && <FieldError>{errors.name}</FieldError>}
                        </Field>

                        <Field>
                            <FieldLabel htmlFor="email">Email</FieldLabel>
                            <Input
                                id="email"
                                type="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                required
                            />
                            {errors.email && <FieldError>{errors.email}</FieldError>}
                        </Field>

                        <Field>
                            <FieldLabel htmlFor="password">Password</FieldLabel>
                            <Input
                                id="password"
                                type="password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                required
                            />
                            {errors.password && <FieldError>{errors.password}</FieldError>}
                        </Field>

                        <Field>
                            <FieldLabel htmlFor="password_confirmation">Confirm Password</FieldLabel>
                            <Input
                                id="password_confirmation"
                                type="password"
                                value={data.password_confirmation}
                                onChange={(e) => setData('password_confirmation', e.target.value)}
                                required
                            />
                            {errors.password_confirmation && <FieldError>{errors.password_confirmation}</FieldError>}
                        </Field>
                    </FieldGroup>

                    <div className="flex gap-4">
                        <Button type="submit" disabled={processing}>
                            Create User
                        </Button>
                        <Button variant="outline" asChild>
                            <Link href={adminUsersIndex().url}>Cancel</Link>
                        </Button>
                    </div>
                </form>
            </div>
        </>
    )
}

UsersCreate.layout = {
    breadcrumbs: [
        { title: 'Dashboard', href: dashboard().url },
        { title: 'Users', href: adminUsersIndex().url },
        { title: 'Create', href: '#' },
    ],
}
