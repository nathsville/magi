@push('scripts')
<script>
    // Auto uppercase kode saat typing
    document.getElementById('kode').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9_]/g, '');
    });
    
    // Konfirmasi jika mengubah kode
    const form = document.getElementById('datamasterForm');
    const kodeInput = document.getElementById('kode');
    const originalKode = '{{ $data->kode }}';
    
    form.addEventListener('submit', function(e) {
        if (kodeInput.value !== originalKode) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Perubahan Kode Terdeteksi!',
                html: `
                    <div class="text-left space-y-3">
                        <p class="text-gray-600">Anda akan mengubah kode data master:</p>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Kode Lama:</span>
                                <code class="text-sm bg-gray-200 px-2 py-1 rounded font-mono">${originalKode}</code>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Kode Baru:</span>
                                <code class="text-sm bg-blue-200 px-2 py-1 rounded font-mono">${kodeInput.value}</code>
                            </div>
                        </div>
                        <p class="text-orange-600 text-sm">
                            ⚠️ Perubahan kode dapat memengaruhi logika sistem!
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000878',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'px-5 py-2.5 rounded-lg text-sm font-medium',
                    cancelButton: 'px-5 py-2.5 rounded-lg text-sm font-medium'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });

    // Confirm delete with detail
    document.querySelector('.delete-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Hapus Data Master Ini?',
            html: `
                <div class="text-left space-y-2">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <div class="mb-2">
                            <span class="text-xs font-semibold text-gray-500">KODE:</span>
                            <code class="text-sm bg-red-100 px-2 py-1 rounded ml-2">{{ $data->kode }}</code>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-gray-500">NILAI:</span>
                            <span class="text-sm font-medium ml-2">{{ $data->nilai }}</span>
                        </div>
                    </div>
                    <p class="text-red-600 text-sm mt-3">
                        ⚠️ <strong>PERINGATAN:</strong> Data yang sudah dihapus tidak dapat dikembalikan!
                    </p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'px-5 py-2.5 rounded-lg text-sm font-medium',
                cancelButton: 'px-5 py-2.5 rounded-lg text-sm font-medium'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endpush