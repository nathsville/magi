@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('penggunaForm');
    
    // Auto format phone number
    const phoneInput = document.getElementById('no_telepon');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+\-()]/g, '');
        });
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        const username = document.getElementById('username').value.trim();
        const nama = document.getElementById('nama').value.trim();
        const role = document.querySelector('input[name="role"]:checked');
        const password = document.getElementById('password').value;
        
        if (!username || !nama || !role) {
            e.preventDefault();
            
            Swal.fire({
                icon: 'warning',
                title: 'Form Tidak Lengkap',
                text: 'Mohon lengkapi semua field yang wajib diisi',
                confirmButtonColor: '#000878'
            });
            
            return false;
        }

        // Validate password if provided
        if (password && password.length < 6) {
            e.preventDefault();
            
            Swal.fire({
                icon: 'warning',
                title: 'Password Terlalu Pendek',
                text: 'Password harus minimal 6 karakter',
                confirmButtonColor: '#000878'
            });
            
            return false;
        }

        // Show loading
        Swal.fire({
            title: 'Memperbarui Data...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

    // Flash messages
    @if(session('success'))
        showSuccessToast('{{ session('success') }}');
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            html: '<ul class="text-left text-sm">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#000878'
        });
    @endif
});

// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
        `;
    } else {
        field.type = 'password';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
    }
}

// Delete confirmation (reuse from actions.blade.php)
function confirmDeleteUser(button) {
    const nama = button.dataset.nama;
    const username = button.dataset.username;
    const hasOrangTua = button.dataset.hasOrangTua === 'true';
    const formAction = button.dataset.formAction;

    if (hasOrangTua) {
        Swal.fire({
            icon: 'error',
            title: 'Tidak Dapat Dihapus!',
            html: `
                <div class="text-left">
                    <p class="text-sm text-gray-700 mb-3">Pengguna <strong>${nama}</strong> tidak dapat dihapus karena:</p>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <div class="flex items-start space-x-2">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div class="text-sm text-red-800">
                                Masih memiliki <strong>data profil orang tua</strong> yang terdaftar di sistem.
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mt-3">💡 <em>Hapus terlebih dahulu data terkait sebelum menghapus pengguna ini.</em></p>
                </div>
            `,
            confirmButtonColor: '#000878',
            confirmButtonText: 'Mengerti'
        });
        return;
    }

    Swal.fire({
        title: 'Hapus Pengguna?',
        html: `
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="font-semibold text-gray-900">${nama}</div>
                        <div class="text-sm text-gray-600">@${username}</div>
                        <div class="text-xs text-gray-500 mt-1">Data yang sudah dihapus tidak dapat dikembalikan!</div>
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
                        <p class="mt-1">Pengguna ini akan kehilangan akses ke sistem setelah dihapus.</p>
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
        width: '550px'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

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
@endpush