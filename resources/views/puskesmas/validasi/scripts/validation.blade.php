<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Quick Validate (single row)
function quickValidate(id, status) {
    const statusText = status === 'Validated' ? 'memvalidasi' : 'menolak';
    const statusColor = status === 'Validated' ? 'green' : 'red';
    
    Swal.fire({
        title: `${status === 'Validated' ? 'Validasi' : 'Tolak'} Data Ini?`,
        html: `
            <p class="text-gray-600 mb-4">Anda akan ${statusText} data pengukuran ini.</p>
            <textarea id="catatanValidasi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary" 
                placeholder="Catatan validasi (opsional)" rows="3"></textarea>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: statusColor === 'green' ? '#16a34a' : '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, ' + statusText.charAt(0).toUpperCase() + statusText.slice(1),
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const catatan = document.getElementById('catatanValidasi').value;
            
            return fetch(`/puskesmas/validasi/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status_validasi: status,
                    catatan_validasi: catatan
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .catch(error => {
                Swal.showValidationMessage(`Request failed: ${error}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: result.value.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Remove row from table
                document.querySelector(`tr[data-id="${id}"]`).remove();
                
                // Reload if no more data
                if (document.querySelectorAll('tbody tr').length === 0) {
                    location.reload();
                }
            });
        }
    });
}

// Show Info Modal
function showInfoModal() {
    Swal.fire({
        title: 'Panduan Validasi Data',
        html: `
            <div class="text-left space-y-4">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-2">Kriteria Validasi:</h4>
                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                        <li>Periksa kewajaran data antropometri (BB, TB, LK)</li>
                        <li>Pastikan Z-Score sesuai dengan kondisi fisik anak</li>
                        <li>Verifikasi tanggal pengukuran</li>
                        <li>Cek riwayat pertumbuhan anak</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-2">Tindakan:</h4>
                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                        <li><span class="text-green-600 font-semibold">Validated:</span> Data akurat dan dapat dilaporkan</li>
                        <li><span class="text-red-600 font-semibold">Rejected:</span> Data tidak valid, perlu input ulang</li>
                    </ul>
                </div>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Mengerti',
        confirmButtonColor: '#000878'
    });
}

// Success/Error messages from session
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session("error") }}',
        confirmButtonColor: '#000878'
    });
@endif
</script>