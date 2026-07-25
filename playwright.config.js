import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
    testDir: './tests',

    /*
     * Tiempo máximo permitido para cada prueba.
     */
    timeout: 30_000,

    /*
     * Tiempo máximo para cada expect().
     */
    expect: {
        timeout: 10_000
    },

    /*
     * En CI se reintenta una vez.
     * Localmente no se hacen reintentos.
     */
    retries: process.env.CI ? 1 : 0,

    /*
     * Un solo worker en GitHub Actions evita problemas cuando
     * varias pruebas modifican los mismos datos.
     */
    workers: process.env.CI ? 1 : undefined,

    /*
     * Impide que test.only llegue accidentalmente a producción.
     */
    forbidOnly: Boolean(process.env.CI),

    /*
     * Genera tres tipos de salida:
     *
     * 1. list: muestra los errores en la consola de GitHub Actions.
     * 2. html: genera playwright-report/index.html.
     * 3. json: genera playwright-results.json.
     */
    reporter: [
        ['list'],

        [
            'html',
            {
                outputFolder: 'playwright-report',
                open: 'never'
            }
        ],

        [
            'json',
            {
                outputFile: 'playwright-results.json'
            }
        ]
    ],

    /*
     * Carpeta para screenshots, videos y traces.
     */
    outputDir: 'test-results',

    use: {
        /*
         * GitHub Actions usará el secret EC2_HOST.
         * Localmente se utilizará la IP indicada como respaldo.
         */
        baseURL:
            process.env.BASE_URL ??
            'http://18.191.77.25:8000',

        headless: true,

        /*
         * Captura una imagen cuando falla una prueba.
         */
        screenshot: 'only-on-failure',

        /*
         * Conserva el video únicamente cuando falla.
         */
        video: 'retain-on-failure',

        /*
         * Conserva el trace cuando falla.
         */
        trace: 'retain-on-failure',

        /*
         * Tiempo máximo para acciones como click y fill.
         */
        actionTimeout: 15_000,

        /*
         * Tiempo máximo para cargar páginas.
         */
        navigationTimeout: 30_000,

        /*
         * Ignorar errores HTTPS solo si la aplicación usa
         * certificados locales o autofirmados.
         */
        ignoreHTTPSErrors: false
    },

    projects: [
        {
            name: 'chromium',

            use: {
                ...devices['Desktop Chrome']
            }
        }
    ]
});