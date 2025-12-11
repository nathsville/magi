<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-[#000878] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                    Tren Pengukuran 6 Bulan Terakhir
                </h3>
                <p class="text-sm text-gray-600 mt-1">Grafik perkembangan jumlah pengukuran per bulan</p>
            </div>
            <div class="flex space-x-2">
                <button onclick="changeTrenView('line')" 
                    id="btnLineChart"
                    class="px-3 py-1.5 text-sm font-medium rounded-lg transition bg-[#000878] text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </button>
                <button onclick="changeTrenView('bar')" 
                    id="btnBarChart"
                    class="px-3 py-1.5 text-sm font-medium rounded-lg transition bg-gray-100 text-gray-700 hover:bg-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="p-6">
        <canvas id="trenChart" height="80"></canvas>
    </div>

    {{-- Summary Stats --}}
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <div class="grid grid-cols-3 gap-4 text-center">
            <div>
                <p class="text-xs text-gray-600 mb-1">Total Pengukuran</p>
                <p class="text-lg font-bold text-gray-900">
                    {{ number_format($trenBulanan->sum('total_pengukuran')) }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-600 mb-1">Rata-rata/Bulan</p>
                <p class="text-lg font-bold text-gray-900">
                    {{ number_format($trenBulanan->avg('total_pengukuran')) }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-600 mb-1">Bulan Tertinggi</p>
                <p class="text-lg font-bold text-gray-900">
                    {{ $trenBulanan->sortByDesc('total_pengukuran')->first()->bulan ?? 'N/A' }}
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Data dari controller
const trenData = @json($trenBulanan);

// Prepare data untuk Chart.js
const labels = trenData.map(item => {
    const [year, month] = item.bulan.split('-');
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return `${monthNames[parseInt(month) - 1]} ${year}`;
});

const dataValues = trenData.map(item => item.total_pengukuran);

// Chart Configuration
let trenChart = null;
let currentChartType = 'line';

function initTrenChart() {
    const ctx = document.getElementById('trenChart').getContext('2d');
    
    trenChart = new Chart(ctx, {
        type: currentChartType,
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pengukuran',
                data: dataValues,
                borderColor: '#000878',
                backgroundColor: currentChartType === 'line' 
                    ? 'rgba(0, 8, 120, 0.1)' 
                    : 'rgba(0, 8, 120, 0.8)',
                borderWidth: 2,
                fill: currentChartType === 'line',
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#000878',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 8, 120, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#000878',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} pengukuran`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: '#6b7280'
                    },
                    grid: {
                        color: '#f3f4f6',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#6b7280'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

function changeTrenView(type) {
    currentChartType = type;
    
    // Update button states
    document.getElementById('btnLineChart').classList.toggle('bg-[#000878]', type === 'line');
    document.getElementById('btnLineChart').classList.toggle('text-white', type === 'line');
    document.getElementById('btnLineChart').classList.toggle('bg-gray-100', type !== 'line');
    document.getElementById('btnLineChart').classList.toggle('text-gray-700', type !== 'line');
    
    document.getElementById('btnBarChart').classList.toggle('bg-[#000878]', type === 'bar');
    document.getElementById('btnBarChart').classList.toggle('text-white', type === 'bar');
    document.getElementById('btnBarChart').classList.toggle('bg-gray-100', type !== 'bar');
    document.getElementById('btnBarChart').classList.toggle('text-gray-700', type !== 'bar');
    
    // Destroy and recreate chart
    if (trenChart) {
        trenChart.destroy();
    }
    initTrenChart();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initTrenChart();
});
</script>
@endpush