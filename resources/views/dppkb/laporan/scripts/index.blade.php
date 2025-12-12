<script>
// ============================================================================
// GLOBAL VARIABLES
// ============================================================================
let currentHistoryPage = 1;
let currentPreviewData = null;

// ============================================================================
// INITIALIZATION
// ============================================================================
document.addEventListener('DOMContentLoaded', function() {
    loadLaporanHistory();
    updateLaporanCount();
    
    // Setup search with debounce
    const searchHistory = document.getElementById('searchHistory');
    let searchTimeout;
    searchHistory?.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadLaporanHistory(1);
        }, 500);
    });
    
    // Setup share method toggle
    document.querySelectorAll('input[name="share_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            toggleShareMethod(this.value);
        });
    });
});

// ============================================================================
// FORM DYNAMICS
// ============================================================================
function updateFormByType() {
    const selectedType = document.querySelector('input[name="jenis_laporan"]:checked')?.value;
    
    // Hide all periode sections
    document.getElementById('periodeBulanan').classList.add('hidden');
    document.getElementById('periodeTahunan').classList.add('hidden');
    document.getElementById('periodeCustom').classList.add('hidden');
    
    // Remove required from all
    document.getElementById('inputBulan').removeAttribute('required');
    document.getElementById('inputTahun').removeAttribute('required');
    document.getElementById('inputTahunTahunan').removeAttribute('required');
    document.getElementById('inputTanggalMulai').removeAttribute('required');
    document.getElementById('inputTanggalSelesai').removeAttribute('required');
    
    // Show relevant section
    if (selectedType === 'Laporan Bulanan') {
        document.getElementById('periodeBulanan').classList.remove('hidden');
        document.getElementById('inputBulan').setAttribute('required', 'required');
        document.getElementById('inputTahun').setAttribute('required', 'required');
    } else if (selectedType === 'Laporan Tahunan') {
        document.getElementById('periodeTahunan').classList.remove('hidden');
        document.getElementById('inputTahunTahunan').setAttribute('required', 'required');
    } else if (selectedType === 'Laporan Custom') {
        document.getElementById('periodeCustom').classList.remove('hidden');
        document.getElementById('inputTanggalMulai').setAttribute('required', 'required');
        document.getElementById('inputTanggalSelesai').setAttribute('required', 'required');
    }
}

function focusGenerateForm() {
    const formCard = document.getElementById('generateFormCard');
    formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
    
    // Add highlight effect
    formCard.classList.add('ring-4', 'ring-teal-300');
    setTimeout(() => {
        formCard.classList.remove('ring-4', 'ring-teal-300');
    }, 2000);
}

function generateCurrentMonth() {
    document.querySelector('input[name="jenis_laporan"][value="Laporan Bulanan"]').checked = true;
    updateFormByType();
    focusGenerateForm();
    showInfoToast('Form diisi untuk bulan ini');
}

function generateYearly() {
    document.querySelector('input[name="jenis_laporan"][value="Laporan Tahunan"]').checked = true;
    updateFormByType();
    focusGenerateForm();
    showInfoToast('Form diisi untuk tahun ini');
}

function scrollToHistory() {
    document.getElementById('historySection').scrollIntoView({ behavior: 'smooth' });
}

// ============================================================================
// GENERATE LAPORAN
// ============================================================================
async function submitGenerateLaporan(event) {
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
        <span class="ml-2">Generating...</span>
    `;
    
    try {
        const response = await fetch('{{ route("dppkb.laporan.generate") }}', {
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
            showSuccessToast(result.message || 'Laporan berhasil di-generate');
            
            // Download file
            if (result.download_url) {
                window.location.href = result.download_url;
            }
            
            // Reload history
            loadLaporanHistory();
            updateLaporanCount();
            
        } else {
            throw new Error(result.message || 'Gagal generate laporan');
        }
        
    } catch (error) {
        console.error('Error:', error);
        showErrorToast(error.message || 'Terjadi kesalahan saat generate laporan');
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    }
}

// ============================================================================
// PREVIEW
// ============================================================================
async function previewLaporan() {
    const formData = new FormData(document.getElementById('formGenerateLaporan'));
    
    // Show loading in preview tab
    document.getElementById('previewContent').innerHTML = `
        <div class="flex items-center justify-center py-12">
            <div class="text-center">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-600 border-t-transparent mb-3"></div>
                <p class="text-gray-700 font-medium">Memuat preview...</p>
            </div>
        </div>
    `;
    
    try {
        const response = await fetch('{{ route("dppkb.laporan") }}/preview', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            currentPreviewData = data.data;
            openModalPreview(data.data);
        } else {
            throw new Error(data.message || 'Gagal memuat preview');
        }
        
    } catch (error) {
        console.error('Error:', error);
        showErrorToast(error.message);
        document.getElementById('previewContent').innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-600">Gagal memuat preview</p>
            </div>
        `;
    }
}

function openModalPreview(data) {
    // Populate modal with data
    document.getElementById('previewTitle').textContent = data.judul || 'Laporan Stunting';
    document.getElementById('previewPeriodeLaporan').textContent = data.periode || '-';
    document.getElementById('previewTotalAnak').textContent = data.total_anak || '-';
    document.getElementById('previewTotalStunting').textContent = data.total_stunting || '-';
    document.getElementById('previewTotalNormal').textContent = data.total_normal || '-';
    document.getElementById('previewPrevalensi').textContent = data.prevalensi ? `${data.prevalensi}%` : '-%';
    
    const now = new Date();
    document.getElementById('previewTanggalCetak').textContent = now.toLocaleDateString('id-ID');
    document.getElementById('previewTanggalTTD').textContent = now.toLocaleDateString('id-ID');
    
    // Populate table
    if (data.kecamatan && data.kecamatan.length > 0) {
        let tableHtml = '';
        data.kecamatan.forEach(kec => {
            tableHtml += `
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2">${kec.nama}</td>
                    <td class="px-4 py-2 text-center">${kec.total_anak}</td>
                    <td class="px-4 py-2 text-center">${kec.total_stunting}</td>
                    <td class="px-4 py-2 text-center">${kec.prevalensi}%</td>
                </tr>
            `;
        });
        document.getElementById('previewTableBody').innerHTML = tableHtml;
    }
    
    openModal('modalPreview');
}

function closeModalPreview() {
    closeModal('modalPreview');
    currentPreviewData = null;
}

function downloadFromPreview() {
    if (!currentPreviewData || !currentPreviewData.download_url) {
        showErrorToast('Data preview tidak tersedia');
        return;
    }
    window.location.href = currentPreviewData.download_url;
}

function printPreview() {
    const printContent = document.getElementById('previewContainer').innerHTML;
    const printWindow = window.open('', '', 'height=800,width=800');
    printWindow.document.write('<html><head><title>Print Laporan</title>');
    printWindow.document.write('<style>body{font-family: Arial, sans-serif; padding: 20px;} table{width:100%; border-collapse: collapse;} th,td{border:1px solid #ddd; padding:8px;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// ============================================================================
// TEMPLATES
// ============================================================================
function showTemplateTab(tab) {
    const previewTab = document.getElementById('previewTab');
    const templatesTab = document.getElementById('templatesTab');
    const btnPreview = document.getElementById('btnTabPreview');
    const btnTemplates = document.getElementById('btnTabTemplates');
    
    if (tab === 'preview') {
        previewTab.classList.remove('hidden');
        templatesTab.classList.add('hidden');
        btnPreview.className = 'px-3 py-1.5 bg-white text-blue-700 text-sm rounded-lg transition font-medium';
        btnTemplates.className = 'px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition';
    } else {
        previewTab.classList.add('hidden');
        templatesTab.classList.remove('hidden');
        btnPreview.className = 'px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition';
        btnTemplates.className = 'px-3 py-1.5 bg-white text-blue-700 text-sm rounded-lg transition font-medium';
    }
}

function showTemplates() {
    showTemplateTab('templates');
}

function applyTemplate(templateType) {
    showInfoToast(`Template "${templateType}" diterapkan`);
    showTemplateTab('preview');
    // Apply template settings to form
}

// ============================================================================
// HISTORY
// ============================================================================
async function loadLaporanHistory(page = 1) {
    currentHistoryPage = page;
    
    const searchQuery = document.getElementById('searchHistory')?.value || '';
    const filterPeriode = document.getElementById('filterHistoryPeriode')?.value || 'semua';
    
    try {
        const params = new URLSearchParams({
            page: currentHistoryPage,
            search: searchQuery,
            periode: filterPeriode
        });
        
        const response = await fetch(`{{ route('dppkb.laporan') }}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Failed to load history');
        
        const data = await response.json();
        renderHistoryTable(data.data);
        renderHistoryPagination(data);
        
    } catch (error) {
        console.error('Error loading history:', error);
        showErrorToast('Gagal memuat riwayat laporan');
    }
}

function renderHistoryTable(data) {
    const tbody = document.getElementById('historyTableBody');
    
    if (!data || data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="px-6 py-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-600 text-lg font-medium">Belum Ada Laporan</p>
                    <p class="text-gray-500 text-sm mt-2">Generate laporan pertama Anda</p>
                </td>
            </tr>
        `;
        return;
    }
    
    let html = '';
    data.forEach((item, index) => {
        const rowNumber = (currentHistoryPage - 1) * 10 + index + 1;
        const statusBadge = getStatusBadge(item.status);
        const formatBadge = getFormatBadge(item.format);
        
        html += `
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm text-gray-900 font-medium">${rowNumber}</td>
                <td class="px-6 py-4">
                    <p class="text-sm font-semibold text-gray-900">${item.jenis_laporan}</p>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">${item.periode}</td>
                <td class="px-6 py-4 text-sm text-gray-700">${item.wilayah || 'Seluruh Kota'}</td>
                <td class="px-6 py-4">${formatBadge}</td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-900">${item.pembuat}</p>
                    <p class="text-xs text-gray-500">${formatDate(item.tanggal_buat)}</p>
                </td>
                <td class="px-6 py-4 text-center">${statusBadge}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center space-x-2">
                        <button onclick="downloadLaporan(${item.id_laporan})" 
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                            title="Download">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </button>
                        <button onclick="shareLaporan(${item.id_laporan})" 
                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                            title="Share">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                        </button>
                        <button onclick="deleteLaporan(${item.id_laporan})" 
                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                            title="Delete">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function renderHistoryPagination(data) {
    const container = document.getElementById('historyPagination');
    if (!container || data.last_page <= 1) {
        container.innerHTML = '';
        return;
    }
    
    let html = '<div class="flex items-center justify-between">';
    html += `<div class="text-sm text-gray-600">Halaman ${data.current_page} dari ${data.last_page}</div>`;
    html += '<div class="flex space-x-2">';
    
    if (data.current_page > 1) {
        html += `<button onclick="loadLaporanHistory(${data.current_page - 1})" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Sebelumnya</button>`;
    }
    
    if (data.current_page < data.last_page) {
        html += `<button onclick="loadLaporanHistory(${data.current_page + 1})" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Selanjutnya</button>`;
    }
    
    html += '</div></div>';
    container.innerHTML = html;
}

function getStatusBadge(status) {
    const badges = {
        'completed': '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Selesai</span>',
        'processing': '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Proses</span>',
        'failed': '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Gagal</span>'
    };
    return badges[status] || status;
}

function getFormatBadge(format) {
    const badges = {
        'pdf': '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">PDF</span>',
        'excel': '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Excel</span>'
    };
    return badges[format] || format;
}

function updateLaporanCount() {
    fetch('{{ route("dppkb.laporan") }}/count', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('totalLaporanCount').textContent = `${data.total || 0} Laporan Tersimpan`;
        document.getElementById('historyCount').textContent = `${data.total || 0} laporan`;
    })
    .catch(console.error);
}

// ============================================================================
// ACTIONS
// ============================================================================
function downloadLaporan(id) {
    showInfoToast('Mengunduh laporan...');
    window.location.href = `{{ url('dppkb/laporan') }}/${id}/download`;
}

function shareLaporan(id) {
    document.getElementById('shareReportId').value = id;
    openModal('modalShare');
}

function deleteLaporan(id) {
    if (!confirm('Yakin ingin menghapus laporan ini?')) return;
    
    fetch(`{{ url('dppkb/laporan') }}/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showSuccessToast('Laporan berhasil dihapus');
            loadLaporanHistory();
            updateLaporanCount();
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        showErrorToast(error.message || 'Gagal menghapus laporan');
    });
}

// ============================================================================
// SHARE MODAL
// ============================================================================
function toggleShareMethod(method) {
    const emailSection = document.getElementById('emailInputSection');
    const whatsappSection = document.getElementById('whatsappInputSection');
    const emailInput = document.getElementById('shareEmail');
    const whatsappInput = document.getElementById('shareWhatsapp');
    
    if (method === 'email') {
        emailSection.classList.remove('hidden');
        whatsappSection.classList.add('hidden');
        emailInput.setAttribute('required', 'required');
        whatsappInput.removeAttribute('required');
    } else {
        emailSection.classList.add('hidden');
        whatsappSection.classList.remove('hidden');
        emailInput.removeAttribute('required');
        whatsappInput.setAttribute('required', 'required');
    }
}

async function submitShare(event) {
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
        const response = await fetch('{{ route("dppkb.laporan") }}/share', {
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
            closeModalShare();
            showSuccessToast(result.message || 'Laporan berhasil dikirim');
        } else {
            throw new Error(result.message || 'Gagal mengirim laporan');
        }
        
    } catch (error) {
        console.error('Error:', error);
        showErrorToast(error.message);
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    }
}

function closeModalShare() {
    closeModal('modalShare');
    document.getElementById('formShare').reset();
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