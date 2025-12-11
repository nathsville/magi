<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
        <h3 class="font-bold text-gray-800 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#000878]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
            </svg>
            Tren Pengukuran
        </h3>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
            6 Bulan Terakhir
        </span>
    </div>

    <div class="p-6">
        <div class="relative h-[300px] w-full">
            <canvas id="monthlyTrendChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyTrendChart');
    if (!ctx) return;
    
    const data = @json($monthlyTrend ?? []);
    // Fallback if data is empty
    const labels = data.length ? data.map(item => item.label) : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
    const values = data.length ? data.map(item => item.value) : [0, 0, 0, 0, 0, 0];

    // Create gradient
    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(0, 8, 120, 0.2)'); // Brand Color #000878
    gradient.addColorStop(1, 'rgba(0, 8, 120, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pengukuran',
                data: values,
                borderColor: '#000878',
                backgroundColor: gradient,
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#000878',
                pointBorderWidth: 2,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: (context) => context.parsed.y + ' Anak'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 5, font: { size: 11 } },
                    grid: { color: '#f3f4f6' },
                    border: { display: false }
                },
                x: {
                    ticks: { font: { size: 11 } },
                    grid: { display: false },
                    border: { display: false }
                }
            }
        }
    });
});
</script>
@endpush