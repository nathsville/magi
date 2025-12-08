<script>
function confirmDelete(id, namaAnak) {
    Swal.fire({
        icon: 'warning',
        title: 'Hapus Data Anak?',
        html: `
            <div class="text-left">
                <p class="text-gray-700 mb-4">Apakah Anda yakin ingin menghapus data anak:</p>
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg mb-4">
                    <p class="font-semibold text-red-900">${namaAnak}</p>
                </div>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded-r-lg">
                    <p class="text-xs text-yellow-800">
                        <strong>⚠ Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. 
                        Semua riwayat pengukuran anak juga akan terhapus.
                    </p>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#DC2626',
        cancelButtonColor: '#6B7280',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Create and submit delete form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/puskesmas/data-anak/${id}`;
            
            const csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '_token';
            csrfField.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfField);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>