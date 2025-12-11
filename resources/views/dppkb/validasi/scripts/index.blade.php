<script>
// ============================================================================
// GLOBAL VARIABLES
// ============================================================================
let currentPage = 1;
let currentFilters = {
    search: '',
    status: 'Validated',
    kecamatan: ''
};
let selectedData = null;

// ============================================================================
// INITIALIZATION
// ============================================================================
document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    loadValidasiData();
    updateHeaderTime();
    setInterval(updateHeaderTime, 60000); // Update every minute
    
    // Setup search with debounce
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentFilters.search = this.value;
            loadValidasiData();
        }, 500);
    });
    
    // Setup filter change handlers
    document.getElementById('statusFilter').addEventListener('change', function() {
        currentFilters.status = this.value;
        loadValidasiData();
    });
    
    document.getElementById('kecamatanFilter').addEventListener('change', function() {
        currentFilters.kecamatan = this.value;
        loadValidasiData();
    });
});

// ============================================================================
// PAGE INITIALIZATION
// ============================================================================
function initializePage() {
    // Setup keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K: Focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            document.getElementById('searchInput').focus();
        }
        
        // ESC: Close modals
        if (e.key === 'Escape') {
            closeModalDetail();
            closeModalApprove();
            closeModalKlarifikasi();
        }
    });
    
    // Setup modal click-outside-to-close
    ['modalDetail', 'modalApprove', 'modalKlarifikasi'].forEach(modalId => {
        document.getElementById(modalId)?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(modalId);
            }
        });
    });
}

function updateHeaderTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const timeElement = document.getElementById('headerTime');
    if (timeElement) {
        timeElement.textContent = `${hours}:${minutes} WITA`;
    }
}

// ============================================================================
// DATA LOADING
// ============================================================================
async function loadValidasiData(page = 1) {
    currentPage = page;
    showLoading();
    
    try {
        const params = new URLSearchParams({
            page: currentPage,
            search: currentFilters.search,
            status: currentFilters.status,
            kecamatan: currentFilters.kecamatan
        });
        
        const response = await fetch(`{{ route('dppkb.validasi.data') }}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        
        renderTable(data.data);
        renderPagination(data);
        updateStats(data.stats);
        updateShowingCount(data.total);
        
    } catch (error) {
        console.error('Error loading data:', error);
        showErrorToast('Gagal memuat data. Silakan refresh halaman.');
        showErrorState();
    }
}

function showLoading() {
    document.getElementById('validasiTableContainer').innerHTML = `
        <div class="flex items-center justify-center py-12">
            <div class="text-center">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-purple-600 border-t-transparent mb-4"></div>
                <p class="text-gray-600">Memuat data validasi...</p>
            </div>
        </div>
    `;
}

function showErrorState() {
    document.getElementById('validasiTableContainer').innerHTML = `
        <div class="flex items-center justify-center py-12">
            <div class="text-center">
                <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-600 mb-4">Terjadi kesalahan saat memuat data</p>
                <button onclick="loadValidasiData()" 
                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    Coba Lagi
                </button>
            </div>
        </div>
    `;
}

// ============================================================================
// TABLE RENDERING
// ============================================================================
function renderTable(data) {
    const container = document.getElementById('validasiTableContainer');
    
    if (!data || data.length === 0) {
        container.innerHTML = `
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-600 text-lg font-medium mb-2">Tidak Ada Data</p>
                <p class="text-gray-500 text-sm">Tidak ada data yang sesuai dengan filter Anda</p>
            </div>
        `;
        return;
    }
    
    let tableHTML = `
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-purple-600 to-purple-800 text-white">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Data Anak</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Orang Tua</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Status Gizi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Validator Puskesmas</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
    `;
    
    data.forEach((item, index) => {
        const rowNumber = (currentPage - 1) * 20 + index + 1;
        const statusBadge = getStatusBadge(item.status_stunting);
        const validasiBadge = getValidasiBadge(item.status_validasi);
        
        tableHTML += `
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm text-gray-900 font-medium">${rowNumber}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">${item.anak.nama_anak}</p>
                            <p class="text-xs text-gray-500">${item.anak.nik_anak}</p>
                            <p class="text-xs text-gray-500">${item.umur_bulan} bulan • ${item.anak.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-900">${item.anak.orang_tua.nama_ibu || '-'}</p>
                    <p class="text-xs text-gray-500">${item.anak.orang_tua.telepon || '-'}</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-900">${item.anak.posyandu.nama_posyandu}</p>
                    <p class="text-xs text-gray-500">${item.anak.posyandu.puskesmas.nama_puskesmas}</p>
                    <p class="text-xs text-purple-600 font-medium">${item.anak.posyandu.puskesmas.kecamatan}</p>
                </td>
                <td class="px-6 py-4">
                    <div class="space-y-1">
                        ${statusBadge}
                        <div class="text-xs text-gray-600">
                            <span class="font-medium">TB/U:</span> ${item.z_score_tb_u}
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-900">${item.validator?.nama || '-'}</p>
                    <p class="text-xs text-gray-500">${item.tanggal_validasi ? formatDate(item.tanggal_validasi) : '-'}</p>
                </td>
                <td class="px-6 py-4">${validasiBadge}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center space-x-2">
                        <button onclick="showDetail(${item.id_stunting})" 
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                            title="Lihat Detail">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                        ${item.status_validasi === 'Validated' ? `
                            <button onclick="showApproveModal(${item.id_stunting})" 
                                class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                title="Setujui">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                            <button onclick="showKlarifikasiModal(${item.id_stunting})" 
                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                title="Minta Klarifikasi">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </button>
                        ` : ''}
                    </div>
                </td>
            </tr>
        `;
    });
    
    tableHTML += `
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200" id="paginationContainer">
                <!-- Pagination will be inserted here -->
            </div>
        </div>
    `;
    
    container.innerHTML = tableHTML;
}

function getStatusBadge(status) {
    const badges = {
        'Normal': '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Normal</span>',
        'Stunting Ringan': '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Stunting Ringan</span>',
        'Stunting Sedang': '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">Stunting Sedang</span>',
        'Stunting Berat': '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Stunting Berat</span>'
    };
    return badges[status] || status;
}

function getValidasiBadge(status) {
    const badges = {
        'Pending': '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800"><span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>Pending</span>',
        'Validated': '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800"><span class="w-2 h-2 bg-orange-500 rounded-full mr-2 animate-pulse"></span>Menunggu Approval</span>',
        'Final': '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800"><span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Disetujui</span>',
        'Rejected': '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800"><span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>Ditolak</span>'
    };
    return badges[status] || status;
}

// ============================================================================
// PAGINATION
// ============================================================================
function renderPagination(data) {
    const container = document.getElementById('paginationContainer');
    if (!container) return;
    
    if (data.last_page <= 1) {
        container.innerHTML = '';
        return;
    }
    
    let paginationHTML = '<div class="flex items-center justify-between">';
    
    // Info
    paginationHTML += `
        <div class="text-sm text-gray-600">
            Halaman <span class="font-semibold text-gray-900">${data.current_page}</span> 
            dari <span class="font-semibold text-gray-900">${data.last_page}</span>
        </div>
    `;
    
    // Buttons
    paginationHTML += '<div class="flex space-x-2">';
    
    // Previous
    if (data.current_page > 1) {
        paginationHTML += `
            <button onclick="loadValidasiData(${data.current_page - 1})" 
                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Sebelumnya
            </button>
        `;
    }
    
    // Page numbers
    const maxButtons = 5;
    let startPage = Math.max(1, data.current_page - Math.floor(maxButtons / 2));
    let endPage = Math.min(data.last_page, startPage + maxButtons - 1);
    
    if (endPage - startPage < maxButtons - 1) {
        startPage = Math.max(1, endPage - maxButtons + 1);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        const isActive = i === data.current_page;
        paginationHTML += `
            <button onclick="loadValidasiData(${i})" 
                class="px-4 py-2 text-sm rounded-lg transition ${
                    isActive 
                        ? 'bg-purple-600 text-white font-semibold' 
                        : 'text-gray-700 bg-white border border-gray-300 hover:bg-gray-50'
                }">
                ${i}
            </button>
        `;
    }
    
    // Next
    if (data.current_page < data.last_page) {
        paginationHTML += `
            <button onclick="loadValidasiData(${data.current_page + 1})" 
                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Selanjutnya
                <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        `;
    }
    
    paginationHTML += '</div></div>';
    container.innerHTML = paginationHTML;
}

// ============================================================================
// STATS UPDATE
// ============================================================================
function updateStats(stats) {
    if (!stats) return;
    
    document.getElementById('statPending').textContent = stats.pending || 0;
    document.getElementById('statApproved').textContent = stats.approved_today || 0;
    document.getElementById('statClarification').textContent = stats.clarification || 0;
    document.getElementById('statTotal').textContent = stats.total_month || 0;
}

function updateShowingCount(total) {
    const element = document.getElementById('showingCount');
    if (element) {
        element.textContent = total || 0;
    }
}

// ============================================================================
// FILTER ACTIONS
// ============================================================================
function applyFilter() {
    loadValidasiData(1);
}

function resetFilter() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = 'Validated';
    document.getElementById('kecamatanFilter').value = '';
    
    currentFilters = {
        search: '',
        status: 'Validated',
        kecamatan: ''
    };
    
    loadValidasiData(1);
}

function refreshData() {
    showSuccessToast('Memperbarui data...');
    loadValidasiData(currentPage);
}

// ============================================================================
// MODAL DETAIL
// ============================================================================
async function showDetail(id) {
    try {
        const response = await fetch(`{{ url('dppkb/validasi') }}/${id}/detail`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Failed to fetch detail');
        
        const data = await response.json();
        populateDetailModal(data);
        openModal('modalDetail');
        
    } catch (error) {
        console.error('Error:', error);
        showErrorToast('Gagal memuat detail data');
    }
}

function populateDetailModal(data) {
    selectedData = data;
    
    // Anak info
    document.getElementById('detailNamaAnak').textContent = data.anak.nama_anak;
    document.getElementById('detailNIKAnak').textContent = data.anak.nik_anak;
    document.getElementById('detailTanggalLahir').textContent = formatDate(data.anak.tanggal_lahir);
    document.getElementById('detailUmur').textContent = data.pengukuran.umur_bulan;
    
    // Orang tua
    document.getElementById('detailNamaAyah').textContent = data.anak.orang_tua.nama_ayah || '-';
    document.getElementById('detailNamaIbu').textContent = data.anak.orang_tua.nama_ibu || '-';
    document.getElementById('detailTelepon').textContent = data.anak.orang_tua.telepon || '-';
    document.getElementById('detailAlamat').textContent = data.anak.orang_tua.alamat || '-';
    
    // Lokasi
    document.getElementById('detailPosyandu').textContent = data.anak.posyandu.nama_posyandu;
    document.getElementById('detailPuskesmas').textContent = data.anak.posyandu.puskesmas.nama_puskesmas;
    document.getElementById('detailKecamatan').textContent = data.anak.posyandu.puskesmas.kecamatan;
    
    // Z-Score
    document.getElementById('detailBBU').textContent = data.z_score_bb_u;
    document.getElementById('detailTBU').textContent = data.z_score_tb_u;
    document.getElementById('detailBBTB').textContent = data.z_score_bb_tb;
    document.getElementById('detailStatus').textContent = data.status_stunting;
    document.getElementById('detailCatatan').textContent = data.catatan || 'Tidak ada catatan';
    
    // Status color
    const statusContainer = document.getElementById('detailStatusContainer');
    const statusColors = {
        'Normal': 'bg-green-50',
        'Stunting Ringan': 'bg-yellow-50',
        'Stunting Sedang': 'bg-orange-50',
        'Stunting Berat': 'bg-red-50'
    };
    statusContainer.className = `text-center p-4 rounded-lg ${statusColors[data.status_stunting] || 'bg-gray-50'}`;
    
    // Validation history
    populateValidationHistory(data.validation_history);
    
    // Measurement history
    populateMeasurementHistory(data.measurement_history);
    
    // Action buttons
    populateActionButtons(data);
}

function populateValidationHistory(history) {
    const container = document.getElementById('detailValidationHistory');
    if (!history || history.length === 0) {
        container.innerHTML = '<p class="text-sm text-gray-500 text-center py-4">Belum ada riwayat validasi</p>';
        return;
    }
    
    let html = '';
    history.forEach(item => {
        const icon = item.status_validasi === 'Final' ? '✓' : item.status_validasi === 'Pending' ? '⚠' : '○';
        const color = item.status_validasi === 'Final' ? 'text-green-600' : item.status_validasi === 'Pending' ? 'text-orange-600' : 'text-gray-600';
        
        html += `
            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-6 h-6 ${color} flex-shrink-0 font-bold text-lg">${icon}</div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-sm font-semibold text-gray-900">${item.validator}</p>
                        <span class="text-xs text-gray-500">${formatDate(item.tanggal_validasi)}</span>
                    </div>
                    <p class="text-xs ${color} font-medium mb-1">${item.status_validasi}</p>
                    <p class="text-xs text-gray-600">${item.catatan_validasi || '-'}</p>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function populateMeasurementHistory(history) {
    const tbody = document.getElementById('detailMeasurementHistory');
    if (!history || history.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">Tidak ada riwayat</td></tr>';
        return;
    }
    
    let html = '';
    history.forEach(item => {
        const statusBadge = getStatusBadge(item.status_stunting);
        html += `
            <tr>
                <td class="px-4 py-3 text-sm text-gray-900">${formatDate(item.tanggal_ukur)}</td>
                <td class="px-4 py-3 text-sm text-gray-900">${item.umur_bulan} bulan</td>
                <td class="px-4 py-3 text-sm text-gray-900">${item.berat_badan}</td>
                <td class="px-4 py-3 text-sm text-gray-900">${item.tinggi_badan}</td>
                <td class="px-4 py-3">${statusBadge}</td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function populateActionButtons(data) {
    const container = document.getElementById('detailActionButtons');
    if (data.status_validasi === 'Validated') {
        container.innerHTML = `
            <button onclick="showApproveModal(${data.id_stunting})" 
                class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium shadow-lg flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Setujui</span>
            </button>
            <button onclick="showKlarifikasiModal(${data.id_stunting})" 
                class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition font-medium shadow-lg flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span>Minta Klarifikasi</span>
            </button>
        `;
    } else {
        container.innerHTML = '';
    }
}

function closeModalDetail() {
    closeModal('modalDetail');
    selectedData = null;
}

// ============================================================================
// MODAL APPROVE
// ============================================================================
function showApproveModal(id) {
    if (!selectedData || selectedData.id_stunting !== id) {
        // Load data first
        showDetail(id).then(() => {
            setTimeout(() => openApproveModalWithData(), 300);
        });
    } else {
        openApproveModalWithData();
    }
}

function openApproveModalWithData() {
    if (!selectedData) return;
    
    document.getElementById('approveId').value = selectedData.id_stunting;
    document.getElementById('approveNamaAnak').textContent = selectedData.anak.nama_anak;
    document.getElementById('approveStatus').textContent = selectedData.status_stunting;
    document.getElementById('approvePosyandu').textContent = selectedData.anak.posyandu.nama_posyandu;
    document.getElementById('approveCatatan').value = '';
    
    openModal('modalApprove');
}

async function submitApprove(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const id = document.getElementById('approveId').value;
    
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="ml-2">Memproses...</span>
    `;
    
    try {
        const response = await fetch(`{{ url('dppkb/validasi') }}/${id}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const result = await response.json();
        
        if (response.ok && result.success) {
            closeModalApprove();
            closeModalDetail();
            showSuccessToast(result.message || 'Data berhasil disetujui');
            loadValidasiData(currentPage);
        } else {
            throw new Error(result.message || 'Gagal menyetujui data');
        }
        
    } catch (error) {
        console.error('Error:', error);
        showErrorToast(error.message || 'Terjadi kesalahan saat menyetujui data');
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    }
}

function closeModalApprove() {
    closeModal('modalApprove');
    document.getElementById('formApprove').reset();
}

// ============================================================================
// MODAL KLARIFIKASI
// ============================================================================
function showKlarifikasiModal(id) {
    if (!selectedData || selectedData.id_stunting !== id) {
        showDetail(id).then(() => {
            setTimeout(() => openKlarifikasiModalWithData(), 300);
        });
    } else {
        openKlarifikasiModalWithData();
    }
}

function openKlarifikasiModalWithData() {
    if (!selectedData) return;
    
    document.getElementById('klarifikasiId').value = selectedData.id_stunting;
    document.getElementById('klarifikasiNamaAnak').textContent = selectedData.anak.nama_anak;
    document.getElementById('klarifikasiStatus').textContent = selectedData.status_stunting;
    document.getElementById('klarifikasiPosyandu').textContent = selectedData.anak.posyandu.nama_posyandu;
    document.getElementById('klarifikasiAlasan').value = '';
    
    // Reset radio buttons
    document.querySelectorAll('input[name="kategori"]').forEach(radio => radio.checked = false);
    
    openModal('modalKlarifikasi');
}

async function submitKlarifikasi(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const id = document.getElementById('klarifikasiId').value;
    
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="ml-2">Mengirim...</span>
    `;
    
    try {
        const response = await fetch(`{{ url('dppkb/validasi') }}/${id}/klarifikasi`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const result = await response.json();
        
        if (response.ok && result.success) {
            closeModalKlarifikasi();
            closeModalDetail();
            showSuccessToast(result.message || 'Permintaan klarifikasi berhasil dikirim');
            loadValidasiData(currentPage);
        } else {
            throw new Error(result.message || 'Gagal mengirim klarifikasi');
        }
        
    } catch (error) {
        console.error('Error:', error);
        showErrorToast(error.message || 'Terjadi kesalahan saat mengirim klarifikasi');
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    }
}

function closeModalKlarifikasi() {
    closeModal('modalKlarifikasi');
    document.getElementById('formKlarifikasi').reset();
}

// ============================================================================
// MODAL UTILITIES
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

// ============================================================================
// UTILITIES
// ============================================================================
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric' 
    });
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