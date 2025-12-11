<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// ============================================================================
// GLOBAL VARIABLES
// ============================================================================
let monitoringFilters = {
    periode: 'bulan_ini',
    kecamatan: '',
    status: '',
    tampilan: 'map'
};

let trenChartInstance = null;
let distribusiChartInstance = null;
let mapViewMode = 'marker'; // marker or heat

// ============================================================================
// INITIALIZATION
// ============================================================================
document.addEventListener('DOMContentLoaded', function() {
    loadMonitoringData();
    initializeCharts();
    updateMonitoringTime();
    setInterval(updateMonitoringTime, 60000);
    
    // Auto refresh every 5 minutes
    setInterval(() => {
        refreshMonitoringData();
    }, 300000);
});

function updateMonitoringTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const timeElement = document.getElementById('monitoringTime');
    if (timeElement) {
        timeElement.textContent = `${hours}:${minutes} WITA`;
    }
}

// ============================================================================
// DATA LOADING
// ============================================================================
async function loadMonitoringData() {
    try {
        const params = new URLSearchParams(monitoringFilters);
        
        const response = await fetch(`{{ route('dppkb.monitoring.data') }}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Failed to load data');
        
        const data = await response.json();
        
        updateQuickStats(data.stats);
        updateMap(data.kecamatan);
        updateKecamatanList(data.kecamatan);
        updateTrenChart(data.tren);
        updateDistribusiChart(data.distribusi);
        updateTopPuskesmas(data.top_puskesmas);
        
    } catch (error) {
        console.error('Error loading monitoring data:', error);
        showErrorToast('Gagal memuat data monitoring');
    }
}

function refreshMonitoringData() {
    showInfoToast('Memperbarui data...');
    loadMonitoringData();
}

// ============================================================================
// QUICK STATS UPDATE
// ============================================================================
function updateQuickStats(stats) {
    document.getElementById('statTotalAnak').textContent = formatNumber(stats.total_anak || 0);
    document.getElementById('statTotalAnakTrend').textContent = `+${stats.trend_anak || 0}%`;
    
    document.getElementById('statTotalStunting').textContent = formatNumber(stats.total_stunting || 0);
    document.getElementById('statTotalStuntingDetail').textContent = 
        `${stats.stunting_ringan || 0} ringan • ${stats.stunting_sedang || 0} sedang • ${stats.stunting_berat || 0} berat`;
    
    const prevalensi = stats.prevalensi || 0;
    document.getElementById('statPrevalensi').textContent = `${prevalensi.toFixed(1)}%`;
    
    document.getElementById('statWilayahPrioritas').textContent = stats.wilayah_prioritas || 0;
}

// ============================================================================
// MAP UPDATE
// ============================================================================
function updateMap(kecamatanData) {
    const kecamatanMap = {
        'Bacukiki': 'textBacukiki',
        'Bacukiki Barat': 'textBacukikiBarat',
        'Ujung': 'textUjung',
        'Soreang': 'textSoreang'
    };
    
    kecamatanData.forEach(kec => {
        const textId = kecamatanMap[kec.nama];
        if (textId) {
            const element = document.getElementById(textId);
            if (element) {
                element.textContent = `${kec.total_stunting} Stunting (${kec.prevalensi.toFixed(1)}%)`;
            }
            
            // Update region color based on prevalensi
            const regionId = `kec-${kec.nama.toLowerCase().replace(/\s+/g, '-')}`;
            const region = document.getElementById(regionId);
            if (region) {
                const path = region.querySelector('path');
                if (path) {
                    const gradient = getGradientByPrevalensi(kec.prevalensi);
                    path.setAttribute('fill', gradient);
                }
            }
        }
    });
}

function getGradientByPrevalensi(prevalensi) {
    if (prevalensi < 14) return 'url(#gradGreen)';
    if (prevalensi < 20) return 'url(#gradYellow)';
    if (prevalensi < 30) return 'url(#gradOrange)';
    return 'url(#gradRed)';
}

function highlightKecamatan(element) {
    const path = element.querySelector('path');
    if (path) {
        path.setAttribute('opacity', '1');
        path.setAttribute('stroke-width', '4');
    }
}

function unhighlightKecamatan(element) {
    const path = element.querySelector('path');
    if (path) {
        path.setAttribute('opacity', '0.8');
        path.setAttribute('stroke-width', '3');
    }
}

function selectKecamatan(kecamatan) {
    monitoringFilters.kecamatan = kecamatan;
    document.getElementById('filterKecamatan').value = kecamatan;
    showInfoToast(`Filter diubah ke ${kecamatan}`);
    loadMonitoringData();
}

function toggleMapView(mode) {
    mapViewMode = mode;
    
    // Update button states
    const btnHeat = document.getElementById('btnHeatMap');
    const btnMarker = document.getElementById('btnMarkerMap');
    
    if (mode === 'heat') {
        btnHeat.className = 'px-3 py-1.5 bg-white text-blue-700 text-sm rounded-lg transition font-medium';
        btnMarker.className = 'px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition';
    } else {
        btnHeat.className = 'px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition';
        btnMarker.className = 'px-3 py-1.5 bg-white text-blue-700 text-sm rounded-lg transition font-medium';
    }
    
    // Implement different visualizations if needed
    showInfoToast(`Tampilan peta diubah ke ${mode === 'heat' ? 'Heat Map' : 'Markers'}`);
}

// ============================================================================
// KECAMATAN LIST UPDATE
// ============================================================================
function updateKecamatanList(kecamatanData) {
    const container = document.getElementById('kecamatanListContainer');
    
    if (!kecamatanData || kecamatanData.length === 0) {
        container.innerHTML = `
            <div class="px-6 py-8 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p>Tidak ada data</p>
            </div>
        `;
        return;
    }
    
    let html = '';
    kecamatanData.forEach((kec, index) => {
        const prevalensiColor = getPrevalensiColor(kec.prevalensi);
        const statusIcon = getStatusIcon(kec.prevalensi);
        
        html += `
            <div class="p-6 hover:bg-gray-50 transition cursor-pointer" 
                onclick="showKecamatanDetail('${kec.nama}')">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 ${prevalensiColor} rounded-full flex items-center justify-center font-bold text-white">
                            ${index + 1}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">${kec.nama}</h4>
                            <p class="text-xs text-gray-500">${kec.total_posyandu} Posyandu</p>
                        </div>
                    </div>
                    ${statusIcon}
                </div>
                
                <div class="grid grid-cols-3 gap-3 mb-3">
                    <div class="text-center p-2 bg-blue-50 rounded-lg">
                        <p class="text-xs text-blue-600 font-medium">Total Anak</p>
                        <p class="text-lg font-bold text-blue-900">${kec.total_anak}</p>
                    </div>
                    <div class="text-center p-2 bg-red-50 rounded-lg">
                        <p class="text-xs text-red-600 font-medium">Stunting</p>
                        <p class="text-lg font-bold text-red-900">${kec.total_stunting}</p>
                    </div>
                    <div class="text-center p-2 bg-orange-50 rounded-lg">
                        <p class="text-xs text-orange-600 font-medium">Prevalensi</p>
                        <p class="text-lg font-bold text-orange-900">${kec.prevalensi.toFixed(1)}%</p>
                    </div>
                </div>
                
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="${prevalensiColor} h-2 rounded-full transition-all duration-300" 
                        style="width: ${Math.min(kec.prevalensi, 100)}%"></div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function getPrevalensiColor(prevalensi) {
    if (prevalensi < 14) return 'bg-green-500';
    if (prevalensi < 20) return 'bg-yellow-500';
    if (prevalensi < 30) return 'bg-orange-500';
    return 'bg-red-500';
}

function getStatusIcon(prevalensi) {
    if (prevalensi < 14) {
        return `<span class="text-green-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>`;
    } else if (prevalensi >= 30) {
        return `<span class="text-red-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></span>`;
    }
    return `<span class="text-yellow-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>`;
}

function showKecamatanDetail(kecamatan) {
    window.location.href = `{{ url('dppkb/monitoring/wilayah') }}/${kecamatan}`;
}

// ============================================================================
// CHARTS INITIALIZATION
// ============================================================================
function initializeCharts() {
    initTrenChart();
    initDistribusiChart();
}

function initTrenChart() {
    const ctx = document.getElementById('trenChart');
    if (!ctx) return;
    
    trenChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Kasus Stunting',
                data: [],
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 5,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 7
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
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#6366f1',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        stepSize: 10
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

function initDistribusiChart() {
    const ctx = document.getElementById('distribusiChart');
    if (!ctx) return;
    
    distribusiChartInstance = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Normal', 'Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'],
            datasets: [{
                data: [0, 0, 0, 0],
                backgroundColor: [
                    '#10b981',
                    '#fbbf24',
                    '#fb923c',
                    '#ef4444'
                ],
                borderColor: '#fff',
                borderWidth: 3
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
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// ============================================================================
// CHARTS UPDATE
// ============================================================================
function updateTrenChart(trenData) {
    if (!trenChartInstance || !trenData) return;
    
    trenChartInstance.data.labels = trenData.labels || [];
    trenChartInstance.data.datasets[0].data = trenData.values || [];
    trenChartInstance.update();
    
    // Update summary
    const total = trenData.values.reduce((a, b) => a + b, 0);
    const average = trenData.values.length > 0 ? (total / trenData.values.length).toFixed(1) : 0;
    
    document.getElementById('trenTotalKasus').textContent = formatNumber(total);
    document.getElementById('trenRataRata').textContent = formatNumber(average);
    
    // Calculate trend
    if (trenData.values.length >= 2) {
        const last = trenData.values[trenData.values.length - 1];
        const previous = trenData.values[trenData.values.length - 2];
        const diff = last - previous;
        
        let trendHtml = '';
        if (diff > 0) {
            trendHtml = `
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                <span class="text-sm font-semibold text-red-600">Naik</span>
            `;
        } else if (diff < 0) {
            trendHtml = `
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                </svg>
                <span class="text-sm font-semibold text-green-600">Turun</span>
            `;
        } else {
            trendHtml = `
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
                </svg>
                <span class="text-sm font-semibold text-gray-600">Stabil</span>
            `;
        }
        
        document.getElementById('trenDirection').innerHTML = trendHtml;
    }
}

function updateDistribusiChart(distribusiData) {
    if (!distribusiChartInstance || !distribusiData) return;
    
    const values = [
        distribusiData.normal || 0,
        distribusiData.ringan || 0,
        distribusiData.sedang || 0,
        distribusiData.berat || 0
    ];
    
    distribusiChartInstance.data.datasets[0].data = values;
    distribusiChartInstance.update();
    
    // Update legend detail
    document.getElementById('distNormal').textContent = formatNumber(distribusiData.normal || 0);
    document.getElementById('distRingan').textContent = formatNumber(distribusiData.ringan || 0);
    document.getElementById('distSedang').textContent = formatNumber(distribusiData.sedang || 0);
    document.getElementById('distBerat').textContent = formatNumber(distribusiData.berat || 0);
}

function toggleChartType(chartName, type) {
    if (chartName === 'trenChart' && trenChartInstance) {
        trenChartInstance.config.type = type;
        trenChartInstance.update();
        
        // Update buttons
        document.getElementById('btnTrenLine').className = type === 'line' 
            ? 'px-3 py-1.5 bg-white text-indigo-700 text-sm rounded-lg transition font-medium'
            : 'px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition';
        document.getElementById('btnTrenBar').className = type === 'bar'
            ? 'px-3 py-1.5 bg-white text-indigo-700 text-sm rounded-lg transition font-medium'
            : 'px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition';
    }
    
    if (chartName === 'distribusiChart' && distribusiChartInstance) {
        distribusiChartInstance.config.type = type;
        distribusiChartInstance.update();
        
        // Update buttons
        document.getElementById('btnDistribusiPie').className = type === 'pie'
            ? 'px-3 py-1.5 bg-white text-purple-700 text-sm rounded-lg transition font-medium'
            : 'px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition';
        document.getElementById('btnDistribusiDoughnut').className = type === 'doughnut'
            ? 'px-3 py-1.5 bg-white text-purple-700 text-sm rounded-lg transition font-medium'
            : 'px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition';
    }
}

// ============================================================================
// TOP PUSKESMAS TABLE UPDATE
// ============================================================================
function updateTopPuskesmas(puskesmasData) {
    const tbody = document.getElementById('topPuskesmasTableBody');
    
    if (!puskesmasData || puskesmasData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                    Tidak ada data
                </td>
            </tr>
        `;
        return;
    }
    
    let html = '';
    puskesmasData.forEach((pusk, index) => {
        const rankBadge = getRankBadge(index + 1);
        const prevalensiClass = getPrevalensiClass(pusk.prevalensi);
        
        html += `
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">${rankBadge}</td>
                <td class="px-6 py-4">
                    <p class="text-sm font-semibold text-gray-900">${pusk.nama_puskesmas}</p>
                    <p class="text-xs text-gray-500">${pusk.total_posyandu} Posyandu</p>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">${pusk.kecamatan}</td>
                <td class="px-6 py-4 text-center text-sm font-medium text-gray-900">${pusk.total_anak}</td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                        ${pusk.total_stunting}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ${prevalensiClass}">
                        ${pusk.prevalensi.toFixed(1)}%
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <button onclick="showPuskesmasDetail('${pusk.nama_puskesmas}')" 
                        class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Detail
                    </button>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function getRankBadge(rank) {
    const badges = {
        1: '<div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">🥇</div>',
        2: '<div class="w-8 h-8 bg-gradient-to-br from-gray-300 to-gray-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg">🥈</div>',
        3: '<div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">🥉</div>'
    };
    return badges[rank] || `<div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-700 font-bold">${rank}</div>`;
}

function getPrevalensiClass(prevalensi) {
    if (prevalensi < 14) return 'bg-green-100 text-green-800';
    if (prevalensi < 20) return 'bg-yellow-100 text-yellow-800';
    if (prevalensi < 30) return 'bg-orange-100 text-orange-800';
    return 'bg-red-100 text-red-800';
}

function showPuskesmasDetail(nama) {
    showInfoToast(`Menampilkan detail ${nama}`);
    // Implement detail view
}

// ============================================================================
// FILTER ACTIONS
// ============================================================================
function applyMonitoringFilter() {
    monitoringFilters.periode = document.getElementById('filterPeriode').value;
    monitoringFilters.kecamatan = document.getElementById('filterKecamatan').value;
    monitoringFilters.status = document.getElementById('filterStatus').value;
    
    updateActiveFilters();
    loadMonitoringData();
}

function resetMonitoringFilter() {
    document.getElementById('filterPeriode').value = 'bulan_ini';
    document.getElementById('filterKecamatan').value = '';
    document.getElementById('filterStatus').value = '';
    
    monitoringFilters = {
        periode: 'bulan_ini',
        kecamatan: '',
        status: '',
        tampilan: 'map'
    };
    
    updateActiveFilters();
    loadMonitoringData();
    showInfoToast('Filter direset');
}

function changeViewMode() {
    monitoringFilters.tampilan = document.getElementById('filterTampilan').value;
    showInfoToast(`Tampilan diubah ke ${monitoringFilters.tampilan}`);
    // Implement view mode change
}

function updateActiveFilters() {
    const container = document.getElementById('activeFiltersDisplay');
    const tagsContainer = document.getElementById('activeFilterTags');
    
    let hasActiveFilter = false;
    let tagsHtml = '';
    
    if (monitoringFilters.kecamatan) {
        hasActiveFilter = true;
        tagsHtml += `
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                Kecamatan: ${monitoringFilters.kecamatan}
                <button onclick="clearFilter('kecamatan')" class="ml-2 hover:text-blue-900">×</button>
            </span>
        `;
    }
    
    if (monitoringFilters.status) {
        hasActiveFilter = true;
        tagsHtml += `
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                Status: ${monitoringFilters.status}
                <button onclick="clearFilter('status')" class="ml-2 hover:text-purple-900">×</button>
            </span>
        `;
    }
    
    if (hasActiveFilter) {
        container.classList.remove('hidden');
        tagsContainer.innerHTML = tagsHtml;
    } else {
        container.classList.add('hidden');
    }
}

function clearFilter(filterName) {
    monitoringFilters[filterName] = '';
    document.getElementById(`filter${filterName.charAt(0).toUpperCase() + filterName.slice(1)}`).value = '';
    updateActiveFilters();
    loadMonitoringData();
}

// ============================================================================
// EXPORT
// ============================================================================
function exportData() {
    showInfoToast('Mengekspor data...');
    window.location.href = `{{ route('dppkb.monitoring') }}/export?${new URLSearchParams(monitoringFilters)}`;
}

// ============================================================================
// UTILITIES
// ============================================================================
function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
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
    toast.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-2xl z-[60] transform transition-all duration-300 translate-x-0 opacity-100 flex items-center space-x-3 max-w-md`;
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