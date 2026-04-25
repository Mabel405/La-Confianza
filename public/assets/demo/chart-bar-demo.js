Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor  = '#64748b';



(function () {
    var el = document.getElementById('grafCV');
    if (!el) return;

    var src     = window.POS_cvsv || { labels: [], ventas: [], compras: [] };
    var labels  = src.labels;
    var ventas  = src.ventas;
    var compras = src.compras;

    new Chart(el, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Ventas',
                    backgroundColor: 'rgba(5,150,105,0.8)',
                    borderColor: 'rgba(5,150,105,0.8)',
                    borderWidth: 0,
                    data: ventas,
                },
                {
                    label: 'Compras',
                    backgroundColor: 'rgba(37,99,235,0.8)',
                    borderColor: 'rgba(37,99,235,0.8)',
                    borderWidth: 0,
                    data: compras,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    gridLines: { display: false },
                    ticks: { fontColor: '#94a3b8', fontSize: 11 },
                    barPercentage: 0.7,
                    categoryPercentage: 0.75
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
                mode: 'index',
                intersect: false
            }
        }
    });
})();



(function () {
    var el = document.getElementById('grafTP');
    if (!el) return;

    var src    = window.POS_top5 || { labels: [], data: [] };
    var labels = src.labels;
    var datos  = src.data;

    
    var bgColors = [
        'rgba(220,38,38,0.85)',
        'rgba(220,38,38,0.65)',
        'rgba(220,38,38,0.46)',
        'rgba(220,38,38,0.30)',
        'rgba(220,38,38,0.16)'
    ];

    new Chart(el, {
        type: 'horizontalBar',          
        data: {
            labels: labels,
            datasets: [{
                label: 'Vendidos',
                backgroundColor: bgColors.slice(0, datos.length),
                borderWidth: 0,
                data: datos,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    ticks: {
                        min: 0,
                        maxTicksLimit: 5,
                        fontColor: '#94a3b8',
                        fontSize: 11,
                        callback: function (v) { return Number.isInteger(v) ? v : null; }
                    },
                    gridLines: { color: 'rgba(0,0,0,0.05)' }
                }],
                yAxes: [{
                    gridLines: { display: false },
                    ticks: { fontColor: '#334155', fontSize: 11, fontStyle: 'bold' }
                }]
            },
            legend: { display: false },
            tooltips: {
                backgroundColor: '#0f172a',
                titleFontColor: '#fff',
                bodyFontColor: '#94a3b8',
                callbacks: {
                    label: function (item) { return '  ' + item.xLabel + ' vendidos'; }
                }
            }
        }
    });
})();