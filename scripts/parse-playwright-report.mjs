import fs from 'node:fs';

const [inputPath, outputPath] = process.argv.slice(2);

if (!inputPath || !outputPath) {
    console.error('Uso: node scripts/parse-playwright-report.mjs <input> <output>');
    process.exit(1);
}

const raw = fs.readFileSync(inputPath, 'utf8');
const report = JSON.parse(raw);
const stats = report.stats ?? {};

const passed = Number(stats.expected ?? 0);
const failed = Number(stats.unexpected ?? 0);
const skipped = Number(stats.skipped ?? 0);
const total = passed + failed + skipped;
const status = failed > 0 ? 'danger' : 'success';

const payload = {
    status,
    status_label: failed > 0
        ? `Playwright con ${failed} fallo(s)`
        : `Playwright OK (${passed} prueba(s))`,
    updated_at: new Date().toISOString(),
    total,
    passed,
    failed,
    skipped,
    duration_ms: Number(stats.duration ?? 0),
    report_url: `${process.env.GITHUB_SERVER_URL}/${process.env.GITHUB_REPOSITORY}/actions/runs/${process.env.GITHUB_RUN_ID}`,
};

fs.writeFileSync(outputPath, `${JSON.stringify(payload, null, 2)}\n`);
