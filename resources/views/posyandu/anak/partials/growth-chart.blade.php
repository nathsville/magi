<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-bold text-gray-900">Grafik Pertumbuhan</h3>
        <div class="flex space-x-2">
            <button onclick="switchChart('berat')" id="btnBerat" class="px-3 py-1.5 bg-[#000878] text-white text-xs rounded transition">Berat Badan</button>
            <button onclick="switchChart('tinggi')" id="btnTinggi" class="px-3 py-1.5 bg-gray-100 text-gray-600 text-xs rounded hover:bg-gray-200 transition">Tinggi Badan</button>
        </div>
    </div>

    <div class="relative h-[300px] w-full">
        <canvas id="growthChart"></canvas>
    </div>
</div>

@if(!$riwayatPengukuran->isEmpty())
@push('scripts')
<script>
let growthChart;
const chartData = {
    labels: @json($riwayatPengukuran->pluck('tanggal_ukur')->map(fn($date) => \Carbon\Carbon::parse($date)->translatedFormat('M Y'))),
    beratBadan: @json($riwayatPengukuran->pluck('berat_badan')),
    tinggiBadan: @json($riwayatPengukuran->pluck('tinggi_badan')),
    statuses: @json($riwayatPengukuran->map(fn($m) => $m->stunting ? $m->stunting->status_stunting : 'Normal'))
};

function getPointColors(statuses) {
    return statuses.map(status => {
        switch(status) {
            case 'Normal': return 'rgba(34, 197, 94, 1)';
            case 'Stunting Ringan': return 'rgba(234, 179, 8, 1)';
            case 'Stunting Sedang': return 'rgba(249, 115, 22, 1)';
            case 'Stunting Berat': return 'rgba(239, 68, 68, 1)';
            default: return 'rgba(107, 114, 128, 1)';
        }
    });
}

function initChart() {
    const ctx = document.getElementById('growthChart');
    
    growthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Berat Badan (kg)',
                data: chartData.beratBadan,
                borderColor: '#000878',
                backgroundColor: 'rgba(0, 8, 120, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: getPointColors(chartData.statuses),
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    callbacks: {
                        afterLabel: function(context) {
                            return 'Status: ' + chartData.statuses[context.dataIndex];
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    ticks: {
                        callback: function(value) {
                            return value + ' kg';
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

function switchChart(type) {
    const btnBerat = document.getElementById('btnBerat');
    const btnTinggi = document.getElementById('btnTinggi');
    
    if (type === 'berat') {
        btnBerat.classList.remove('bg-gray-200', 'text-gray-700');
        btnBerat.classList.add('bg-teal-600', 'text-white');
        btnTinggi.classList.remove('bg-teal-600', 'text-white');
        btnTinggi.classList.add('bg-gray-200', 'text-gray-700');
        
        growthChart.data.datasets[0].label = 'Berat Badan (kg)';
        growthChart.data.datasets[0].data = chartData.beratBadan;
        growthChart.options.scales.y.ticks.callback = function(value) {
            return value + ' kg';
        };
    } else {
        btnTinggi.classList.remove('bg-gray-200', 'text-gray-700');
        btnTinggi.classList.add('bg-teal-600', 'text-white');
        btnBerat.classList.remove('bg-teal-600', 'text-white');
        btnBerat.classList.add('bg-gray-200', 'text-gray-700');
        
        growthChart.data.datasets[0].label = 'Tinggi Badan (cm)';
        growthChart.data.datasets[0].data = chartData.tinggiBadan;
        growthChart.options.scales.y.ticks.callback = function(value) {
            return value + ' cm';
        };
    }
    
    growthChart.update();
}

document.addEventListener('DOMContentLoaded', function() {
    initChart();
});
</script>
@endpush
@endif