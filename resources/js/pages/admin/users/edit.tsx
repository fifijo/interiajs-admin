import { Head, Link, useForm } from '@inertiajs/react'
import type { FormEventHandler } from 'react'
import { Button } from '@/components/ui/button'
import { Field, FieldError, FieldGroup, FieldLabel } from '@/components/ui/field'
import { Input } from '@/components/ui/input'
import { dashboard } from '@/routes'
import { edit as adminUsersEdit, index as adminUsersIndex, update as adminUsersUpdate } from '@/routes/admin/users'
import type { User } from '@/types'

interface Props {
    user: User
}

export default function UsersEdit({ user }: Props) {
    const { data, setData, patch, processing, errors } = useForm({
        name: user.name,
        email: user.email,
    })

    const submit: FormEventHandler = (e) => {
        e.preventDefault()
        patch(adminUsersUpdate(user.id).url)
    }

    return (
        <>
            <Head title={`Edit ${user.name}`} />
            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold tracking-tight">Edit User</h1>
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
                    </FieldGroup>

                    <div className="flex gap-4">
                        <Button type="submit" disabled={processing}>
                            Update User
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

UsersEdit.layout = {
    breadcrumbs: [
        { title: 'Dashboard', href: dashboard().url },
        { title: 'Users', href: adminUsersIndex().url },
        { title: 'Edit', href: adminUsersEdit(0).url },
    ],
}
