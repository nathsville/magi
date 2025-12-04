<script>
// Form validation and submission
document.getElementById('inputForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const formData = new FormData(this);
    
    // Validate required fields
    const idAnak = document.getElementById('id_anak').value;
    const beratBadan = document.getElementById('berat_badan').value;
    const tinggiBadan = document.getElementById('tinggi_badan').value;
    const lingkarKepala = document.getElementById('lingkar_kepala').value;
    const lingkarLengan = document.getElementById('lingkar_lengan').value;
    
    if (!idAnak) {
        Swal.fire({
            icon: 'warning',
            title: 'Data Tidak Lengkap',
            text: 'Silakan pilih anak terlebih dahulu',
            confirmButtonColor: '#000878'
        });
        return;
    }
    
    // Check for outliers before submit
    const hasOutlier = checkAllOutliers();
    
    if (hasOutlier) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan Data Tidak Wajar',
            html: `
                <p class="text-gray-700 mb-4">Sistem mendeteksi data yang tidak wajar. Apakah Anda yakin data sudah benar?</p>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 text-left">
                    <p class="text-sm text-yellow-800 font-medium mb-2">⚠ Tips Memastikan Data Akurat:</p>
                    <ul class="text-xs text-yellow-700 space-y-1 ml-4">
                        <li>• Periksa kembali timbangan dan alat ukur</li>
                        <li>• Pastikan anak dalam posisi yang benar</li>
                        <li>• Ulangi pengukuran jika perlu</li>
                    </ul>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan Tetap',
            cancelButtonText: 'Periksa Kembali',
            confirmButtonColor: '#000878',
            cancelButtonColor: '#6B7280'
        }).then((result) => {
            if (result.isConfirmed) {
                submitFormData(formData, submitBtn);
            }
        });
    } else {
        // Confirmation before submit
        Swal.fire({
            icon: 'question',
            title: 'Konfirmasi Simpan Data',
            html: `
                <p class="text-gray-700 mb-4">Data akan langsung tervalidasi dan masuk ke sistem. Pastikan semua data sudah benar.</p>
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 text-left">
                    <p class="text-sm text-blue-800 font-medium mb-2">✓ Setelah disimpan:</p>
                    <ul class="text-xs text-blue-700 space-y-1 ml-4">
                        <li>• Data otomatis divalidasi oleh sistem</li>
                        <li>• Z-Score dihitung secara real-time</li>
                        <li>• Notifikasi dikirim jika terdeteksi stunting</li>
                    </ul>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan Data',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#000878',
            cancelButtonColor: '#6B7280'
        }).then((result) => {
            if (result.isConfirmed) {
                submitFormData(formData, submitBtn);
            }
        });
    }
});

function submitFormData(formData, submitBtn) {
    // Disable button and show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Menyimpan...
    `;
    
    // Submit via AJAX
    fetch('{{ route("puskesmas.input.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Data Berhasil Disimpan!',
                html: `
                    <div class="text-left">
                        <p class="text-gray-700 mb-4">${data.message}</p>
                        
                        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
                            <p class="text-sm font-semibold text-gray-900 mb-2">Hasil Analisis:</p>
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <div>
                                    <span class="text-gray-600">Status Gizi:</span>
                                    <span class="ml-2 px-2 py-1 rounded font-medium ${
                                        data.data.status_stunting === 'Normal' 
                                            ? 'bg-green-100 text-green-800' 
                                            : 'bg-red-100 text-red-800'
                                    }">
                                        ${data.data.status_stunting}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Z-Score TB/U:</span>
                                    <span class="ml-2 font-semibold">${data.data.zscore_tb_u}</span>
                                </div>
                            </div>
                        </div>
                        
                        ${data.data.stunting_detected ? `
                            <div class="bg-red-50 border-l-4 border-red-400 p-3 rounded-r-lg">
                                <p class="text-xs text-red-800">
                                    ⚠ <strong>Perhatian:</strong> Anak terdeteksi stunting. 
                                    Notifikasi telah dikirim ke orang tua.
                                </p>
                            </div>
                        ` : ''}
                    </div>
                `,
                confirmButtonColor: '#000878',
                timer: data.data.stunting_detected ? null : 3000,
                timerProgressBar: !data.data.stunting_detected
            }).then(() => {
                // Reset form and reload
                resetForm();
                location.reload();
            });
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal Menyimpan',
            text: error.message || 'Terjadi kesalahan saat menyimpan data',
            confirmButtonColor: '#000878'
        });
    })
    .finally(() => {
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.innerHTML = `
            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
            </svg>
            Simpan Data Pengukuran
        `;
    });
}

function resetForm() {
    document.getElementById('inputForm').reset();
    document.getElementById('id_anak').disabled = true;
    document.getElementById('id_anak').innerHTML = '<option value="">Pilih posyandu terlebih dahulu</option>';
    document.getElementById('anakInfo').classList.add('hidden');
    
    // Hide all warnings
    document.querySelectorAll('[id^="warning"]').forEach(el => {
        el.classList.add('hidden');
    });
}

// Panduan Input Modal
function showInputGuide() {
    Swal.fire({
        icon: 'info',
        title: 'Panduan Input Data Pengukuran',
        html: `
            <div class="text-left space-y-4">
                <div>
                    <p class="font-semibold text-gray-900 mb-2">📋 Langkah-Langkah:</p>
                    <ol class="text-sm text-gray-700 space-y-2 ml-4 list-decimal">
                        <li>Pilih posyandu dan nama anak</li>
                        <li>Masukkan data hasil pengukuran antropometri</li>
                        <li>Periksa warning jika ada data tidak wajar</li>
                        <li>Tambahkan catatan jika diperlukan</li>
                        <li>Klik "Simpan Data Pengukuran"</li>
                    </ol>
                </div>
                
                <div class="bg-blue-50 border-l-4 border-blue-400 p-3 rounded-r-lg">
                    <p class="font-semibold text-blue-900 text-sm mb-2">💡 Tips Pengukuran Akurat:</p>
                    <ul class="text-xs text-blue-800 space-y-1 ml-4">
                        <li>• Pastikan timbangan dan alat ukur terkalibrasi</li>
                        <li>• Anak dalam kondisi tenang saat diukur</li>
                        <li>• Gunakan posisi berbaring untuk anak < 2 tahun</li>
                        <li>• Catat hasil segera untuk menghindari lupa</li>
                    </ul>
                </div>
                
                <div class="bg-green-50 border-l-4 border-green-400 p-3 rounded-r-lg">
                    <p class="font-semibold text-green-900 text-sm mb-2">✓ Auto-Validated:</p>
                    <p class="text-xs text-green-800">
                        Data yang Anda input akan langsung tervalidasi oleh sistem. 
                        Tidak perlu menunggu validasi dari petugas lain.
                    </p>
                </div>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded-r-lg">
                    <p class="font-semibold text-yellow-900 text-sm mb-2">⚠ Outlier Detection:</p>
                    <p class="text-xs text-yellow-800">
                        Sistem akan memberi peringatan jika data tidak wajar. 
                        Periksa kembali pengukuran jika muncul warning.
                    </p>
                </div>
            </div>
        `,
        width: '600px',
        confirmButtonText: 'Mengerti',
        confirmButtonColor: '#000878'
    });
}
</script>