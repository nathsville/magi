<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('broadcastForm');
    const judulInput = document.getElementById('judul');
    const pesanInput = document.getElementById('pesan');
    const judulCount = document.getElementById('judulCount');
    const pesanCount = document.getElementById('pesanCount');

    // Character counter for judul
    if (judulInput && judulCount) {
        judulInput.addEventListener('input', function() {
            const length = this.value.length;
            judulCount.textContent = length;
            
            if (length > 180) {
                judulCount.classList.add('text-yellow-600', 'font-semibold');
            } else {
                judulCount.classList.remove('text-yellow-600', 'font-semibold');
            }
        });
    }

    // Character counter for pesan
    if (pesanInput && pesanCount) {
        pesanInput.addEventListener('input', function() {
            const length = this.value.length;
            pesanCount.textContent = length;
        });
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const judul = judulInput.value.trim();
        const pesan = pesanInput.value.trim();
        const target = document.querySelector('input[name="target_audience"]:checked').value;
        const channel = document.querySelector('input[name="tipe_pengiriman"]:checked').value;

        if (!judul || !pesan) {
            Swal.fire({
                icon: 'warning',
                title: 'Form Tidak Lengkap',
                text: 'Mohon isi judul dan pesan broadcast',
                confirmButtonColor: '#000878'
            });
            return false;
        }

        // Get target label
        let targetLabel = 'Semua Orang Tua';
        if (target === 'with_stunting') {
            targetLabel = 'Orang Tua dengan Anak Terindikasi Stunting';
        } else if (target === 'without_stunting') {
            targetLabel = 'Orang Tua dengan Anak Status Gizi Normal';
        }

        // Get channel label
        let channelLabel = 'WhatsApp';
        let channelIcon = `
            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
        `;
        if (channel === 'email') {
            channelLabel = 'Email';
            channelIcon = `
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            `;
        } else if (channel === 'both') {
            channelLabel = 'WhatsApp & Email';
            channelIcon = `
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
            `;
        }

        Swal.fire({
            title: 'Konfirmasi Broadcast',
            html: `
                <div class="text-left space-y-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-blue-900 mb-2">Detail Broadcast:</p>
                                <div class="space-y-2 text-sm text-blue-800">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Judul:</span>
                                        <span class="font-medium">${judul}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Target:</span>
                                        <span class="font-medium">${targetLabel}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Channel:</span>
                                        <span class="font-medium flex items-center space-x-1">
                                            ${channelIcon}
                                            <span>${channelLabel}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start space-x-2">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div class="text-sm text-yellow-800">
                                <strong class="font-semibold">Perhatian:</strong>
                                <p class="mt-1">Broadcast akan dikirim ke seluruh penerima yang sesuai kriteria. Pastikan pesan sudah benar sebelum mengirim.</p>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#000878',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-paper-plane mr-2"></i>Ya, Kirim Broadcast!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            width: '600px'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Mengirim Broadcast...',
                    html: `
                        <div class="text-center">
                            <div class="animate-pulse mb-4">
                                <svg class="w-16 h-16 text-primary mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600">Mohon tunggu, broadcast sedang dikirim...</p>
                        </div>
                    `,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                form.submit();
            }
        });
    });

    // Flash messages
    @if(session('success'))
        Swal.close();
        showSuccessToast('{{ session('success') }}');
        
        // Reset form after success
        setTimeout(() => {
            form.reset();
            judulCount.textContent = '0';
            pesanCount.textContent = '0';
        }, 500);
    @endif

    @if(session('warning'))
        Swal.close();
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: '{{ session('warning') }}',
            confirmButtonColor: '#000878'
        });
    @endif

    @if(session('error'))
        Swal.close();
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: '{{ session('error') }}',
            confirmButtonColor: '#000878'
        });
    @endif

    @if($errors->any())
        Swal.close();
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            html: '<ul class="text-left text-sm space-y-1">@foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#000878'
        });
    @endif
});
</script>