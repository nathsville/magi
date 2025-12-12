<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// ============================================================================
// GLOBAL VARIABLES
// ============================================================================
let chartTrenPrevalensiInstance = null;
let chartDistribusiUsiaInstance = null;
let chartPerbandinganWilayahInstance = null;
let chartDetailTrenInstance = null;

let currentStatistikFilters = {
    time_range: '1_tahun',
    wilayah: 'all',
    metric: 'prevalensi',
    start_date: null,
    end_date: null
};

let currentDetailWilayah = null;

// ============================================================================
// INITIALIZATION
// ============================================================================
document.addEventListener('DOMContentLoaded', function() {
    initializeStatistik();
    updateLastUpdateTime();
    
    // Setup time range change handler
    document.getElementById('filterTimeRange')?.addEventListener('change', function() {
        if (this.value === 'custom') {
            document.getElementById('customRangeInputs').classList.remove('hidden');
        } else {
            document.getElementById('customRangeInputs').classList.add('hidden');
        }
    });
    
    // Auto refresh every 5 minutes
    setInterval(refreshAllData, 300000);
});

async function initializeStatistik() {
    await loadStatistikData();
    initializeCharts();
}

function updateLastUpdateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    document.getElementById('lastUpdate').textContent = `Terakhir update: ${timeString}`;
}

// ============================================================================
// DATA LOADING
// ============================================================================
async function loadStatistikData() {
    try {
        const params = new URLSearchParams(currentStatistikFilters);
        
        const response = await fetch(`{{ route('dppkb.statistik') }}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Failed to load data');
        
        const data = await response.json();
        
        updateQuickStats(data.quick_stats);
        updateTrenChart(data.tren_prevalensi);
        updateDistribusiChart(data.distribusi_usia);
        updatePerbandinganChart(data.perbandingan_wilayah);
        updateTopBottomTables(data.ranking_posyandu);
        updateAdvancedAnalytics(data.advanced_analytics);
        
        updateLastUpdateTime();
        
    } catch (error) {
        console.error('Error loading statistik:', error);
        showErrorToast('Gagal memuat data statistik');
    }
}

// ============================================================================
// QUICK STATS UPDATE
// ============================================================================
function updateQuickStats(data) {
    if (!data) return;
    
    // Avg Prevalensi
    document.getElementById('avgPrevalensi').textContent = `${data.avg_prevalensi}%`;
    document.getElementById('trendAvgPrevalensi').textContent = `${data.trend_avg > 0 ? '+' : ''}${data.trend_avg}%`;
    
    // Wilayah Prioritas
    document.getElementById('wilayahPrioritas').textContent = data.wilayah_prioritas;
    
    // Tren Bulanan
    const trendValue = data.tren_bulanan;
    const trendText = trendValue > 0 ? 'Naik' : trendValue < 0 ? 'Turun' : 'Stabil';
    const trendIcon = trendValue > 0 
        ? '<svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>'
        : '<svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>';
    
    document.getElementById('trenBulanan').textContent = trendText;
    document.getElementById('trendIndicator').innerHTML = `<span class="text-sm font-medium">${trendValue > 0 ? '+' : ''}${trendValue}%</span>${trendIcon}`;
    
    // Posyandu Monitored
    document.getElementById('posyanduMonitored').textContent = data.posyandu_monitored;
    document.getElementById('totalPosyandu').textContent = data.total_posyandu;
    
    const coverage = Math.round((data.posyandu_monitored / data.total_posyandu) * 100);
    document.getElementById('coverageBadge').textContent = `${coverage}%`;
}

// ============================================================================
// CHARTS INITIALIZATION
// ============================================================================
function initializeCharts() {
    initTrenPrevalensiChart();
    initDistribusiUsiaChart();
    initPerbandinganWilayahChart();
}

function initTrenPrevalensiChart() {
    const ctx = document.getElementById('chartTrenPrevalensi');
    if (!ctx) return;
    
    chartTrenPrevalensiInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Prevalensi (%)',
                data: [],
                borderColor: 'rgb(147, 51, 234)',
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7
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
                    titleFont: { size: 14 },
                    bodyFont: { size: 13 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 30,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

function initDistribusiUsiaChart() {
    const ctx = document.getElementById('chartDistribusiUsia');
    if (!ctx) return;
    
    chartDistribusiUsiaInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['0-6 Bulan', '7-12 Bulan', '13-24 Bulan', '25-60 Bulan'],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(239, 68, 68)',
                    'rgb(249, 115, 22)',
                    'rgb(234, 179, 8)',
                    'rgb(34, 197, 94)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' anak';
                        }
                    }
                }
            }
        }
    });
}

function initPerbandinganWilayahChart() {
    const ctx = document.getElementById('chartPerbandinganWilayah');
    if (!ctx) return;
    
    chartPerbandinganWilayahInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Prevalensi (%)',
                data: [],
                backgroundColor: function(context) {
                    const value = context.parsed.y;
                    if (value < 14) return 'rgb(34, 197, 94)';
                    if (value < 20) return 'rgb(234, 179, 8)';
                    if (value < 30) return 'rgb(249, 115, 22)';
                    return 'rgb(239, 68, 68)';
                },
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Prevalensi: ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 35,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

// ============================================================================
// CHARTS UPDATE
// ============================================================================
function updateTrenChart(data) {
    if (!chartTrenPrevalensiInstance || !data) return;
    
    chartTrenPrevalensiInstance.data.labels = data.labels;
    chartTrenPrevalensiInstance.data.datasets[0].data = data.values;
    chartTrenPrevalensiInstance.update();
    
    // Update stats
    const values = data.values;
    const max = Math.max(...values);
    const min = Math.min(...values);
    const avg = (values.reduce((a, b) => a + b, 0) / values.length).toFixed(1);
    
    document.getElementById('statTertinggi').textContent = `${max}%`;
    document.getElementById('statRataRata').textContent = `${avg}%`;
    document.getElementById('statTerendah').textContent = `${min}%`;
}

function updateDistribusiChart(data) {
    if (!chartDistribusiUsiaInstance || !data) return;
    
    chartDistribusiUsiaInstance.data.datasets[0].data = data.values;
    chartDistribusiUsiaInstance.update();
    
    // Update legend cards
    document.getElementById('usia0_6').textContent = data.values[0] || 0;
    document.getElementById('usia7_12').textContent = data.values[1] || 0;
    document.getElementById('usia13_24').textContent = data.values[2] || 0;
    document.getElementById('usia25_60').textContent = data.values[3] || 0;
}

function updatePerbandinganChart(data) {
    if (!chartPerbandinganWilayahInstance || !data) return;
    
    chartPerbandinganWilayahInstance.data.labels = data.labels;
    chartPerbandinganWilayahInstance.data.datasets[0].data = data.values;
    chartPerbandinganWilayahInstance.update();
}

// ============================================================================
// CHART TYPE TOGGLE
// ============================================================================
function toggleTrenChartType(type) {
    if (!chartTrenPrevalensiInstance) return;
    
    chartTrenPrevalensiInstance.config.type = type;
    chartTrenPrevalensiInstance.update();
    
    // Update button states
    document.getElementById('btnTrenLine').className = type === 'line' 
        ? 'px-3 py-1.5 bg-purple-600 text-white text-sm rounded-lg transition font-medium'
        : 'px-3 py-1.5 bg-white text-gray-700 border border-gray-300 text-sm rounded-lg hover:bg-gray-50 transition';
    document.getElementById('btnTrenBar').className = type === 'bar'
        ? 'px-3 py-1.5 bg-purple-600 text-white text-sm rounded-lg transition font-medium'
        : 'px-3 py-1.5 bg-white text-gray-700 border border-gray-300 text-sm rounded-lg hover:bg-gray-50 transition';
}

function toggleDistribusiChartType(type) {
    if (!chartDistribusiUsiaInstance) return;
    
    chartDistribusiUsiaInstance.config.type = type;
    chartDistribusiUsiaInstance.update();
    
    // Update button states
    document.getElementById('btnDistDoughnut').className = type === 'doughnut'
        ? 'px-3 py-1.5 bg-purple-600 text-white text-sm rounded-lg transition font-medium'
        : 'px-3 py-1.5 bg-white text-gray-700 border border-gray-300 text-sm rounded-lg hover:bg-gray-50 transition';
    document.getElementById('btnDistBar').className = type === 'bar'
        ? 'px-3 py-1.5 bg-purple-600 text-white text-sm rounded-lg transition font-medium'
        : 'px-3 py-1.5 bg-white text-gray-700 border border-gray-300 text-sm rounded-lg hover:bg-gray-50 transition';
}

// ============================================================================
// TOP/BOTTOM TABLES
// ============================================================================
function updateTopBottomTables(data) {
    if (!data) return;
    
    // Render Top 5
    renderTopPosyandu(data.top_5);
    
    // Render Bottom 5
    renderBottomPosyandu(data.bottom_5);
}

function renderTopPosyandu(data) {
    const tbody = document.getElementById('tableTopBody');
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">Tidak ada data</td></tr>';
        return;
    }
    
    let html = '';
    data.forEach((item, index) => {
        html += `
            <tr class="hover:bg-green-50 transition">
                <td class="px-4 py-3">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full ${index < 3 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'} font-bold text-sm">
                        ${index + 1}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm font-medium text-gray-900">${item.nama}</td>
                <td class="px-4 py-3 text-sm text-gray-700 text-center">${item.kecamatan}</td>
                <td class="px-4 py-3 text-center">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                        ${item.prevalensi}%
                    </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700 text-center">${item.total_anak}</td>
            </tr>
        `;
    });
    tbody.innerHTML = html;
}

function renderBottomPosyandu(data) {
    const tbody = document.getElementById('tableBottomBody');
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">Tidak ada data</td></tr>';
        return;
    }
    
    let html = '';
    data.forEach((item, index) => {
        html += `
            <tr class="hover:bg-red-50 transition">
                <td class="px-4 py-3">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full ${index < 3 ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700'} font-bold text-sm">
                        ${index + 1}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm font-medium text-gray-900">${item.nama}</td>
                <td class="px-4 py-3 text-sm text-gray-700 text-center">${item.kecamatan}</td>
                <td class="px-4 py-3 text-center">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                        ${item.prevalensi}%
                    </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700 text-center">${item.total_anak}</td>
            </tr>
        `;
    });
    tbody.innerHTML = html;
}

function showTopBottom(type) {
    const tableTop = document.getElementById('tableTop');
    const tableBottom = document.getElementById('tableBottom');
    const btnTop = document.getElementById('btnShowTop');
    const btnBottom = document.getElementById('btnShowBottom');
    
    if (type === 'top') {
        tableTop.classList.remove('hidden');
        tableBottom.classList.add('hidden');
        btnTop.className = 'flex-1 px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg font-medium shadow-sm';
        btnBottom.className = 'flex-1 px-4 py-2 bg-white text-gray-700 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium';
    } else {
        tableTop.classList.add('hidden');
        tableBottom.classList.remove('hidden');
        btnTop.className = 'flex-1 px-4 py-2 bg-white text-gray-700 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium';
        btnBottom.className = 'flex-1 px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg font-medium shadow-sm';
    }
}

// ============================================================================
// ADVANCED ANALYTICS
// ============================================================================
function updateAdvancedAnalytics(data) {
    if (!data) return;
    
    // Korelasi
    document.getElementById('korelasiEkonomi').textContent = `${data.korelasi.ekonomi}%`;
    document.getElementById('barEkonomi').style.width = `${data.korelasi.ekonomi}%`;
    document.getElementById('korelasiPendidikan').textContent = `${data.korelasi.pendidikan}%`;
    document.getElementById('barPendidikan').style.width = `${data.korelasi.pendidikan}%`;
    
    // Prediksi
    document.getElementById('prediksiPrevalensi').textContent = `${data.prediksi.nilai}%`;
    document.getElementById('confidenceLevel').textContent = `${data.prediksi.confidence}%`;
    
    const trendIcon = data.prediksi.trend === 'naik'
        ? '<svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>'
        : '<svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>';
    
    document.getElementById('prediksiTrend').innerHTML = `
        <span class="text-sm capitalize">${data.prediksi.trend}</span>
        ${trendIcon}
    `;
    
    // Rekomendasi
    let rekomendasiHtml = '';
    data.rekomendasi.forEach(item => {
        rekomendasiHtml += `
            <div class="flex items-start space-x-2">
                <div class="w-1.5 h-1.5 rounded-full bg-yellow-400 mt-2 flex-shrink-0"></div>
                <p class="text-sm text-indigo-100">${item}</p>
            </div>
        `;
    });
    document.getElementById('rekomendasiList').innerHTML = rekomendasiHtml;
}

// ============================================================================
// FILTERS
// ============================================================================
function applyStatistikFilter() {
    // Collect filter values
    currentStatistikFilters.time_range = document.getElementById('filterTimeRange').value;
    currentStatistikFilters.wilayah = document.getElementById('filterWilayah').value;
    currentStatistikFilters.metric = document.getElementById('filterMetric').value;
    
    if (currentStatistikFilters.time_range === 'custom') {
        currentStatistikFilters.start_date = document.getElementById('filterStartDate').value;
        currentStatistikFilters.end_date = document.getElementById('filterEndDate').value;
    }
    
    loadStatistikData();
    showInfoToast('Filter diterapkan');
}

function resetStatistikFilter() {
    currentStatistikFilters = {
        time_range: '1_tahun',
        wilayah: 'all',
        metric: 'prevalensi',
        start_date: null,
        end_date: null
    };
    
    document.getElementById('filterTimeRange').value = '1_tahun';
    document.getElementById('filterWilayah').value = 'all';
    document.getElementById('filterMetric').value = 'prevalensi';
    document.getElementById('customRangeInputs').classList.add('hidden');
    
    loadStatistikData();
    showInfoToast('Filter direset');
}

function refreshAllData() {
    loadStatistikData();
    showInfoToast('Data diperbarui');
}

// ============================================================================
// DETAIL WILAYAH MODAL
// ============================================================================
async function showDetailWilayah(kecamatan = null) {
    const wilayah = kecamatan || document.getElementById('filterWilayah').value;
    
    try {
        const response = await fetch(`{{ route('dppkb.statistik') }}/detail/${wilayah}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            currentDetailWilayah = data.data;
            populateDetailWilayahModal(data.data);
            openModal('modalDetailWilayah');
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showErrorToast('Gagal memuat detail wilayah');
    }
}

function populateDetailWilayahModal(data) {
    document.getElementById('detailWilayahNama').textContent = data.nama;
    document.getElementById('detailTotalAnak').textContent = data.total_anak;
    document.getElementById('detailStunting').textContent = data.total_stunting;
    document.getElementById('detailNormal').textContent = data.total_normal;
    document.getElementById('detailPrevalensi').textContent = `${data.prevalensi}%`;
    
    // Render Tren Chart
    if (chartDetailTrenInstance) {
        chartDetailTrenInstance.destroy();
    }
    
    const ctx = document.getElementById('chartDetailTren');
    chartDetailTrenInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.tren.labels,
            datasets: [{
                label: 'Prevalensi',
                data: data.tren.values,
                borderColor: 'rgb(147, 51, 234)',
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
    
    // Render Posyandu List
    let tableHtml = '';
    data.posyandu.forEach((item, index) => {
        const statusBadge = item.prevalensi < 14 
            ? '<span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Baik</span>'
            : item.prevalensi < 20
            ? '<span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Waspada</span>'
            : '<span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Prioritas</span>';
        
        tableHtml += `
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-900">${index + 1}</td>
                <td class="px-4 py-3 text-sm font-medium text-gray-900">${item.nama}</td>
                <td class="px-4 py-3 text-sm text-gray-700 text-center">${item.total_anak}</td>
                <td class="px-4 py-3 text-sm text-gray-700 text-center">${item.stunting}</td>
                <td class="px-4 py-3 text-sm text-gray-900 text-center font-semibold">${item.prevalensi}%</td>
                <td class="px-4 py-3 text-center">${statusBadge}</td>
            </tr>
        `;
    });
    document.getElementById('detailPosyanduList').innerHTML = tableHtml;
}

function closeModalDetailWilayah() {
    closeModal('modalDetailWilayah');
    currentDetailWilayah = null;
}

function exportDetailWilayah() {
    if (!currentDetailWilayah) return;
    window.location.href = `{{ route('dppkb.statistik') }}/export-detail/${currentDetailWilayah.kode}`;
}

// ============================================================================
// EXPORT MODAL
// ============================================================================
function openModalExport() {
    openModal('modalExport');
}

function closeModalExport() {
    closeModal('modalExport');
}

async function submitExport(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    
    // Add current filters
    Object.keys(currentStatistikFilters).forEach(key => {
        if (currentStatistikFilters[key]) {
            formData.append(`filters[${key}]`, currentStatistikFilters[key]);
        }
    });
    
    try {
        const response = await fetch('{{ route("dppkb.statistik") }}/export', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });
        
        if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `statistik_stunting_${new Date().getTime()}.${formData.get('export_format')}`;
            document.body.appendChild(a);
            a.click();
            a.remove();
            
            closeModalExport();
            showSuccessToast('Export berhasil diunduh');
        } else {
            throw new Error('Export gagal');
        }
    } catch (error) {
        console.error('Error:', error);
        showErrorToast('Gagal export data');
    }
}

// ============================================================================
// UTILITIES
// ============================================================================
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

function showSuccessToast(message) {
    showToast(message, 'success');
}

function showErrorToast(message) {
    showToast(message, 'error');
}

function showInfoToast(message) {
    showToast(message, 'info');
}

function showToast(message, type = 'info') {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500'
    };
    
    const icons = {
        success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>',
        error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
        info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
    };
    
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-2xl z-[60] transform transition-all duration-300 flex items-center space-x-3 max-w-md`;
    toast.innerHTML = `
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            ${icons[type]}
        </svg>
        <span class="text-sm font-medium">${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.transform = 'translateX(400px)';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>