<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto submit filter on change
    const filterSelects = document.querySelectorAll('select[name="puskesmas"], select[name="kecamatan"], select[name="status"]');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Flash messages
    @if(session('success'))
        showSuccessToast('{{ session('success') }}');
    @endif

    @if(session('error'))
        showErrorToast('{{ session('error') }}');
    @endif

    @if($errors->any())
        showErrorToast('{{ $errors->first() }}');
    @endif
});

// Delete confirmation
function confirmDeletePosyandu(button) {
    const nama = button.dataset.nama;
    const formAction = button.dataset.formAction;

    Swal.fire({
        title: 'Hapus Posyandu?',
        html: `
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="font-semibold text-gray-900">${nama}</div>
                        <div class="text-sm text-gray-600 mt-1">Data yang sudah dihapus tidak dapat dikembalikan!</div>
                    </div>
                </div>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-left">
                <div class="flex items-start space-x-2">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div class="text-sm text-yellow-800">
                        <strong class="font-semibold">Perhatian:</strong>
                        <p class="mt-1">Pastikan posyandu ini tidak memiliki data pengukuran yang masih aktif.</p>
                    </div>
                </div>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        width: '550px',
        customClass: {
            confirmButton: 'px-5 py-2.5 text-sm font-medium',
            cancelButton: 'px-5 py-2.5 text-sm font-medium'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = formAction;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>