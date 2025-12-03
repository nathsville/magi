{{-- Load Chart.js from CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Prepare chart data from backend
    const chartData = {
        labels: @json($stuntingPerWilayah->pluck('nama_puskesmas')),
        totalAnak: @json($stuntingPerWilayah->pluck('total_anak')),
        jumlahStunting: @json($stuntingPerWilayah->pluck('jumlah_stunting')),
        persentase: @json($stuntingPerWilayah->pluck('persentase')->map(function($p) { return round($p, 1); }))
    };

    console.log('Chart Data:', chartData); // Debug

    // Initialize Chart when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initStuntingChart();
    });

    function initStuntingChart() {
        const ctx = document.getElementById('stuntingChart');
        
        if (!ctx) {
            console.error('Canvas element not found!');
            return;
        }

        console.log('Initializing chart...'); // Debug

        // Check if data is empty
        if (!chartData.labels || chartData.labels.length === 0) {
            console.warn('No data available for chart');
            ctx.getContext('2d').font = '14px Inter';
            ctx.getContext('2d').fillStyle = '#9CA3AF';
            ctx.getContext('2d').textAlign = 'center';
            ctx.getContext('2d').fillText('Grafik Batang Stunting per Wilayah', ctx.width / 2, 60);
            ctx.getContext('2d').fillText('Chart.js akan diintegrasikan di sini', ctx.width / 2, 90);
            return;
        }

        // Get background colors based on percentage
        const backgroundColors = chartData.persentase.map(persentase => {
            if (persentase >= 30) return 'rgba(239, 68, 68, 0.8)'; // Red
            if (persentase >= 20) return 'rgba(249, 115, 22, 0.8)'; // Orange
            if (persentase >= 10) return 'rgba(234, 179, 8, 0.8)'; // Yellow
            return 'rgba(34, 197, 94, 0.8)'; // Green
        });

        const borderColors = chartData.persentase.map(persentase => {
            if (persentase >= 30) return 'rgb(239, 68, 68)';
            if (persentase >= 20) return 'rgb(249, 115, 22)';
            if (persentase >= 10) return 'rgb(234, 179, 8)';
            return 'rgb(34, 197, 94)';
        });

        try {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: 'Total Anak',
                            data: chartData.totalAnak,
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 2,
                            borderRadius: 6,
                            barThickness: 35
                        },
                        {
                            label: 'Jumlah Stunting',
                            data: chartData.jumlahStunting,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 2,
                            borderRadius: 6,
                            barThickness: 35
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: {
                                    size: 12,
                                    family: "'Inter', sans-serif"
                                },
                                padding: 15,
                                usePointStyle: true,
                                pointStyle: 'circle'
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
                            callbacks: {
                                afterLabel: function(context) {
                                    if (context.datasetIndex === 1) {
                                        const index = context.dataIndex;
                                        return 'Persentase: ' + chartData.persentase[index] + '%';
                                    }
                                    return '';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 11
                                },
                                maxRotation: 45,
                                minRotation: 45
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    }
                }
            });

            console.log('Chart initialized successfully!'); // Debug
        } catch (error) {
            console.error('Error initializing chart:', error);
        }
    }

    // Refresh Data Function
    function refreshData() {
        location.reload();
    }

    // Toggle Filter Dropdown
    function toggleFilterDropdown() {
        const dropdown = document.getElementById('filterDropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    // Set Filter
    function setFilter(filter) {
        const filterText = document.getElementById('filterText');
        const dropdown = document.getElementById('filterDropdown');
        
        if (filterText) filterText.textContent = filter;
        if (dropdown) dropdown.classList.add('hidden');
        
        console.log('Filter set to:', filter);
        // TODO: Implement actual filtering
    }

    // Toggle Wilayah Menu
    function toggleWilayahMenu() {
        console.log('Wilayah menu toggled');
        // TODO: Implement menu
    }

    // Show Wilayah Detail
    function showWilayahDetail(id) {
        console.log('Showing detail for Puskesmas ID:', id);
        // TODO: Implement detail view
    }

    // Show Detail Modal
    function showDetailModal(type) {
        console.log('Showing detail modal for:', type);
        // TODO: Implement modal
    }

    // Show Info Modal
    function showInfoModal(type) {
        let message = '';
        if (type === 'distribusi') {
            message = 'Distribusi Status Gizi menampilkan perbandingan anak dengan status Normal dan Stunting berdasarkan standar WHO.';
        }
        console.log(message);
        // TODO: Implement modal instead of alert
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('filterDropdown');
        const isButton = event.target.closest('button[onclick="toggleFilterDropdown()"]');
        
        if (dropdown && !isButton && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>