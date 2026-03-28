import { test as setup, expect } from '@playwright/test'

setup('authenticate', async ({ page }) => {
    await page.goto('/login')
    await page.getByLabel('Email').fill('admin@example.com')
    await page.getByLabel('Password').fill('password')
    await page.getByRole('button', { name: 'Log in' }).click()
    await expect(page).toHaveURL('/dashboard')
    await page.context().storageState({ path: 'tests/e2e/.auth/user.json' })
})
