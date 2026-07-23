# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: productos.spec.js >> CRUD de productos
- Location: tests\productos.spec.js:23:1

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
  6  | async function login(page) {
  7  |     await page.goto('/login');
> 8  |     await page.locator('input[name="email"]').fill(EMAIL);
     |                                               ^ Error: locator.fill: Test timeout of 30000ms exceeded.
  9  |     await page.locator('input[name="password"]').fill(PASSWORD);
  10 |     await page.getByRole('button', { name: /iniciar sesi/i }).click();
  11 | 
  12 |     await expect(page).toHaveURL(/\/$/);
  13 |     await expect(page.getByRole('heading', { name: /panel de control/i })).toBeVisible();
  14 | }
  15 | 
  16 | async function firstSelectValue(page, selector) {
  17 |     return page.locator(selector).evaluate((select) => {
  18 |         const option = select.querySelector('option:not([disabled]):not([value=""])');
  19 |         return option ? option.value : null;
  20 |     });
  21 | }
  22 | 
  23 | test('CRUD de productos', async ({ page }) => {
  24 |     const suffix = Date.now();
  25 |     const originalName = `Producto E2E ${suffix}`;
  26 |     const editedName = `Producto Editado ${suffix}`;
  27 |     const productCode = `E2E-${suffix}`;
  28 | 
  29 |     await login(page);
  30 | 
  31 |     await page.goto('/productos');
  32 |     await page.getByRole('button', { name: /a\u00f1adir nuevo registro/i }).click();
  33 | 
  34 |     const marcaId = await firstSelectValue(page, '#marca_id');
  35 |     const presentacionId = await firstSelectValue(page, '#presentacione_id');
  36 |     const categoriaId = await firstSelectValue(page, '#categorias');
  37 | 
  38 |     expect(marcaId, 'Debe existir al menos una marca activa').not.toBeNull();
  39 |     expect(presentacionId, 'Debe existir al menos una presentacion activa').not.toBeNull();
  40 |     expect(categoriaId, 'Debe existir al menos una categoria activa').not.toBeNull();
  41 | 
  42 |     await page.locator('input[name="codigo"]').fill(productCode);
  43 |     await page.locator('input[name="nombre"]').fill(originalName);
  44 |     await page.locator('textarea[name="descripcion"]').fill('Producto creado por Playwright');
  45 |     await page.locator('input[name="fecha_vencimiento"]').fill('2030-12-31');
  46 |     await page.locator('#marca_id').selectOption(marcaId);
  47 |     await page.locator('#presentacione_id').selectOption(presentacionId);
  48 |     await page.locator('#categorias').selectOption([categoriaId]);
  49 |     await page.getByRole('button', { name: /^guardar$/i }).click();
  50 | 
  51 |     await expect(page.getByRole('cell', { name: originalName })).toBeVisible();
  52 | 
  53 |     let productRow = page.locator('#datatablesSimple tbody tr').filter({ hasText: originalName }).first();
  54 |     await productRow.getByRole('button', { name: /editar/i }).click();
  55 | 
  56 |     await page.locator('input[name="nombre"]').fill(editedName);
  57 |     await page.getByRole('button', { name: /^guardar$/i }).click();
  58 | 
  59 |     await expect(page.getByRole('cell', { name: editedName })).toBeVisible();
  60 |     await expect(page.getByRole('cell', { name: originalName })).toHaveCount(0);
  61 | 
  62 |     await page.locator('.datatable-input').fill(editedName);
  63 |     await expect(page.locator('#datatablesSimple tbody tr').filter({ hasText: editedName })).toBeVisible();
  64 | 
  65 |     await page.locator('.datatable-input').fill('');
  66 | 
  67 |     productRow = page.locator('#datatablesSimple tbody tr').filter({ hasText: editedName }).first();
  68 |     await productRow.getByRole('button', { name: /eliminar/i }).click();
  69 |     await page.getByRole('button', { name: /^confirmar$/i }).click();
  70 | 
  71 |     await expect(page.locator('#datatablesSimple tbody tr').filter({ hasText: editedName })).toContainText('Restaurar');
  72 | });
  73 | 
```