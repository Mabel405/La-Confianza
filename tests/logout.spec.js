import { test, expect } from '@playwright/test';

const EMAIL = process.env.TEST_EMAIL ?? 'admin@gmail.com';
const PASSWORD = process.env.TEST_PASSWORD ?? '123456';

test('Cerrar sesión', async ({ page }) => {
    await page.goto('/login');

    await page.locator('input[name="email"]').fill(EMAIL);
    await page.locator('input[name="password"]').fill(PASSWORD);
    await page.getByRole('button', { name: /iniciar sesión/i }).click();

    await expect(page).toHaveURL(/\/$/);
    await expect(page.getByRole('heading', { name: /panel de control/i })).toBeVisible();

    await page.locator('#navbarDropdown').click();
    await page.locator('a[href$="/logout"]').click();

    await expect(page).toHaveURL(/\/login$/);
    await expect(page.getByRole('button', { name: /iniciar sesión/i })).toBeVisible();
});
