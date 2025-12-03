@push('scripts')
<script>
    // Auto format nomor telepon
    document.getElementById('no_telepon').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9+\-()]/g, '');
    });

    // Confirm Delete
    function confirmDeletePuskesmas(button) {
        const nama = button.dataset.nama;
        const count = parseInt(button.dataset.count);

        if (count > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Tidak Dapat Dihapus!',
                text: `Puskesmas ${nama} masih memiliki ${count} posyandu aktif. Hapus atau pindahkan posyandu terlebih dahulu.`,
                confirmButtonColor: '#000878'
            });
            return;
        }

        Swal.fire({
            title: 'Hapus Puskesmas?',
            html: `
                <div class="text-left space-y-3">
                    <p class="text-gray-600">Anda akan menghapus:</p>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <div class="font-medium text-gray-900">${nama}</div>
                    </div>
                    <p class="text-red-600 text-sm">⚠️ <strong>PERINGATAN:</strong> Data yang sudah dihapus tidak dapat dikembalikan!</p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus Permanen!',
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
                document.getElementById('deleteForm').submit();
            }
        });
    }

    // Validasi form
    document.getElementById('puskesmasForm').addEventListener('submit', function(e) {
        // Show loading
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
</script>
@endpush