import { test, expect } from '@playwright/test';

test('Página principal', async ({ page }) => {
  await page.goto('http://18.219.191.23:8000/login');

  await expect(page).toHaveURL(/login/);
});