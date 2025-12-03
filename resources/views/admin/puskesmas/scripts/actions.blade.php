<script>
    // ==================== FILTER AUTO SUBMIT ====================

    document.querySelectorAll('select[name="kecamatan"], select[name="status"]').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // ==================== DELETE CONFIRMATION ====================

    function confirmDeletePuskesmas(button) {
        const form = button.closest('form');
        const nama = button.dataset.nama;
        const posyanduCount = parseInt(button.dataset.posyandu);

        if (posyanduCount > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Tidak Dapat Dihapus!',
                html: `
                    <div class="text-left space-y-3">
                        <p class="text-gray-700">Puskesmas <strong>${nama}</strong> tidak dapat dihapus karena:</p>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <span class="text-sm font-medium text-red-800">
                                    Masih memiliki <strong>${posyanduCount} Posyandu</strong> yang terdaftar
                                </span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            Hapus semua Posyandu yang terkait terlebih dahulu sebelum menghapus Puskesmas ini.
                        </p>
                    </div>
                `,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Mengerti'
            });
            return;
        }

        Swal.fire({
            title: 'Hapus Puskesmas?',
            html: `
                <div class="text-left space-y-3">
                    <p class="text-gray-600">Anda akan menghapus:</p>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <div class="font-medium text-gray-900">${nama}</div>
                    </div>
                    <p class="text-red-600 text-sm">⚠️ Data yang sudah dihapus tidak dapat dikembalikan!</p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    }

    // ==================== FLASH MESSAGES ====================

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc2626'
        });
    @endif
</script>