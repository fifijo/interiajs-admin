import { expect, test } from '@playwright/test'

test.describe('Dashboard', () => {
    test('can view dashboard with stats', async ({ page }) => {
        await page.goto('/dashboard')
        await expect(page.getByText('Total Users')).toBeVisible()
        await expect(page.getByText('New This Month')).toBeVisible()
        await expect(page.getByText('Recent Users')).toBeVisible()
    })

    test('can navigate to users from dashboard', async ({ page }) => {
        await page.goto('/dashboard')
        await page.getByRole('link', { name: 'View all' }).click()
        await expect(page).toHaveURL('/admin/users')
    })
})
