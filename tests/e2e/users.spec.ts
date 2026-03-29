import { expect, test } from '@playwright/test'

test.describe('Users CRUD', () => {
    test('can view users list', async ({ page }) => {
        await page.goto('/admin/users')
        await expect(page.getByRole('heading', { name: 'Users' })).toBeVisible()
        await expect(page.getByRole('table')).toBeVisible()
    })

    test('can search users', async ({ page }) => {
        await page.goto('/admin/users')
        await page.getByPlaceholder('Search users...').fill('admin')
        await expect(page.getByRole('table')).toBeVisible()
    })

    test('can navigate to create user page', async ({ page }) => {
        await page.goto('/admin/users')
        await page.getByRole('link', { name: 'Create User' }).click()
        await expect(page.getByRole('heading', { name: 'Create User' })).toBeVisible()
    })

    test('can create a new user', async ({ page }) => {
        await page.goto('/admin/users/create')

        await page.getByLabel('Name').fill('Test User E2E')
        await page.getByLabel('Email').fill(`e2e-${Date.now()}@example.com`)
        await page.getByLabel('Password', { exact: true }).fill('password')
        await page.getByLabel('Confirm Password').fill('password')
        await page.getByRole('button', { name: 'Create User' }).click()

        await expect(page).toHaveURL('/admin/users')
    })

    test('can navigate to edit user page', async ({ page }) => {
        await page.goto('/admin/users')
        const editLink = page.getByRole('link', { name: 'Edit' }).first()
        await editLink.click()
        await expect(page.getByRole('heading', { name: 'Edit User' })).toBeVisible()
    })
})
