<script>
function previewBroadcast() {
    const judul = document.getElementById('judul').value.trim();
    const pesan = document.getElementById('pesan').value.trim();
    const target = document.querySelector('input[name="target_audience"]:checked');
    const channel = document.querySelector('input[name="tipe_pengiriman"]:checked');

    if (!judul || !pesan) {
        Swal.fire({
            icon: 'warning',
            title: 'Form Belum Lengkap',
            text: 'Mohon isi judul dan pesan terlebih dahulu',
            confirmButtonColor: '#000878'
        });
        return;
    }

    // Format pesan with line breaks
    const formattedPesan = pesan.replace(/\n/g, '<br>');

    // Get target label
    let targetLabel = 'Semua Orang Tua';
    let targetColor = 'blue';
    if (target.value === 'with_stunting') {
        targetLabel = 'Orang Tua dengan Anak Terindikasi Stunting';
        targetColor = 'red';
    } else if (target.value === 'without_stunting') {
        targetLabel = 'Orang Tua dengan Anak Status Gizi Normal';
        targetColor = 'green';
    }

    // Get channel info
    let channelHTML = '';
    if (channel.value === 'whatsapp') {
        channelHTML = `
            <div class="flex items-center space-x-2 text-green-700">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                <span class="font-medium">WhatsApp</span>
            </div>
        `;
    } else if (channel.value === 'email') {
        channelHTML = `
            <div class="flex items-center space-x-2 text-purple-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span class="font-medium">Email</span>
            </div>
        `;
    } else {
        channelHTML = `
            <div class="flex items-center space-x-2 text-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
                <span class="font-medium">WhatsApp & Email</span>
            </div>
        `;
    }

    Swal.fire({
        title: 'Preview Broadcast',
        html: `
            <div class="text-left space-y-4">
                <!-- Target Audience Badge -->
                <div class="inline-flex items-center px-3 py-1.5 bg-${targetColor}-100 text-${targetColor}-800 rounded-full text-sm font-medium">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    ${targetLabel}
                </div>

                <!-- Message Preview Card -->
                <div class="bg-white border-2 border-gray-300 rounded-xl shadow-sm overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-primary to-blue-900 px-4 py-3 flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-semibold text-sm">MaGi - DPPKB Parepare</p>
                            <p class="text-blue-200 text-xs">Sistem Monitoring Stunting</p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4 space-y-3">
                        <div class="bg-blue-50 border-l-4 border-primary rounded-r-lg p-3">
                            <h3 class="font-bold text-gray-900 text-base mb-2">${judul}</h3>
                        </div>
                        
                        <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap bg-gray-50 rounded-lg p-3 border border-gray-200">
                            ${formattedPesan}
                        </div>

                        <!-- Channel Info -->
                        <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                            <span class="text-xs text-gray-500">Akan dikirim via:</span>
                            ${channelHTML}
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-4 py-2 border-t border-gray-200">
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>📅 ${new Date().toLocaleDateString('id-ID', { 
                                day: 'numeric', 
                                month: 'long', 
                                year: 'numeric' 
                            })}</span>
                            <span>🕐 ${new Date().toLocaleTimeString('id-ID', { 
                                hour: '2-digit', 
                                minute: '2-digit' 
                            })}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <div class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xs text-blue-800">
                            Ini adalah preview tampilan pesan. Tampilan sebenarnya mungkin sedikit berbeda tergantung perangkat penerima.
                        </p>
                    </div>
                </div>
            </div>
        `,
        width: '650px',
        showCloseButton: true,
        confirmButtonColor: '#000878',
        confirmButtonText: 'Tutup Preview'
    });
}
</script>