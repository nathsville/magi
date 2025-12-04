<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartDataElement = document.getElementById('chartData');
    
    if (!chartDataElement) {
        console.log('Chart data element not found');
        return;
    }
    
    const labels = JSON.parse(chartDataElement.dataset.labels);
    const beratBadan = JSON.parse(chartDataElement.dataset.bb);
    const tinggiBadan = JSON.parse(chartDataElement.dataset.tb);
    
    const ctx = document.getElementById('riwayatChart');
    
    if (!ctx) {
        console.error('Chart canvas not found');
        return;
    }
    
    // Create gradients
    const ctxGradient = ctx.getContext('2d');
    
    const gradientBB = ctxGradient.createLinearGradient(0, 0, 0, 300);
    gradientBB.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
    gradientBB.addColorStop(1, 'rgba(59, 130, 246, 0.01)');
    
    const gradientTB = ctxGradient.createLinearGradient(0, 0, 0, 300);
    gradientTB.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
    gradientTB.addColorStop(1, 'rgba(16, 185, 129, 0.01)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Berat Badan (kg)',
                    data: beratBadan,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: gradientBB,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverBackgroundColor: 'rgb(59, 130, 246)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3,
                    yAxisID: 'y'
                },
                {
                    label: 'Tinggi Badan (cm)',
                    data: tinggiBadan,
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: gradientTB,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'rgb(16, 185, 129)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverBackgroundColor: 'rgb(16, 185, 129)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 13,
                            weight: 'bold'
                        }
                    }
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
                    displayColors: true,
                    callbacks: {
                        title: function(context) {
                            return 'Tanggal: ' + context[0].label;
                        },
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y.toFixed(1);
                                label += context.datasetIndex === 0 ? ' kg' : ' cm';
                            }
                            return label;
                        },
                        afterLabel: function(context) {
                            // Calculate growth from previous measurement
                            const currentIndex = context.dataIndex;
                            if (currentIndex > 0) {
                                const previousValue = context.dataset.data[currentIndex - 1];
                                const currentValue = context.parsed.y;
                                const growth = currentValue - previousValue;
                                const unit = context.datasetIndex === 0 ? 'kg' : 'cm';
                                
                                if (growth > 0) {
                                    return `↑ +${growth.toFixed(1)} ${unit} dari pengukuran sebelumnya`;
                                } else if (growth < 0) {
                                    return `↓ ${growth.toFixed(1)} ${unit} dari pengukuran sebelumnya`;
                                } else {
                                    return 'Tidak ada perubahan';
                                }
                            }
                            return '';
                        }
                    }
                }
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Tanggal Pengukuran',
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        color: '#6B7280'
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        color: '#6B7280',
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Berat Badan (kg)',
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        color: 'rgb(59, 130, 246)'
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        color: 'rgb(59, 130, 246)',
                        callback: function(value) {
                            return value.toFixed(1) + ' kg';
                        }
                    },
                    grid: {
                        color: 'rgba(59, 130, 246, 0.1)',
                        drawBorder: false
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Tinggi Badan (cm)',
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        color: 'rgb(16, 185, 129)'
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        color: 'rgb(16, 185, 129)',
                        callback: function(value) {
                            return value.toFixed(1) + ' cm';
                        }
                    },
                    grid: {
                        drawOnChartArea: false,
                        drawBorder: false
                    }
                }
            }
        }
    });
});
</script>

<style>
/* Custom styles for better chart appearance */
#riwayatChart {
    background: linear-gradient(to bottom, #ffffff 0%, #f9fafb 100%);
    border-radius: 8px;
}
</style>