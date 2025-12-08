<script>
// Chart Configuration
const chartConfig = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
            position: 'top',
            labels: {
                usePointStyle: true,
                padding: 15,
                font: {
                    size: 11
                }
            }
        },
        tooltip: {
            mode: 'index',
            intersect: false,
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            titleFont: {
                size: 13,
                weight: 'bold'
            },
            bodyFont: {
                size: 12
            },
            callbacks: {
                label: function(context) {
                    let label = context.dataset.label || '';
                    if (label) {
                        label += ': ';
                    }
                    if (context.parsed.y !== null) {
                        label += context.parsed.y.toFixed(1) + ' ' + (context.dataset.unit || '');
                    }
                    return label;
                }
            }
        }
    },
    interaction: {
        mode: 'nearest',
        axis: 'x',
        intersect: false
    }
};

// Chart Data from Backend
const chartData = @json($chartData);
const whoStandards = @json($whoStandards);

// ==============================================
// 1. BERAT BADAN CHART
// ==============================================
const beratBadanCtx = document.getElementById('beratBadanChart').getContext('2d');

// Create WHO reference lines (min, median, max)
const bbWhoMin = chartData.labels.map(() => whoStandards.bb_min);
const bbWhoMedian = chartData.labels.map(() => whoStandards.bb_median);
const bbWhoMax = chartData.labels.map(() => whoStandards.bb_max);

const beratBadanChart = new Chart(beratBadanCtx, {
    type: 'line',
    data: {
        labels: chartData.labels,
        datasets: [
            {
                label: 'Batas Bawah WHO',
                data: bbWhoMin,
                borderColor: 'rgba(239, 68, 68, 0.8)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 0,
                fill: false,
                tension: 0.4,
                unit: 'kg'
            },
            {
                label: 'Median WHO',
                data: bbWhoMedian,
                borderColor: 'rgba(34, 197, 94, 0.8)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 0,
                fill: false,
                tension: 0.4,
                unit: 'kg'
            },
            {
                label: 'Batas Atas WHO',
                data: bbWhoMax,
                borderColor: 'rgba(34, 197, 94, 0.4)',
                backgroundColor: 'rgba(34, 197, 94, 0.05)',
                borderWidth: 1,
                borderDash: [5, 5],
                pointRadius: 0,
                fill: false,
                tension: 0.4,
                unit: 'kg'
            },
            {
                label: 'Berat Badan Anak',
                data: chartData.beratBadan,
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: chartData.statusColors,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                fill: true,
                tension: 0.4,
                unit: 'kg'
            }
        ]
    },
    options: {
        ...chartConfig,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Berat Badan (kg)',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Periode Pengukuran',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});

// ==============================================
// 2. TINGGI BADAN CHART
// ==============================================
const tinggiBadanCtx = document.getElementById('tinggiBadanChart').getContext('2d');

// Create WHO reference lines
const tbWhoMin = chartData.labels.map(() => whoStandards.tb_min);
const tbWhoMedian = chartData.labels.map(() => whoStandards.tb_median);
const tbWhoMax = chartData.labels.map(() => whoStandards.tb_max);

const tinggiBadanChart = new Chart(tinggiBadanCtx, {
    type: 'line',
    data: {
        labels: chartData.labels,
        datasets: [
            {
                label: 'Batas Bawah WHO',
                data: tbWhoMin,
                borderColor: 'rgba(239, 68, 68, 0.8)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 0,
                fill: false,
                tension: 0.4,
                unit: 'cm'
            },
            {
                label: 'Median WHO',
                data: tbWhoMedian,
                borderColor: 'rgba(34, 197, 94, 0.8)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 0,
                fill: false,
                tension: 0.4,
                unit: 'cm'
            },
            {
                label: 'Batas Atas WHO',
                data: tbWhoMax,
                borderColor: 'rgba(34, 197, 94, 0.4)',
                backgroundColor: 'rgba(34, 197, 94, 0.05)',
                borderWidth: 1,
                borderDash: [5, 5],
                pointRadius: 0,
                fill: false,
                tension: 0.4,
                unit: 'cm'
            },
            {
                label: 'Tinggi Badan Anak',
                data: chartData.tinggiBadan,
                borderColor: 'rgba(147, 51, 234, 1)',
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                borderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: chartData.statusColors,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                fill: true,
                tension: 0.4,
                unit: 'cm'
            }
        ]
    },
    options: {
        ...chartConfig,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Tinggi Badan (cm)',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Periode Pengukuran',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});

// ==============================================
// 3. LINGKAR KEPALA & LENGAN CHART
// ==============================================
const lingkarCtx = document.getElementById('lingkarChart').getContext('2d');

const lingkarChart = new Chart(lingkarCtx, {
    type: 'line',
    data: {
        labels: chartData.labels,
        datasets: [
            {
                label: 'Lingkar Kepala',
                data: chartData.lingkarKepala,
                borderColor: 'rgba(249, 115, 22, 1)',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                borderWidth: 3,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgba(249, 115, 22, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                fill: true,
                tension: 0.4,
                unit: 'cm'
            },
            {
                label: 'Lingkar Lengan',
                data: chartData.lingkarLengan,
                borderColor: 'rgba(20, 184, 166, 1)',
                backgroundColor: 'rgba(20, 184, 166, 0.1)',
                borderWidth: 3,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgba(20, 184, 166, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                fill: true,
                tension: 0.4,
                unit: 'cm'
            }
        ]
    },
    options: {
        ...chartConfig,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Ukuran (cm)',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Periode Pengukuran',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});

// ==============================================
// UTILITY FUNCTIONS
// ==============================================

/**
 * Update chart data dynamically (for future AJAX updates)
 */
function updateChartData(chartInstance, newData) {
    chartInstance.data.labels = newData.labels;
    chartInstance.data.datasets.forEach((dataset, index) => {
        if (newData.datasets[index]) {
            dataset.data = newData.datasets[index].data;
        }
    });
    chartInstance.update();
}

/**
 * Export chart as image
 */
function downloadChart(chartInstance, filename) {
    const url = chartInstance.toBase64Image();
    const link = document.createElement('a');
    link.download = filename + '.png';
    link.href = url;
    link.click();
}

/**
 * Print chart
 */
function printChart(canvasId) {
    const canvas = document.getElementById(canvasId);
    const dataUrl = canvas.toDataURL();
    
    const windowContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Grafik Pertumbuhan</title>
            <style>
                body { 
                    margin: 0; 
                    display: flex; 
                    justify-content: center; 
                    align-items: center; 
                    min-height: 100vh;
                }
                img { 
                    max-width: 100%; 
                    height: auto; 
                }
            </style>
        </head>
        <body>
            <img src="${dataUrl}">
        </body>
        </html>
    `;
    
    const printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.open();
    printWindow.document.write(windowContent);
    printWindow.document.close();
    
    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}

// ==============================================
// RESPONSIVE BEHAVIOR
// ==============================================
window.addEventListener('resize', function() {
    beratBadanChart.resize();
    tinggiBadanChart.resize();
    lingkarChart.resize();
});

// ==============================================
// ANIMATION ON SCROLL (Optional Enhancement)
// ==============================================
function animateChartOnScroll() {
    const charts = document.querySelectorAll('.chart-container');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, { threshold: 0.1 });
    
    charts.forEach(chart => observer.observe(chart));
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    animateChartOnScroll();
    
    // Add fade-in animation class
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
    `;
    document.head.appendChild(style);
});

// ==============================================
// CONSOLE LOG FOR DEBUGGING
// ==============================================
console.log('Charts initialized successfully!');
console.log('Chart Data:', chartData);
console.log('WHO Standards:', whoStandards);
</script>