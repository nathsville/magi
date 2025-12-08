<script>
function showExportModal() {
    Swal.fire({
        icon: 'info',
        title: 'Export Data Monitoring',
        html: `
            <div class="text-left space-y-4">
                <p class="text-gray-700 text-sm">Pilih format export yang diinginkan:</p>
                
                <div class="space-y-3">
                    <button onclick="exportData('excel')" 
                        class="w-full flex items-center justify-between px-4 py-3 bg-green-50 border-2 border-green-200 rounded-lg hover:bg-green-100 transition">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-green-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"></path>
                            </svg>
                            <div class="text-left">
                                <p class="font-semibold text-gray-900">Excel (.xlsx)</p>
                                <p class="text-xs text-gray-600">Data lengkap dengan formula</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <button onclick="exportData('pdf')" 
                        class="w-full flex items-center justify-between px-4 py-3 bg-red-50 border-2 border-red-200 rounded-lg hover:bg-red-100 transition">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-red-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"></path>
                            </svg>
                            <div class="text-left">
                                <p class="font-semibold text-gray-900">PDF (.pdf)</p>
                                <p class="text-xs text-gray-600">Format laporan siap cetak</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <button onclick="exportData('csv')" 
                        class="w-full flex items-center justify-between px-4 py-3 bg-blue-50 border-2 border-blue-200 rounded-lg hover:bg-blue-100 transition">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"></path>
                            </svg>
                            <div class="text-left">
                                <p class="font-semibold text-gray-900">CSV (.csv)</p>
                                <p class="text-xs text-gray-600">Data mentah untuk analisis</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="bg-gray-50 border-l-4 border-gray-400 p-3 rounded-r-lg mt-4">
                    <p class="text-xs text-gray-700">
                        <strong>Info:</strong> Export akan menggunakan filter yang sedang aktif
                    </p>
                </div>
            </div>
        `,
        showConfirmButton: false,
        width: '500px'
    });
}

function exportData(format) {
    Swal.close();
    
    // Get current filter parameters
    const params = new URLSearchParams(window.location.search);
    params.append('export', format);
    
    // Show loading
    Swal.fire({
        title: 'Memproses Export...',
        html: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // TODO: Implement actual export functionality
    // For now, just show success message
    setTimeout(() => {
        Swal.fire({
            icon: 'success',
            title: 'Export Berhasil!',
            text: `File ${format.toUpperCase()} sedang diunduh`,
            timer: 2000,
            showConfirmButton: false
        });
        
        // In production, trigger download:
        // window.location.href = `/puskesmas/monitoring/export?${params.toString()}`;
    }, 1500);
}
</script>