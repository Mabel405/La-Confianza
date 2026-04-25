Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor  = '#64748b';


(function () {
    var el = document.getElementById('grafVM');
    if (!el) return;

    var src    = window.POS_ventasMes || { labels: [], data: [] };
    var labels = src.labels;
    var datos  = src.data;

    
    var ptColors = datos.map(function (_, i) {
        return i === datos.length - 1 ? '#059669' : 'rgba(5,150,105,0.4)';
    });

    new Chart(el, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ventas',
                lineTension: 0.35,
                backgroundColor: 'rgba(5,150,105,0.08)',
                borderColor: '#059669',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: ptColors,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 6,
                pointHitRadius: 40,
                data: datos,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    gridLines: { display: false },
                    ticks: { maxTicksLimit: 7, fontColor: '#94a3b8', fontSize: 11 }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        maxTicksLimit: 5,
                        fontColor: '#94a3b8',
                        fontSize: 11,
                        callback: function (v) { return Number.isInteger(v) ? v : null; }
                    },
                    gridLines: { color: 'rgba(0,0,0,0.05)' }
                }]
            },
            legend: { display: false },
            tooltips: {
                backgroundColor: '#0f172a',
                titleFontColor: '#fff',
                bodyFontColor: '#94a3b8',
                callbacks: {
                    label: function (item) { return '  ' + item.yLabel + ' ventas'; }
                }
            }
        }
    });
})();



(function () {
    var el = document.getElementById('grafDN');
    if (!el) return;

    var src    = window.POS_categorias || { labels: [], data: [] };
    var labels = src.labels;
    var datos  = src.data;
    var total  = datos.reduce(function (a, b) { return a + b; }, 0);

    var COLORS = ['#2563eb', '#059669', '#d97706', '#dc2626', '#7c3aed', '#475569'];

    new Chart(el, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: datos,
                backgroundColor: COLORS,
                borderWidth: 2,
                borderColor: '#fff',
                hoverBorderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 66,
            legend: { display: false },
            tooltips: {
                backgroundColor: '#0f172a',
                titleFontColor: '#fff',
                bodyFontColor: '#94a3b8',
                callbacks: {
                    label: function (item, data) {
                        var lbl = data.labels[item.index];
                        var val = data.datasets[0].data[item.index];
                        var pct = total > 0 ? Math.round(val / total * 100) : 0;
                        return '  ' + lbl + ': ' + val + ' (' + pct + '%)';
                    }
                }
            }
        }
    });

    var leg = document.getElementById('donutLegend');
    if (leg && total > 0) {
        labels.forEach(function (lbl, i) {
            var pct = Math.round(datos[i] / total * 100);
            var item = document.createElement('span');
            item.className = 'graf-legend-item';
            item.innerHTML =
                '<span class="graf-legend-sq" style="background:' + COLORS[i % COLORS.length] + '"></span>' +
                lbl + ' ' + pct + '%';
            leg.appendChild(item);
        });
    }
})();