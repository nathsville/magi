<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartDataElement = document.getElementById('chartData');
    
    if (!chartDataElement) {
        console.error('Chart data element not found');
        return;
    }
    
    const labels = JSON.parse(chartDataElement.dataset.labels);
    const values = JSON.parse(chartDataElement.dataset.values);
    
    const ctx = document.getElementById('trendChart');
    
    if (!ctx) {
        console.error('Chart canvas not found');
        return;
    }
    
    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
    gradient.addColorStop(1, 'rgba(239, 68, 68, 0.01)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Kasus Stunting',
                data: values,
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgb(239, 68, 68)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverBackgroundColor: 'rgb(239, 68, 68)',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' kasus';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12
                        },
                        color: '#6B7280'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 12
                        },
                        color: '#6B7280'
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>