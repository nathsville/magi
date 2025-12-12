<script>
// ============================================================================
// GLOBAL VARIABLES
// ============================================================================
let currentNotifPage = 1;
let currentNotifFilters = {
    search: '',
    type: 'all',
    status: 'all'
};
let currentDetailId = null;

// ============================================================================
// INITIALIZATION
// ============================================================================
document.addEventListener('DOMContentLoaded', function() {
    loadNotifikasi();
    loadStats();
    
    // Setup search with debounce
    const searchInput = document.getElementById('searchNotifikasi');
    let searchTimeout;
    searchInput?.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentNotifFilters.search = this.value;
            loadNotifikasi(1);
        }, 500);
    });
    
    // Setup compose form watchers
    setupComposeWatchers();
    
    // Auto refresh every 2 minutes
    setInterval(() => {
        loadNotifikasi(currentNotifPage);
        loadStats();
    }, 120000);
});

// ============================================================================
// DATA LOADING
// ============================================================================
async function loadNotifikasi(page = 1) {
    currentNotifPage = page;
    
    try {
        const params = new URLSearchParams({
            page: currentNotifPage,
            search: currentNotifFilters.search,
            type: currentNotifFilters.type,
            status: currentNotifFilters.status
        });
        
        const response = await fetch(`{{ route('dppkb.notifikasi') }}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Failed to load notifications');
        
        const data = await response.json();
        
        renderNotificationList(data.data);
        renderNotificationPagination(data);
        updateNotifCount(data.total);
        
    } catch (error) {
        console.error('Error:', error);
        showErrorToast('Gagal memuat notifikasi');
    }
}

async function loadStats() {
    try {
        const response = await fetch('{{ route("dppkb.notifikasi") }}/stats', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Failed to load stats');
        
        const data = await response.json();
        updateStats(data);
        
    } catch (error) {
        console.error('Error loading stats:', error);
    }
}

// ============================================================================
// RENDER FUNCTIONS
// ============================================================================
function renderNotificationList(data) {
    const container = document.getElementById('notificationListContainer');
    
    if (!data || data.length === 0) {
        container.innerHTML = `
            <div class="px-6 py-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <p class="text-gray-600 text-lg font-medium">Tidak Ada Notifikasi</p>
                <p class="text-gray-500 text-sm mt-2">Belum ada notifikasi yang diterima</p>
            </div>
        `;
        return;
    }
    
    let html = '';
    data.forEach(item => {
        const isUnread = item.status_baca === 'belum_dibaca';
        const typeIcon = getTypeIcon(item.tipe_notifikasi);
        const typeColor = getTypeColor(item.tipe_notifikasi);
        
        html += `
            <div onclick="showNotifDetail(${item.id_notifikasi})" 
                class="px-6 py-4 hover:bg-gray-50 cursor-pointer transition ${isUnread ? 'bg-blue-50' : ''}">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 ${typeColor} rounded-lg flex items-center justify-center">
                            ${typeIcon}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-sm font-bold text-gray-900 truncate ${isUnread ? 'font-extrabold' : ''}">
                                ${item.judul}
                            </p>
                            <span class="text-xs text-gray-500 ml-2 flex-shrink-0">
                                ${formatRelativeTime(item.tanggal_kirim)}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-2">
                            ${item.pesan}
                        </p>
                        <div class="flex items-center space-x-2">
                            ${getTypeBadge(item.tipe_notifikasi)}
                            ${isUnread ? '<span class="px-2 py-0.5 bg-blue-500 text-white text-xs font-semibold rounded-full">Baru</span>' : ''}
                        </div>
                    </div>
                    ${isUnread ? '<div class="flex-shrink-0"><div class="w-2 h-2 bg-blue-500 rounded-full"></div></div>' : ''}
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function renderNotificationPagination(data) {
    const container = document.getElementById('notificationPagination');
    if (!container || data.last_page <= 1) {
        container.innerHTML = '';
        return;
    }
    
    let html = '<div class="flex items-center justify-between">';
    html += `<div class="text-sm text-gray-600">Halaman ${data.current_page} dari ${data.last_page}</div>`;
    html += '<div class="flex space-x-2">';
    
    if (data.current_page > 1) {
        html += `<button onclick="loadNotifikasi(${data.current_page - 1})" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Sebelumnya</button>`;
    }
    
    if (data.current_page < data.last_page) {
        html += `<button onclick="loadNotifikasi(${data.current_page + 1})" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Selanjutnya</button>`;
    }
    
    html += '</div></div>';
    container.innerHTML = html;
}

function updateStats(data) {
    if (!data) return;
    
    document.getElementById('statTotalNotifikasi').textContent = data.total || '0';
    document.getElementById('statBelumDibaca').textContent = data.belum_dibaca || '0';
    document.getElementById('statTerkirimHariIni').textContent = data.terkirim_hari_ini || '0';
    document.getElementById('headerUnreadBadge').textContent = data.belum_dibaca || '0';
    
    // Summary sidebar
    document.getElementById('summaryValidasi').textContent = data.by_type.validasi || '0';
    document.getElementById('summaryPeringatan').textContent = data.by_type.peringatan || '0';
    document.getElementById('summaryInformasi').textContent = data.by_type.informasi || '0';
    document.getElementById('summaryMingguIni').textContent = data.minggu_ini || '0';
    document.getElementById('summaryBulanIni').textContent = data.bulan_ini || '0';
}

function updateNotifCount(count) {
    document.getElementById('notifCount').textContent = `${count} notifikasi`;
}

// ============================================================================
// HELPER FUNCTIONS
// ============================================================================
function getTypeIcon(type) {
    const icons = {
        validasi: '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        peringatan: '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
        informasi: '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
    };
    return icons[type] || icons.informasi;
}

function getTypeColor(type) {
    const colors = {
        validasi: 'bg-purple-500',
        peringatan: 'bg-red-500',
        informasi: 'bg-green-500'
    };
    return colors[type] || 'bg-gray-500';
}

function getTypeBadge(type) {
    const badges = {
        validasi: '<span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">Validasi</span>',
        peringatan: '<span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Peringatan</span>',
        informasi: '<span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Informasi</span>'
    };
    return badges[type] || '';
}

function formatRelativeTime(dateString) {
    if (!dateString) return '-';
    
    const date = new Date(dateString);
    const now = new Date();
    const diff = now - date;
    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    
    if (days > 7) {
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    } else if (days > 0) {
        return `${days} hari lalu`;
    } else if (hours > 0) {
        return `${hours} jam lalu`;
    } else if (minutes > 0) {
        return `${minutes} menit lalu`;
    } else {
        return 'Baru saja';
    }
}

// ============================================================================
// FILTERS
// ============================================================================
function applyNotifikasiFilter() {
    currentNotifFilters.type = document.getElementById('filterType').value;
    currentNotifFilters.status = document.getElementById('filterStatus').value;
    loadNotifikasi(1);
    showInfoToast('Filter diterapkan');
}

function resetNotifikasiFilter() {
    currentNotifFilters = {
        search: '',
        type: 'all',
        status: 'all'
    };
    
    document.getElementById('searchNotifikasi').value = '';
    document.getElementById('filterType').value = 'all';
    document.getElementById('filterStatus').value = 'all';
    
    loadNotifikasi(1);
    showInfoToast('Filter direset');
}

function filterByStatus(status) {
    currentNotifFilters.status = status;
    document.getElementById('filterStatus').value = status;
    loadNotifikasi(1);
}

function filterByType(type) {
    currentNotifFilters.type = type;
    document.getElementById('filterType').value = type;
    loadNotifikasi(1);
}

function refreshNotifikasi() {
    loadNotifikasi(currentNotifPage);
    loadStats();
    showInfoToast('Data diperbarui');
}

// ============================================================================
// MODAL DETAIL
// ============================================================================
async function showNotifDetail(id) {
    currentDetailId = id;
    
    try {
        const response = await fetch(`{{ route('dppkb.notifikasi') }}/${id}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Failed to load detail');
        
        const result = await response.json();
        
        if (result.success) {
            populateDetailModal(result.data);
            openModal('modalDetail');
            
            // Auto mark as read if unread
            if (result.data.status_baca === 'belum_dibaca') {
                markAsRead(id, false); // Silent mark
            }
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showErrorToast('Gagal memuat detail notifikasi');
    }
}

function populateDetailModal(data) {
    // Header color based on type
    const headerColors = {
        validasi: 'from-purple-600 to-indigo-700',
        peringatan: 'from-red-600 to-red-700',
        informasi: 'from-green-600 to-green-700'
    };
    document.getElementById('modalDetailHeader').className = 
        `bg-gradient-to-r ${headerColors[data.tipe_notifikasi]} px-6 py-5 rounded-t-2xl`;
    
    // Icon
    document.getElementById('detailIcon').innerHTML = getTypeIcon(data.tipe_notifikasi).match(/<path[^>]*>/g).join('');
    
    // Basic info
    document.getElementById('detailType').textContent = data.tipe_notifikasi.charAt(0).toUpperCase() + data.tipe_notifikasi.slice(1);
    document.getElementById('detailJudul').textContent = data.judul;
    document.getElementById('detailPesan').textContent = data.pesan;
    document.getElementById('detailTanggal').textContent = formatDate(data.tanggal_kirim);
    document.getElementById('detailPenerima').textContent = data.penerima_nama || '-';
    document.getElementById('detailPengirim').textContent = data.pengirim_nama || 'Sistem';
    
    // Status badge
    const statusBadge = data.status_baca === 'belum_dibaca'
        ? '<span class="bg-blue-100 text-blue-800">Belum Dibaca</span>'
        : '<span class="bg-gray-100 text-gray-800">Sudah Dibaca</span>';
    document.getElementById('detailStatusBadge').innerHTML = statusBadge;
    document.getElementById('detailStatusBadge').className = data.status_baca === 'belum_dibaca'
        ? 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800'
        : 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800';
    
    // Related data
    if (data.related_data) {
        document.getElementById('detailRelatedData').classList.remove('hidden');
        document.getElementById('detailAnakNama').textContent = data.related_data.nama_anak || '-';
        document.getElementById('detailAnakStatus').textContent = data.related_data.status_stunting || '-';
        document.getElementById('detailPosyandu').textContent = data.related_data.posyandu || '-';
        document.getElementById('detailKecamatan').textContent = data.related_data.kecamatan || '-';
    } else {
        document.getElementById('detailRelatedData').classList.add('hidden');
    }
    
    // Button state
    if (data.status_baca === 'sudah_dibaca') {
        document.getElementById('btnMarkAsRead').style.display = 'none';
    } else {
        document.getElementById('btnMarkAsRead').style.display = 'flex';
    }
}

function closeModalDetail() {
    closeModal('modalDetail');
    currentDetailId = null;
    loadNotifikasi(currentNotifPage);
    loadStats();
}

// ============================================================================
// ACTIONS
// ============================================================================
async function markAsRead(id, showToast = true) {
    try {
        const response = await fetch(`{{ route('dppkb.notifikasi') }}/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const result = await response.json();
        
        if (response.ok && result.success) {
            if (showToast) {
                showSuccessToast('Notifikasi ditandai sudah dibaca');
                closeModalDetail();
            }
        }
    } catch (error) {
        console.error('Error:', error);
        if (showToast) {
            showErrorToast('Gagal menandai notifikasi');
        }
    }
}

async function markAllAsRead() {
    if (!confirm('Tandai semua notifikasi sebagai sudah dibaca?')) return;
    
    try {
        const response = await fetch('{{ route("dppkb.notifikasi") }}/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const result = await response.json();
        
        if (response.ok && result.success) {
            showSuccessToast(result.message || 'Semua notifikasi ditandai sudah dibaca');
            loadNotifikasi(currentNotifPage);
            loadStats();
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showErrorToast(error.message || 'Gagal menandai notifikasi');
    }
}

async function deleteNotifikasi(id) {
    if (!confirm('Hapus notifikasi ini?')) return;
    
    try {
        const response = await fetch(`{{ route('dppkb.notifikasi') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const result = await response.json();
        
        if (response.ok && result.success) {
            showSuccessToast('Notifikasi berhasil dihapus');
            closeModalDetail();
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showErrorToast(error.message || 'Gagal menghapus notifikasi');
    }
}

// ============================================================================
// COMPOSE MODAL
// ============================================================================
function setupComposeWatchers() {
    // Penerima change
    document.getElementById('composePenerima')?.addEventListener('change', function() {
        const specificSection = document.getElementById('specificUserSection');
        if (this.value === 'specific') {
            specificSection.classList.remove('hidden');
            loadUserList();
        } else {
            specificSection.classList.add('hidden');
        }
    });
    
    // Link stunting checkbox
    document.getElementById('composeLinkStunting')?.addEventListener('change', function() {
        const stuntingSection = document.getElementById('stuntingDataSection');
        if (this.checked) {
            stuntingSection.classList.remove('hidden');
            loadStuntingDataList();
        } else {
            stuntingSection.classList.add('hidden');
        }
    });
    
    // Schedule checkbox
    document.getElementById('composeSchedule')?.addEventListener('change', function() {
        const scheduleSection = document.getElementById('scheduleSection');
        if (this.checked) {
            scheduleSection.classList.remove('hidden');
        } else {
            scheduleSection.classList.add('hidden');
        }
    });
    
    // Live preview
    document.getElementById('composeJudul')?.addEventListener('input', function() {
        document.getElementById('previewJudul').textContent = this.value || 'Judul akan muncul di sini';
    });
    
    document.getElementById('composePesan')?.addEventListener('input', function() {
        document.getElementById('previewPesan').textContent = this.value || 'Isi pesan akan muncul di sini';
        document.getElementById('charCount').textContent = this.value.length;
    });
}

async function loadUserList() {
    // Load specific users for dropdown
    try {
        const response = await fetch('{{ route("dppkb.notifikasi") }}/users', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        const select = document.getElementById('composeUserSpecific');
        
        select.innerHTML = '<option value="">Pilih pengguna...</option>';
        data.forEach(user => {
            select.innerHTML += `<option value="${user.id_user}">${user.nama} - ${user.role}</option>`;
        });
    } catch (error) {
        console.error('Error loading users:', error);
    }
}

async function loadStuntingDataList() {
    // Load stunting data for dropdown
    try {
        const response = await fetch('{{ route("dppkb.notifikasi") }}/stunting-data', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        const select = document.getElementById('composeStuntingData');
        
        select.innerHTML = '<option value="">Pilih data stunting...</option>';
        data.forEach(item => {
            select.innerHTML += `<option value="${item.id_stunting}">${item.nama_anak} - ${item.status_stunting} (${item.posyandu})</option>`;
        });
    } catch (error) {
        console.error('Error loading stunting data:', error);
    }
}

function useTemplate(templateType) {
    const templates = {
        validasi_selesai: {
            type: 'validasi',
            judul: 'Data Validasi Stunting Selesai',
            pesan: 'Data stunting telah berhasil divalidasi dan tersedia di sistem.'
        },
        peringatan_stunting: {
            type: 'peringatan',
            judul: 'Peringatan: Anak Terindikasi Stunting',
            pesan: 'Anak Anda terindikasi stunting. Segera konsultasi ke Puskesmas terdekat.'
        },
        jadwal_posyandu: {
            type: 'informasi',
            judul: 'Pengingat Jadwal Posyandu',
            pesan: 'Posyandu akan dilaksanakan minggu depan. Jangan lupa membawa buku KIA.'
        },
        laporan_bulanan: {
            type: 'informasi',
            judul: 'Laporan Bulanan Tersedia',
            pesan: 'Laporan rekapitulasi data stunting bulan ini telah tersedia untuk diunduh.'
        }
    };
    
    const template = templates[templateType];
    if (template) {
        openModalCompose();
        document.querySelector(`input[name="tipe_notifikasi"][value="${template.type}"]`).checked = true;
        document.getElementById('composeJudul').value = template.judul;
        document.getElementById('composePesan').value = template.pesan;
        
        // Update preview
        document.getElementById('previewJudul').textContent = template.judul;
        document.getElementById('previewPesan').textContent = template.pesan;
        document.getElementById('charCount').textContent = template.pesan.length;
    }
}

function openModalCompose() {
    openModal('modalCompose');
}

function closeModalCompose() {
    closeModal('modalCompose');
    document.getElementById('formCompose').reset();
    document.getElementById('specificUserSection').classList.add('hidden');
    document.getElementById('stuntingDataSection').classList.add('hidden');
    document.getElementById('scheduleSection').classList.add('hidden');
    document.getElementById('previewJudul').textContent = 'Judul akan muncul di sini';
    document.getElementById('previewPesan').textContent = 'Isi pesan akan muncul di sini';
    document.getElementById('charCount').textContent = '0';
}

async function submitCompose(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
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
        const response = await fetch('{{ route("dppkb.notifikasi.send") }}', {
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
            closeModalCompose();
            showSuccessToast(result.message || 'Notifikasi berhasil dikirim');
            loadNotifikasi(1);
            loadStats();
        } else {
            throw new Error(result.message || 'Gagal mengirim notifikasi');
        }
    } catch (error) {
        console.error('Error:', error);
        showErrorToast(error.message);
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
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

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
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