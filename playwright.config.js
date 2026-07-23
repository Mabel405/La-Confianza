// playwright.config.js
import { defineConfig, devices } from '@playwright/test';

export default defineConfig({

    testDir: './tests',

    timeout: 30000,

    retries: 1,

    reporter: [
        ['html'],
        ['list']
    ],

    use: {

        baseURL: process.env.BASE_URL ?? 'http://18.191.77.25:8000',

        headless: true,

        screenshot: 'only-on-failure',

        video: 'retain-on-failure',

        trace: 'retain-on-failure'
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