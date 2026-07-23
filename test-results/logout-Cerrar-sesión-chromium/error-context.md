# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: logout.spec.js >> Cerrar sesión
- Location: tests\logout.spec.js:6:1

# Error details

```
Test timeout of 30000ms exceeded.
```

```
Error: locator.fill: Test timeout of 30000ms exceeded.
Call log:
  - waiting for locator('input[name="email"]')

```

# Page snapshot

```yaml
- generic [active] [ref=e1]:
  - heading "Not Found" [level=1] [ref=e2]
  - paragraph [ref=e3]: The requested URL was not found on this server.
  - separator [ref=e4]
  - generic [ref=e5]: Apache/2.4.66 (Ubuntu) Server at 18.191.77.25 Port 80
```

# Test source

```ts
  1  | import { test, expect } from '@playwright/test';
  2  | 
  3  | const EMAIL = process.env.TEST_EMAIL ?? 'admin@gmail.com';
  4  | const PASSWORD = process.env.TEST_PASSWORD ?? '123456';
  5  | 
  6  | test('Cerrar sesión', async ({ page }) => {
  7  |     await page.goto('/login');
  8  | 
> 9  |     await page.locator('input[name="email"]').fill(EMAIL);
     |                                               ^ Error: locator.fill: Test timeout of 30000ms exceeded.
  10 |     await page.locator('input[name="password"]').fill(PASSWORD);
  11 |     await page.getByRole('button', { name: /iniciar sesión/i }).click();
  12 | 
  13 |     await expect(page).toHaveURL(/\/$/);
  14 |     await expect(page.getByRole('heading', { name: /panel de control/i })).toBeVisible();
  15 | 
  16 |     await page.locator('#navbarDropdown').click();
  17 |     await page.locator('a[href$="/logout"]').click();
  18 | 
  19 |     await expect(page).toHaveURL(/\/login$/);
  20 |     await expect(page.getByRole('button', { name: /iniciar sesión/i })).toBeVisible();
  21 | });
  22 | 
```