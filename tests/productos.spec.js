import { test, expect } from '@playwright/test';

const EMAIL = process.env.TEST_EMAIL ?? 'admin@gmail.com';
const PASSWORD = process.env.TEST_PASSWORD ?? '123456';

async function login(page) {
    await page.goto('/login');
    await page.locator('input[name="email"]').fill(EMAIL);
    await page.locator('input[name="password"]').fill(PASSWORD);
    await page.getByRole('button', { name: /iniciar sesi/i }).click();

    await expect(page).toHaveURL(/\/$/);
    await expect(page.getByRole('heading', { name: /panel de control/i })).toBeVisible();
}

async function firstSelectValue(page, selector) {
    return page.locator(selector).evaluate((select) => {
        const option = select.querySelector('option:not([disabled]):not([value=""])');
        return option ? option.value : null;
    });
}

test('CRUD de productos', async ({ page }) => {
    const suffix = Date.now();
    const originalName = `Producto E2E ${suffix}`;
    const editedName = `Producto Editado ${suffix}`;
    const productCode = `E2E-${suffix}`;

    await login(page);

    await page.goto('/productos');
    await page.getByRole('button', { name: /a\u00f1adir nuevo registro/i }).click();

    const marcaId = await firstSelectValue(page, '#marca_id');
    const presentacionId = await firstSelectValue(page, '#presentacione_id');
    const categoriaId = await firstSelectValue(page, '#categorias');

    expect(marcaId, 'Debe existir al menos una marca activa').not.toBeNull();
    expect(presentacionId, 'Debe existir al menos una presentacion activa').not.toBeNull();
    expect(categoriaId, 'Debe existir al menos una categoria activa').not.toBeNull();

    await page.locator('input[name="codigo"]').fill(productCode);
    await page.locator('input[name="nombre"]').fill(originalName);
    await page.locator('textarea[name="descripcion"]').fill('Producto creado por Playwright');
    await page.locator('input[name="fecha_vencimiento"]').fill('2030-12-31');
    await page.locator('#marca_id').selectOption(marcaId);
    await page.locator('#presentacione_id').selectOption(presentacionId);
    await page.locator('#categorias').selectOption([categoriaId]);
    await page.getByRole('button', { name: /^guardar$/i }).click();

    await expect(page.getByRole('cell', { name: originalName })).toBeVisible();

    let productRow = page.locator('#datatablesSimple tbody tr').filter({ hasText: originalName }).first();
    await productRow.getByRole('button', { name: /editar/i }).click();

    await page.locator('input[name="nombre"]').fill(editedName);
    await page.getByRole('button', { name: /^guardar$/i }).click();

    await expect(page.getByRole('cell', { name: editedName })).toBeVisible();
    await expect(page.getByRole('cell', { name: originalName })).toHaveCount(0);

    await page.locator('.datatable-input').fill(editedName);
    await expect(page.locator('#datatablesSimple tbody tr').filter({ hasText: editedName })).toBeVisible();

    await page.locator('.datatable-input').fill('');

    productRow = page.locator('#datatablesSimple tbody tr').filter({ hasText: editedName }).first();
    await productRow.getByRole('button', { name: /eliminar/i }).click();
    await page.getByRole('button', { name: /^confirmar$/i }).click();

    await expect(page.locator('#datatablesSimple tbody tr').filter({ hasText: editedName })).toContainText('Restaurar');
});
